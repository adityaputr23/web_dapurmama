<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Dapur Bunda</title>
    <meta name="description" content="Masuk ke Dapur Bunda dan nikmati kuliner terbaik pilihan bunda.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --brand:        #c8735a;
            --brand-dark:   #a85c44;
            --brand-light:  #f5e8e2;
            --cream:        #faf7f3;
            --brown-dark:   #2c2416;
            --brown-mid:    #6b5744;
            --brown-light:  #a89278;
            --white:        #ffffff;
            --border:       #ebe3da;
            --shadow-card:  0 24px 64px rgba(44,36,22,.13), 0 4px 16px rgba(44,36,22,.06);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--cream);
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* ── Decorative blobs ── */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            opacity: .6;
        }
        .blob-1 { width: 480px; height: 480px; background: #e8d5c8; top: -140px; right: -100px; animation: blobFloat 14s ease-in-out infinite alternate; }
        .blob-2 { width: 420px; height: 420px; background: #ddd3c0; bottom: -130px; left: -80px; animation: blobFloat 17s ease-in-out infinite alternate-reverse; }
        .blob-3 { width: 250px; height: 250px; background: #f2c8b0; top: 55%; left: 42%; transform: translate(-50%,-50%); animation: blobFloat 11s ease-in-out infinite alternate; }
        @keyframes blobFloat {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(20px,25px) scale(1.06); }
        }

        /* ── Card ── */
        .auth-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--border);
            overflow: hidden;
            animation: cardIn .5s cubic-bezier(.22,.68,0,1.15) both;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(32px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Card top banner ── */
        .card-banner {
            background: linear-gradient(135deg, #c8735a 0%, #9e5540 100%);
            padding: 28px 28px 24px;
            position: relative;
            overflow: hidden;
        }
        .card-banner::before {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
            top: -60px; right: -40px;
        }
        .card-banner::after {
            content: '';
            position: absolute;
            width: 130px; height: 130px;
            background: rgba(255,255,255,.06);
            border-radius: 50%;
            bottom: -50px; left: 20px;
        }

        /* Back button — inside banner */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: rgba(255,255,255,.85);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 50px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            backdrop-filter: blur(6px);
            transition: all .2s ease;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }
        .back-btn i { font-size: 10px; transition: transform .2s; }
        .back-btn:hover {
            background: rgba(255,255,255,.25);
            color: #fff;
        }
        .back-btn:hover i { transform: translateX(-3px); }

        /* Brand row inside banner */
        .banner-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 2;
        }
        .brand-icon {
            width: 50px; height: 50px;
            background: rgba(255,255,255,.2);
            border: 1.5px solid rgba(255,255,255,.35);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 20px;
            flex-shrink: 0;
        }
        .banner-text {}
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
        }
        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,.7);
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ── Card body ── */
        .card-body {
            padding: 28px 28px 24px;
        }

        .body-title {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 700;
            color: var(--brown-dark);
            margin-bottom: 4px;
        }
        .body-sub {
            font-size: 13px;
            color: var(--brown-light);
            margin-bottom: 22px;
            line-height: 1.5;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 16px;
        }
        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--brown-mid);
            margin-bottom: 7px;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 13px;
            color: #c0b0a0;
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
            z-index: 1;
        }
        .input-eye {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #c0b0a0;
            font-size: 13px;
            padding: 4px;
            transition: color .2s;
            line-height: 1;
        }
        .input-eye:hover { color: var(--brand); }
        .form-input {
            width: 100%;
            padding: 11px 14px 11px 38px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--brown-dark);
            background: #faf8f5;
            outline: none;
            transition: all .2s;
        }
        .form-input::placeholder { color: #ccc2b5; font-size: 13px; }
        .form-input:focus {
            border-color: var(--brand);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(200,115,90,.12);
        }
        .form-input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--brand); }

        /* ── Meta row ── */
        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--brown-mid);
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }
        .check-label input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 17px; height: 17px;
            border: 1.5px solid #d8cfc6;
            border-radius: 5px;
            background: #faf8f5;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: all .15s;
        }
        .check-label input:checked {
            background: var(--brand);
            border-color: var(--brand);
        }
        .check-label input:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 9px;
            color: #fff;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }
        .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--brand);
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: var(--brand-dark); }

        /* ── Submit ── */
        .submit-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--brand) 0%, #a85c44 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            box-shadow: 0 6px 20px rgba(200,115,90,.35);
            transition: all .22s ease;
            letter-spacing: .01em;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(200,115,90,.42);
        }
        .submit-btn:active { transform: translateY(0); }

        /* ── Card footer ── */
        .card-footer {
            padding: 16px 28px 22px;
            border-top: 1px solid var(--border);
            background: #faf7f3;
            text-align: center;
        }
        .switch-hint {
            font-size: 13.5px;
            color: var(--brown-light);
        }
        .switch-hint a {
            color: var(--brand);
            font-weight: 700;
            text-decoration: none;
        }
        .switch-hint a:hover { text-decoration: underline; }
        .secure-note {
            margin-top: 10px;
            font-size: 11.5px;
            color: #c0b0a0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .secure-note i { font-size: 10px; }

        /* ── Alerts ── */
        .alert {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 13px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .alert-error   { background: #fdeaea; border: 1px solid #f5c0c0; color: #b83232; }
        .alert-success { background: #eaf5ea; border: 1px solid #b8dcb8; color: #276727; }

        @media (max-width: 480px) {
            body {
                padding: 12px 10px;
            }
            .auth-card {
                max-width: 100%;
                border-radius: 18px;
            }
            .card-banner {
                padding: 20px 18px 18px;
            }
            .brand-name {
                font-size: 19px;
            }
            .card-body {
                padding: 20px 18px;
            }
            .body-title {
                font-size: 19px;
            }
            .body-sub {
                font-size: 12.5px;
                margin-bottom: 18px;
            }
            .meta-row {
                flex-wrap: wrap;
                gap: 8px;
            }
            .card-footer {
                padding: 14px 18px;
            }
            .form-input {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="auth-card">

        <!-- Banner (back button + brand) -->
        <div class="card-banner">
            <a href="{{ url('/') }}" class="back-btn" id="back-home-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
            <div class="banner-brand">
                <div class="brand-icon">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <div class="banner-text">
                    <div class="brand-name">Dapur Bunda</div>
                    <div class="brand-sub">Cita Rasa Rumahan Terbaik</div>
                </div>
            </div>
        </div>

        <!-- Form body -->
        <div class="card-body">
            <h1 class="body-title">Selamat Datang 👋</h1>
            <p class="body-sub">Masuk ke akun Anda untuk memesan kuliner pilihan bunda.</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="login-form">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input"
                               placeholder="nama@email.com"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Masukkan password" required style="padding-right: 40px;">
                        <button type="button" class="input-eye" id="toggle-pw" aria-label="Lihat password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="meta-row">
                    <label class="check-label">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya</span>
                    </label>
                    <a href="#" class="forgot-link">Lupa Password?</a>
                </div>

                <button type="submit" class="submit-btn" id="login-submit-btn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Masuk Sekarang</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="card-footer">
            <p class="switch-hint">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </p>
            <p class="secure-note">
                <i class="fa-solid fa-shield-halved"></i>
                Koneksi aman & terenkripsi
            </p>
        </div>

    </div>

    <script>
        const togglePw = document.getElementById('toggle-pw');
        const pwField  = document.getElementById('password');
        if (togglePw && pwField) {
            togglePw.addEventListener('click', () => {
                const isHidden = pwField.type === 'password';
                pwField.type = isHidden ? 'text' : 'password';
                togglePw.querySelector('i').className = isHidden
                    ? 'fa-regular fa-eye-slash'
                    : 'fa-regular fa-eye';
            });
        }
    </script>
</body>
</html>
