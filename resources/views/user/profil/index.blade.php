@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.profil-wrap * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

/* ── PAGE HEADER ── */
.profil-header {
    margin-bottom: 24px;
    animation: fadeSlideDown 0.5s ease both;
}
.profil-header h3 {
    font-size: 20px; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.3px;
}
.profil-header small { font-size: 13px; color: #6b7280; }

/* ── LEFT CARD ── */
.left-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: fadeSlideUp 0.5s ease 0.05s both;
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.left-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

/* cover strip */
.profile-cover {
    height: 90px;
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
    position: relative;
}
.profile-cover::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* avatar */
.avatar-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: -44px;
    padding: 0 24px 24px;
    position: relative;
    z-index: 2;
}
.avatar-ring {
    width: 88px; height: 88px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    padding: 3px;
    box-shadow: 0 4px 18px rgba(99,102,241,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.avatar-ring:hover {
    transform: scale(1.06) rotate(-3deg);
    box-shadow: 0 8px 28px rgba(99,102,241,0.55);
}
.avatar-ring img {
    width: 100%; height: 100%;
    border-radius: 50%;
    border: 3px solid #fff;
    object-fit: cover;
    display: block;
}

.profile-name {
    font-size: 16px; font-weight: 700; color: #111827; margin: 10px 0 2px; text-align: center;
}
.profile-email {
    font-size: 12.5px; color: #6b7280; text-align: center; margin: 0;
}

/* status badge */
.status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px;
    border-radius: 20px;
    background: #f0fdf4;
    border: 1px solid #a7f3d0;
    font-size: 12px; font-weight: 600; color: #065f46;
    margin-top: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.status-badge:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16,185,129,0.2); }
.status-dot {
    width: 7px; height: 7px; border-radius: 50%; background: #10b981;
    animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(1.4); }
}

/* divider */
.left-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
    margin: 0 24px 20px;
}

/* quick stats inside left card */
.quick-stats {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px; padding: 0 20px 24px;
}
.qs-item {
    background: #f8fafc;
    border-radius: 12px;
    padding: 12px 14px;
    border: 1px solid #f1f5f9;
    transition: background 0.2s ease, transform 0.2s ease, border-color 0.2s ease;
}
.qs-item:hover {
    background: #eff6ff; border-color: #bfdbfe; transform: translateY(-2px);
}
.qs-label { font-size: 10.5px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin: 0 0 3px; }
.qs-value { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }

/* ── RIGHT CARD ── */
.right-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: fadeSlideUp 0.5s ease 0.1s both;
    transition: box-shadow 0.25s ease, transform 0.25s ease;
}
.right-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.card-section-header {
    padding: 18px 22px 14px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 10px;
}
.card-section-header .sec-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #ede9fe; color: #6366f1;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    transition: transform 0.25s ease;
}
.right-card:hover .sec-icon { transform: rotate(-6deg) scale(1.1); }
.card-section-header h5 {
    font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; letter-spacing: -0.1px;
}
.card-section-header small { font-size: 12px; color: #9ca3af; }

/* field grid */
.field-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: #f1f5f9;
}
.field-grid .field-full { grid-column: 1 / -1; }

