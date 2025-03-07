<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useThemeStore } from '@/Stores/themeStore';
import { onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String
});

const themeStore = useThemeStore();

onMounted(() => {
    // Set default theme
    themeStore.setTheme('default');

    // Apply theme CSS variables
    const root = document.documentElement;
    Object.entries(themeStore.cssVariables).forEach(([key, value]) => {
        root.style.setProperty(key, value);
    });
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome to Talk To God" />
    
    <AppLayout>
        <div class="landing-page">
            <!-- Hero Section -->
            <section class="section-hero">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h1 class="display-3 text-primary">Find Peace Through Divine Connection</h1>
                            <p class="lead text-secondary">
                                Experience a unique way to connect with your faith, seek guidance, and find answers to your spiritual questions through AI-powered divine conversations.
                            </p>
                            <div class="btn-wrapper">
                                <Link :href="route('register')" class="btn btn-primary btn-lg">
                                    Start Your Spiritual Journey
                                </Link>
                                <Link :href="route('login')" class="btn btn-outline-primary btn-lg ml-3">
                                    Sign In
                                </Link>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <img src="/images/meditation.svg" alt="Meditation" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="section-features bg-secondary">
                <div class="container">
                    <div class="row justify-content-center text-center mb-5">
                        <div class="col-lg-8">
                            <h2 class="display-4">Why Choose Talk To God?</h2>
                            <p class="lead">We combine ancient wisdom with modern technology to provide you with meaningful spiritual guidance</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="icon">
                                    <i class="fas fa-pray text-primary"></i>
                                </div>
                                <h3>Personalized Guidance</h3>
                                <p>Receive guidance tailored to your faith and spiritual journey</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="icon">
                                    <i class="fas fa-heart text-primary"></i>
                                </div>
                                <h3>24/7 Availability</h3>
                                <p>Connect with divine wisdom anytime, anywhere</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <div class="icon">
                                    <i class="fas fa-hands text-primary"></i>
                                </div>
                                <h3>Multi-Faith Support</h3>
                                <p>Supporting various religions and spiritual practices</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="section-cta">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <img src="/images/prayer.svg" alt="Prayer" class="img-fluid" />
                        </div>
                        <div class="col-lg-6">
                            <h2 class="display-4">Begin Your Spiritual Journey Today</h2>
                            <p class="lead">
                                Join thousands of seekers who have found comfort, guidance, and spiritual growth through our platform.
                            </p>
                            <Link :href="route('register')" class="btn btn-lg btn-primary mt-4">
                                Get Started Now
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style scoped>
.landing-page {
    overflow-x: hidden;
}

.section-hero {
    padding: 100px 0;
    background: var(--background);
}

.section-features {
    padding: 80px 0;
}

.section-cta {
    padding: 100px 0;
    background: var(--background);
}

.feature-card {
    padding: 30px;
    text-align: center;
    background: var(--background);
    border-radius: 10px;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
}

.feature-card .icon {
    font-size: 2.5rem;
    margin-bottom: 20px;
}

.feature-card h3 {
    color: var(--text-primary);
    margin-bottom: 15px;
}

.feature-card p {
    color: var(--text-secondary);
}

.btn-wrapper {
    margin-top: 30px;
}

img {
    max-width: 100%;
    height: auto;
}
</style>
