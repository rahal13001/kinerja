<?php

namespace App\Livewire;

use App\Services\GeminiService;
use Livewire\Component;

class AiChatWidget extends Component
{
    public $isOpen = false;
    public $messages = [];
    public $newMessage = '';
    public $isLoading = false;

    public function mount()
    {
        $this->messages = [
            ['role' => 'assistant', 'content' => 'Halo! Saya asisten AI Kinerja LPSPL Sorong. Ada yang bisa saya bantu terkait data kinerja tahun ini?']
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public $lastMessageTime = null;

    public function sendMessage(GeminiService $geminiService)
    {
        if (empty(trim($this->newMessage))) {
            return;
        }

        // Add user message
        $this->messages[] = ['role' => 'user', 'content' => $this->newMessage];
        $userMessage = $this->newMessage;
        $this->newMessage = '';
        
        // Artificial delay for better UX (2 seconds)
        sleep(2);

        // Dispatch job or call service directly (using direct call for simplicity on shared hosting)
        try {
            $response = $geminiService->generateResponse($userMessage);
            $this->messages[] = ['role' => 'assistant', 'content' => $response];
        } catch (\Exception $e) {
            $this->messages[] = ['role' => 'assistant', 'content' => 'Maaf, terjadi kesalahan saat memproses pesan Anda.'];
        }
    }

    public function render()
    {
        return view('livewire.ai-chat-widget');
    }
}
