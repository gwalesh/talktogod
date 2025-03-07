<x-app-layout>
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Choose Your Plan</h2>
            <p class="lead text-muted">Get unlimited access to spiritual guidance and personalized conversations</p>
        </div>

        <div class="row justify-content-center">
            <!-- Free Plan -->
            <div class="col-md-5">
                <div class="card h-100 shadow">
                    <div class="card-body p-5">
                        <h3 class="card-title h2 mb-4">Free Plan</h3>
                        <div class="mb-4">
                            <span class="display-4 fw-bold">₹0</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3">
                                <i class="fas fa-check text-success me-2"></i>
                                10 messages per day
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check text-success me-2"></i>
                                Basic spiritual guidance
                            </li>
                        </ul>
                        <button class="btn btn-outline-secondary w-100" disabled>
                            Current Plan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-md-5">
                <div class="card h-100 shadow border-primary">
                    <div class="card-body p-5">
                        <h3 class="card-title h2 mb-4">Premium Plan</h3>
                        <div class="mb-4">
                            <span class="display-4 fw-bold">₹499</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3">
                                <i class="fas fa-check text-success me-2"></i>
                                Unlimited messages
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check text-success me-2"></i>
                                Advanced spiritual insights
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check text-success me-2"></i>
                                Personalized guidance
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check text-success me-2"></i>
                                Priority support
                            </li>
                        </ul>
                        <button onclick="initiatePayment()" class="btn btn-primary w-100">
                            Upgrade Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://sdk.cashfree.com/js/ui/2.0.0/cashfree.sandbox.js"></script>
    <script>
        function initiatePayment() {
            fetch('/subscription/create-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    plan: 'premium',
                    amount: 499
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.order_token) {
                    const cashfree = new Cashfree();
                    
                    const checkoutConfig = {
                        paymentSessionId: data.order_token,
                        returnUrl: window.location.origin + '/subscription/callback'
                    };

                    cashfree.init(checkoutConfig);
                    cashfree.redirect();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to initiate payment. Please try again.');
            });
        }
    </script>
    @endpush
</x-app-layout> 