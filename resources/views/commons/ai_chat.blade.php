<div id="desa-ai-chat-widget" class="fixed flex flex-col items-end" style="z-index: 9999; bottom: 24px; right: 24px;">

    <!-- Chat Window -->
    <div id="chat-window"
        class="bg-white rounded-2xl shadow-2xl w-[90vw] sm:w-[380px] h-[500px] max-h-[80vh] mb-4 flex flex-col transition-all duration-300 transform translate-y-4 opacity-0 pointer-events-auto hidden border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="bg-green-700 p-4 flex justify-between items-center shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <img src="{{ theme_asset('icons/ai-icon.png') }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="font-bold text-white text-base">AI Asisten {{ ucfirst(setting('sebutan_desa')) }}
                        {{ ucwords($desa['nama_desa']) }}
                    </h3>
                    <p class="text-white text-xs">Online • Siap membantu</p>
                </div>
            </div>
            <button id="close-chat"
                class="text-white/80 hover:text-white hover:bg-white/10 p-1.5 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 scroll-smooth">
            <!-- Welcome Message -->
            <div class="flex gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 border border-green-200 overflow-hidden"
                    style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; flex-shrink: 0;">
                    <img src="{{ theme_asset('icons/ai-icon.png') }}" class="w-full h-full shadow-sm object-cover"
                        style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 max-w-[85%]">
                    <p class="text-sm text-gray-700">Halo! Saya asisten virtual {{ ucfirst(setting('sebutan_desa')) }}
                        {{ ucwords($desa['nama_desa']) }}. Ada yang bisa saya bantu terkait
                        informasi desa?
                    </p>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-white border-t border-gray-100 shrink-0">
            <form id="chat-form" class="relative flex items-end gap-2">
                <textarea id="chat-input" rows="1" placeholder="Ketik pertanyaan Anda..."
                    class="w-full py-2.5 pl-4 pr-10 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500/20 focus:border-green-500 text-sm resize-none max-h-24 scrollbar-hide text-gray-700"
                    required></textarea>
                <button type="submit" id="send-btn"
                    class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed shadow-sm shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
            <div class="text-center mt-2">
                <a href="https://opendesa.id/tema-pro-opensid/" target="_blank"
                    class="text-[10px] text-gray-400">Didukung oleh Tema Perwira</a>
            </div>
        </div>
    </div>

    <!-- AI Welcome Message Tooltip -->
    <div id="ai-chat-tooltip"
        class="mb-4 mr-4 bg-white text-gray-800 text-sm p-4 rounded-xl shadow-lg border border-green-100 max-w-[280px] relative transform transition-all duration-500 opacity-0 translate-y-4 hidden origin-bottom-right pointer-events-auto">
        <div class="flex items-start gap-3">
            <div
                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0 border border-green-200">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-900">Halo! Saya Ai Asisten {{ ucfirst(setting('sebutan_desa')) }}
                    {{ ucwords($desa['nama_desa']) }}
                </p>
                <p class="text-xs text-gray-600 mt-1">Kamu bisa tanya apa saja disini.</p>
            </div>
            <button onclick="document.getElementById('ai-chat-tooltip').remove()"
                class="text-gray-400 hover:text-gray-600 -mt-1 -mr-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <!-- Arrow -->
        <div class="absolute -bottom-2 right-8 w-4 h-4 bg-white border-b border-r border-green-100 transform rotate-45">
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="toggle-chat"
        class="group mb-4 p-3 rounded-full transition-all duration-300 pointer-events-auto flex items-center justify-center gap-2 relative overflow-hidden animate-pulse-green">
        <span
            class="absolute hover:scale-105 inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
        <img src="{{ theme_asset('icons/ai-icon.png') }}" class="w-10 h-10 relative z-10 object-cover rounded-full">
        <span
            class="font-semibold text-sm pr-1 relative z-10 hidden group-hover:block transition-all duration-300">Chat</span>
    </button>
</div>


<!-- Load AI Chat CSS -->
<link rel="stylesheet" href="{{ theme_asset('css/ai_chat.css') }}">

<!-- Load Marked.js for Markdown rendering -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<!-- AI Chat Configuration -->
<script>
    window.DESA_AI_CONFIG = {
        apiUrl: 'https://ai-assistant.digidesa.id',
        apiKey: '1b7b39be-a750-48ad-9090-629b1c6fd6e9',
        villageUrl: '{{ site_url("/") }}',
        iconUrl: '{{ theme_asset("icons/ai-icon.png") }}'
    };
</script>

<!-- Load AI Chat Widget JS -->
<script src="{{ theme_asset('js/ai_chat_widget.js') }}"></script>