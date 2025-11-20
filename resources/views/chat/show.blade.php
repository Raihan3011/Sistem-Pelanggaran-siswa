@extends('layouts.admin')

@section('content')
<style>
    .chat-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        height: calc(100vh - 180px);
        display: flex;
        flex-direction: column;
    }
    .chat-header-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .chat-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        border: 2px solid white;
    }
    .chat-header-info h3 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
    }
    .chat-header-info p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 25px;
        background: #f8fafc;
    }
    .message-wrapper {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
    }
    .message-wrapper.sent {
        flex-direction: row-reverse;
    }
    .message-bubble {
        max-width: 70%;
        padding: 12px 18px;
        border-radius: 18px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .message-bubble.sent {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .message-bubble.received {
        background: white;
        color: #2d3748;
        border-bottom-left-radius: 4px;
    }
    .message-sender {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 5px;
    }
    .message-text {
        margin: 0;
        line-height: 1.5;
    }
    .message-time {
        font-size: 0.75rem;
        opacity: 0.7;
        margin-top: 5px;
    }
    .chat-input-box {
        padding: 20px 25px;
        background: white;
        border-top: 1px solid #e2e8f0;
    }
    .chat-input-form {
        display: flex;
        gap: 10px;
    }
    .chat-input {
        flex: 1;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 25px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    .chat-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .chat-send-btn {
        padding: 12px 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .chat-send-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .empty-chat {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }
    .empty-chat i {
        font-size: 60px;
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid">
    <div class="chat-container">
        <div class="chat-header-box">
            <a href="{{ route('chat.index') }}" style="color: white; text-decoration: none;">
                <i class="bi bi-arrow-left" style="font-size: 1.5rem;"></i>
            </a>
            <div class="chat-avatar">
                {{ strtoupper(substr($lawan->nama_lengkap, 0, 1)) }}
            </div>
            <div class="chat-header-info">
                <h3>{{ $lawan->nama_lengkap }}</h3>
                <p>{{ $lawan->level_text }}</p>
            </div>
        </div>

        <div class="chat-messages" id="chatBox">
            @forelse($chats as $chat)
                <div class="message-wrapper {{ $chat->pengirim_id == Auth::id() ? 'sent' : 'received' }}">
                    <div class="message-bubble {{ $chat->pengirim_id == Auth::id() ? 'sent' : 'received' }}">
                        <div class="message-sender">{{ $chat->pengirim->nama_lengkap }}</div>
                        <p class="message-text">{{ $chat->pesan }}</p>
                        <div class="message-time">{{ $chat->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-chat">
                    <i class="bi bi-chat-dots"></i>
                    <p>Belum ada pesan. Mulai percakapan dengan mengirim pesan!</p>
                </div>
            @endforelse
        </div>

        <div class="chat-input-box">
            <form action="{{ route('chat.store') }}" method="POST" class="chat-input-form">
                @csrf
                <input type="hidden" name="penerima_id" value="{{ $lawan->user_id }}">
                <input type="text" name="pesan" class="chat-input" placeholder="Ketik pesan..." required autocomplete="off">
                <button type="submit" class="chat-send-btn">
                    <i class="bi bi-send-fill"></i> Kirim
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection
