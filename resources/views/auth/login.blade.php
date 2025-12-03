@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-page">
    <!-- Left Side - Illustration -->
    <div class="login-left">
        <svg class="login-illustration" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="50" y="50" width="400" height="300" rx="20" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
            <rect x="70" y="80" width="120" height="80" rx="10" fill="rgba(255,255,255,0.15)"/>
            <rect x="200" y="80" width="120" height="80" rx="10" fill="rgba(255,255,255,0.15)"/>
            <rect x="330" y="80" width="100" height="80" rx="10" fill="rgba(255,255,255,0.15)"/>
            <rect x="70" y="180" width="250" height="150" rx="10" fill="rgba(255,255,255,0.1)"/>
            <rect x="330" y="180" width="100" height="70" rx="10" fill="rgba(255,255,255,0.1)"/>
            <rect x="330" y="260" width="100" height="70" rx="10" fill="rgba(255,255,255,0.1)"/>
            <path d="M90 280 L130 250 L170 270 L210 220 L250 240 L290 200" stroke="rgba(255,255,255,0.5)" stroke-width="3" fill="none" stroke-linecap="round"/>
            <circle cx="90" cy="280" r="5" fill="white"/>
            <circle cx="130" cy="250" r="5" fill="white"/>
            <circle cx="170" cy="270" r="5" fill="white"/>
            <circle cx="210" cy="220" r="5" fill="white"/>
            <circle cx="250" cy="240" r="5" fill="white"/>
            <circle cx="290" cy="200" r="5" fill="white"/>
            <circle cx="130" cy="120" r="20" fill="rgba(255,255,255,0.2)"/>
            <circle cx="260" cy="120" r="20" fill="rgba(255,255,255,0.2)"/>
            <circle cx="380" cy="120" r="20" fill="rgba(255,255,255,0.2)"/>
            <circle cx="30" cy="150" r="15" fill="rgba(255,255,255,0.1)">
                <animate attributeName="cy" values="150;130;150" dur="3s" repeatCount="indefinite"/>
            </circle>
            <circle cx="470" cy="250" r="20" fill="rgba(255,255,255,0.1)">
                <animate attributeName="cy" values="250;270;250" dur="4s" repeatCount="indefinite"/>
            </circle>
        </svg>
        <h2>Si Basumba</h2>
        <p>Sistem Informasi Bapas Sumbawa Besar - Melayani dengan profesional dan transparan.</p>
    </div>

    <!-- Right Side - Login Form -->
    <div class="login-right">
        <div class="login-form">
            <div class="text-center mb-5">
                <div class="sidebar-logo d-inline-flex mb-4" style="width: 60px; height: 60px; font-size: 28px;">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <h1>Masuk</h1>
                <p class="subtitle">Silakan masuk dengan akun Anda.</p>
            </div>

            @if($errors->any())
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                @foreach($errors->all() as $error)
                    <p style="margin: 0;">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="position-relative">
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" style="padding-left: 48px;" required>
                        <i class="bi bi-envelope position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" style="padding-left: 48px; padding-right: 48px;" required>
                        <i class="bi bi-lock position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-between align-center mb-4">
                    <label class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk
                </button>
            </form>

            <div class="text-center mt-5">
                <button class="theme-toggle" id="themeToggle" style="background: var(--border-color);">
                    <i class="bi bi-moon-fill"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection
