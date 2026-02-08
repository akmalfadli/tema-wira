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
        class="group p-3 rounded-full transition-all duration-300 pointer-events-auto flex items-center justify-center gap-2 relative overflow-hidden animate-pulse-green">
        <span
            class="absolute hover:scale-105 inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
        <img src="{{ theme_asset('icons/ai-icon.png') }}" class="w-10 h-10 relative z-10 object-cover rounded-full">
        <span
            class="font-semibold text-sm pr-1 relative z-10 hidden group-hover:block transition-all duration-300">Chat</span>
    </button>
</div>

<!-- Load DesaAIAssistant Script -->


<style>
    /* Custom Markdown Styling for Chat */
    @keyframes pulse-green {

        0%,
        100% {
            background: linear-gradient(135deg, #15803D, #22ed6cff);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }

        50% {
            background: linear-gradient(135deg, #15803D, #22ed6cff);
            box-shadow: 0 0 0 15px rgba(16, 185, 129, 0);
        }
    }

    .animate-pulse-green {
        animation: pulse-green 2s ease-in-out infinite;
    }

    #chat-messages .prose-sm ul {
        list-style-type: disc;
        padding-left: 1.25em;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    #chat-messages .prose-sm ol {
        list-style-type: decimal;
        padding-left: 1.25em;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    #chat-messages .prose-sm a {
        color: #16a34a;
        text-decoration: underline;
    }

    #chat-messages .prose-sm p {
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    #chat-messages .prose-sm strong {
        font-weight: 600;
    }

    #chat-messages .prose-sm img {
        max-width: 100%;
        border-radius: 0.5rem;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }

    #chat-messages .prose-sm blockquote {
        border-left: 4px solid #e5e7eb;
        padding-left: 1em;
        color: #4b5563;
        font-style: italic;
    }

    #chat-messages .prose-sm code {
        background-color: #f3f4f6;
        padding: 0.2em 0.4em;
        border-radius: 0.25em;
        font-size: 0.875em;
    }

    #chat-messages .prose-sm pre {
        background-color: #1f2937;
        color: #f9fafb;
        padding: 1em;
        border-radius: 0.5rem;
        overflow-x: auto;
    }

    #chat-messages .prose-sm pre code {
        background-color: transparent;
        padding: 0;
        color: inherit;
    }
</style>

