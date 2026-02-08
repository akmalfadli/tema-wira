/**
 * AI Chat Widget JavaScript
 * Extracted from ai_chat.blade.php for better maintainability
 * 
 * Requires: 
 * - window.DESA_AI_CONFIG object with apiUrl, apiKey, villageUrl, iconUrl
 * - marked.js library for markdown parsing
 */

// Desa AI Assistant Class Definition
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

// ========================================
// JDIH SEARCH INTEGRATION
// ========================================

/**
 * Check if user message is a JDIH search query
 */
function isJdihSearchMode(message) {
    const triggers = [
        'cari peraturan', 'cari hukum', 'cari regulasi',
        'perbup ', 'perda ', 'pergub ', 'permen ',
        'uu ', 'undang-undang', 'peraturan daerah',
        'peraturan bupati', 'peraturan gubernur',
        'jdih', 'hukum daerah'
    ];
    const lowerMessage = message.toLowerCase();
    return triggers.some(t => lowerMessage.includes(t));
}

/**
 * Search JDIH API
 */
async function searchJdih(params) {
    const queryParams = new URLSearchParams();
    if (params.keywords) queryParams.append('keywords', params.keywords);
    if (params.tentang) queryParams.append('tentang', params.tentang);
    if (params.tahun) queryParams.append('tahun', params.tahun);
    if (params.page) queryParams.append('page', params.page);

    try {
        const response = await fetch(`/api/jdih/search?${queryParams}`);
        if (!response.ok) {
            throw new Error('Gagal mengambil data JDIH');
        }
        return await response.json();
    } catch (error) {
        console.error('JDIH Search Error:', error);
        throw error;
    }
}

/**
 * Extract search keywords from user message
 */
function extractJdihKeywords(message) {
    // Remove common trigger words to get the actual search terms
    const removeWords = [
        'cari', 'carikan', 'tolong', 'bantu', 'peraturan', 'hukum', 'regulasi',
        'tentang', 'mengenai', 'terkait', 'yang', 'ada', 'apa', 'saya', 'mau'
    ];
    let cleaned = message.toLowerCase();
    removeWords.forEach(word => {
        cleaned = cleaned.replace(new RegExp(`\\b${word}\\b`, 'gi'), '');
    });
    return cleaned.trim().replace(/\s+/g, ' ');
}

/**
 * Render JDIH search results as HTML
 */
function renderJdihResults(data, meta) {
    if (!data || data.length === 0) {
        return `
            <div class="text-center py-4">
                <div class="text-4xl mb-2">📭</div>
                <p class="text-gray-500">Tidak ditemukan peraturan yang sesuai.</p>
                <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci yang berbeda.</p>
            </div>
        `;
    }

    let html = `
        <div class="jdih-results">
            <div class="text-sm text-gray-500 mb-3">
                📋 Ditemukan <strong>${meta?.total || data.length}</strong> peraturan
            </div>
    `;

    data.forEach(item => {
        html += `
            <div class="jdih-card">
                <div class="jdih-card-header">
                    <span class="jdih-badge">${item.jenis || 'Peraturan'}</span>
                    <span class="jdih-year">${item.tahun || '-'}</span>
                </div>
                <h4 class="jdih-title">${item.judul || 'Tanpa Judul'}</h4>
                ${item.tentang ? `<p class="jdih-desc">${item.tentang}</p>` : ''}
                <div class="jdih-meta">
                    ${item.nomor ? `<span>No. ${item.nomor}</span>` : ''}
                    ${item.status ? `<span class="jdih-status jdih-status-${item.status.toLowerCase().replace(/\s+/g, '-')}">${item.status}</span>` : ''}
                </div>
                ${item.download_url ? `
                    <a href="${item.download_url}" target="_blank" rel="noopener noreferrer" class="jdih-download">
                        📄 Download PDF
                    </a>
                ` : ''}
            </div>
        `;
    });

    // Pagination info
    if (meta && meta.last_page > 1) {
        html += `
            <div class="jdih-pagination">
                Halaman ${meta.current_page} dari ${meta.last_page}
            </div>
        `;
    }

    html += '</div>';
    return html;
}