.field-item {
    background: #fff;
    padding: 16px 22px;
    transition: background 0.18s ease;
    position: relative;
}
.field-item:hover { background: #fafbff; }
.field-item::before {
    content: '';
    position: absolute; left: 0; top: 20%; bottom: 20%;
    width: 3px; border-radius: 0 3px 3px 0;
    background: #6366f1;
    opacity: 0;
    transition: opacity 0.18s ease;
}
.field-item:hover::before { opacity: 1; }

.field-icon {
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    margin-bottom: 8px;
    flex-shrink: 0;
}
.fi-blue   { background: #dbeafe; color: #1967d2; }
.fi-green  { background: #dcfce7; color: #1e8e3e; }
.fi-amber  { background: #fef3c7; color: #d97706; }
.fi-purple { background: #ede9fe; color: #6366f1; }
.fi-red    { background: #fee2e2; color: #dc2626; }
.fi-teal   { background: #ccfbf1; color: #0d9488; }

.field-label {
    font-size: 10.5px; font-weight: 600; color: #9ca3af;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin: 0 0 4px; line-height: 1;
}
.field-value {
    font-size: 14px; font-weight: 600; color: #1e293b;
    margin: 0; line-height: 1.4;
}

/* edit button */
.btn-edit-profil {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px;
    border-radius: 11px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    font-size: 13.5px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    box-shadow: 0 3px 12px rgba(99,102,241,0.3);
    position: relative; overflow: hidden;
}
.btn-edit-profil::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.12), transparent);
    opacity: 0; transition: opacity 0.2s;
}
.btn-edit-profil:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 22px rgba(99,102,241,0.45);
    color: #fff;
}
.btn-edit-profil:hover::before { opacity: 1; }
.btn-edit-profil:active { transform: translateY(0); }

/* action footer */
.action-footer {
    padding: 16px 22px;
    border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 10px;
}
.last-updated {
    font-size: 12px; color: #9ca3af;
    display: flex; align-items: center; gap: 6px;
}

/* alert */
.alert-modern {
    display: flex; align-items: flex-start; gap: 14px;
    background: #fff5f5; border: 1px solid #fecaca;
    border-radius: 12px; padding: 18px 20px;
    margin: 20px;
}
.alert-modern i { color: #ef4444; font-size: 20px; flex-shrink: 0; margin-top: 1px; }
.alert-modern strong { font-size: 14px; color: #991b1b; display: block; margin-bottom: 3px; }
.alert-modern span { font-size: 13px; color: #6b7280; }

/* animations */
@keyframes fadeSlideDown {
    from { opacity: 0; transform: translateY(-12px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<div class="container-fluid profil-wrap">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 profil-header">
        <div>
            <h3 class="mb-0">Profil Mahasiswa</h3>
            <small class="text-muted">Informasi data diri akun kamu</small>
        </div>
    </div>

    @php $mhs = auth()->user()->mahasiswa; @endphp

    <div class="row g-3">

        {{-- ── LEFT CARD ── --}}
        <div class="col-md-4">
            <div class="left-card h-100">

                {{-- Cover --}}
                <div class="profile-cover"></div>

                {{-- Avatar + Info --}}
                <div class="avatar-wrap">
                    <div class="avatar-ring">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=6366f1&color=fff&bold=true"
                             alt="Avatar">
                    </div>
                    <p class="profile-name">{{ auth()->user()->name }}</p>
                    <p class="profile-email">{{ auth()->user()->email }}</p>
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        Mahasiswa Aktif
                    </div>
                </div>

                <div class="left-divider"></div>

                {{-- Quick stats --}}
                @if($mhs)
                <div class="quick-stats">
                    <div class="qs-item">
                        <p class="qs-label"><i class="fa-solid fa-id-card me-1"></i>NIM</p>
                        <p class="qs-value">{{ $mhs->nim }}</p>
                    </div>
                    <div class="qs-item">
                        <p class="qs-label"><i class="fa-solid fa-layer-group me-1"></i>Angkatan</p>
                        <p class="qs-value">{{ $mhs->angkatan }}</p>
                    </div>
                    <div class="qs-item" style="grid-column:1/-1">
                        <p class="qs-label"><i class="fa-solid fa-venus-mars me-1"></i>Jenis Kelamin</p>
                        <p class="qs-value">{{ $mhs->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- ── RIGHT CARD ── --}}
        <div class="col-md-8">
            <div class="right-card h-100">

                <div class="card-section-header">
                    <div class="sec-icon">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div>
                        <h5>Data Lengkap</h5>
                        <small>Informasi akademik & personal mahasiswa</small>
                    </div>
                </div>

                @if($mhs)

                    <div class="field-grid">

                        <div class="field-item">
                            <div class="field-icon fi-blue"><i class="fa-solid fa-id-badge"></i></div>
                            <p class="field-label">NIM</p>
                            <p class="field-value">{{ $mhs->nim }}</p>
                        </div>

                        <div class="field-item">
                            <div class="field-icon fi-purple"><i class="fa-solid fa-user"></i></div>
                            <p class="field-label">Nama Lengkap</p>
                            <p class="field-value">{{ $mhs->nama }}</p>
                        </div>

                        <div class="field-item">
                            <div class="field-icon fi-green"><i class="fa-solid fa-venus-mars"></i></div>
                            <p class="field-label">Jenis Kelamin</p>
                            <p class="field-value">{{ $mhs->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>

                        <div class="field-item">
                            <div class="field-icon fi-amber"><i class="fa-solid fa-phone"></i></div>
                            <p class="field-label">No HP</p>
                            <p class="field-value">{{ $mhs->no_hp }}</p>
                        </div>

                        <div class="field-item">
                            <div class="field-icon fi-teal"><i class="fa-solid fa-layer-group"></i></div>
                            <p class="field-label">Angkatan</p>
                            <p class="field-value">{{ $mhs->angkatan }}</p>
                        </div>

                        <div class="field-item">
                            <div class="field-icon fi-red"><i class="fa-solid fa-envelope"></i></div>
                            <p class="field-label">Email</p>
                            <p class="field-value">{{ auth()->user()->email }}</p>
                        </div>

                        <div class="field-item field-full">
                            <div class="field-icon fi-blue"><i class="fa-solid fa-map-marker-alt"></i></div>
                            <p class="field-label">Alamat</p>
                            <p class="field-value">{{ $mhs->alamat }}</p>
                        </div>

                    </div>

                    <div class="action-footer">
                        <div class="last-updated">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            Data tersimpan di sistem SIAKAD
                        </div>
                        <a href="{{ route('user.profil.edit') }}" class="btn-edit-profil">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Edit Profil
                        </a>
                    </div>

                @else

                    <div class="alert-modern">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            <strong>Data tidak ditemukan</strong>
                            <span>Data mahasiswa tidak ditemukan. Silakan hubungi administrator untuk bantuan.</span>
                        </div>
                    </div>

                @endif

            </div>
        </div>

    </div>
</div>

@endsection