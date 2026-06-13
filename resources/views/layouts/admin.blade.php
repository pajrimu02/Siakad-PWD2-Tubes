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
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 10px;
        }

        .sidebar a:hover {
            background: #1f2937;
            color: white;
        }

        .sidebar .logo {
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #374151;
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
        .sidebar a.active {
            background: #ffffff;
            color: #111827;
            font-weight: 600;
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

    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/mahasiswa" class="{{ request()->is('mahasiswa*') ? 'active' : '' }}"><i class="fa fa-user-graduate"></i> Mahasiswa</a>
    <a href="/dosen" class="{{ request()->is('dosen*') ? 'active' : '' }}"><i class="fa fa-chalkboard-teacher"></i> Dosen</a>
    <a href="/matakuliah" class="{{ request()->is('matakuliah*') ? 'active' : '' }}"><i class="fa fa-book"></i> Mata Kuliah</a>
    <a href="/jadwal" class="{{ request()->is('jadwal*') ? 'active' : '' }}"><i class="fa fa-calendar"></i> Jadwal</a>
    <a href="/krs" class="{{ request()->is('krs*') ? 'active' : '' }}"><i class="fa fa-file"></i> KRS</a>

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

@stack('scripts')
</body>
</html>