# Atlas AI — Run Instructions

## Prerequisites
- Python 3.10 or higher
- An OpenAI API key

---

## Setup

### 1. Navigate to this folder
```bash
cd atlas-ai
```

### 2. Create and activate a virtual environment
```bash
# Windows
python -m venv venv
venv\Scripts\activate

# macOS / Linux
python -m venv venv
source venv/bin/activate
```

### 3. Install dependencies
```bash
pip install -r requirements.txt
```

### 4. Create your `.env` file
```bash
copy .env.example .env      # Windows
cp .env.example .env        # macOS / Linux
```
Open `.env` and set your `OPENAI_API_KEY`.

---

## Run the AI Service

Make sure the **Laravel app is running first** (on port 8000), then:

```bash
uvicorn app:app --host 0.0.0.0 --port 8001 --reload
```

The service will:
1. Fetch all tour data from `http://localhost:8000/api/tours`
2. Build an in-memory FAISS vector store
3. Start listening on `http://localhost:8001`

---

## Test the endpoint

```bash
curl -X POST http://localhost:8001/chat \
  -H "Content-Type: application/json" \
  -d '{"question": "Show me cheap tours in Pakistan"}'
```

---