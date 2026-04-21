<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login · ActiveHub</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      width: 100%;
      height: 100%;
      font-family: 'Outfit', 'Poppins', sans-serif;
      background: #162810;
      color: #1a2e0d;
      overflow: hidden;
    }

    body {
      padding: 0;
    }

    .login-layout {
      display: grid;
      grid-template-columns: 54% 46%;
      height: 100vh;
      border-radius: 0;
      overflow: hidden;
      background: #f4f7f0;
    }

    .hero-panel {
      --hero-image: url('https://images.pexels.com/photos/6203523/pexels-photo-6203523.jpeg?auto=compress&cs=tinysrgb&w=1600&h=1200&dpr=1');
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: flex-end;
      padding: 0 52px 56px;
    }

    .hero-panel::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: var(--hero-image);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      transform: scale(1);
      transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      z-index: 0;
    }

    .hero-panel::after {
      content: '';
      position: absolute;
      inset: 0;
      background:
        linear-gradient(160deg, rgba(10, 30, 5, 0.18) 0%, rgba(20, 60, 8, 0.52) 55%, rgba(8, 22, 4, 0.80) 100%);
      z-index: 1;
    }

    .hero-panel:hover::before {
      transform: scale(1.06);
    }

    .hero-overlay {
      position: relative;
      z-index: 2;
      max-width: 620px;
      color: #ffffff;
    }

    .brand {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 28px;
      text-decoration: none;
      color: #ffffff;
      transition: transform 0.3s ease;
    }

    .brand:hover {
      transform: translateX(4px);
    }

    .brand-icon {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: #c6df28;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 20px rgba(198, 223, 40, 0.45);
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .brand:hover .brand-icon {
      box-shadow: 0 12px 28px rgba(198, 223, 40, 0.65);
      transform: rotate(-6deg) scale(1.1);
    }

    .brand-name {
      font-size: 44px;
      font-weight: 700;
      letter-spacing: -0.02em;
      line-height: 1;
      color: #ffffff;
    }

    .hero-title {
      font-size: clamp(54px, 4.8vw, 72px);
      line-height: 1.03;
      letter-spacing: -0.03em;
      font-weight: 800;
      margin-bottom: 16px;
      text-shadow: 0 8px 24px rgba(0, 0, 0, 0.32);
    }

    .hero-subtitle {
      font-size: 18px;
      line-height: 1.45;
      color: rgba(255, 255, 255, 0.82);
      margin-bottom: 20px;
      max-width: 650px;
    }

    .hero-users {
      display: flex;
      align-items: center;
      gap: 14px;
      color: rgba(255, 255, 255, 0.9);
      font-size: 18px;
      font-weight: 500;
    }

    .avatar-group {
      display: flex;
      align-items: center;
    }

    .avatar {
      width: 36px;
      height: 36px;
      border-radius: 999px;
      border: 2.5px solid rgba(255, 255, 255, 0.95);
      margin-left: -10px;
      display: inline-block;
      object-fit: cover;
      box-shadow: 0 2px 8px rgba(0,0,0,0.25);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .avatar:first-child {
      margin-left: 0;
    }

    .avatar:hover {
      transform: scale(1.12) translateY(-2px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.3);
      z-index: 10;
      position: relative;
    }

    .form-panel {
      background: #f4f7f0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 44px 56px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #8aac5a #f4f7f0;
    }

    .form-panel::-webkit-scrollbar {
      width: 8px;
    }

    .form-panel::-webkit-scrollbar-track {
      background: #f4f7f0;
    }

    .form-panel::-webkit-scrollbar-thumb {
      background: #8aac5a;
      border-radius: 999px;
    }

    .form-wrap {
      width: 100%;
      max-width: 580px;
    }

    .form-header h1 {
      font-size: 38px;
      line-height: 1.08;
      color: #1a2e0d;
      font-weight: 800;
      margin-bottom: 12px;
      letter-spacing: -0.02em;
    }

    .form-header p {
      font-size: 16px;
      color: #3d5e28;
      margin-bottom: 24px;
      line-height: 1.2;
    }

    .form-header p a {
      color: #4a7a1e;
      font-weight: 700;
      text-decoration: underline;
      text-underline-offset: 3px;
      transition: color 0.2s;
    }

    .form-header p a:hover {
      color: #c6df28;
    }

    .field-group {
      margin-bottom: 24px;
    }

    .field-head {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 11px;
    }

    .field-label {
      display: block;
      color: #2a4418;
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 11px;
    }

    .field-head .field-label {
      margin-bottom: 0;
    }

    .forgot-link {
      color: #4a7a1e;
      text-decoration: none;
      font-size: 13px;
      font-weight: 600;
      transition: color 0.2s;
    }

    .forgot-link:hover {
      color: #c6df28;
    }

    .input-wrap {
      position: relative;
    }

    .input-field {
      width: 100%;
      height: 56px;
      border: 1.5px solid #c8d9bb;
      border-radius: 18px;
      background: #ffffff;
      font-size: 14px;
      font-family: 'Outfit', 'Poppins', sans-serif;
      color: #1a2e0d;
      padding: 0 24px;
      transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
    }

    .input-field::placeholder {
      color: #8aaa76;
      font-weight: 400;
    }

    .input-field:focus {
      outline: none;
      border-color: #c6df28;
      box-shadow: 0 0 0 3px rgba(198, 223, 40, 0.18);
      background: #fbfff0;
    }

    .input-field:hover:not(:focus) {
      border-color: #8aac5a;
    }

    .input-field.password {
      padding-right: 70px;
    }

    .password-toggle {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      border: 0;
      background: transparent;
      color: #5a8a30;
      cursor: pointer;
      width: 30px;
      height: 30px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s, transform 0.2s;
    }

    .password-toggle:hover {
      color: #4a7a1e;
      transform: translateY(-50%) scale(1.15);
    }

    .remember-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 22px 0 26px;
    }

    .remember-row input {
      width: 20px;
      height: 20px;
      accent-color: #2a4418;
      cursor: pointer;
    }

    .remember-row label {
      font-size: 16px;
      color: #3d5e28;
      font-weight: 500;
      cursor: pointer;
    }

    .submit-btn {
      width: 100%;
      height: 58px;
      border: 0;
      border-radius: 20px;
      background: linear-gradient(135deg, #1a2e0d 0%, #2a4418 50%, #1a2e0d 100%);
      background-size: 200% 100%;
      background-position: right center;
      color: #c6df28;
      font-size: 17px;
      font-weight: 700;
      font-family: 'Outfit', 'Poppins', sans-serif;
      letter-spacing: 0.01em;
      cursor: pointer;
      box-shadow: 0 4px 18px rgba(26, 46, 13, 0.40);
      transition: background-position 0.4s ease, box-shadow 0.3s, transform 0.2s;
    }

    .submit-btn:hover {
      background-position: left center;
      box-shadow: 0 8px 28px rgba(26, 46, 13, 0.55);
      transform: translateY(-2px);
      color: #d4f030;
    }

    .submit-btn:active {
      transform: translateY(0);
      box-shadow: 0 3px 12px rgba(26, 46, 13, 0.30);
    }

    .divider {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      gap: 16px;
      align-items: center;
      margin: 24px 0;
      color: #6d9048;
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .divider::before,
    .divider::after {
      content: '';
      height: 1px;
      background: #c8d9bb;
    }

    .google-btn {
      width: 100%;
      height: 56px;
      border-radius: 18px;
      border: 1.5px solid #c8d9bb;
      background: #ffffff;
      color: #1a2e0d;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      font-weight: 600;
      font-family: 'Outfit', 'Poppins', sans-serif;
      cursor: pointer;
      transition: border-color 0.25s, box-shadow 0.25s, background 0.25s, transform 0.2s;
    }

    .google-btn:hover {
      border-color: #c6df28;
      background: #fbfff0;
      box-shadow: 0 4px 16px rgba(198, 223, 40, 0.20);
      transform: translateY(-1px);
    }

    .legal {
      margin-top: 22px;
      text-align: center;
      color: #6d9048;
      font-size: 12px;
      line-height: 1.55;
    }

    .legal a {
      color: #4a7a1e;
      text-decoration: underline;
      text-underline-offset: 3px;
      transition: color 0.2s;
    }

    .legal a:hover {
      color: #2a4418;
    }

    .error-box {
      background: #fff4f4;
      border: 1px solid #f5b4b4;
      color: #8e1f1f;
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 18px;
      font-size: 14px;
    }

    .error-box p + p {
      margin-top: 6px;
    }

    .success-box {
      background: #edfbe9;
      border: 1px solid #9ad58a;
      color: #1f6b2a;
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 18px;
      font-size: 14px;
      font-weight: 600;
    }

    /* ── Role Switcher ── */
    .role-switcher {
      display: flex;
      background: #e4edd9;
      border-radius: 999px;
      padding: 4px;
      margin: 0 auto 32px;
      position: relative;
      width: fit-content;
    }

    .role-tab {
      position: relative;
      z-index: 2;
      padding: 10px 28px;
      border-radius: 999px;
      border: none;
      background: transparent;
      font-family: 'Outfit', 'Poppins', sans-serif;
      font-size: 14px;
      font-weight: 600;
      color: #5a7a3a;
      cursor: pointer;
      transition: color 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }

    .role-tab.active {
      color: #ffffff;
    }

    .role-slider {
      position: absolute;
      top: 4px;
      left: 4px;
      height: calc(100% - 8px);
      border-radius: 999px;
      background: linear-gradient(135deg, #1a2e0d, #2a4418);
      box-shadow: 0 4px 14px rgba(26, 46, 13, 0.35);
      transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), width 0.35s ease;
      z-index: 1;
    }

    .role-tab svg {
      flex-shrink: 0;
      transition: transform 0.3s ease;
    }

    .role-tab.active svg {
      transform: scale(1.15);
    }

    .form-header h1 span {
      display: inline-block;
      transition: opacity 0.2s, transform 0.2s;
    }

    @media (max-width: 1100px) {
      html,
      body {
        overflow: auto;
      }

      .login-layout {
        grid-template-columns: 1fr;
        border-radius: 0;
        height: auto;
        min-height: 100vh;
      }

      body {
        padding: 0;
      }

      .hero-panel {
        display: none;
      }

      .form-panel {
        min-height: 100vh;
      }

      .brand-name {
        font-size: 30px;
      }

      .hero-title {
        font-size: clamp(34px, 8vw, 48px);
      }

      .hero-subtitle {
        font-size: 16px;
        max-width: 100%;
      }

      .hero-users {
        font-size: 15px;
      }

      .avatar {
        width: 28px;
        height: 28px;
        font-size: 12px;
      }

      .form-panel {
        padding: 28px 20px 36px;
        overflow: visible;
        background: #f4f7f0;
      }

      .form-header h1 {
        font-size: 30px;
      }

      .form-header p {
        font-size: 14px;
      }

      .field-label,
      .forgot-link,
      .remember-row label,
      .divider,
      .google-btn {
        font-size: 14px;
      }

      .submit-btn {
        font-size: 16px;
      }

      .input-field {
        font-size: 14px;
        height: 52px;
      }

      .legal {
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
<main class="login-layout">
  <section class="hero-panel" aria-label="ActiveHub intro">
    <div class="hero-overlay">
      <a href="{{ route('home') }}" class="brand" aria-label="ActiveHub">
        <span class="brand-icon" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="12" r="8" stroke="#03210F" stroke-width="2"/>
            <path d="M4 12H20" stroke="#03210F" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 4C13.9101 5.9543 15 8.55692 15 12C15 15.4431 13.9101 18.0457 12 20" stroke="#03210F" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 4C10.0899 5.9543 9 8.55692 9 12C9 15.4431 10.0899 18.0457 12 20" stroke="#03210F" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </span>
        <span class="brand-name">ActiveHub</span>
      </a>

      <h2 class="hero-title">Cari lapangan.<br>Temukan lawan. Main bareng.</h2>
      <p class="hero-subtitle">Booking badminton, futsal, basket &amp; padel - semua di satu tempat.</p>

      <div class="hero-users" aria-label="Jumlah pemain aktif">
        <div class="avatar-group" aria-hidden="true">
          <img class="avatar" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=72&h=72&fit=crop&crop=face&auto=format" alt="Pemain 1">
          <img class="avatar" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=72&h=72&fit=crop&crop=face&auto=format" alt="Pemain 2">
          <img class="avatar" src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=72&h=72&fit=crop&crop=face&auto=format" alt="Pemain 3">
          <img class="avatar" src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=72&h=72&fit=crop&crop=face&auto=format" alt="Pemain 4">
        </div>
        <span>10.000+ pemain aktif</span>
      </div>
    </div>
  </section>

  <section class="form-panel" aria-label="Login form">
    <div class="form-wrap">

      <!-- Role Switcher -->
      <div class="role-switcher" id="roleSwitcher" role="tablist" aria-label="Pilih peran">
        <div class="role-slider" id="roleSlider"></div>
        <button class="role-tab active" id="tab-user" role="tab" aria-selected="true" data-role="user">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="2"/>
            <circle cx="16" cy="9" r="2.5" stroke="currentColor" stroke-width="2"/>
            <path d="M3 19C3 16.239 5.686 14 9 14C12.314 14 15 16.239 15 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M13 19C13 17.067 14.791 15.5 17 15.5C19.209 15.5 21 17.067 21 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Pemain
        </button>
        <button class="role-tab" id="tab-owner" role="tab" aria-selected="false" data-role="owner">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 11L6.5 6.5H17.5L21 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <rect x="4" y="11" width="16" height="9" rx="2" stroke="currentColor" stroke-width="2"/>
            <path d="M12 11V20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M8.5 15.5H9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M14.5 15.5H15.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Pemilik Lapangan
        </button>
      </div>

      <header class="form-header">
        <h1 id="formTitle">Masuk sebagai <span id="roleLabel">Pemain</span></h1>
        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
      </header>

      @if (session('success'))
      <div class="success-box" role="status">
        <p>{{ session('success') }}</p>
      </div>
      @endif

      @if ($errors->any())
      <div class="error-box" role="alert">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
      </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="field-group">
          <label class="field-label" for="login">Email / No. Hp</label>
          <input
            class="input-field @error('login') !border-red-400 @enderror"
            id="login"
            name="login"
            type="text"
            value="{{ old('login') }}"
            placeholder="nama@email.com"
            autocomplete="username"
            required
          >
        </div>

        <div class="field-group">
          <div class="field-head">
            <label class="field-label" for="password">Password</label>
            <a href="#" class="forgot-link">Lupa password?</a>
          </div>
          <div class="input-wrap">
            <input
              class="input-field password @error('password') !border-red-400 @enderror"
              id="password"
              name="password"
              type="password"
              placeholder="••••••••"
              autocomplete="current-password"
              required
            >
            <button class="password-toggle" type="button" id="togglePassword" aria-label="Toggle password visibility">
              <!-- Mata dicoret: password hidden (default) -->
              <svg id="icon-eye-off" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M9.88 9.88C9.34 10.42 9 11.17 9 12C9 13.66 10.34 15 12 15C12.83 15 13.58 14.66 14.12 14.12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M10.73 5.08C11.15 5.03 11.57 5 12 5C16.18 5 19.77 7.56 21.31 11.2C20.98 11.99 20.54 12.74 20 13.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M6.71 6.72C4.88 7.85 3.43 9.39 2.69 11.2C4.23 14.84 7.82 17.4 12 17.4C13.23 17.4 14.41 17.17 15.49 16.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              <!-- Mata terbuka: password visible -->
              <svg id="icon-eye-on" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none">
                <path d="M2.69 12C4.23 8.36 7.82 5.8 12 5.8C16.18 5.8 19.77 8.36 21.31 12C19.77 15.64 16.18 18.2 12 18.2C7.82 18.2 4.23 15.64 2.69 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="remember-row">
          <input id="remember" name="remember" type="checkbox">
          <label for="remember">Ingat saya</label>
        </div>

        <button class="submit-btn" type="submit">Masuk</button>

        <div class="divider">Atau</div>

        <button type="button" class="google-btn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M22.56 12.25C22.56 11.47 22.49 10.72 22.36 10H12V14.26H17.92C17.66 15.63 16.88 16.79 15.71 17.57V20.34H19.28C21.36 18.42 22.56 15.6 22.56 12.25Z" fill="#4285F4"/>
            <path d="M12 23C14.97 23 17.46 22.02 19.28 20.34L15.71 17.57C14.73 18.23 13.48 18.63 12 18.63C9.14 18.63 6.71 16.7 5.84 14.1H2.18V16.94C3.99 20.53 7.7 23 12 23Z" fill="#34A853"/>
            <path d="M5.84 14.1C5.62 13.44 5.49 12.74 5.49 12.01C5.49 11.28 5.62 10.58 5.84 9.92V7.08H2.18C1.43 8.56 1 10.23 1 12.01C1 13.79 1.43 15.46 2.18 16.94L5.84 14.1Z" fill="#FBBC05"/>
            <path d="M12 5.38C13.62 5.38 15.06 5.94 16.21 7.02L19.36 3.87C17.45 2.09 14.97 1 12 1C7.7 1 3.99 3.47 2.18 7.08L5.84 9.92C6.71 7.31 9.14 5.38 12 5.38Z" fill="#EA4335"/>
          </svg>
          Masuk dengan Google
        </button>

        <p class="legal">
          Dengan masuk, kamu setuju dengan
          <a href="#">Syarat &amp; ketentuan</a>
          dan
          <a href="#">Kebijakan privasi</a>.
        </p>
      </form>
    </div>
  </section>
</main>

<script>
  // ── Password Toggle ──
  const toggle = document.getElementById('togglePassword');
  const password = document.getElementById('password');
  const iconEyeOff = document.getElementById('icon-eye-off');
  const iconEyeOn  = document.getElementById('icon-eye-on');

  toggle.addEventListener('click', function () {
    const isHidden = password.type === 'password';
    password.type = isHidden ? 'text' : 'password';
    iconEyeOff.style.display = isHidden ? 'none'  : 'block';
    iconEyeOn.style.display  = isHidden ? 'block' : 'none';
  });

  // ── Role Switcher ──
  const tabs      = document.querySelectorAll('.role-tab');
  const slider    = document.getElementById('roleSlider');
  const roleLabel = document.getElementById('roleLabel');
  const loginInput = document.getElementById('login');
  const heroPanel = document.querySelector('.hero-panel');

  const roleConfig = {
    user:  {
      label: 'Pemain',
      placeholder: 'Email atau No. HP kamu',
      heroImage: "url('https://images.pexels.com/photos/6203523/pexels-photo-6203523.jpeg?auto=compress&cs=tinysrgb&w=1600&h=1200&dpr=1')"
    },
    owner: {
      label: 'Pemilik Lapangan',
      placeholder: 'Email pemilik lapangan',
      heroImage: "url('https://images.pexels.com/photos/114296/pexels-photo-114296.jpeg?auto=compress&cs=tinysrgb&w=1600&h=1200&dpr=1')"
    },
  };

  function updateSlider(activeTab) {
    const switcher  = document.getElementById('roleSwitcher');
    const switcherRect = switcher.getBoundingClientRect();
    const tabRect      = activeTab.getBoundingClientRect();
    slider.style.width     = tabRect.width + 'px';
    slider.style.transform = `translateX(${tabRect.left - switcherRect.left - 4}px)`;
  }

  // Init slider on load
  window.addEventListener('load', () => {
    const activeTab = document.querySelector('.role-tab.active');
    updateSlider(activeTab);
    const initialRole = activeTab?.dataset?.role || 'user';
    if (heroPanel && roleConfig[initialRole]) {
      heroPanel.style.setProperty('--hero-image', roleConfig[initialRole].heroImage);
    }
  });

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      // Update active state
      tabs.forEach(t => {
        t.classList.remove('active');
        t.setAttribute('aria-selected', 'false');
      });
      tab.classList.add('active');
      tab.setAttribute('aria-selected', 'true');

      // Move slider
      updateSlider(tab);

      // Update text & placeholder
      const role = tab.dataset.role;
      const cfg  = roleConfig[role];

      roleLabel.style.opacity   = '0';
      roleLabel.style.transform = 'translateY(-6px)';
      setTimeout(() => {
        roleLabel.textContent     = cfg.label;
        roleLabel.style.opacity   = '1';
        roleLabel.style.transform = 'translateY(0)';
      }, 160);

      loginInput.placeholder = cfg.placeholder;
      if (heroPanel) {
        heroPanel.style.setProperty('--hero-image', cfg.heroImage);
      }
    });
  });
</script>
</body>
</html>
```