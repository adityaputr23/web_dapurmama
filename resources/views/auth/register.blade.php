<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – Dapur Bunda</title>
    <meta name="description" content="Buat akun Dapur Bunda dan mulai menikmati kuliner rumahan terbaik.">
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
            overflow-x: hidden;
        }

        /* ── Decorative blobs ── */
        .blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            opacity: .55;
        }
        .blob-1 { width: 420px; height: 420px; background: #dcd3c2; top: -110px; left: -80px; animation: blobF 15s ease-in-out infinite alternate; }
        .blob-2 { width: 480px; height: 480px; background: #e8d5c8; bottom: -120px; right: -90px; animation: blobF 18s ease-in-out infinite alternate-reverse; }
        .blob-3 { width: 220px; height: 220px; background: #f5c8b0; top: 40%; right: 15%; animation: blobF 10s ease-in-out infinite alternate; }
        @keyframes blobF {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(18px,22px) scale(1.05); }
        }

        /* ── Card ── */
        .auth-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
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

        /* ── Banner ── */
        .card-banner {
            background: linear-gradient(135deg, #c8735a 0%, #8c4a35 100%);
            padding: 24px 28px 22px;
            position: relative;
            overflow: hidden;
        }
        .card-banner::before {
            content: '';
            position: absolute;
            width: 220px; height: 220px;
            background: rgba(255,255,255,.07);
            border-radius: 50%;
            top: -70px; right: -50px;
        }
        .card-banner::after {
            content: '';
            position: absolute;
            width: 140px; height: 140px;
            background: rgba(255,255,255,.05);
            border-radius: 50%;
            bottom: -55px; left: 30px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: rgba(255,255,255,.85);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            padding: 6px 13px;
            border-radius: 50px;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            transition: all .2s;
            margin-bottom: 18px;
            position: relative;
            z-index: 2;
            width: fit-content;
        }
        .back-btn i { font-size: 10px; transition: transform .2s; }
        .back-btn:hover { background: rgba(255,255,255,.25); color: #fff; }
        .back-btn:hover i { transform: translateX(-3px); }

        .banner-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 2;
        }
        .brand-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,.18);
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 19px;
            flex-shrink: 0;
        }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 800;
            color: #fff;
        }
        .brand-sub {
            font-size: 10.5px;
            color: rgba(255,255,255,.65);
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ── Benefits strip ── */
        .benefits-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0;
            border-bottom: 1px solid var(--border);
        }
        .benefit-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            padding: 14px 6px;
            font-size: 10.5px;
            font-weight: 600;
            color: var(--brown-mid);
            text-align: center;
            border-right: 1px solid var(--border);
        }
        .benefit-item:last-child { border-right: none; }
        .benefit-ico {
            width: 32px; height: 32px;
            background: var(--brand-light);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: var(--brand);
            font-size: 13px;
        }

        /* ── Card body ── */
        .card-body {
            padding: 24px 28px 20px;
        }
        .body-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--brown-dark);
            margin-bottom: 3px;
        }
        .body-sub {
            font-size: 13px;
            color: var(--brown-light);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 14px;
        }
        .form-label {
            display: block;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--brown-mid);
            margin-bottom: 6px;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 13px;
            color: #c8bbb0;
            font-size: 13px;
            pointer-events: none;
            transition: color .2s;
        }
        .input-eye {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #c8bbb0;
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
        .form-input::placeholder { color: #cfc4b8; font-size: 13px; }
        .form-input:focus {
            border-color: var(--brand);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(200,115,90,.11);
        }
        .form-input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--brand); }
        .form-input.is-valid   { border-color: #2ecc71; }
        .form-input.is-invalid { border-color: #e74c3c; }

        /* ── Strength bar ── */
        .pw-strength {
            margin-top: 7px;
        }
        .strength-segs {
            display: flex;
            gap: 4px;
            margin-bottom: 4px;
        }
        .seg {
            flex: 1; height: 3px;
            border-radius: 2px;
            background: var(--border);
            transition: background .3s;
        }
        .seg.weak   { background: #e74c3c; }
        .seg.medium { background: #f39c12; }
        .seg.strong { background: #27ae60; }
        .strength-lbl {
            font-size: 11px;
            font-weight: 600;
            color: var(--brown-light);
        }
        .strength-lbl.weak   { color: #e74c3c; }
        .strength-lbl.medium { color: #f39c12; }
        .strength-lbl.strong { color: #27ae60; }

        /* ── Requirements ── */
        .req-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 7px;
        }
        .req {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            background: #f2ece6;
            color: var(--brown-light);
            border: 1px solid var(--border);
            transition: all .25s;
        }
        .req.met {
            background: #eafaf1;
            color: #27ae60;
            border-color: #b8dcb8;
        }
        .req i { font-size: 9px; }

        /* ── Match label ── */
        .match-lbl {
            font-size: 11px;
            font-weight: 600;
            margin-top: 5px;
            color: var(--brown-light);
        }
        .match-lbl.ok  { color: #27ae60; }
        .match-lbl.err { color: #e74c3c; }

        /* ── Terms ── */
        .terms-box {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 13px;
            background: #faf7f3;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            margin-bottom: 16px;
        }
        .terms-box input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 17px; height: 17px;
            border: 1.5px solid #d8cfc6;
            border-radius: 5px;
            background: #fff;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            margin-top: 1px;
            transition: all .15s;
        }
        .terms-box input:checked {
            background: var(--brand);
            border-color: var(--brand);
        }
        .terms-box input:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 9px;
            color: #fff;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%,-50%);
        }
        .terms-text {
            font-size: 12.5px;
            color: var(--brown-mid);
            line-height: 1.55;
        }
        .terms-text a { color: var(--brand); font-weight: 600; text-decoration: none; }
        .terms-text a:hover { text-decoration: underline; }

        /* ── Submit ── */
        .submit-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--brand) 0%, #a05040 100%);
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

        /* ── Footer ── */
        .card-footer {
            padding: 16px 28px 20px;
            border-top: 1px solid var(--border);
            background: #faf7f3;
            text-align: center;
        }
        .switch-hint { font-size: 13.5px; color: var(--brown-light); }
        .switch-hint a { color: var(--brand); font-weight: 700; text-decoration: none; }
        .switch-hint a:hover { text-decoration: underline; }
        .secure-note {
            margin-top: 9px;
            font-size: 11.5px;
            color: #c4b5a5;
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
            margin-bottom: 14px;
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
                padding: 18px 16px;
            }
            .brand-name {
                font-size: 18px;
            }
            .benefits-strip {
                grid-template-columns: repeat(2, 1fr);
            }
            .benefit-item {
                border-bottom: 1px solid var(--border);
            }
            .benefit-item:nth-child(2) {
                border-right: none;
            }
            .benefit-item:nth-child(3),
            .benefit-item:nth-child(4) {
                border-bottom: none;
            }
            .card-body {
                padding: 18px 16px;
            }
            .body-title {
                font-size: 18.5px;
            }
            .body-sub {
                font-size: 12px;
                margin-bottom: 16px;
            }
            .card-footer {
                padding: 14px 16px;
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

        <!-- Banner: back + brand -->
        <div class="card-banner">
            <a href="{{ url('/') }}" class="back-btn" id="back-home-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
            <div class="banner-brand">
                <div class="brand-icon">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <div>
                    <div class="brand-name">Dapur Bunda</div>
                    <div class="brand-sub">Cita Rasa Rumahan Terbaik</div>
                </div>
            </div>
        </div>

        <!-- Benefits strip -->
        <div class="benefits-strip">
            <div class="benefit-item">
                <div class="benefit-ico"><i class="fa-solid fa-bolt"></i></div>
                <span>Pesan Cepat</span>
            </div>
            <div class="benefit-item">
                <div class="benefit-ico"><i class="fa-solid fa-heart"></i></div>
                <span>Menu Favorit</span>
            </div>
            <div class="benefit-item">
                <div class="benefit-ico"><i class="fa-solid fa-receipt"></i></div>
                <span>Riwayat</span>
            </div>
            <div class="benefit-item">
                <div class="benefit-ico"><i class="fa-solid fa-tag"></i></div>
                <span>Promo Eksklusif</span>
            </div>
        </div>

        <!-- Form body -->
        <div class="card-body">
            <h1 class="body-title">Buat Akun Baru ✨</h1>
            <p class="body-sub">Bergabung dan nikmati kemudahan memesan kuliner pilihan bunda.</p>

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="register-form">
                @csrf

                <!-- Nama -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-wrap">
                        <i class="fa-regular fa-user input-icon"></i>
                        <input type="text" id="name" name="name" class="form-input"
                               placeholder="Nama lengkap Anda"
                               value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="fa-regular fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input"
                               placeholder="nama@email.com"
                               value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Min. 8 karakter" required style="padding-right: 40px;">
                        <button type="button" class="input-eye" id="toggle-pw1" aria-label="Lihat password">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <!-- Strength -->
                    <div class="pw-strength">
                        <div class="strength-segs">
                            <div class="seg" id="s1"></div>
                            <div class="seg" id="s2"></div>
                            <div class="seg" id="s3"></div>
                            <div class="seg" id="s4"></div>
                        </div>
                        <div class="strength-lbl" id="strength-lbl"></div>
                        <div class="req-badges">
                            <span class="req" id="req-len"><i class="fa-solid fa-circle-xmark"></i> 8+ karakter</span>
                            <span class="req" id="req-num"><i class="fa-solid fa-circle-xmark"></i> Angka</span>
                            <span class="req" id="req-up"><i class="fa-solid fa-circle-xmark"></i> Huruf besar</span>
                        </div>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-input" placeholder="Ulangi password Anda"
                               required style="padding-right: 40px;">
                        <button type="button" class="input-eye" id="toggle-pw2" aria-label="Lihat konfirmasi">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    <div class="match-lbl" id="match-lbl"></div>
                </div>

                <!-- Terms -->
                <div class="terms-box">
                    <input type="checkbox" id="agree" required>
                    <label for="agree" class="terms-text">
                        Saya menyetujui <a href="#">Syarat & Ketentuan</a> serta
                        <a href="#">Kebijakan Privasi</a> Dapur Bunda.
                    </label>
                </div>

                <button type="submit" class="submit-btn" id="register-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Buat Akun Sekarang</span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="card-footer">
            <p class="switch-hint">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di Sini</a>
            </p>
            <p class="secure-note">
                <i class="fa-solid fa-shield-halved"></i>
                Data Anda aman & terenkripsi
            </p>
        </div>

    </div>

    <script>
        // ── Toggle eye ──
        function eyeToggle(btnId, inputId) {
            const btn = document.getElementById(btnId);
            const inp = document.getElementById(inputId);
            if (!btn || !inp) return;
            btn.addEventListener('click', () => {
                const hide = inp.type === 'password';
                inp.type = hide ? 'text' : 'password';
                btn.querySelector('i').className = hide
                    ? 'fa-regular fa-eye-slash'
                    : 'fa-regular fa-eye';
            });
        }
        eyeToggle('toggle-pw1', 'password');
        eyeToggle('toggle-pw2', 'password_confirmation');

        // ── Password strength ──
        const pw      = document.getElementById('password');
        const conf    = document.getElementById('password_confirmation');
        const segs    = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
        const sLbl    = document.getElementById('strength-lbl');
        const mLbl    = document.getElementById('match-lbl');
        const rLen    = document.getElementById('req-len');
        const rNum    = document.getElementById('req-num');
        const rUp     = document.getElementById('req-up');

        function setReq(el, ok) {
            el.className = 'req' + (ok ? ' met' : '');
            el.querySelector('i').className = ok ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark';
        }

        function strength(val) {
            let s = 0;
            if (val.length >= 8)          s++;
            if (/[0-9]/.test(val))        s++;
            if (/[A-Z]/.test(val))        s++;
            if (/[^a-zA-Z0-9]/.test(val)) s++;
            return s;
        }

        pw && pw.addEventListener('input', () => {
            const v = pw.value;
            const s = strength(v);
            setReq(rLen, v.length >= 8);
            setReq(rNum, /[0-9]/.test(v));
            setReq(rUp,  /[A-Z]/.test(v));

            const cls = ['','weak','weak','medium','strong'];
            segs.forEach((el, i) => { el.className = 'seg ' + (i < s ? cls[s] : ''); });

            if (!v) { sLbl.textContent = ''; sLbl.className = 'strength-lbl'; }
            else if (s <= 1) { sLbl.textContent = 'Lemah'; sLbl.className = 'strength-lbl weak'; }
            else if (s === 2) { sLbl.textContent = 'Cukup'; sLbl.className = 'strength-lbl medium'; }
            else if (s === 3) { sLbl.textContent = 'Kuat'; sLbl.className = 'strength-lbl strong'; }
            else              { sLbl.textContent = 'Sangat Kuat 💪'; sLbl.className = 'strength-lbl strong'; }

            checkMatch();
        });

        function checkMatch() {
            if (!conf.value) { mLbl.textContent = ''; return; }
            const ok = pw.value === conf.value;
            mLbl.textContent  = ok ? '✓ Password cocok' : '✗ Password tidak cocok';
            mLbl.className    = 'match-lbl ' + (ok ? 'ok' : 'err');
            conf.classList.toggle('is-valid',   ok);
            conf.classList.toggle('is-invalid', !ok);
        }
        conf && conf.addEventListener('input', checkMatch);
    </script>
</body>
</html>
