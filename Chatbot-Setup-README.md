# Atlas Tours & Travel — AI Chatbot Setup (feature/ai-chatbot)

This branch contains the experimental **AI Chatbot** for Atlas Tours & Travel.  
It provides a conversational assistant that helps users explore tour packages and answer questions about destinations, pricing, and highlights.

---

## ⚡ Features

- **RAG (Retrieval-Augmented Generation)** using:
  - **Groq LLM** (credit-free)
  - **FAISS** for vector search
  - **HuggingFace embeddings** for document representation
- Fine-tuned for:
  - Concise answers by default
  - Detailed answers when requested
  - Handling irrelevant or out-of-context questions gracefully
- Frontend integration with **Laravel**, **Tailwind CSS**, and **Alpine.js**
- Conversational memory maintained per user session
- Simple `/chat` and `/health` endpoints

---

## 🛠️ Prerequisites

1. **Python**: 3.11+ recommended
2. **Node.js**: v18+ recommended (for Laravel frontend assets)
3. **Laravel** project set up and running
4. **Groq API Key**: Store in `.env` file

---

## 📁 File Structure


atlas-ai/
├── app.py # Main AI service
├── requirements.txt # Python dependencies
├── .env # Environment variables (GROQ_API_KEY, LARAVEL_API_URL)
└── README.md # Chatbot setup instructions


---

## 🔧 Setup Instructions

### 1. Activate Python Virtual Environment

```bash
# Navigate to the chatbot folder
cd myapp/atlas-ai

# Activate the virtual environment (Windows)
.\venv\Scripts\activate


# Activate the virtual environment (Linux/macOS)
source venv/bin/activate
```

### 2. Install Python Dependencies
```bash
pip install -r requirements.txt
```

- This installs:
- FastAPI, Uvicorn
- LangChain (core + classic + community components)
- Groq and HuggingFace integration
- FAISS vector store
- Python-dotenv for environment variable management

### 3. Configure Environment Variables

Create a .env file in atlas-ai/:

```dotenv
GROQ_API_KEY=your_groq_api_key_here
LARAVEL_API_URL=http://localhost:8000/api/tours
```

GROQ_API_KEY: Your Groq credentials
LARAVEL_API_URL: URL for the Laravel backend tours endpoint

### 4. Run the AI Service

```bash
uvicorn app:app --host 127.0.0.1 --port 8005 --reload
```

The chatbot service will now be accessible at http://127.0.0.1:8005/chat
Health check: http://127.0.0.1:8005/health

### 5. Connect Frontend

Ensure your Laravel project is running and the chatbot.js is included in your layout.
The frontend automatically sends user messages to http://127.0.0.1:8005/chat.

### 6. Optional: Jupyter Notebook for Experimentation

You can test or fine-tune the chatbot logic in a notebook:

# Activate venv
```bash
.\venv\Scripts\activate
```

# Run notebook
```bash
python -m notebook
```

- Open the notebook in the browser
- Import app.py functions to fetch tours, build chains, or test embeddings
- Great for experimenting with prompt templates, temperature settings, or vector retrieval logic

📝 Tips & Notes

- The chatbot is experimental — do not merge into main unless fully tested
- Fine-tuning can be done via:
- Modifying SYSTEM_PROMPT in app.py
- Adjusting temperature or retrieval k value


🚀 Next Steps

- Merge changes into main after more experimenting and fine-tuning
- Experiment with different embedding models or vector stores
- Collect feedback from users to improve prompt design

