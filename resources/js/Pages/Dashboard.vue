<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="mb-0">Dashboard</h2>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">Welcome to your dashboard!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
