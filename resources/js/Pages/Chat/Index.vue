<template>
    <AppLayout>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Chat with Spiritual Guide</h5>
                            <button 
                                v-if="chatHistory.length > 0"
                                @click="clearHistory" 
                                class="btn btn-outline-danger btn-sm"
                            >
                                Clear History
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="chat-messages" ref="messagesContainer">
                                <div 
                                    v-for="message in chatHistory" 
                                    :key="message.id"
                                    class="message mb-3"
                                    :class="{'message-user': message.user_message, 'message-ai': message.ai_response}"
                                >
                                    <div class="message-content p-3 rounded">
                                        <div v-if="message.user_message" class="user-message">
                                            {{ message.user_message }}
                                        </div>
                                        <div v-if="message.ai_response" class="ai-message">
                                            {{ message.ai_response }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-input mt-4">
                                <div class="input-group">
                                    <input 
                                        v-model="newMessage"
                                        @keyup.enter="sendMessage"
                                        type="text"
                                        class="form-control"
                                        placeholder="Type your message..."
                                        :disabled="isLoading"
                                    >
                                    <button 
                                        @click="sendMessage"
                                        class="btn btn-primary"
                                        :disabled="isLoading || !newMessage.trim()"
                                    >
                                        <span v-if="isLoading" class="spinner-border spinner-border-sm me-1"></span>
                                        Send
                                    </button>
                                </div>
                            </div>

                            <div v-if="error" class="alert alert-danger mt-3">
                                {{ error }}
                            </div>

                            <div v-if="!isPremium" class="alert alert-info mt-3">
                                <small>
                                    You are using the free tier. You have {{ remainingMessages }} messages remaining today.
                                    <Link :href="route('subscription')" class="alert-link">Upgrade to premium</Link> for unlimited messages.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

const props = defineProps({
    chatHistory: Array,
    isPremium: Boolean,
});

const newMessage = ref('');
const isLoading = ref(false);
const error = ref('');
const messagesContainer = ref(null);
const remainingMessages = ref(10 - props.chatHistory.length);

const scrollToBottom = async () => {
    await nextTick();
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

const sendMessage = async () => {
    if (!newMessage.value.trim() || isLoading.value) return;

    isLoading.value = true;
    error.value = '';

    try {
        const response = await axios.post(route('chat.send'), {
            message: newMessage.value,
        });

        // Add new message to chat history
        props.chatHistory.push({
            id: Date.now(),
            user_message: newMessage.value,
            ai_response: response.data.response,
        });

        newMessage.value = '';
        remainingMessages.value--;
        await scrollToBottom();
    } catch (err) {
        error.value = err.response?.data?.error || 'An error occurred. Please try again.';
    } finally {
        isLoading.value = false;
    }
};

const clearHistory = async () => {
    if (!confirm('Are you sure you want to clear your chat history?')) return;

    try {
        await axios.post(route('chat.clear'));
        props.chatHistory.length = 0;
        remainingMessages.value = 10;
    } catch (err) {
        error.value = 'Failed to clear chat history. Please try again.';
    }
};

onMounted(() => {
    scrollToBottom();
});
</script>

<style scoped>
.chat-messages {
    height: 500px;
    overflow-y: auto;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.25rem;
}

.message {
    display: flex;
    flex-direction: column;
}

.message-user {
    align-items: flex-end;
}

.message-ai {
    align-items: flex-start;
}

.message-content {
    max-width: 80%;
}

.user-message {
    background-color: #007bff;
    color: white;
    border-radius: 1rem 1rem 0 1rem;
}

.ai-message {
    background-color: #e9ecef;
    color: #212529;
    border-radius: 1rem 1rem 1rem 0;
}

.chat-input {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}
</style> 