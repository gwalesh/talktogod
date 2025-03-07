<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-primary bg-gradient text-white py-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Connect with Divine Wisdom</h1>
                    <p class="lead mb-4">Experience a unique spiritual journey through AI-powered conversations that help you explore life's deepest questions and find divine guidance.</p>
                    <div class="d-grid gap-3 d-sm-flex">
                        @auth
                            <a href="{{ route('chat.index') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-comments me-2"></i>Start Chat
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-user-plus me-2"></i>Get Started
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/meditation.svg') }}" alt="Spiritual Journey" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-primary bg-gradient text-white mb-3">
                            <i class="fas fa-brain fa-2x"></i>
                        </div>
                        <h3 class="fs-4 fw-bold">AI-Powered Wisdom</h3>
                        <p class="text-muted mb-0">Access spiritual insights powered by advanced AI technology, available 24/7 for your guidance.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-primary bg-gradient text-white mb-3">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        <h3 class="fs-4 fw-bold">Personal Growth</h3>
                        <p class="text-muted mb-0">Embark on a journey of self-discovery and spiritual development with personalized guidance.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 text-center">
                        <div class="feature-icon bg-primary bg-gradient text-white mb-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="fs-4 fw-bold">Community Support</h3>
                        <p class="text-muted mb-0">Join a community of spiritual seekers and share your journey with like-minded individuals.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-light py-5">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="{{ asset('images/enlightenment.svg') }}" alt="Spiritual Enlightenment" class="img-fluid">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-3">Ready to Begin Your Journey?</h2>
                    <p class="lead mb-4">Start your spiritual conversation today and discover the answers you've been seeking.</p>
                    @auth
                        <a href="{{ route('chat.index') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-comments me-2"></i>Start Your Journey
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Join Now
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <style>
        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .bg-gradient {
            background: linear-gradient(45deg, var(--bs-primary), #0056b3);
        }
    </style>
</x-app-layout> 