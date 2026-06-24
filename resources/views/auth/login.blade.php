<x-guest-layout>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Inter', sans-serif; }

  /* ── FULL SCREEN WRAP ── */
  .login-wrap {
    min-height: 100vh;
    display: flex;
    position: relative;
    overflow: hidden;
  }

  /* ── BACKGROUND IMAGE (full screen, blurred) ── */
  .bg-image {
    position: fixed;
    inset: 0;
    background: url("{{ asset('images/login-image.png') }}") center center / cover no-repeat;
    filter: blur(14px) brightness(0.45) saturate(1.2);
    transform: scale(1.06);
    z-index: 0;
  }

  /* dark overlay on top of blurred bg */
  .bg-overlay {
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg,
      rgba(17,24,39,0.72) 0%,
      rgba(17,24,39,0.55) 50%,
      rgba(25,103,210,0.18) 100%);
    z-index: 1;
  }

  /* ── LEFT PANEL ── */
  .left-panel {
    display: none;
    width: 55%;
    position: relative;
    z-index: 2;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 48px 40px;
  }

  @media (min-width: 1024px) { .left-panel { display: flex; } }

  .left-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 28px;
    text-align: center;
  }

  /* brand */
  .uni-brand {
    display: flex;
    align-items: center;
    gap: 14px;
    animation: slideDown 0.7s ease both;
  }

  .uni-logo {
    width: 54px; height: 54px;
    border-radius: 14px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(8px);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #fff; font-weight: 800;
    letter-spacing: -1px;
  }

  .uni-name  { font-size: 16px; font-weight: 700; color: #fff; line-height: 1.3; text-align: left; }
  .uni-sub   { font-size: 11.5px; color: rgba(255,255,255,0.55); font-weight: 400; }

  /* illustration — floating clean on top of blurred bg */
  .illus-wrap {
    width: 78%;
    max-width: 420px;
    animation: floatImg 6s ease-in-out infinite;
    filter: drop-shadow(0 24px 48px rgba(0,0,0,0.5));
  }

  .illus-wrap img { width: 100%; }

  @keyframes floatImg {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-14px); }
  }

  /* tagline */
  .tagline { animation: slideUp 0.9s ease both; }
  .tagline h2 { font-size: 24px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
  .tagline p  { font-size: 13px; color: rgba(255,255,255,0.55); margin-top: 7px; }

  /* pills */
  .feature-pills {
    display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;
    animation: slideUp 1.1s ease both;
  }

  .pill {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(8px);
    font-size: 11.5px; color: rgba(255,255,255,0.8); font-weight: 500;
    transition: transform 0.2s ease, background 0.2s ease;
  }

  .pill:hover { transform: translateY(-2px); background: rgba(255,255,255,0.16); }
  .pill i { font-size: 11px; color: #60a5fa; }

  /* ── RIGHT PANEL (glassmorphism card) ── */
  .right-panel {
    flex: 1;
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 32px 40px;
  }

  .form-card {
    width: 100%;
    max-width: 420px;
    background: rgba(17,24,39,0.75);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    padding: 36px 32px 28px;
    box-shadow: 0 24px 64px rgba(0,0,0,0.4);
    animation: slideUp 0.6s ease both;
    position: relative;
    overflow: hidden;
  }

  /* glow accent inside card */
  .form-card::before {
    content: '';
    position: absolute;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(25,103,210,0.22), transparent 70%);
    top: -100px; right: -80px;
    pointer-events: none;
    animation: glowPulse 5s ease-in-out infinite;
  }

  @keyframes glowPulse {
    0%, 100% { opacity: 0.6; transform: scale(1); }
    50%       { opacity: 1;   transform: scale(1.15); }
  }

  /* grid texture inside card */
  .form-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
    border-radius: 20px;
  }

  .form-inner { position: relative; z-index: 3; }

  /* app badge */
  .app-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(25,103,210,0.15);
    border: 1px solid rgba(25,103,210,0.3);
    border-radius: 20px;
    padding: 5px 14px 5px 8px;
    margin-bottom: 22px;
  }

  .app-badge-icon {
    width: 26px; height: 26px;
    background: #1967d2;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; color: #fff;
  }

  .app-badge span { font-size: 12px; color: #93c5fd; font-weight: 600; }

  /* heading */
  .form-heading h1 { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -0.5px; line-height: 1.2; }
  .form-heading p  { font-size: 13px; color: #6b7280; margin-top: 6px; }

  /* divider */
  .divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    margin: 20px 0;
  }

  /* field */
  .field { margin-bottom: 16px; }

  .field label {
    display: block;
    font-size: 11px; font-weight: 600; color: #9ca3af;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin-bottom: 7px;
  }

  /* input wrapper: icon left, eye right */
  .input-wrap { position: relative; }

  .input-icon-left {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    color: #4b5563; font-size: 13px;
    transition: color 0.2s; pointer-events: none; z-index: 1;
  }

  .input-wrap:focus-within .input-icon-left { color: #60a5fa; }

  .input-wrap input {
    width: 100%;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    color: #fff;
    font-size: 14px; font-family: 'Inter', sans-serif;
    padding: 12px 44px 12px 38px;
    outline: none;
    transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
  }

  .input-wrap input::placeholder { color: #4b5563; }

  .input-wrap input:focus {
    border-color: #1967d2;
    background: rgba(25,103,210,0.1);
    box-shadow: 0 0 0 3px rgba(25,103,210,0.2);
  }

  /* toggle eye — INSIDE input on the right */
  .toggle-pw {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    background: none; border: none;
    color: #4b5563; font-size: 14px;
    cursor: pointer; padding: 4px; line-height: 1;
    transition: color 0.2s; z-index: 2;
    display: flex; align-items: center;
  }

  .toggle-pw:hover { color: #9ca3af; }

  /* meta row */
  .meta-row {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
  }

  .remember { display: flex; align-items: center; gap: 8px; cursor: pointer; }
  .remember input[type=checkbox] { width: 15px; height: 15px; accent-color: #1967d2; cursor: pointer; }
  .remember span { font-size: 13px; color: #9ca3af; }

  .forgot-link { font-size: 13px; color: #60a5fa; text-decoration: none; transition: color 0.2s; }
  .forgot-link:hover { color: #93c5fd; }

  /* submit */
  .btn-login {
    width: 100%;
    background: #1967d2;
    color: #fff; font-size: 14px; font-weight: 700; font-family: 'Inter', sans-serif;
    padding: 13px; border: none; border-radius: 10px; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
    letter-spacing: 0.02em; position: relative; overflow: hidden;
  }

  .btn-login::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.12), transparent);
    opacity: 0; transition: opacity 0.2s;
  }

  .btn-login:hover { background: #1557b8; transform: translateY(-1px); box-shadow: 0 6px 22px rgba(25,103,210,0.45); }
  .btn-login:hover::before { opacity: 1; }
  .btn-login:active { transform: translateY(0); box-shadow: none; }

  /* footer */
  .form-footer { text-align: center; margin-top: 22px; font-size: 11.5px; color: #374151; }

  /* animations */
  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-16px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation: none !important; transition: none !important; }
  }
</style>

{{-- Full screen blurred background image --}}
<div class="bg-image"></div>
<div class="bg-overlay"></div>

<div class="login-wrap">

    {{-- ── LEFT PANEL ── --}}
    <div class="left-panel">
        <div class="left-inner">

            {{-- Brand --}}
            <div class="uni-brand">
                <div class="uni-logo">SI</div>
                <div>
                    <div class="uni-name">SIAKAD</div>
                    <div class="uni-sub">Sistem Informasi Akademik</div>
                </div>
            </div>

        
            <div class="illus-wrap">
                <img src="{{ asset('images/icon.png') }}" alt="Login Illustration">
            </div>

            {{-- Tagline --}}
            <div class="tagline">
                <h2>Kelola Akademik dengan Mudah</h2>
                <p>Satu platform untuk mengelola kegiatan akademik.</p>
            </div>

            {{-- Feature pills --}}
            <div class="feature-pills">
                <div class="pill"><i class="fa-solid fa-file-signature"></i> KRS Online</div>
                <div class="pill"><i class="fa-solid fa-calendar-check"></i> Jadwal Real-time</div>
                <div class="pill"><i class="fa-solid fa-chart-bar"></i> Monitoring Nilai</div>
            </div>

        </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="right-panel">
        <div class="form-card">
            <div class="form-inner">

                {{-- App badge --}}
                <div class="app-badge">
                    <div class="app-badge-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <span>Login SIAKAD</span>
                </div>

                {{-- Heading --}}
                <div class="form-heading">
                    <h1>Selamat Datang</h1>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <div class="divider"></div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="field">
                        <label for="email">Email</label>
                        <div class="input-wrap">
                            <i class="fa-solid fa-envelope input-icon-left"></i>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                                autofocus>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                required>
                            <button type="button" class="toggle-pw" id="toggleBtn" onclick="togglePw()">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="meta-row">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-login">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Masuk ke SIAKAD
                    </button>

                </form>

                <div class="form-footer">
                    © {{ date('Y') }} SIAKAD · Sistem Informasi Akademik
                </div>

            </div>
        </div>
    </div>

</div>

<script>
function togglePw() {
    var inp  = document.getElementById('password');
    var icon = document.getElementById('eyeIcon');
    if (inp.type === 'password') {
        inp.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        inp.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</x-guest-layout>