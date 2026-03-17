{{--
    Chatbot Partial — Atlas Tours & Travel
    Floating AI travel assistant widget powered by the Python atlas-ai service.
    Styled to match the site's indigo/white card-based design language.
--}}

{{-- ── Floating chatbot widget ─────────────────────────────────────────── --}}
<div
    id="chatbot-widget"
    x-data="{ open: false }"
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end"
>
    {{-- ── Chat window ──────────────────────────────────────────────────── --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        class="mb-4 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden"
        style="height: 480px;"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-indigo-600">
            <div class="flex items-center space-x-2">
                {{-- Bot avatar icon --}}
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-semibold text-sm leading-tight">Atlas AI</p>
                    <p class="text-indigo-200 text-xs">Travel Assistant</p>
                </div>
            </div>
            <button
                @click="open = false"
                class="text-indigo-200 hover:text-white transition p-1 rounded-lg hover:bg-white/10"
                aria-label="Close chat"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Message history --}}
        <div
            id="chatbot-messages"
            class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-gray-50"
        >
            {{-- Initial bot greeting --}}
            <div class="flex items-start space-x-2">
                <div class="w-7 h-7 rounded-full bg-indigo-100 flex-shrink-0 flex items-center justify-center mt-0.5">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
                    </svg>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-2.5 shadow-sm border border-gray-100 max-w-[85%]">
                    <p class="text-sm text-gray-700">
                        👋 Hi! I'm your Atlas travel assistant. Ask me about tours — destinations, prices, highlights, and more!
                    </p>
                </div>
            </div>
        </div>

        {{-- Input area --}}
        <div class="px-3 py-3 bg-white border-t border-gray-100">
            <div class="flex items-center space-x-2">
                <input
                    id="chatbot-input"
                    type="text"
                    placeholder="Ask about tours…"
                    class="flex-1 text-sm bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-transparent transition"
                    autocomplete="off"
                    maxlength="500"
                />
                <button
                    id="chatbot-send"
                    class="flex-shrink-0 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-2.5 transition font-medium text-sm flex items-center space-x-1 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span>Send</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Floating toggle button ───────────────────────────────────────── --}}
    <button
        @click="open = !open"
        class="flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-full shadow-lg hover:shadow-xl transition transform hover:scale-105 font-medium text-sm"
        aria-label="Toggle AI assistant"
    >
        {{-- Bot icon (shown when closed) --}}
        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
        </svg>
        {{-- Close icon (shown when open) --}}
        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span x-show="!open">Ask AI</span>
        <span x-show="open" class="sr-only">Close AI</span>
    </button>
</div>
