@php
use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-white p-4 border-bottom-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h2 class="h4 mb-0 text-primary">
                                <i class="fas fa-comments me-2"></i>Spiritual Chat
                            </h2>
                            @if(!Auth::user()->isPremium())
                                <a href="{{ route('subscription') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-crown me-1"></i>Upgrade to Premium
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @livewire('chat-component')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .messages-container {
            height: 500px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        .message-content {
            max-width: 80%;
            display: inline-block;
        }
        .user-message {
            text-align: right;
        }
        .user-message .message-content {
            text-align: left;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: var(--bs-primary);
        }
    </style>
</x-app-layout> 