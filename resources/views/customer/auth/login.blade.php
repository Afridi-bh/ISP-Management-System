<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Customer Login</title>

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
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Customer Login</h2>
                <p style="color: #6b7280; font-size: 0.875rem;">Sign in to access your account</p>
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

            <form method="POST" action="{{ route('customer.login.submit') }}">
                @csrf
                
                <!-- Email Input -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="position: relative;">
                        <input 
                            id="email" 
                            type="email"
                            style="display: block; width: 100%; padding: 1rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="email" 
                            placeholder="Enter Your Email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus 
                            onfocus="this.style.borderColor='#f97316'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                    </div>
                </div>

                <!-- Password Input -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="position: relative;">
                        <input 
                            id="password" 
                            type="password"
                            style="display: block; width: 100%; padding: 1rem; padding-right: 3rem; background: #f9fafb; border: 2px solid #e5e7eb; border-radius: 1rem; color: #374151; transition: all 0.2s; font-size: 1rem;"
                            name="password" 
                            placeholder="Enter Your Password" 
                            required
                            onfocus="this.style.borderColor='#f97316'"
                            onblur="this.style.borderColor='#e5e7eb'"
                        />
                        <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #fb923c; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.5rem; width: 1.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
                    <input 
                        id="remember_me" 
                        type="checkbox"
                        style="width: 1rem; height: 1rem; border-radius: 0.25rem; border: 1px solid #d1d5db; color: #f97316;"
                        name="remember"
                    />
                    <label for="remember_me" style="margin-left: 0.5rem; font-size: 0.875rem; color: #4b5563;">
                        Remember Me
                    </label>
                </div>

                <!-- Customer Login Button -->
                <button
                    type="submit"
                    style="width: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(to right, #f97316, #ea580c); color: white; font-weight: 700; padding: 1rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.2s; margin-bottom: 1rem; font-size: 1rem;"
                    onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)'"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem; margin-right: 0.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Customer Login
                </button>

                <!-- Back to Admin Login Button -->
                <a href="{{ route('login') }}"
                   style="width: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(to right, #2563eb, #1d4ed8); color: white; font-weight: 700; padding: 1rem; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); text-decoration: none; transition: all 0.2s; font-size: 1rem;"
                   onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 20px 25px -5px rgba(0, 0, 0, 0.1)'"
                   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 1.25rem; width: 1.25rem; margin-right: 0.5rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Admin Login
                </a>

            </form>

            <!-- Footer Links -->
            <div style="margin-top: 2rem; text-align: center;">
                <p style="color: #6b7280; font-size: 0.875rem;">
                    Don't have an account? 
                    <a href="{{ route('customer.register') }}" style="color: #f97316; font-weight: 600; text-decoration: none;">Create Account</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>