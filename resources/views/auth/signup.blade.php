@extends('layout.app')

@section('title')
    Sign Up
@endsection

@section('content')
<section class="p-6 md:p-8 max-w-md mx-auto">
    <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-black">Sign Up</h1>
            <p class="mt-2 text-blue-500">Create an account to get started.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-blue-100 rounded-lg shadow-md overflow-hidden border border-blue-200">
            <form action="{{ route('register') }}" method="POST" class="p-6">
                @csrf
                <div class="flex flex-col gap-4">
                    <!-- Name -->
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-semibold text-black">Name <span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="border border-blue-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Enter your full name"
                            required
                        />
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label for="email" class="font-semibold text-black">Email Address <span class="text-red-500">*</span></label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="border border-blue-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                            placeholder="Enter your email address"
                            required
                        />
                    </div>

                    <!-- Password -->
                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-semibold text-black">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="border border-blue-300 rounded-lg p-3 w-full pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Create a password"
                                required
                            />
                            <button 
                                type="button" 
                                id="toggle-password" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-700"
                                aria-label="Toggle password visibility"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation" class="font-semibold text-black">Confirm Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="border border-blue-300 rounded-lg p-3 w-full pr-10 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Confirm your password"
                                required
                            />
                            <button 
                                type="button" 
                                id="toggle-confirm-password" 
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-blue-500 hover:text-blue-700"
                                aria-label="Toggle password visibility"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="mt-2 px-6 py-3 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition-all duration-200"
                    >
                        Create Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Sign In Link -->
        <div class="text-center">
            <p class="text-black">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline font-medium">Sign in</a>
            </p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            this.innerHTML = type === 'password' 
                ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>'
                : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" /></svg>';
        });
    }
    
    // Confirm Password toggle functionality
    const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    if (toggleConfirmPassword && confirmPasswordInput) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            this.innerHTML = type === 'password' 
                ? '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>'
                : '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" /></svg>';
        });
    }
});
</script>
@endsection

@section('js')
@if ($errors->any())
@foreach ($errors->all() as $error)
    <script>
        Toastify({
            text: "{{ $error }}",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: "#3B82F6",
                border: "1px solid #2563EB",
                borderRadius: "8px",
                boxShadow: "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
                color: "white",
                padding: "12px 20px",
            },
            onClick: function() {}
        }).showToast();
    </script>
@endforeach
@endif
@endsection
