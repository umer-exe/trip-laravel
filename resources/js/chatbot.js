/**
 * chatbot.js — Atlas Tours & Travel AI Assistant
 *
 * Handles user input, sends messages to the Python atlas-ai FastAPI service,
 * and renders responses inside the chatbot widget.
 */

const AI_SERVICE_URL = 'http://127.0.0.1:8005/chat';

document.addEventListener('DOMContentLoaded', () => {
    const input    = document.getElementById('chatbot-input');
    const sendBtn  = document.getElementById('chatbot-send');
    const messages = document.getElementById('chatbot-messages');

    if (!input || !sendBtn || !messages) return; // widget not present on this page

    // ── Helpers ──────────────────────────────────────────────────────────────

    /** Scroll the message list to the latest message. */
    function scrollToBottom() {
        messages.scrollTop = messages.scrollHeight;
    }

    /**
     * Append a message bubble to the chat window.
     * @param {'user'|'bot'} role
     * @param {string} text
     */
    function appendMessage(role, text) {
        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-start space-x-2' + (role === 'user' ? ' justify-end' : '');

        if (role === 'bot') {
            wrapper.innerHTML = `
                <div class="w-7 h-7 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center mt-0.5">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
                    </svg>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm border border-gray-100 max-w-[85%]">
                    <p class="text-sm text-gray-700 whitespace-pre-wrap">${escapeHtml(text)}</p>
                </div>`;
        } else {
            wrapper.innerHTML = `
                <div class="bg-indigo-600 rounded-2xl rounded-tr-sm px-4 py-2.5 shadow-sm max-w-[85%]">
                    <p class="text-sm text-white whitespace-pre-wrap">${escapeHtml(text)}</p>
                </div>`;
        }

        messages.appendChild(wrapper);
        scrollToBottom();
    }

    /**
     * Show an animated "typing…" indicator while waiting for the AI response.
     * Returns the element so it can be removed later.
     */
    function showTypingIndicator() {
        const el = document.createElement('div');
        el.id = 'chatbot-typing';
        el.className = 'flex items-start space-x-2';
        el.innerHTML = `
            <div class="w-7 h-7 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center mt-0.5">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
                </svg>
            </div>
            <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm border border-gray-100">
                <div class="flex space-x-1">
                    <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>
            </div>`;
        messages.appendChild(el);
        scrollToBottom();
        return el;
    }

    /** Escape HTML special characters to prevent XSS. */
    function escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    // ── Main send logic ───────────────────────────────────────────────────────

    async function sendMessage() {
        const question = input.value.trim();
        if (!question) return;

        // Clear input & disable controls while waiting
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        // Show user bubble
        appendMessage('user', question);

        // Show typing indicator
        const typingEl = showTypingIndicator();

        try {
            const response = await fetch(AI_SERVICE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question }),
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();
            typingEl.remove();
            appendMessage('bot', data.answer ?? "Sorry, I didn't get that.");
        } catch (err) {
            typingEl.remove();
            appendMessage('bot', '⚠️ Could not reach the AI service. Please ensure it is running on port 8005.');
            console.error('[Chatbot] Connection Error:', err);
        } finally {
            input.disabled = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    // ── Event listeners ───────────────────────────────────────────────────────

    sendBtn.addEventListener('click', sendMessage);

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
});
