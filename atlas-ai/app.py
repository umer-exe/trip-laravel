"""
Atlas Tours & Travel — AI Chatbot Service (Groq Edition)
==========================================================
Fetches tour data from the Laravel API, embeds it into a FAISS vector store,
and exposes a /chat endpoint using a ConversationalRetrievalChain.
Powered by Groq (LLM) and HuggingFace (Embeddings) for a credit-free experience.

Run:
    uvicorn app:app --host 0.0.0.0 --port 8001 --reload
"""

import os
import requests

from dotenv import load_dotenv
from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

from langchain_text_splitters import RecursiveCharacterTextSplitter
from langchain_core.documents import Document
from langchain_groq import ChatGroq
from langchain_huggingface import HuggingFaceEmbeddings
from langchain_community.vectorstores import FAISS
from langchain_classic.chains import ConversationalRetrievalChain
from langchain_classic.memory import ConversationBufferMemory
from langchain_core.prompts import PromptTemplate, SystemMessagePromptTemplate, HumanMessagePromptTemplate, ChatPromptTemplate

# ── Load environment variables ────────────────────────────────────────────────
load_dotenv()

GROQ_API_KEY = os.getenv("GROQ_API_KEY")
LARAVEL_API_URL = os.getenv("LARAVEL_API_URL", "http://localhost:8000/api/tours")

if not GROQ_API_KEY:
    raise RuntimeError("GROQ_API_KEY is not set. Check your .env file.")

# ── FastAPI app ───────────────────────────────────────────────────────────────
app = FastAPI(title="Atlas Tours AI Service (Groq)", version="1.1.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],   # Allow Laravel frontend
    allow_methods=["*"],
    allow_headers=["*"],
)

# ── Request/Response schemas ──────────────────────────────────────────────────
class ChatRequest(BaseModel):
    question: str

class ChatResponse(BaseModel):
    answer: str


# ── System prompt ─────────────────────────────────────────────────────────────
SYSTEM_PROMPT = """You are an AI travel assistant for Atlas Tours & Travel.
Your role is to help users discover and learn about tour packages available on the platform.

Guidelines:
- Only recommend tours that exist in the provided context.
- When suggesting tours, present them clearly with: Tour Name, Location, Duration, Price, and Highlights.
- If a user asks about a specific tour, give a concise and helpful summary.
- Encourage follow-up questions to help the user find the perfect tour.
- If information is unavailable, honestly say you couldn't find it — never invent details.
- Keep responses friendly, professional, and enthusiastic about travel.

Context:
{context}
"""

# ── Helper: fetch tours from Laravel API ─────────────────────────────────────
def fetch_tours() -> list[dict]:
    """Fetch all tours from the Laravel API."""
    try:
        response = requests.get(LARAVEL_API_URL, timeout=10)
        response.raise_for_status()
        data = response.json()
        if isinstance(data, list):
            return data
        return data.get("data", [])
    except requests.RequestException as e:
        print(f"[ERROR] Could not fetch tours from Laravel API: {e}")
        return []


# ── Helper: convert tours to LangChain Documents ────────────────────────────
def tours_to_documents(tours: list[dict]) -> list[Document]:
    """Format each tour as a readable LangChain Document."""
    documents = []
    for tour in tours:
        highlights = tour.get("highlights", "")
        if isinstance(highlights, list):
            highlights = ", ".join(highlights)

        content = (
            f"Tour: {tour.get('title', 'N/A')}\n"
            f"Location: {tour.get('location', 'N/A')}\n"
            f"Duration: {tour.get('duration', 'N/A')}\n"
            f"Price: ${tour.get('price', 'N/A')}\n"
            f"Type: {tour.get('type', 'N/A')}\n"
            f"Highlights: {highlights or 'N/A'}\n"
            f"Description: {tour.get('overview', tour.get('description', 'N/A'))}\n"
        )
        documents.append(Document(page_content=content, metadata={"title": tour.get("title", "")}))
    return documents


# ── Build vector store ────────────────────────────────────────────────────────
def build_vector_store(documents: list[Document]) -> FAISS:
    """Split documents and embed them into a FAISS vector store using local embeddings."""
    splitter = RecursiveCharacterTextSplitter(chunk_size=800, chunk_overlap=100)
    chunks = splitter.split_documents(documents)
    
    # Use free, local embeddings
    print("[INFO] Initializing HuggingFace embeddings (local model)...")
    embeddings = HuggingFaceEmbeddings(model_name="all-MiniLM-L6-v2")
    return FAISS.from_documents(chunks, embeddings)


# ── Build conversational chain ────────────────────────────────────────────────
def build_chain(vector_store: FAISS) -> ConversationalRetrievalChain:
    """Create a ConversationalRetrievalChain with memory and a system prompt (Groq Edition)."""
    llm = ChatGroq(
        groq_api_key=GROQ_API_KEY,
        model_name="llama-3.1-8b-instant",
        temperature=0.4,
    )

    memory = ConversationBufferMemory(
        memory_key="chat_history",
        return_messages=True,
        output_key="answer",
    )

    system_prompt_template = SystemMessagePromptTemplate(
        prompt=PromptTemplate(input_variables=["context"], template=SYSTEM_PROMPT)
    )
    human_prompt_template = HumanMessagePromptTemplate(
        prompt=PromptTemplate(input_variables=["question"], template="{question}")
    )
    chat_prompt = ChatPromptTemplate.from_messages(
        [system_prompt_template, human_prompt_template]
    )

    chain = ConversationalRetrievalChain.from_llm(
        llm=llm,
        retriever=vector_store.as_retriever(search_kwargs={"k": 5}),
        memory=memory,
        combine_docs_chain_kwargs={"prompt": chat_prompt},
        return_source_documents=False,
        verbose=False,
    )
    return chain


# ── Startup: load data and build the chain ───────────────────────────────────
print("[INFO] Fetching tour data from Laravel API...")
tours = fetch_tours()

if not tours:
    print("[WARNING] No tours fetched. The chatbot will have no tour data.")
    tours_docs = [Document(page_content="No tours are currently available.")]
else:
    print(f"[INFO] Loaded {len(tours)} tours.")
    tours_docs = tours_to_documents(tours)

vector_store = build_vector_store(tours_docs)
conversation_chain = build_chain(vector_store)
print("[INFO] AI service is ready (Powered by Groq).")


# ── Chat endpoint ─────────────────────────────────────────────────────────────
@app.post("/chat", response_model=ChatResponse)
async def chat(request: ChatRequest):
    """Receive a user question and return the AI assistant's answer."""
    if not request.question.strip():
        raise HTTPException(status_code=400, detail="Question cannot be empty.")

    try:
        result = conversation_chain({"question": request.question})
        return ChatResponse(answer=result["answer"])
    except Exception as e:
        print(f"[ERROR] Chain invocation failed: {e}")
        raise HTTPException(status_code=500, detail="AI service error. Please try again.")


# ── Health check ──────────────────────────────────────────────────────────────
@app.get("/health")
async def health():
    return {"status": "ok", "tours_loaded": len(tours), "provider": "groq"}
