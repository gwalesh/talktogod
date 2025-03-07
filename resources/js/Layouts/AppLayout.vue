<template>
    <div class="min-h-screen bg-light">
        <nav class="navbar navbar-expand-lg custom-navbar">
            <div class="container">
                <Link class="navbar-brand" :href="route('welcome')">
                    Talk To God
                </Link>
                <button 
                    class="navbar-toggler" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <Link class="nav-link active" :href="route('welcome')">Home</Link>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <template v-if="$page.props.auth.user">
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('dashboard')">Dashboard</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('chat')">Chat</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('profile.edit')">Profile</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('subscription')">Subscription</Link>
                            </li>
                            <li class="nav-item">
                                <Link 
                                    class="nav-link" 
                                    :href="route('logout')" 
                                    method="post" 
                                    as="button"
                                >
                                    Log Out
                                </Link>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('login')">Log in</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" :href="route('register')">Register</Link>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container py-4">
            <slot></slot>
        </main>

        <footer class="bg-dark text-light py-4 mt-auto">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; {{ new Date().getFullYear() }} Talk To God. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <Link class="text-light me-3" :href="route('privacy')">Privacy Policy</Link>
                        <Link class="text-light" :href="route('terms')">Terms of Service</Link>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import * as bootstrap from 'bootstrap';

onMounted(() => {
    // Initialize Bootstrap navbar toggler
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        new bootstrap.Collapse(document.getElementById('navbarNav'), {
            toggle: false
        });
    }
});
</script>

<style scoped>
.custom-navbar {
    background-color: #fb6340 !important;
    padding: 1rem 0;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
    color: #ffffff !important;
}

.nav-link {
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease;
    color: #ffffff !important;
    opacity: 0.9;
}

.nav-link:hover, .nav-link.active {
    color: #ffffff !important;
    opacity: 1;
}

.navbar-toggler {
    border-color: rgba(255, 255, 255, 0.7);
    padding: 0.5rem;
}

.navbar-toggler:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        background-color: #fb6340;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .nav-link {
        padding: 0.75rem 1rem;
    }
}

footer {
    margin-top: auto;
}

/* Fix for button styling in navbar */
.nav-link[type="button"] {
    background: none;
    border: none;
    cursor: pointer;
    color: #ffffff !important;
    opacity: 0.9;
}

.nav-link[type="button"]:hover {
    opacity: 1;
}
</style> 