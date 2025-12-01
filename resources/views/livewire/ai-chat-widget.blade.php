<div style="position: fixed; bottom: 24px; right: 24px; z-index: 9999;">
    <style>
        .chat-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 0.5rem; }
        .chat-content ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 0.5rem; }
        .chat-content p { margin-bottom: 0.5rem; }
        .chat-content p:last-child { margin-bottom: 0; }
        .chat-content strong { font-weight: 600; }

        .chat-window {
            position: absolute;
            bottom: 100%;
            right: 0;
            margin-bottom: 16px;
            width: 450px;
            height: 600px;
            max-height: 80vh;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        @media (max-width: 640px) {
            .chat-window {
                width: calc(100vw - 48px); /* Full width minus margins (24px left + 24px right) */
                height: 70vh;
                position: fixed; /* Fix to viewport on mobile */
                bottom: 90px; /* Above the FAB */
                right: 24px; /* Align with FAB */
                margin-bottom: 0;
            }
        }
    </style>

    <!-- Floating Action Button -->
    <div>
        <button wire:click="toggleChat" class="bg-amber-500 hover:bg-amber-600 text-white rounded-full p-4 shadow-lg transition-transform transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
            @if($isOpen)
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            @endif
        </button>
    </div>

    <!-- Chat Window -->
    @if($isOpen)
        <div class="chat-window">
            <!-- Header -->
            <div class="bg-amber-500 p-4 flex items-center justify-between">
                <h3 class="text-white font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Asisten Kinerja AI
                </h3>
                <button wire:click="toggleChat" class="text-white hover:text-gray-200 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- Messages Area -->
            <div class="flex-1 p-4 overflow-y-auto bg-gray-50" id="chat-messages">
                @foreach($messages as $msg)
                    <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }} mb-4">
                        <div class="max-w-[80%] rounded-lg px-4 py-3 text-sm {{ $msg['role'] === 'user' ? 'bg-amber-500 text-white rounded-br-none' : 'bg-white text-gray-800 border border-gray-200 rounded-bl-none shadow-sm' }}">
                            <div class="chat-content {{ $msg['role'] === 'user' ? 'text-white' : 'text-gray-800' }}">
                                {!! Str::markdown($msg['content']) !!}
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Loading Indicator -->
                <div wire:loading wire:target="sendMessage" class="flex justify-start mb-4">
                    <div class="bg-white text-gray-800 border border-gray-200 rounded-lg rounded-bl-none shadow-sm px-4 py-3 text-sm flex items-center gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form wire:submit.prevent="sendMessage" class="flex gap-2">
                    <input 
                        wire:model="newMessage" 
                        type="text" 
                        placeholder="Tanya tentang capaian kinerja..." 
                        class="flex-1 border-gray-300 rounded-full text-sm focus:border-amber-500 focus:ring-amber-500 shadow-sm px-4"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                    >
                    <button 
                        type="submit" 
                        class="bg-amber-500 text-white rounded-full p-2 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        wire:loading.attr="disabled"
                        wire:target="sendMessage"
                    >
                        <div wire:loading wire:target="sendMessage">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <div wire:loading.remove wire:target="sendMessage">
                            <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <script>
            // Auto-scroll to bottom when messages update
            document.addEventListener('livewire:initialized', () => {
                const messagesContainer = document.getElementById('chat-messages');
                
                Livewire.hook('morph.updated', ({ component, el }) => {
                    if (messagesContainer) {
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    }
                });
            });
        </script>
    @endif
</div>
