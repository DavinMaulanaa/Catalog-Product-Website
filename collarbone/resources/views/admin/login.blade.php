<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Collarbone Admin</title>
    <meta name="description" content="Login ke Collarbone Admin Dashboard">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0a0f;
            --bg-secondary: #12121a;
            --bg-card: #1a1a2e;
            --bg-input: #16162a;
            --border: #2a2a45;
            --border-hover: #3a3a5c;
            --text-primary: #e8e8f0;
            --text-secondary: #8888a8;
            --text-muted: #5a5a7a;
            --accent-teal: #00d4aa;
            --accent-teal-hover: #00eabb;
            --accent-teal-glow: rgba(0, 212, 170, 0.1);
            --accent-purple: #8b5cf6;
            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.1);
            --success: #10b981;
            --success-bg: rgba(16, 185, 129, 0.1);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== ANIMATED BACKGROUND ===== */
        .login-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .login-bg::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 212, 170, 0.1) 0%, transparent 70%);
            top: -150px;
            right: -100px;
            animation: floatOrb1 18s ease-in-out infinite;
        }

        .login-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%);
            bottom: -100px;
            left: -80px;
            animation: floatOrb2 22s ease-in-out infinite;
        }

        .login-bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
        }

        .login-bg-orb:nth-child(1) {
            width: 350px; height: 350px;
            background: rgba(0, 212, 170, 0.08);
            top: 20%; left: 60%;
            animation: floatOrb3 15s ease-in-out infinite;
        }

        .login-bg-orb:nth-child(2) {
            width: 280px; height: 280px;
            background: rgba(139, 92, 246, 0.06);
            bottom: 30%; right: 55%;
            animation: floatOrb4 20s ease-in-out infinite;
        }

        .login-bg-orb:nth-child(3) {
            width: 200px; height: 200px;
            background: rgba(0, 212, 170, 0.05);
            top: 60%; left: 30%;
            animation: floatOrb1 25s ease-in-out infinite reverse;
        }

        .login-bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        }

        @keyframes floatOrb1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -40px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        @keyframes floatOrb2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-40px, 30px) scale(1.1); }
            66% { transform: translate(25px, -25px) scale(0.9); }
        }
        @keyframes floatOrb3 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-50px, 40px); }
        }
        @keyframes floatOrb4 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(40px, -50px); }
        }

        /* ===== LOGIN CONTAINER ===== */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 20px;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: rgba(26, 26, 46, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 48px 40px;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.03), 0 20px 60px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0, 212, 170, 0.03);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent-teal), var(--accent-purple), transparent);
            opacity: 0.8;
        }

        /* ===== LOGO ===== */
        .login-logo { text-align: center; margin-bottom: 36px; }

        .login-logo-icon {
            width: 64px; height: 64px;
            border-radius: var(--radius);
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-purple));
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 800; color: white;
            margin: 0 auto 16px;
            animation: logoPulse 3s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 0 20px rgba(0, 212, 170, 0.2); }
            50% { box-shadow: 0 0 30px rgba(0, 212, 170, 0.4); }
        }

        .login-logo h1 {
            font-size: 22px; font-weight: 700;
            background: linear-gradient(135deg, var(--accent-teal), var(--accent-purple));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
        }

        .login-logo p {
            font-size: 12px; color: var(--text-muted);
            letter-spacing: 0.1em; text-transform: uppercase; font-weight: 500;
        }

        /* ===== ALERTS ===== */
        .login-alert {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: var(--radius-sm);
            font-size: 13px; margin-bottom: 20px;
            animation: shakeError 0.4s ease;
        }

        .login-alert-error {
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .login-alert-success {
            background: var(--success-bg);
            border: 1px solid rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .login-alert svg { width: 16px; height: 16px; flex-shrink: 0; }

        @keyframes shakeError {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }

        /* ===== FORM ===== */
        .login-form { display: flex; flex-direction: column; gap: 20px; }

        .form-group { display: flex; flex-direction: column; gap: 7px; }

        .form-label {
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--text-secondary);
        }

        .form-input-wrapper {
            position: relative;
            display: flex; align-items: center;
        }

        .form-input-icon {
            position: absolute; left: 14px;
            width: 18px; height: 18px;
            color: var(--text-muted); pointer-events: none;
            transition: color 0.25s ease;
        }

        .form-input {
            width: 100%; height: 48px;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 14px 0 44px;
            font-size: 14px; color: var(--text-primary);
            font-family: inherit; transition: var(--transition); outline: none;
        }

        .form-input::placeholder { color: var(--text-muted); }

        .form-input:focus {
            border-color: var(--accent-teal);
            box-shadow: 0 0 0 3px var(--accent-teal-glow);
        }

        .form-input-wrapper:focus-within .form-input-icon { color: var(--accent-teal); }

        .form-input.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px var(--danger-bg);
        }

        .password-toggle {
            position: absolute; right: 14px;
            width: 18px; height: 18px;
            color: var(--text-muted); cursor: pointer;
            transition: color 0.15s ease;
            background: none; border: none; padding: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .password-toggle:hover { color: var(--text-primary); }

        .form-options {
            display: flex; align-items: center;
            justify-content: space-between; margin-top: -4px;
        }

        .remember-me {
            display: flex; align-items: center; gap: 8px; cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--accent-teal); cursor: pointer;
        }

        .remember-me span { font-size: 13px; color: var(--text-secondary); }

        /* ===== BUTTON ===== */
        .login-btn {
            width: 100%; height: 48px;
            background: linear-gradient(135deg, var(--accent-teal), #00b894);
            color: var(--bg-primary); border: none;
            border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 700;
            letter-spacing: 0.08em; text-transform: uppercase;
            cursor: pointer; transition: var(--transition);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            font-family: inherit; margin-top: 4px;
        }

        .login-btn::before {
            content: '';
            position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.6s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, var(--accent-teal-hover), var(--accent-teal));
            box-shadow: 0 6px 24px rgba(0, 212, 170, 0.3);
            transform: translateY(-2px);
        }
        .login-btn:hover::before { left: 100%; }
        .login-btn:active { transform: translateY(0); }
        .login-btn svg { width: 16px; height: 16px; transition: transform 0.15s ease; }
        .login-btn:hover svg { transform: translateX(3px); }

        .login-divider {
            display: flex; align-items: center; gap: 16px; margin: 4px 0;
        }
        .login-divider::before, .login-divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }
        .login-divider span {
            font-size: 10px; color: var(--text-muted);
            letter-spacing: 0.15em; text-transform: uppercase; font-weight: 500;
        }

        .login-footer {
            text-align: center; margin-top: 28px;
            font-size: 13px; color: var(--text-muted);
        }
        .login-footer a {
            color: var(--accent-teal); text-decoration: none;
            font-weight: 500; transition: color 0.15s ease;
        }
        .login-footer a:hover { color: var(--accent-teal-hover); }

        .particle {
            position: absolute;
            width: 3px; height: 3px;
            background: rgba(0, 212, 170, 0.3);
            border-radius: 50%; pointer-events: none;
        }
        .particle:nth-child(4) { top: 15%; left: 10%; animation: fp 8s ease-in-out infinite; }
        .particle:nth-child(5) { top: 70%; right: 15%; animation: fp 12s ease-in-out infinite 2s; }
        .particle:nth-child(6) { top: 40%; left: 80%; animation: fp 10s ease-in-out infinite 4s; }
        .particle:nth-child(7) { top: 85%; left: 25%; animation: fp 14s ease-in-out infinite 1s; }

        @keyframes fp {
            0%, 100% { transform: translate(0, 0); opacity: 0.3; }
            25% { transform: translate(15px, -20px); opacity: 0.7; }
            50% { transform: translate(-10px, -35px); opacity: 0.4; }
            75% { transform: translate(20px, -15px); opacity: 0.6; }
        }

        @media (max-width: 480px) {
            .login-card { padding: 36px 24px; }
            .login-logo-icon { width: 56px; height: 56px; font-size: 24px; }
            .login-logo h1 { font-size: 18px; }
            .login-container { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="login-bg">
        <div class="login-bg-orb"></div>
        <div class="login-bg-orb"></div>
        <div class="login-bg-orb"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="login-bg-grid"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <div class="login-logo-icon">C</div>
                <h1>Collarbone</h1>
                <p>Admin Panel</p>
            </div>

            @if(session('success'))
                <div class="login-alert login-alert-success">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="login-alert login-alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="form-input-wrapper">
                        <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" class="form-input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email admin" required autofocus autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="form-input-wrapper">
                        <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" class="form-input @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                        <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Toggle password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="login-btn">
                    <span>Masuk ke Dashboard</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                    </svg>
                </button>
            </form>

            <div class="login-divider"><span>Secure Login</span></div>
            <div class="login-footer"><a href="/">← Kembali ke Website</a></div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>