// Initialize Chat Widget
document.addEventListener('DOMContentLoaded', function () {
    // Get configuration from global object
    const config = window.DESA_AI_CONFIG || {};

    const widget = document.getElementById('desa-ai-chat-widget');
    const chatWindow = document.getElementById('chat-window');
    const toggleBtn = document.getElementById('toggle-chat');
    const closeBtn = document.getElementById('close-chat');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const messagesContainer = document.getElementById('chat-messages');
    const sendBtn = document.getElementById('send-btn');
    const tooltip = document.getElementById('ai-chat-tooltip');

    // JDIH Elements
    const jdihSearchPanel = document.getElementById('jdih-search-panel');
    const jdihResultsContainer = document.getElementById('jdih-results-container');
    const jdihSearchForm = document.getElementById('jdih-search-form');
    const jdihSearchBtn = document.getElementById('jdih-search-btn');
    const exitJdihModeBtn = document.getElementById('exit-jdih-mode');
    const toggleJdihFiltersBtn = document.getElementById('toggle-jdih-filters');
    const jdihAdvancedFilters = document.getElementById('jdih-advanced-filters');
    const filterArrow = document.getElementById('filter-arrow');

    let assistant = null;
    let isChatOpen = false;
    let isJdihMode = false;

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
            apiUrl: config.apiUrl || 'https://ai-assistant.digidesa.id',
            apiKey: config.apiKey || '',
            villageUrl: config.villageUrl || window.location.origin
        });
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

    // ========================================
    // JDIH MODE HANDLERS
    // ========================================

    /**
     * Enter JDIH search mode
     */
    function enterJdihMode(initialKeywords = '') {
        isJdihMode = true;

        // Show JDIH panel and results container
        if (jdihSearchPanel) {
            jdihSearchPanel.classList.remove('hidden');
            jdihSearchPanel.classList.add('flex');
        }
        if (jdihResultsContainer) {
            jdihResultsContainer.classList.remove('hidden');
        }

        // Hide chat messages and input
        if (messagesContainer) {
            messagesContainer.classList.add('hidden');
        }

        // Pre-fill keywords if provided
        const keywordsInput = document.getElementById('jdih-keywords');
        if (keywordsInput && initialKeywords) {
            keywordsInput.value = initialKeywords;
        }

        // Expand chat for better view
        expandChat();
    }

    /**
     * Exit JDIH search mode
     */
    function exitJdihMode() {
        isJdihMode = false;

        // Hide JDIH panel and results container
        if (jdihSearchPanel) {
            jdihSearchPanel.classList.add('hidden');
            jdihSearchPanel.classList.remove('flex');
        }
        if (jdihResultsContainer) {
            jdihResultsContainer.classList.add('hidden');
            jdihResultsContainer.innerHTML = '';
        }

        // Show chat messages
        if (messagesContainer) {
            messagesContainer.classList.remove('hidden');
        }

        // Clear JDIH form
        if (jdihSearchForm) {
            jdihSearchForm.reset();
        }

        // Collapse advanced filters
        if (jdihAdvancedFilters) {
            jdihAdvancedFilters.classList.add('hidden');
        }
        if (filterArrow) {
            filterArrow.classList.remove('rotate-180');
        }
    }

    // Exit JDIH mode button
    if (exitJdihModeBtn) {
        exitJdihModeBtn.addEventListener('click', exitJdihMode);
    }

    // Toggle advanced filters
    if (toggleJdihFiltersBtn && jdihAdvancedFilters && filterArrow) {
        toggleJdihFiltersBtn.addEventListener('click', function () {
            jdihAdvancedFilters.classList.toggle('hidden');
            filterArrow.classList.toggle('rotate-180');
        });
    }

    // JDIH Search Form Submit
    if (jdihSearchForm) {
        jdihSearchForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(jdihSearchForm);
            const params = {
                keywords: formData.get('keywords') || '',
                tentang: formData.get('tentang') || '',
                nomor: formData.get('nomor') || '',
                tahun: formData.get('tahun') || '',
                jenis: formData.get('jenis') || ''
            };

            // Show loading state
            if (jdihSearchBtn) {
                jdihSearchBtn.disabled = true;
                jdihSearchBtn.innerHTML = '<span class="animate-spin">⏳</span> Mencari...';
            }
            if (jdihResultsContainer) {
                jdihResultsContainer.innerHTML = '<div class="text-center py-8"><div class="animate-pulse text-4xl mb-2">🔍</div><p class="text-gray-500">Mencari peraturan...</p></div>';
            }

            try {
                const results = await searchJdih(params);
                if (jdihResultsContainer) {
                    jdihResultsContainer.innerHTML = renderJdihResults(results.data, results.meta);
                }
            } catch (error) {
                console.error('JDIH Search Error:', error);
                if (jdihResultsContainer) {
                    jdihResultsContainer.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-4xl mb-2">⚠️</div>
                            <p class="text-red-500 font-medium">Gagal mencari peraturan</p>
                            <p class="text-sm text-gray-500 mt-1">${error.message || 'Terjadi kesalahan. Silakan coba lagi.'}</p>
                        </div>
                    `;
                }
            } finally {
                if (jdihSearchBtn) {
                    jdihSearchBtn.disabled = false;
                    jdihSearchBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cari Peraturan';
                }
            }
        });
    }

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

        const iconUrl = config.iconUrl || '';
        const avatar = isUser ? `
            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center shrink-0 border border-gray-300">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        ` : `
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 border border-green-200 overflow-hidden" style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; flex-shrink: 0;">
                <img src="${iconUrl}" class="w-full h-full object-cover" style="width: 100%; height: 100%; object-fit: cover;">
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
        if (!message) return;

        // Reset Input
        chatInput.value = '';
        chatInput.style.height = 'auto';

        // Add User Message
        addMessage('user', message);

        // Check if this is a JDIH search
        if (isJdihSearchMode(message)) {
            // Switch to JDIH Advanced Search Mode
            const keywords = extractJdihKeywords(message);

            // Add assistant message to guide user
            addMessage('assistant', '📚 Membuka pencarian peraturan JDIH...\n\nSaya akan membuka panel pencarian peraturan. Anda bisa menggunakan filter lanjutan untuk pencarian yang lebih spesifik.');

            // Enter JDIH mode with extracted keywords
            setTimeout(() => {
                enterJdihMode(keywords);
            }, 500);

            return;
        } else if (assistant) {
            // Normal AI Chat Mode
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
                        const errorMessage = error.message.replace(/^Error:\s*/, '') || 'Maaf, terjadi kesalahan saat menghubungi asisten. Silakan coba lagi.';
                        aiResponseContainer.innerHTML = `<div class="text-red-500 font-medium">${formatText(errorMessage)}</div>`;
                        sendBtn.disabled = false;
                    }
                );
            } catch (err) {
                console.error('Submission Error:', err);
                sendBtn.disabled = false;
            }
        }
    });
});
