<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar · ActiveHub</title>
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

    .register-layout {
      display: grid;
      grid-template-columns: 54% 46%;
      height: 100vh;
      border-radius: 0;
      overflow: hidden;
      background: #f4f7f0;
    }

    .hero-panel {
      --hero-image: url('https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=1600&q=80');
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
      font-size: clamp(52px, 4.6vw, 70px);
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

    .hero-points {
      display: grid;
      gap: 10px;
      color: rgba(255, 255, 255, 0.93);
      font-size: 17px;
      font-weight: 500;
    }

    .point-item {
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    .point-item svg {
      color: #d7f045;
      flex-shrink: 0;
    }

    .form-panel {
      background: #f4f7f0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 36px 64px 52px;
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
      max-width: 600px;
      padding-block: 8px 24px;
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
      margin-bottom: 28px;
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
      margin-bottom: 22px;
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

    .role-switcher {
      display: flex;
      background: #e4edd9;
      border-radius: 999px;
      padding: 4px;
      margin: 18px auto 32px;
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

    .phone-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .phone-prefix {
      height: 56px;
      padding: 0 16px;
      border: 1.5px solid #c8d9bb;
      border-radius: 18px;
      background: #ffffff;
      color: #5a7a3a;
      display: inline-flex;
      align-items: center;
      font-size: 14px;
      font-weight: 600;
      white-space: nowrap;
    }

    .phone-wrap .input-field {
      flex: 1;
    }

    .strength-wrap {
      margin-top: 12px;
    }

    .strength-bars {
      display: flex;
      gap: 6px;
    }

    .strength-bar {
      height: 5px;
      border-radius: 999px;
      flex: 1;
      background: #d9e6cf;
      transition: background 0.25s ease;
    }

    .strength-text {
      margin-top: 7px;
      min-height: 18px;
      font-size: 12px;
      color: #7b9a64;
      font-weight: 600;
    }

    .match-text {
      margin-top: 7px;
      min-height: 18px;
      font-size: 12px;
      font-weight: 600;
      display: none;
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
      margin-top: 2px;
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

    .legal {
      margin-top: 16px;
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

    .error-text {
      margin-top: 6px;
      color: #d63a3a;
      font-size: 12px;
      font-weight: 600;
    }

    .auth-switch {
      margin-top: 16px;
      text-align: center;
      color: #4c6d33;
      font-size: 14px;
    }

    .auth-switch a {
      color: #2f5316;
      font-weight: 700;
      text-decoration: underline;
      text-underline-offset: 3px;
    }

    .auth-switch a:hover {
      color: #1a2e0d;
    }

    @media (max-width: 1100px) {
      html,
      body {
        overflow: auto;
      }

      .register-layout {
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
        align-items: flex-start;
        padding: 78px 28px 56px;
        overflow: visible;
        background: #f4f7f0;
      }

      .form-wrap {
        padding-top: 14px;
      }

      .role-switcher {
        margin-top: 8px;
      }

      .form-header h1 {
        font-size: 30px;
      }

      .form-header p {
        font-size: 14px;
      }

      .field-label,
      .submit-btn,
      .role-tab {
        font-size: 14px;
      }

      .input-field,
      .phone-prefix {
        font-size: 14px;
        height: 52px;
      }

      .phone-wrap {
        gap: 8px;
      }
    }

    @media (max-width: 640px) {
      .form-panel {
        padding: 94px 20px 58px;
      }

      .form-wrap {
        padding-top: 18px;
      }
    }
  </style>
</head>
<body>
<main class="register-layout">
  <section class="hero-panel" aria-label="ActiveHub register intro">
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

      <h2 class="hero-title">Bikin akun baru.<br>Main tanpa ribet.</h2>
      <p class="hero-subtitle">Gabung sebagai pemain atau owner venue, lalu kelola booking dan pertandingan dalam satu dashboard.</p>

      <div class="hero-points" aria-label="Keunggulan ActiveHub">
        <div class="point-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M20 7L9 18L4 13" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Booking lapangan lebih cepat</span>
        </div>
        <div class="point-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M20 7L9 18L4 13" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Join match public langsung dari aplikasi</span>
        </div>
        <div class="point-item">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M20 7L9 18L4 13" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Owner bisa kelola venue dan jadwal</span>
        </div>
      </div>
    </div>
  </section>

  <section class="form-panel" aria-label="Register form">
    <div class="form-wrap">
      <div class="role-switcher" id="roleSwitcher" role="tablist" aria-label="Pilih peran pendaftaran">
        <div class="role-slider" id="roleSlider"></div>
        <button class="role-tab active" id="tab-user" role="tab" aria-selected="true" data-role="user" type="button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="9" cy="8" r="3" stroke="currentColor" stroke-width="2"/>
            <circle cx="16" cy="9" r="2.5" stroke="currentColor" stroke-width="2"/>
            <path d="M3 19C3 16.239 5.686 14 9 14C12.314 14 15 16.239 15 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M13 19C13 17.067 14.791 15.5 17 15.5C19.209 15.5 21 17.067 21 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Pemain
        </button>
        <button class="role-tab" id="tab-owner" role="tab" aria-selected="false" data-role="owner" type="button">
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
        <h1>Buat akun sebagai <span id="roleLabel">Pemain</span></h1>
        <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
      </header>

      @if ($errors->any())
      <div class="error-box" role="alert">
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
      </div>
      @endif

      <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'user') }}">

        <div class="field-group">
          <label class="field-label" for="name">Nama Lengkap</label>
          <input
            class="input-field @error('name') !border-red-400 @enderror"
            id="name"
            name="name"
            type="text"
            value="{{ old('name') }}"
            placeholder="Nama lengkap kamu"
            autocomplete="name"
            required
          >
          @error('name')
          <p class="error-text">{{ $message }}</p>
          @enderror
        </div>

        <div class="field-group">
          <label class="field-label" for="email">Email</label>
          <input
            class="input-field @error('email') !border-red-400 @enderror"
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            placeholder="nama@email.com"
            autocomplete="email"
            required
          >
          @error('email')
          <p class="error-text">{{ $message }}</p>
          @enderror
        </div>

        <div class="field-group">
          <label class="field-label" for="phone">Nomor HP</label>
          <div class="phone-wrap">
            <span class="phone-prefix">+62</span>
            <input
              class="input-field @error('phone') !border-red-400 @enderror"
              id="phone"
              name="phone"
              type="tel"
              value="{{ old('phone') }}"
              placeholder="812 3456 7890"
              autocomplete="tel"
              required
            >
          </div>
          @error('phone')
          <p class="error-text">{{ $message }}</p>
          @enderror
        </div>

        <div class="field-group">
          <label class="field-label" for="password">Password</label>
          <div class="input-wrap">
            <input
              class="input-field password @error('password') !border-red-400 @enderror"
              id="password"
              name="password"
              type="password"
              placeholder="Minimal 8 karakter"
              autocomplete="new-password"
              required
            >
            <button class="password-toggle" type="button" id="togglePassword" aria-label="Toggle password visibility">
              <svg id="icon-eye-off" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 3L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M9.88 9.88C9.34 10.42 9 11.17 9 12C9 13.66 10.34 15 12 15C12.83 15 13.58 14.66 14.12 14.12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M10.73 5.08C11.15 5.03 11.57 5 12 5C16.18 5 19.77 7.56 21.31 11.2C20.98 11.99 20.54 12.74 20 13.42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M6.71 6.72C4.88 7.85 3.43 9.39 2.69 11.2C4.23 14.84 7.82 17.4 12 17.4C13.23 17.4 14.41 17.17 15.49 16.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              <svg id="icon-eye-on" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none">
                <path d="M2.69 12C4.23 8.36 7.82 5.8 12 5.8C16.18 5.8 19.77 8.36 21.31 12C19.77 15.64 16.18 18.2 12 18.2C7.82 18.2 4.23 15.64 2.69 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
              </svg>
            </button>
          </div>

          <div class="strength-wrap">
            <div class="strength-bars">
              <span class="strength-bar" id="strength-1"></span>
              <span class="strength-bar" id="strength-2"></span>
              <span class="strength-bar" id="strength-3"></span>
              <span class="strength-bar" id="strength-4"></span>
            </div>
            <p class="strength-text" id="strengthText"></p>
          </div>
          @error('password')
          <p class="error-text">{{ $message }}</p>
          @enderror
        </div>

        <div class="field-group">
          <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
          <input
            class="input-field"
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            placeholder="Ulangi password"
            autocomplete="new-password"
            required
          >
          <p class="match-text" id="matchText"></p>
        </div>

        <button class="submit-btn" type="submit">Buat Akun</button>

        <p class="legal">
          Dengan mendaftar, kamu setuju dengan
          <a href="#">Syarat &amp; ketentuan</a>
          dan
          <a href="#">Kebijakan privasi</a>.
        </p>
      </form>
    </div>
  </section>
</main>

<script>
  const tabs = document.querySelectorAll('.role-tab');
  const slider = document.getElementById('roleSlider');
  const roleLabel = document.getElementById('roleLabel');
  const roleInput = document.getElementById('roleInput');
  const heroPanel = document.querySelector('.hero-panel');

  const roleConfig = {
    user: {
      label: 'Pemain',
      heroImage: "url('https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=1600&q=80')"
    },
    owner: {
      label: 'Pemilik Lapangan',
      heroImage: "url('https://images.pexels.com/photos/114296/pexels-photo-114296.jpeg?auto=compress&cs=tinysrgb&w=1600&h=1200&dpr=1')"
    },
  };

  function updateSlider(activeTab) {
    const switcher = document.getElementById('roleSwitcher');
    const switcherRect = switcher.getBoundingClientRect();
    const tabRect = activeTab.getBoundingClientRect();
    slider.style.width = tabRect.width + 'px';
    slider.style.transform = `translateX(${tabRect.left - switcherRect.left - 4}px)`;
  }

  function setRole(role) {
    tabs.forEach(tab => {
      const isActive = tab.dataset.role === role;
      tab.classList.toggle('active', isActive);
      tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
      if (isActive) {
        updateSlider(tab);
      }
    });

    roleInput.value = role;
    roleLabel.textContent = roleConfig[role].label;
    if (heroPanel) {
      heroPanel.style.setProperty('--hero-image', roleConfig[role].heroImage);
    }
  }

  window.addEventListener('load', () => {
    const initialRole = roleInput.value === 'owner' ? 'owner' : 'user';
    setRole(initialRole);
  });

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      setRole(tab.dataset.role);
    });
  });

  const toggle = document.getElementById('togglePassword');
  const password = document.getElementById('password');
  const iconEyeOff = document.getElementById('icon-eye-off');
  const iconEyeOn = document.getElementById('icon-eye-on');

  toggle.addEventListener('click', function () {
    const isHidden = password.type === 'password';
    password.type = isHidden ? 'text' : 'password';
    iconEyeOff.style.display = isHidden ? 'none' : 'block';
    iconEyeOn.style.display = isHidden ? 'block' : 'none';
  });

  const strengthBars = [
    document.getElementById('strength-1'),
    document.getElementById('strength-2'),
    document.getElementById('strength-3'),
    document.getElementById('strength-4')
  ];
  const strengthText = document.getElementById('strengthText');
  const confirmInput = document.getElementById('password_confirmation');
  const matchText = document.getElementById('matchText');

  const meterColors = ['#e05050', '#ea8c2f', '#b2b82f', '#42a45f'];
  const meterLabels = ['Lemah', 'Cukup', 'Kuat', 'Sangat kuat'];

  function updatePasswordStrength() {
    const value = password.value;
    let score = 0;
    if (value.length >= 8) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/\d/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;

    strengthBars.forEach((bar, index) => {
      bar.style.background = index < score ? meterColors[Math.max(score - 1, 0)] : '#d9e6cf';
    });

    if (!value.length) {
      strengthText.textContent = '';
      strengthText.style.color = '#7b9a64';
    } else {
      strengthText.textContent = `Kekuatan password: ${meterLabels[Math.max(score - 1, 0)]}`;
      strengthText.style.color = meterColors[Math.max(score - 1, 0)];
    }

    updatePasswordMatch();
  }

  function updatePasswordMatch() {
    if (!confirmInput.value.length) {
      matchText.style.display = 'none';
      confirmInput.style.borderColor = '#c8d9bb';
      return;
    }

    const isMatch = confirmInput.value === password.value;
    matchText.style.display = 'block';
    matchText.textContent = isMatch ? 'Password cocok' : 'Password belum cocok';
    matchText.style.color = isMatch ? '#42a45f' : '#d63a3a';
    confirmInput.style.borderColor = isMatch ? '#42a45f' : '#d63a3a';
  }

  password.addEventListener('input', updatePasswordStrength);
  confirmInput.addEventListener('input', updatePasswordMatch);
</script>
</body>
</html>
