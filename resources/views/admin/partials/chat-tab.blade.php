<div class="flex flex-col md:flex-row gap-0 h-[calc(100vh-18rem)] min-h-[400px]" style="background:var(--bg-surface);border-radius:18px;border:1px solid var(--border-color);overflow:hidden;">
    {{-- Contact List --}}
    <div class="w-full md:w-72 flex-shrink-0 flex flex-col max-h-48 md:max-h-none border-b md:border-b-0 md:border-r" style="border-color:var(--border-color);">
        <div class="px-4 py-3 flex-shrink-0" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
            <h3 class="font-gaming font-bold text-sm" style="color:var(--text-primary);">Percakapan</h3>
            <div class="mt-2 relative">
                <input type="text" id="chat-search" placeholder="Cari kontak..." class="w-full px-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface-2);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
        </div>
        <div id="chat-contact-list" class="flex-1 overflow-y-auto">
            <div class="flex items-center justify-center py-8">
                <div class="w-5 h-5 border-2 rounded-full animate-spin" style="border-color:var(--border-color);border-top-color:var(--color-accent);"></div>
            </div>
        </div>
    </div>

    {{-- Chat Area --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Chat Header --}}
        <div id="chat-header" class="px-5 py-3 flex-shrink-0 hidden items-center gap-3" style="border-bottom:1px solid var(--border-color);background:var(--bg-surface);">
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0" style="background:linear-gradient(135deg,#7c3aed,#3b82f6);">
                <span id="chat-partner-initials">--</span>
            </div>
            <div class="min-w-0 flex-1">
                <p id="chat-partner-name" class="text-sm font-semibold truncate" style="color:var(--text-primary);">Pilih kontak</p>
                <p id="chat-partner-role" class="text-xs" style="color:var(--text-muted);">-</p>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chat-messages" class="flex-1 overflow-y-auto px-5 py-4 space-y-3" style="background:var(--bg-base);">
            <div class="flex items-center justify-center h-full">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-2" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-sm" style="color:var(--text-muted);">Pilih kontak untuk memulai chat</p>
                </div>
            </div>
        </div>

        {{-- Input --}}
        <div id="chat-input-area" class="px-5 py-3 hidden" style="border-top:1px solid var(--border-color);background:var(--bg-surface);">
            <form id="chat-form" class="flex items-center gap-3">
                <input type="text" id="chat-input" placeholder="Ketik pesan..." autocomplete="off" class="flex-1 px-4 py-2.5 rounded-xl text-sm" style="background:var(--bg-surface-2);border:1px solid var(--border-color);color:var(--text-primary);outline:none;" required>
                <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-medium transition flex-shrink-0" style="background:linear-gradient(135deg,#7c3aed,#3b82f6);color:#fff;border:none;box-shadow:0 2px 8px rgba(124,58,237,0.3);cursor:pointer;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-7 7m7-7l7 7"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var chatState = {
        activeUserId: null,
        pollingInterval: null,
        typingTimeout: null,
    };

    function initChat() {
        loadConversations();
        startPolling();
    }

    function loadConversations() {
        fetch('{{ route("admin.chat.conversations") }}')
            .then(r => r.json())
            .then(data => {
                var list = document.getElementById('chat-contact-list');
                if (data.conversations.length === 0) {
                    list.innerHTML = '<div class="px-4 py-6 text-center text-xs" style="color:var(--text-muted);">Belum ada percakapan</div>';
                    return;
                }
                var html = '';
                data.conversations.forEach(function(c) {
                    var initials = c.user.name.split(' ').map(function(s) { return s[0]; }).join('').toUpperCase().substring(0, 2);
                    var isActive = chatState.activeUserId === c.user.id;
                    var time = c.last_time ? formatChatTime(c.last_time) : '';
                    var unreadBadge = c.unread > 0 ? '<span class="ml-auto px-1.5 py-0.5 rounded-full text-[10px] font-bold" style="background:#7c3aed;color:#fff;">' + c.unread + '</span>' : '';
                    html += '<div class="contact-item px-3 py-2.5 flex items-center gap-3 transition cursor-pointer" style="' + (isActive ? 'background:var(--bg-surface-2);' : '') + 'border-bottom:1px solid var(--border-color);" onclick="selectContact(' + c.user.id + ',\'' + c.user.name + '\',\'' + c.user.role + '\')" onmouseover="this.style.background=\'var(--bg-surface-2)\'" onmouseout="this.style.background=\'' + (isActive ? 'var(--bg-surface-2)' : 'transparent') + '\'">';
                    html += '<div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0" style="background:linear-gradient(135deg,#7c3aed,#3b82f6);">' + initials + '</div>';
                    html += '<div class="min-w-0 flex-1"><p class="text-sm font-medium truncate" style="color:var(--text-primary);">' + c.user.name + '</p><p class="text-xs truncate" style="color:var(--text-muted);">' + (c.last_message || 'Belum ada pesan') + '</p></div>';
                    html += '<div class="flex-shrink-0 text-right"><p class="text-[10px]" style="color:var(--text-muted);">' + time + '</p>' + unreadBadge + '</div>';
                    html += '</div>';
                });
                list.innerHTML = html;
                updateUnreadBadge(data.total_unread);
            }).catch(function() {});
    }

    function selectContact(userId, name, role) {
        chatState.activeUserId = userId;
        document.getElementById('chat-header').classList.remove('hidden');
        document.getElementById('chat-input-area').classList.remove('hidden');
        document.getElementById('chat-partner-name').textContent = name;
        document.getElementById('chat-partner-role').textContent = role;
        document.getElementById('chat-partner-initials').textContent = name.split(' ').map(function(s) { return s[0]; }).join('').toUpperCase().substring(0, 2);

        loadConversations();
        loadMessages(userId);
    }

    function loadMessages(userId) {
        var container = document.getElementById('chat-messages');
        container.innerHTML = '<div class="flex items-center justify-center py-8"><div class="w-5 h-5 border-2 rounded-full animate-spin" style="border-color:var(--border-color);border-top-color:var(--color-accent);"></div></div>';

        fetch('{{ route("admin.chat.messages") }}?with=' + userId)
            .then(r => r.json())
            .then(data => {
                container.innerHTML = '';
                if (data.messages.length === 0) {
                    container.innerHTML = '<div class="flex items-center justify-center h-full"><p class="text-sm" style="color:var(--text-muted);">Belum ada pesan. Mulai percakapan!</p></div>';
                    return;
                }
                data.messages.forEach(function(m) {
                    appendMessage(m);
                });
                scrollChatBottom();
            }).catch(function() {
                container.innerHTML = '<div class="flex items-center justify-center h-full"><p class="text-sm" style="color:var(--text-muted);">Gagal memuat pesan</p></div>';
            });
    }

    function appendMessage(m) {
        var container = document.getElementById('chat-messages');
        var isMine = m.sender_id === {{ auth()->id() }};
        var time = new Date(m.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        var wrapper = document.createElement('div');
        wrapper.className = 'flex ' + (isMine ? 'justify-end' : 'justify-start');
        wrapper.innerHTML = '<div class="max-w-[85%] sm:max-w-[75%] px-4 py-2.5 rounded-2xl text-sm leading-relaxed break-words" style="background:' + (isMine ? 'linear-gradient(135deg,#7c3aed,#3b82f6)' : 'var(--bg-surface-2)') + ';color:' + (isMine ? '#fff' : 'var(--text-primary)') + ';border-bottom-' + (isMine ? 'right' : 'left') + '-radius:4px;"><p>' + escapeHtml(m.message) + '</p><p class="text-xs mt-1" style="opacity:0.7;text-align:' + (isMine ? 'right' : 'left') + ';">' + time + '</p></div>';
        container.appendChild(wrapper);
    }

    function scrollChatBottom() {
        var container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    }

    function sendMessage() {
        var input = document.getElementById('chat-input');
        var text = input.value.trim();
        if (!text || !chatState.activeUserId) return;

        var formData = new FormData();
        formData.append('receiver_id', chatState.activeUserId);
        formData.append('message', text);

        fetch('{{ route("admin.chat.send") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
        })
        .then(r => r.json())
        .then(function(data) {
            input.value = '';
            appendMessage(data.message);
            scrollChatBottom();
            loadConversations();
        }).catch(function() {
            showFloatingNotification('Gagal mengirim pesan', '#ef4444');
        });
    }

    function startPolling() {
        if (chatState.pollingInterval) clearInterval(chatState.pollingInterval);
        chatState.pollingInterval = setInterval(function() {
            if (chatState.activeUserId) {
                fetch('{{ route("admin.chat.messages") }}?with=' + chatState.activeUserId + '&t=' + Date.now())
                    .then(r => r.json())
                    .then(function(data) {
                        var container = document.getElementById('chat-messages');
                        var existingIds = new Set();
                        container.querySelectorAll('[data-msg-id]').forEach(function(el) {
                            existingIds.add(parseInt(el.dataset.msgId));
                        });
                        data.messages.forEach(function(m) {
                            if (!existingIds.has(m.id)) {
                                var el = document.createElement('div');
                                el.dataset.msgId = m.id;
                                appendMessage(m);
                            }
                        });
                        scrollChatBottom();
                    }).catch(function() {});
            }
            loadConversations();
        }, 5000);
    }

    function updateUnreadBadge(count) {
        var badge = document.getElementById('chat-unread-badge');
        if (!badge) {
            badge = document.createElement('span');
            badge.id = 'chat-unread-badge';
            badge.className = 'topbar-badge';
            var btn = document.querySelector('[data-chat-btn]');
            if (btn) btn.appendChild(badge);
        }
        badge.textContent = count;
        badge.classList.toggle('hidden', count === 0);
    }

    function formatChatTime(dateStr) {
        var d = new Date(dateStr);
        var now = new Date();
        var diff = (now - d) / 1000;
        if (diff < 60) return 'baru';
        var mins = Math.floor(diff / 60);
        if (mins < 60) return mins + 'm';
        var hours = Math.floor(mins / 60);
        if (hours < 24) return hours + 'j';
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('chat-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                sendMessage();
            });
        }
        var searchInput = document.getElementById('chat-search');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                var q = this.value.toLowerCase();
                document.querySelectorAll('.contact-item').forEach(function(el) {
                    var name = el.querySelector('p').textContent.toLowerCase();
                    el.style.display = name.includes(q) ? 'flex' : 'none';
                });
            });
        }
    });

    function showFloatingNotification(msg, color) {
        var el = document.createElement('div');
        el.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:12px 20px;border-radius:12px;background:' + color + ';color:#fff;font-size:13px;font-weight:500;box-shadow:0 4px 20px rgba(0,0,0,0.3);opacity:0;transform:translateY(10px);transition:all 0.3s ease;';
        el.textContent = msg;
        document.body.appendChild(el);
        requestAnimationFrame(function() { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; });
        setTimeout(function() { el.style.opacity = '0'; el.style.transform = 'translateY(10px)'; setTimeout(function() { el.remove(); }, 300); }, 3000);
    }
</script>
@endpush