<script>
    // Desa AI Assistant Class Definition (Embedded for reliability)
    class DesaAIAssistant {
        constructor(options) {
            this.apiUrl = options.apiUrl || '';
            this.apiKey = options.apiKey || '';
            this.villageUrl = options.villageUrl || '';
            this.conversationHistory = [];
        }

        async sendMessage(message, onChunk, onComplete = null, onError = null) {
            try {
                const response = await fetch(`${this.apiUrl}/api/chat`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-API-Key': this.apiKey
                    },
                    body: JSON.stringify({
                        village_url: this.villageUrl,
                        message: message,
                        conversation_history: this.conversationHistory,
                        stream: true
                    })
                });

                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.error || 'Request failed');
                }

                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                let fullResponse = '';

                while (true) {
                    const { done, value } = await reader.read();
                    if (done) break;

                    const chunk = decoder.decode(value);
                    const lines = chunk.split('\n');

                    for (const line of lines) {
                        if (line.startsWith('data: ')) {
                            try {
                                const data = JSON.parse(line.slice(6));

                                if (data.content) {
                                    fullResponse += data.content;
                                    if (onChunk) onChunk(data.content);
                                }

                                if (data.done) {
                                    this.conversationHistory.push(
                                        { role: 'user', content: message },
                                        { role: 'assistant', content: fullResponse }
                                    );
                                    if (this.conversationHistory.length > 20) {
                                        this.conversationHistory = this.conversationHistory.slice(-20);
                                    }
                                    if (onComplete) onComplete(fullResponse, data.cached);
                                }
                            } catch (e) {
                                console.warn('Failed to parse SSE data:', e);
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('DesaAIAssistant error:', error);
                if (onError) onError(error);
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const widget = document.getElementById('desa-ai-chat-widget');
        const chatWindow = document.getElementById('chat-window');
        const toggleBtn = document.getElementById('toggle-chat');
        const closeBtn = document.getElementById('close-chat');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const messagesContainer = document.getElementById('chat-messages');
        const sendBtn = document.getElementById('send-btn');
        const tooltip = document.getElementById('ai-chat-tooltip');

        let assistant = null;
        let isChatOpen = false;

        // Show tooltip on load
        if (tooltip) {
            setTimeout(() => {
                if (!isChatOpen) {
                    tooltip.classList.remove('hidden');
                    // Force reflow
                    void tooltip.offsetWidth;
                    tooltip.classList.remove('opacity-0', 'translate-y-4');
                }
            }, 1000); // 1.0 second delay for entrance
        }

        // Initialize Assistant
        try {
            assistant = new DesaAIAssistant({
                apiUrl: 'http://ai-assistant.digidesa.id/', // Replace with actual API URL if different
                apiKey: '1b7b39be-a750-48ad-9090-629b1c6fd6e9',
                villageUrl: {{base_url()}} || window.location.origin
            });
            console.log('DesaAIAssistant Initialized:', assistant);
        } catch (e) {
            console.error('Failed to initialize DesaAIAssistant:', e);
        }

        // Configure Marked.js to auto-embed image links
        if (typeof marked !== 'undefined') {
            marked.use({
                renderer: {
                    link(href, title, text) {
                        let url = href;
                        let linkText = text;
                        let linkTitle = title;

                        // Handle object argument (if href is object)
                        if (typeof href === 'object' && href !== null) {
                            if (href.href) url = href.href;
                            if (href.text) linkText = href.text;
                            if (href.title) linkTitle = href.title;
                        }

                        if (url && /\.(jpg|jpeg|png|gif|webp|bmp|tiff)$/i.test(url)) {
                            return `<img src="${url}" alt="${linkText || 'Image'}" title="${linkTitle || ''}" class="rounded-lg max-w-full my-2 shadow-sm" loading="lazy" />`;
                        }

                        // Fallback for link text
                        if (!linkText || linkText === 'undefined' || typeof linkText === 'object' || linkText === '[object Object]') {
                            linkText = url;
                        }
                        return `<a href="${url}" title="${linkTitle || ''}" target="_blank" rel="noopener noreferrer">${linkText}</a>`;
                    }
                }
            });
        }

        // Toggle Chat Window
        function toggleChat() {
            // Hide tooltip if visible
            if (tooltip && !tooltip.classList.contains('hidden')) {
                tooltip.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => tooltip.classList.add('hidden'), 300);
            }

            isChatOpen = !isChatOpen;
            if (isChatOpen) {
                chatWindow.classList.remove('hidden');
                // Small delay to allow display block to apply before opacity transition
                setTimeout(() => {
                    chatWindow.classList.remove('translate-y-4', 'opacity-0');
                }, 10);
                chatInput.focus();
                // Lock body scroll on mobile when chat is open
                if (window.innerWidth < 768) {
                    document.body.style.overflow = 'hidden';
                }
            } else {
                chatWindow.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => {
                    chatWindow.classList.add('hidden');
                    shrinkChat(); // Reset to small window on close
                    document.body.style.overflow = ''; // Unlock body scroll
                }, 300);
            }
        }

        // Expand Chat to Fullscreen
        function expandChat() {
            // Remove sizing/positioning classes
            chatWindow.classList.remove('w-[90vw]', 'sm:w-[380px]', 'h-[500px]', 'max-h-[80vh]', 'mb-4', 'rounded-2xl');
            // Add fullscreen classes
            chatWindow.classList.add('fixed', 'inset-0', 'z-[9999]', 'w-full', 'h-full', 'max-h-none', 'rounded-none', 'mb-0');

            // Override inline styles for fullscreen
            widget.style.bottom = '0';
            widget.style.right = '0';
            widget.style.left = '0';
            widget.style.top = '0';
            widget.style.width = '100%';
            widget.style.height = '100%';

            // Lock background scrolling
            document.body.style.overflow = 'hidden';
        }

        // Shrink Chat to Default
        function shrinkChat() {
            // Revert classes
            chatWindow.classList.add('w-[90vw]', 'sm:w-[380px]', 'h-[500px]', 'max-h-[80vh]', 'mb-4', 'rounded-2xl');
            chatWindow.classList.remove('fixed', 'inset-0', 'z-[9999]', 'w-full', 'h-full', 'max-h-none', 'rounded-none', 'mb-0');

            // Revert inline styles
            widget.style.left = '';
            widget.style.top = '';
            widget.style.width = '';
            widget.style.height = '';
            widget.style.right = '24px';
            // Let adjustPosition handle the bottom
            adjustPosition();

            // Unlock background scrolling if on desktop (on mobile toggleChat handles it)
            if (window.innerWidth >= 768) {
                document.body.style.overflow = '';
            }
        }

        // Adjust position for mobile locally to ensure visibility
        function adjustPosition() {
            const widget = document.getElementById('desa-ai-chat-widget');
            if (window.innerWidth < 768) {
                widget.style.bottom = '90px'; // clear mobile nav
            } else {
                widget.style.bottom = '24px';
            }
        }

        window.addEventListener('resize', adjustPosition);
        adjustPosition(); // initial call

        toggleBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);

        // Auto-resize textarea
        chatInput.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Handle Enter key
        chatInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });

        // Helper: Add Message to UI
        function addMessage(role, text) {
            const isUser = role === 'user';
            const div = document.createElement('div');
            div.className = `flex gap-2 ${isUser ? 'flex-row-reverse' : ''}`;

            const avatar = isUser ? `
            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center shrink-0 border border-gray-300">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        ` : `
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 border border-green-200 overflow-hidden" style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; flex-shrink: 0;">
                <img src="${"{{ theme_asset('icons/ai-icon.png') }}"}" class="w-full h-full object-cover" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        `;

            const bubbleClasses = isUser
                ? 'bg-green-600 text-white rounded-tr-none'
                : 'bg-white text-gray-700 rounded-tl-none shadow-sm border border-gray-100';

            div.innerHTML = `
            ${avatar}
            <div class="p-3 rounded-2xl ${bubbleClasses} max-w-[85%] text-sm leading-relaxed prose-sm">
                ${formatText(text)}
            </div>
        `;

            messagesContainer.appendChild(div);
            scrollToBottom();
            return div.querySelector('.prose-sm'); // Return content element for streaming updates
        }

        // Helper: Format Text (Uses Marked.js)
        function formatText(text) {
            if (typeof marked !== 'undefined') {
                return marked.parse(text);
            }
            return text.replace(/\n/g, '<br>'); // Fallback
        }

        // Helper: Scroll to Bottom
        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Handle Form Submit
        chatForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message || !assistant) return;

            // Reset Input
            chatInput.value = '';
            chatInput.style.height = 'auto';

            // Add User Message
            addMessage('user', message);

            // Add Placeholder for AI Response
            const aiResponseContainer = addMessage('assistant', '<span class="animate-pulse">Sedang mengetik...</span>');
            let currentResponse = '';

            try {
                sendBtn.disabled = true;

                await assistant.sendMessage(
                    message,
                    (chunk) => {
                        // On Chunk
                        if (currentResponse === '') {
                            aiResponseContainer.innerHTML = ''; // Clear "typing..."
                            expandChat(); // Trigger fullscreen on first chunk
                        }
                        currentResponse += chunk;
                        aiResponseContainer.innerHTML = formatText(currentResponse);
                        scrollToBottom();
                    },
                    (fullResponse) => {
                        // On Complete
                        sendBtn.disabled = false;
                    },
                    (error) => {
                        // On Error
                        console.error('Chat Error:', error);
                        // Display error message from response.json which was thrown as Error
                        const errorMessage = error.message.replace(/^Error:\s*/, '') || 'Maaf, terjadi kesalahan saat menghubungi asisten. Silakan coba lagi.';
                        aiResponseContainer.innerHTML = `<div class="text-red-500 font-medium">${formatText(errorMessage)}</div>`;
                        sendBtn.disabled = false;
                    }
                );
            } catch (err) {
                console.error('Submission Error:', err);
                sendBtn.disabled = false;
            }
        });
    });
</script>