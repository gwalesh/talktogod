<div>
    <div class="messages-container mb-4 bg-light rounded-3 p-3" id="messages">
        @if($error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endif
        
        @forelse($messages as $message)
            <div class="message {{ $message['role'] === 'user' ? 'user-message' : 'assistant-message' }} mb-3">
                <div class="message-content {{ $message['role'] === 'user' ? 'bg-primary text-white' : 'bg-white border' }} p-3 rounded-3 shadow-sm">
                    @if($message['role'] === 'user')
                        {{ $message['content'] }}
                    @else
                        <div class="markdown-content">
                            {!! $this->parseMarkdown($message['content']) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="fas fa-comment-dots fa-3x mb-3"></i>
                <p>Start your spiritual conversation...</p>
            </div>
        @endforelse

        @if($isLoading)
            <div class="message assistant-message mb-3">
                <div class="message-content bg-white border p-3 rounded-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Getting response from divine wisdom...
                    </div>
                </div>
            </div>
        @endif
    </div>

    <form wire:submit.prevent="sendMessage" class="message-form">
        <div class="input-group">
            <input type="text" 
                wire:model.live="message" 
                class="form-control form-control-lg border-2 rounded-start-3" 
                placeholder="Type your spiritual question..." 
                required
                {{-- wire:loading.attr="readonly" --}}
                autocomplete="off">
            <button type="submit" 
                class="btn btn-primary px-4 rounded-end-3" 
                wire:loading.attr="disabled"
                wire:target="sendMessage">
                <span wire:loading.remove wire:target="sendMessage">
                    <i class="fas fa-paper-plane me-2"></i>Send
                </span>
                <span wire:loading wire:target="sendMessage">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Sending...
                </span>
            </button>
        </div>
    </form>

    <script>
        // Scroll to bottom when new messages arrive
        document.addEventListener('livewire:initialized', () => {
            const messagesContainer = document.getElementById('messages');
            const scrollToBottom = () => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            };

            // Scroll on new messages
            Livewire.on('messageAdded', scrollToBottom);

            // Initial scroll
            scrollToBottom();
        });
    </script>

    <style>
        .markdown-content {
            line-height: 1.6;
        }
        .markdown-content p {
            margin-bottom: 1rem;
        }
        .markdown-content strong {
            font-weight: 600;
        }
        .markdown-content ul, .markdown-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .markdown-content h1, .markdown-content h2, .markdown-content h3, 
        .markdown-content h4, .markdown-content h5, .markdown-content h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .markdown-content code {
            background-color: rgba(0, 0, 0, 0.05);
            padding: 0.2em 0.4em;
            border-radius: 3px;
            font-size: 0.9em;
        }
        .markdown-content blockquote {
            border-left: 4px solid #e9ecef;
            padding-left: 1rem;
            margin-left: 0;
            color: #6c757d;
        }
    </style>
</div> 