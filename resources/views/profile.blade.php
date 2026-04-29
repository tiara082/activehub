<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg: #f5f4f0;
  --white: #fff;
  --border: #ebebeb;
  --border-light: #f5f5f5;
  --text: #111;
  --text-muted: #aaa;
  --text-secondary: #666;
  --radius-lg: 16px;
  --radius-md: 10px;
}

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  padding: 32px;
}

/* ---- Layout ---- */
.layout {
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 20px;
  align-items: start;
  max-width: 1000px;
}

.left-col { display: flex; flex-direction: column; gap: 14px; }

/* ---- Card ---- */
.card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 20px;
}

/* ---- Avatar ---- */
.avatar-wrap {
  width: 76px; height: 76px;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  flex-shrink: 0;
}
.avatar-wrap img {
  width: 100%; height: 100%;
  border-radius: 50%;
  object-fit: cover;
  display: block;
}
.avatar-overlay {
  position: absolute; inset: 0;
  border-radius: 50%;
  background: rgba(0,0,0,.3);
  display: flex; align-items: center; justify-content: center;
  opacity: 0;
  transition: opacity .2s;
}
.avatar-wrap:hover .avatar-overlay { opacity: 1; }

/* ---- Badges ---- */
.badge {
  font-size: 11px; font-weight: 500;
  padding: 3px 10px; border-radius: 99px;
}
.badge-green { background: #f0fdf4; color: #166534; }
.badge-blue  { background: #eff6ff; color: #1d4ed8; }

/* ---- Info rows ---- */
.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 9px 0;
  border-bottom: 1px solid var(--border-light);
  font-size: 12.5px;
}
.info-row:last-child { border-bottom: none; }

/* ---- Logout btn ---- */
.logout-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  width: 100%;
  padding: 8px 10px;
  border-radius: var(--radius-md);
  font-size: 12.5px;
  color: #888;
  cursor: pointer;
  transition: all .15s;
  background: none;
  border: none;
  font-family: inherit;
  text-align: left;
}
.logout-btn:hover { background: #fff0f0; color: #c53030; }

/* ---- Tabs ---- */
.tabs {
  display: flex;
  border-bottom: 1px solid var(--border);
  padding: 0 4px;
}
.tab {
  padding: 14px 20px 12px;
  font-size: 13px; font-weight: 500;
  color: var(--text-muted);
  cursor: pointer;
  border-bottom: 2px solid transparent;
  margin-bottom: -1px;
  transition: all .15s;
  user-select: none;
}
.tab.active { color: var(--text); border-bottom-color: var(--text); }
.tab:hover:not(.active) { color: #666; }

/* ---- Panels ---- */
.panel { display: none; padding: 24px; }
.panel.active { display: block; animation: fadeUp .2s ease; }
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(4px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ---- Form ---- */
.grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

.field-label {
  display: block;
  font-size: 11.5px; font-weight: 500;
  color: #999;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: .04em;
}
.field-input {
  width: 100%;
  border: 1px solid #e8e8e8;
  border-radius: var(--radius-md);
  padding: 10px 14px;
  font-size: 13px;
  color: var(--text);
  outline: none;
  transition: border .15s, background .15s;
  background: #fafafa;
  font-family: inherit;
}
.field-input:focus { border-color: #aaa; background: #fff; }
.field-input.err   { border-color: #f87171; background: #fff5f5; }

.err-msg { font-size: 11px; color: #e53e3e; margin-top: 5px; min-height: 16px; }

/* ---- Password ---- */
.pwd-wrap { position: relative; }
.pwd-wrap .field-input { padding-right: 76px; }
.pwd-toggle {
  position: absolute;
  right: 12px; top: 50%;
  transform: translateY(-50%);
  font-size: 11px; font-weight: 500;
  color: #bbb; cursor: pointer;
  user-select: none;
}
.pwd-toggle:hover { color: #555; }

/* ---- Strength bar ---- */
.strength-track {
  height: 3px; background: #f0f0f0;
  border-radius: 99px; margin-top: 8px; overflow: hidden;
}
.strength-fill {
  height: 100%; border-radius: 99px;
  transition: width .3s, background .3s;
  width: 0%;
}
.strength-label { font-size: 11px; margin-top: 4px; min-height: 16px; }

/* ---- Buttons ---- */
.btn {
  padding: 9px 18px;
  border-radius: var(--radius-md);
  font-size: 13px; font-weight: 500;
  cursor: pointer; border: none;
  transition: all .15s;
  font-family: inherit;
}
.btn-primary { background: #111; color: #fff; }
.btn-primary:hover { background: #333; }
.btn-ghost {
  background: transparent; color: var(--text-secondary);
  border: 1px solid #e8e8e8;
}
.btn-ghost:hover { background: var(--bg); }
.btn-danger {
  background: transparent; color: #c53030;
  border: 1px solid #fed7d7;
  font-size: 12px; padding: 7px 14px;
}
.btn-danger:hover { background: #fff5f5; }

/* ---- Divider ---- */
.divider { border: none; border-top: 1px solid var(--border-light); margin: 20px 0; }

/* ---- Danger zone ---- */
.danger-zone {
  border: 1px solid #fee2e2;
  border-radius: 12px;
  padding: 16px;
  margin-top: 20px;
}

/* ---- Toast ---- */
.toast {
  position: fixed;
  bottom: 24px; right: 24px;
  padding: 11px 16px;
  border-radius: 12px;
  font-size: 13px; font-weight: 500;
  border: 1px solid;
  display: flex; align-items: center; gap: 8px;
  opacity: 0; transform: translateY(8px);
  transition: all .25s;
  pointer-events: none;
  z-index: 999;
}
.toast.show { opacity: 1; transform: translateY(0); }
.toast.success { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
.toast.error   { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

/* ---- Section label ---- */
.section-label {
  font-size: 10px; font-weight: 600;
  color: #ccc;
  text-transform: uppercase;
  letter-spacing: .06em;
  margin-bottom: 8px;
  padding: 0 4px;
}
</style>
</head>
<body>

<div class="layout">

  <!-- ========== LEFT ========== -->
  <div class="left-col">

    <!-- Profile card -->
    <div class="card">
      <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px">

        <div class="avatar-wrap" onclick="document.getElementById('fileInput').click()" title="Ganti foto">
          <img id="avatarImg" src="https://ui-avatars.com/api/?name=Owner+Name&background=1a1a1a&color=fff&size=160&bold=true" alt="avatar">
          <div class="avatar-overlay">
            <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
          </div>
        </div>
        <input type="file" id="fileInput" accept="image/*" style="display:none">

        <div>
          <p id="cardName" style="font-size:14px;font-weight:600">Owner Name</p>
          <p id="cardEmail" style="font-size:12px;color:var(--text-muted);margin-top:2px">owner@email.com</p>
        </div>

        <div style="display:flex;gap:6px">
          <span class="badge badge-green">Aktif</span>
          <span class="badge badge-blue">Owner</span>
        </div>
      </div>

      <hr class="divider">

      <div>
        <div class="info-row">
          <span style="color:var(--text-muted)">Telepon</span>
          <span id="cardPhone" style="font-weight:500">08123456789</span>
        </div>
        <div class="info-row">
          <span style="color:var(--text-muted)">Bergabung</span>
          <span style="font-weight:500">12 Jan 2024</span>
        </div>
        <div class="info-row">
          <span style="color:var(--text-muted)">Terakhir login</span>
          <span style="font-weight:500">Hari ini, 09:32</span>
        </div>
      </div>
    </div>

    <!-- Logout card -->
    <div class="card" style="padding:14px">
      <p class="section-label">Akun</p>
      <button class="logout-btn" onclick="showToast('Kamu berhasil keluar.','success')">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Keluar dari akun
      </button>
    </div>

  </div>

  <!-- ========== RIGHT ========== -->
  <div class="card" style="padding:0;overflow:hidden">

    <div class="tabs">
      <div class="tab active" onclick="switchTab('info',this)">Informasi Pribadi</div>
      <div class="tab" onclick="switchTab('security',this)">Keamanan</div>
    </div>

    <!-- Panel: Info -->
    <div class="panel active" id="panel-info">
      <div class="grid2">

        <div>
          <label class="field-label">Nama lengkap</label>
          <input class="field-input" id="f-name" type="text" value="Owner Name" oninput="clearErr(this)">
          <p class="err-msg" id="err-name"></p>
        </div>

        <div>
          <label class="field-label">Alamat email</label>
          <input class="field-input" id="f-email" type="email" value="owner@email.com" oninput="clearErr(this)">
          <p class="err-msg" id="err-email"></p>
        </div>

        <div>
          <label class="field-label">No. telepon</label>
          <input class="field-input" id="f-phone" type="text" value="08123456789" oninput="clearErr(this)">
          <p class="err-msg" id="err-phone"></p>
        </div>

      </div>

      <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border-light)">
        <button class="btn btn-ghost" onclick="resetInfo()">Batal</button>
        <button class="btn btn-primary" onclick="saveInfo()">Simpan Perubahan</button>
      </div>
    </div>

    <!-- Panel: Security -->
    <div class="panel" id="panel-security">

      <div style="margin-bottom:16px">
        <label class="field-label">Password lama</label>
        <div class="pwd-wrap">
          <input class="field-input" id="f-old" type="password" placeholder="Masukkan password lama" oninput="clearErr(this)">
          <span class="pwd-toggle" onclick="togglePwd(this)">Lihat</span>
        </div>
        <p class="err-msg" id="err-old"></p>
      </div>

      <div class="grid2">

        <div>
          <label class="field-label">Password baru</label>
          <div class="pwd-wrap">
            <input class="field-input" id="f-new" type="password" placeholder="Min. 8 karakter"
              oninput="checkStrength(this.value);clearErr(this)">
            <span class="pwd-toggle" onclick="togglePwd(this)">Lihat</span>
          </div>
          <div class="strength-track"><div class="strength-fill" id="sbar"></div></div>
          <p class="strength-label" id="slabel"></p>
          <p class="err-msg" id="err-new"></p>
        </div>

        <div>
          <label class="field-label">Konfirmasi password baru</label>
          <div class="pwd-wrap">
            <input class="field-input" id="f-confirm" type="password" placeholder="Ulangi password baru" oninput="clearErr(this)">
            <span class="pwd-toggle" onclick="togglePwd(this)">Lihat</span>
          </div>
          <p class="err-msg" id="err-confirm"></p>
        </div>

      </div>

      <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border-light)">
        <button class="btn btn-ghost" onclick="resetPwd()">Batal</button>
        <button class="btn btn-primary" onclick="savePwd()">Update Password</button>
      </div>

      <div class="danger-zone">
        <p style="font-size:12.5px;font-weight:600;color:#c53030;margin-bottom:4px">Hapus Akun</p>
        <p style="font-size:12px;color:var(--text-muted);line-height:1.5;margin-bottom:12px">
          Aksi ini tidak bisa dibatalkan. Semua data akun akan dihapus secara permanen.
        </p>
        <button class="btn btn-danger"
          onclick="if(confirm('Yakin hapus akun? Aksi ini permanen.')) showToast('Akun berhasil dihapus.','error')">
          Hapus akun saya
        </button>
      </div>

    </div>
  </div>

</div>

<div class="toast" id="toast"></div>

<script>
// Tab
function switchTab(id, el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.panel').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('panel-' + id).classList.add('active');
}

// Toast
function showToast(msg, type) {
  const el = document.getElementById('toast');
  const icon = type === 'success'
    ? `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>`
    : `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`;
  el.innerHTML = icon + msg;
  el.className = 'toast ' + type + ' show';
  clearTimeout(el._t);
  el._t = setTimeout(() => el.className = 'toast', 3000);
}

// Validation
function setErr(id, msg) {
  document.getElementById('f-' + id).classList.add('err');
  document.getElementById('err-' + id).textContent = msg;
}
function clearErr(input) {
  input.classList.remove('err');
  const err = document.getElementById('err-' + input.id.replace('f-', ''));
  if (err) err.textContent = '';
}

// Save info
function saveInfo() {
  let ok = true;
  const name  = document.getElementById('f-name').value.trim();
  const email = document.getElementById('f-email').value.trim();
  const phone = document.getElementById('f-phone').value.trim();

  if (!name)                          { setErr('name',  'Nama tidak boleh kosong'); ok = false; }
  if (!email || !email.includes('@')) { setErr('email', 'Email tidak valid'); ok = false; }
  if (!phone || phone.length < 9)     { setErr('phone', 'Nomor telepon tidak valid'); ok = false; }
  if (!ok) return;

  document.getElementById('cardName').textContent  = name;
  document.getElementById('cardEmail').textContent = email;
  document.getElementById('cardPhone').textContent = phone;

  const img = document.getElementById('avatarImg');
  if (!img.dataset.custom) {
    img.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1a1a1a&color=fff&size=160&bold=true`;
  }

  showToast('Perubahan berhasil disimpan.', 'success');
}

function resetInfo() {
  document.getElementById('f-name').value  = 'Owner Name';
  document.getElementById('f-email').value = 'owner@email.com';
  document.getElementById('f-phone').value = '08123456789';
  ['f-name','f-email','f-phone'].forEach(id => clearErr(document.getElementById(id)));
}

// Password
function checkStrength(val) {
  let score = 0;
  if (val.length >= 8) score++;
  if (val.length >= 12) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;

  const levels = [
    { w: '0%',   c: 'transparent', t: '' },
    { w: '25%',  c: '#ef4444', t: 'Lemah' },
    { w: '50%',  c: '#f97316', t: 'Cukup' },
    { w: '75%',  c: '#22c55e', t: 'Kuat' },
    { w: '100%', c: '#16a34a', t: 'Sangat kuat' },
  ];
  const l = levels[Math.min(score, 4)];
  document.getElementById('sbar').style.cssText = `width:${l.w};background:${l.c}`;
  const lbl = document.getElementById('slabel');
  lbl.textContent = l.t;
  lbl.style.color = l.c;
}

function savePwd() {
  let ok = true;
  const old  = document.getElementById('f-old').value;
  const nw   = document.getElementById('f-new').value;
  const conf = document.getElementById('f-confirm').value;

  if (!old)           { setErr('old',     'Masukkan password lama'); ok = false; }
  if (nw.length < 8)  { setErr('new',     'Password min. 8 karakter'); ok = false; }
  if (nw !== conf)    { setErr('confirm', 'Password tidak cocok'); ok = false; }
  if (!ok) return;

  resetPwd();
  showToast('Password berhasil diperbarui.', 'success');
}

function resetPwd() {
  ['f-old','f-new','f-confirm'].forEach(id => {
    document.getElementById(id).value = '';
    clearErr(document.getElementById(id));
  });
  document.getElementById('sbar').style.width = '0%';
  document.getElementById('slabel').textContent = '';
}

function togglePwd(btn) {
  const input = btn.previousElementSibling;
  input.type = input.type === 'password' ? 'text' : 'password';
  btn.textContent = input.type === 'password' ? 'Lihat' : 'Sembunyikan';
}

// Avatar preview
document.getElementById('fileInput').addEventListener('change', function () {
  if (!this.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById('avatarImg');
    img.src = e.target.result;
    img.dataset.custom = 'true';
    showToast('Foto profil diperbarui.', 'success');
  };
  reader.readAsDataURL(this.files[0]);
});
</script>
</body>
</html>