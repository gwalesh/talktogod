@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="display-6 fw-bold text-primary mb-0">Welcome, {{ Auth::user()->name }}!</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Chat Stats -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 bg-gradient">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-primary bg-gradient fs-4 rounded-3 me-3">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h3 class="fs-5 mb-0">Chat Activity</h3>
                        </div>
                        <div class="text-primary fs-1 fw-bold mb-2">
                            {{ Auth::user()->chatHistory()->whereDate('created_at', today())->count() }}
                        </div>
                        <p class="text-muted mb-0">Messages Today</p>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 bg-gradient">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-success bg-gradient fs-4 rounded-3 me-3">
                                <i class="fas fa-crown"></i>
                            </div>
                            <h3 class="fs-5 mb-0">Account Status</h3>
                        </div>
                        <div class="text-success fs-4 fw-bold mb-2">
                            {{ Auth::user()->isPremium() ? 'Premium Member' : 'Free Tier' }}
                        </div>
                        <p class="text-muted mb-0">Current Plan</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 bg-gradient">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon-small d-inline-flex align-items-center justify-content-center text-info bg-gradient fs-4 rounded-3 me-3">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h3 class="fs-5 mb-0">Quick Actions</h3>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('chat.index') }}" class="btn btn-primary">
                                <i class="fas fa-comments me-2"></i>Start New Chat
                            </a>
                            @if(!Auth::user()->isPremium())
                                <a href="{{ route('subscription') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-crown me-2"></i>Upgrade to Premium
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3">
                        <h4 class="card-title mb-0">Recent Activity</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Message</th>
                                        <th>Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(Auth::user()->chatHistory()->latest()->take(5)->get() as $chat)
                                        <tr>
                                            <td>{{ $chat->created_at->format('M d, Y') }}</td>
                                            <td>{{ Str::limit($chat->message, 50) }}</td>
                                            <td>{{ Str::limit($chat->response, 50) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No recent activity</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient {
            background: linear-gradient(to right bottom, #ffffff, #f8f9fa);
        }
        .feature-icon-small {
            width: 48px;
            height: 48px;
            background: rgba(var(--bs-primary-rgb), 0.1);
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</x-app-layout> 