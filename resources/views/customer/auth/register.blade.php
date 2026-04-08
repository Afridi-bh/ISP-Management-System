<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Customer Registration</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 50%, #0891b2 100%) !important;
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body style="background: linear-gradient(135deg, #1e3a8a 0%, #0f766e 50%, #0891b2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">

    <div style="width: 100%; max-width: 28rem;">
        <div style="width: 100%; background: white; border-radius: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); padding: 2.5rem;">

            <!-- Logo Section -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <div style="display: inline-flex; align-items: center; justify-content: center; width: 7rem; height: 7rem; background: white; border-radius: 1.5rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem;">
                    <div style="text-align: center;">
                        <span style="display: block; font-size: 2.25rem; font-weight: 900; background: linear-gradient(to right, #f97316, #2563eb); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">ISP</span>
                        <span style="display: block; font-size: 0.75rem; font-weight: 700; color: #f97316; letter-spacing: 0.05em;">BILLING</span>
                    </div>
                </div>
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Create Customer Account</h2>
                <p style="color: #6b7280; font-size: 0.875rem;">Sign up to get started</p>
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.register.submit') }}">
                @csrf
                
                <!-- Full Name Input -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="position: relative;">
                        <input 
                            id="name" 
                            type="text"
                            style="display: block; width: 100%; padding: 1rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="name" 
                            placeholder="Full Name" 
                            value="{{ old('name') }}"
                            required 
                            autofocus 
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                    </div>
                </div>

                <!-- Email Input -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="position: relative;">
                        <input 
                            id="email" 
                            type="email"
                            style="display: block; width: 100%; padding: 1rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="email" 
                            placeholder="Email Address" 
                            value="{{ old('email') }}"
                            required 
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                    </div>
                </div>

                <!-- Phone Input -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="position: relative;">
                        <input 
                            id="phone" 
                            type="text"
                            style="display: block; width: 100%; padding: 1rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="phone" 
                            placeholder="Phone Number (Optional)" 
                            value="{{ old('phone') }}"
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                    </div>
                </div>

                <!-- Password Input -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="position: relative;">
                        <input 
                            id="password" 
                            type="password"
                            style="display: block; width: 100%; padding: 1rem; padding-right: 3rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="password" 
                            placeholder="Password" 
                            required
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                        <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #10b981; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.5rem; width: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="position: relative;">
                        <input 
                            id="password_confirmation" 
                            type="password"
                            style="display: block; width: 100%; padding: 1rem; padding-right: 3rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="password_confirmation" 
                            placeholder="Confirm Password" 
                            required
                            onfocus="this.style.borderColor='#10b981'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                        <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #10b981; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.5rem; width: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Register Button -->
                <button
                    type="submit"
                    style="width: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(to right, #10b981, #059669); color: white; font-weight: 700; padding: 1rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.2s; margin-bottom: 1rem; font-size: 1rem;"
                    onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)'"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem; margin-right: 0.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Create Account
                </button>

            </form>

            <!-- Footer Links -->
            <div style="margin-top: 2rem; text-align: center;">
                <p style="color: #6b7280; font-size: 0.875rem;">
                    Already have an account? 
                    <a href="{{ route('customer.login') }}" style="color: #10b981; font-weight: 600; text-decoration: none;">Sign In</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>