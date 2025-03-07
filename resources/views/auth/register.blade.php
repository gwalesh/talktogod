@extends('layouts.app')

@section('content')
<div class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-2">{{ __('Begin Your Spiritual Journey') }}</h2>
                            <p class="text-muted">{{ __('Create your account to start meaningful conversations') }}</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label small fw-bold">{{ __('Name') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label small fw-bold">{{ __('Email Address') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label small fw-bold">{{ __('Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label small fw-bold">{{ __('Confirm Password') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="religion" class="form-label small fw-bold">{{ __('Religion') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-pray text-muted"></i>
                                        </span>
                                        <select id="religion" class="form-select border-start-0 @error('religion') is-invalid @enderror" name="religion" required>
                                            <option value="">{{ __('Select Religion') }}</option>
                                            <option value="Christianity" {{ old('religion') == 'Christianity' ? 'selected' : '' }}>{{ __('Christianity') }}</option>
                                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>{{ __('Islam') }}</option>
                                            <option value="Hinduism" {{ old('religion') == 'Hinduism' ? 'selected' : '' }}>{{ __('Hinduism') }}</option>
                                            <option value="Buddhism" {{ old('religion') == 'Buddhism' ? 'selected' : '' }}>{{ __('Buddhism') }}</option>
                                            <option value="Judaism" {{ old('religion') == 'Judaism' ? 'selected' : '' }}>{{ __('Judaism') }}</option>
                                            <option value="Sikhism" {{ old('religion') == 'Sikhism' ? 'selected' : '' }}>{{ __('Sikhism') }}</option>
                                            <option value="Other" {{ old('religion') == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                        </select>
                                        @error('religion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="denomination" class="form-label small fw-bold">{{ __('Denomination (Optional)') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-church text-muted"></i>
                                        </span>
                                        <select id="denomination" class="form-select border-start-0 @error('denomination') is-invalid @enderror" name="denomination">
                                            <option value="">{{ __('Select Denomination') }}</option>
                                        </select>
                                        @error('denomination')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="gender" class="form-label small fw-bold">{{ __('Gender') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-venus-mars text-muted"></i>
                                        </span>
                                        <select id="gender" class="form-select border-start-0 @error('gender') is-invalid @enderror" name="gender" required>
                                            <option value="">{{ __('Select Gender') }}</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                            <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>{{ __('Prefer not to say') }}</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="age" class="form-label small fw-bold">{{ __('Age') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-birthday-cake text-muted"></i>
                                        </span>
                                        <input id="age" type="number" class="form-control border-start-0 @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required min="13" max="120">
                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="spiritual_background" class="form-label small fw-bold">{{ __('Spiritual Background (Optional)') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-book text-muted"></i>
                                        </span>
                                        <textarea id="spiritual_background" class="form-control border-start-0 @error('spiritual_background') is-invalid @enderror" name="spiritual_background" rows="3">{{ old('spiritual_background') }}</textarea>
                                        @error('spiritual_background')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary py-3 fw-bold">
                                        {{ __('Create Account') }}
                                    </button>
                                </div>

                                <div class="text-center mt-4">
                                    <span class="text-muted small">{{ __('Already have an account?') }}</span>
                                    <a href="{{ route('login') }}" class="text-primary text-decoration-none ms-1 small fw-bold">
                                        {{ __('Sign in') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const religionSelect = document.getElementById('religion');
    const denominationSelect = document.getElementById('denomination');
    const oldDenomination = "{{ old('denomination') }}";

    const denominations = {
        'Christianity': [
            'Roman Catholic',
            'Eastern Orthodox',
            'Protestant',
            'Anglican',
            'Baptist',
            'Methodist',
            'Lutheran',
            'Presbyterian',
            'Pentecostal',
            'Evangelical',
            'Other Christian'
        ],
        'Islam': [
            'Sunni',
            'Shia',
            'Sufism',
            'Other Islamic'
        ],
        'Hinduism': [
            'Vaishnavism',
            'Shaivism',
            'Shaktism',
            'Smartism',
            'Other Hindu'
        ],
        'Buddhism': [
            'Theravada',
            'Mahayana',
            'Vajrayana',
            'Zen',
            'Other Buddhist'
        ],
        'Judaism': [
            'Orthodox',
            'Conservative',
            'Reform',
            'Reconstructionist',
            'Other Jewish'
        ],
        'Sikhism': [
            'Nihang',
            'Namdharis',
            'Other Sikh'
        ]
    };

    function updateDenominations() {
        const selectedReligion = religionSelect.value;
        denominationSelect.innerHTML = '<option value="">{{ __("Select Denomination") }}</option>';
        
        if (denominations[selectedReligion]) {
            denominations[selectedReligion].forEach(denomination => {
                const option = document.createElement('option');
                option.value = denomination;
                option.textContent = denomination;
                if (oldDenomination === denomination) {
                    option.selected = true;
                }
                denominationSelect.appendChild(option);
            });
            denominationSelect.disabled = false;
        } else {
            if (selectedReligion === 'Other') {
                const option = document.createElement('option');
                option.value = 'Other';
                option.textContent = 'Other';
                if (oldDenomination === 'Other') {
                    option.selected = true;
                }
                denominationSelect.appendChild(option);
            }
            denominationSelect.disabled = selectedReligion === '';
        }
    }

    religionSelect.addEventListener('change', updateDenominations);
    updateDenominations(); // Initialize on page load
});
</script>
@endpush
@endsection 