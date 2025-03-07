<x-app-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Information -->
                <div class="card shadow-lg border-0 rounded-3 mb-4">
                    <div class="card-header bg-white p-4 border-bottom-0">
                        <h2 class="h4 mb-0 text-primary">
                            <i class="fas fa-user-circle me-2"></i>Profile Information
                        </h2>
                        <p class="text-muted mb-0">Update your account's profile information and email address.</p>
                    </div>

                    <div class="card-body p-4">
                        <form method="post" action="{{ route('profile.update') }}" class="mt-3">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                @if (session('status') === 'profile-updated')
                                    <div class="text-success me-3">Saved.</div>
                                @endif
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card shadow-lg border-0 rounded-3 mb-4">
                    <div class="card-header bg-white p-4 border-bottom-0">
                        <h2 class="h4 mb-0 text-primary">
                            <i class="fas fa-lock me-2"></i>Update Password
                        </h2>
                        <p class="text-muted mb-0">Ensure your account is using a long, random password to stay secure.</p>
                    </div>

                    <div class="card-body p-4">
                        <form method="post" action="{{ route('password.update') }}" class="mt-3">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                @if (session('status') === 'password-updated')
                                    <div class="text-success me-3">Saved.</div>
                                @endif
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-key me-2"></i>Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card shadow-lg border-0 rounded-3 bg-danger bg-opacity-10">
                    <div class="card-header bg-transparent p-4 border-bottom-0">
                        <h2 class="h4 mb-0 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                        </h2>
                        <p class="text-muted mb-0">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    </div>

                    <div class="card-body p-4">
                        <form method="post" action="{{ route('profile.destroy') }}" class="mt-3">
                            @csrf
                            @method('delete')

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="fas fa-trash-alt me-2"></i>Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: var(--bs-primary);
        }
        .card {
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</x-app-layout> 