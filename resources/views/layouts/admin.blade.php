<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIAKAD Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: #f5f6fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #111827;
            color: white;
            overflow-y: auto;
        }

        .sidebar .logo {
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #374151;
        }

        /* Link biasa */
        .sidebar a.nav-link {
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            font-size: 14px;
            transition: background 0.15s;
        }

        .sidebar a.nav-link:hover {
            background: #1f2937;
            color: white;
        }

        .sidebar a.nav-link.active {
            background: #ffffff;
            color: #111827;
            font-weight: 600;
        }

        /* Grup label (DATA MASTER, AKADEMIK) */
        .nav-group-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 20px;
            margin: 2px 10px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s, color 0.15s;
        }

        .nav-group-label:hover {
            background: #1f2937;
            color: #e2e8f0;
        }

        .nav-group-label.open {
            color: #e2e8f0;
        }

        .nav-group-label .chevron {
            font-size: 11px;
            transition: transform 0.2s;
        }

        .nav-group-label.open .chevron {
            transform: rotate(180deg);
        }

        /* Sub-item di dalam dropdown */
        .nav-sub {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.25s ease;
        }

        .nav-sub.open {
            max-height: 300px;
        }

        .nav-sub a.nav-link {
            padding-left: 42px;
            font-size: 13.5px;
            color: #9ca3af;
            margin: 1px 10px;
        }

        .nav-sub a.nav-link:hover {
            color: white;
            background: #1f2937;
        }

        .nav-sub a.nav-link.active {
            background: #ffffff;
            color: #111827;
            font-weight: 600;
        }

        /* Divider tipis antar grup */
        .nav-divider {
            height: 1px;
            background: #1f2937;
            margin: 8px 16px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .topbar {
            background: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .bottom-logout {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }
    </style>
    @stack('styles')
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-graduation-cap"></i> SIAKAD
    </div>

    {{-- Dashboard --}}
    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
        <i class="fa fa-home"></i> Dashboard
    </a>

    <div class="nav-divider"></div>

    {{-- DATA MASTER dropdown --}}
    @php
        $masterActive = request()->is('mahasiswa*') || request()->is('dosen*') || request()->is('matakuliah*');
    @endphp

    <div class="nav-group-label {{ $masterActive ? 'open' : '' }}" onclick="toggleGroup(this, 'group-master')">
        <span><i class="fa fa-database" style="margin-right:8px; font-size:12px;"></i> Data Master</span>
        <i class="fa fa-chevron-down chevron"></i>
    </div>

    <div class="nav-sub {{ $masterActive ? 'open' : '' }}" id="group-master">
        <a href="/mahasiswa" class="nav-link {{ request()->is('mahasiswa*') ? 'active' : '' }}">
            <i class="fa fa-user-graduate"></i> Mahasiswa
        </a>
        <a href="/dosen" class="nav-link {{ request()->is('dosen*') ? 'active' : '' }}">
            <i class="fa fa-chalkboard-teacher"></i> Dosen
        </a>
        <a href="/matakuliah" class="nav-link {{ request()->is('matakuliah*') ? 'active' : '' }}">
            <i class="fa fa-book"></i> Mata Kuliah
        </a>
    </div>

    <div class="nav-divider"></div>

    {{-- AKADEMIK dropdown --}}
    @php
        $akademikActive = request()->is('krs*') || request()->is('jadwal*') || request()->is('nilai*');
    @endphp

    <div class="nav-group-label {{ $akademikActive ? 'open' : '' }}" onclick="toggleGroup(this, 'group-akademik')">
        <span><i class="fa fa-graduation-cap" style="margin-right:8px; font-size:12px;"></i> Akademik</span>
        <i class="fa fa-chevron-down chevron"></i>
    </div>

    <div class="nav-sub {{ $akademikActive ? 'open' : '' }}" id="group-akademik">
        <a href="/krs" class="nav-link {{ request()->is('krs*') ? 'active' : '' }}">
            <i class="fa fa-file"></i> KRS
        </a>
        <a href="/jadwal" class="nav-link {{ request()->is('jadwal*') ? 'active' : '' }}">
            <i class="fa fa-calendar"></i> Jadwal
        </a>
        <a href="/nilai" class="nav-link {{ request()->is('nilai*') ? 'active' : '' }}">
            <i class="fa fa-star-half-alt"></i> Nilai
        </a>
    </div>

    <div class="nav-divider"></div>

    {{-- Users --}}
    <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
        <i class="fa fa-users"></i> Users
    </a>

    <!-- LOGOUT BAWAH -->
    <div class="bottom-logout px-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger w-100">
                <i class="fa fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

</div>

<!-- CONTENT -->
<div class="content">

    <!-- TOP BAR -->
    <div class="topbar">
        <h5 class="mb-0">Dashboard</h5>

        <div class="profile">
            <span>{{ auth()->user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="profile">
        </div>
    </div>

    @yield('content')

</div>

<script>
function toggleGroup(label, groupId) {
    const sub = document.getElementById(groupId);
    const isOpen = sub.classList.contains('open');

    sub.classList.toggle('open', !isOpen);
    label.classList.toggle('open', !isOpen);
}
</script>

@stack('scripts')
</body>
</html>