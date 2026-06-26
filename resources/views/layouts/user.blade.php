<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAKAD Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body{
            background:#f8fafc;
            font-family:'Segoe UI',sans-serif;
            overflow-x:hidden;
        }

        .sidebar{
            width:260px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:linear-gradient(180deg,#0f172a,#1e293b);
            color:white;
            z-index:1000;
        }

        .logo{
            padding:25px;
            text-align:center;
            border-bottom:1px solid rgba(255,255,255,.1);
        }

        .logo h4{
            margin:0;
            font-weight:700;
        }

        .logo p{
            margin:0;
            color:#94a3b8;
            font-size:13px;
        }

        .sidebar-menu{
            padding:15px 10px;
        }

        .sidebar-menu a{
            display:flex;
            align-items:center;
            gap:12px;
            color:#cbd5e1;
            text-decoration:none;
            padding:12px 15px;
            border-radius:12px;
            margin-bottom:8px;
            transition:.3s;
        }

        .sidebar-menu a:hover{
            background:rgba(255,255,255,.08);
            color:white;
            transform:translateX(5px);
        }

        .sidebar-menu a.active{
            background:white;
            color:#0f172a;
            font-weight:600;
        }

        .content{
            margin-left:260px;
            padding:25px;
        }

        .topbar{
            background:white;
            border-radius:16px;
            padding:15px 25px;
            box-shadow:0 2px 15px rgba(0,0,0,.05);
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .welcome h5{
            margin:0;
            font-weight:700;
        }

        .welcome small{
            color:#64748b;
        }

        .profile{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .profile img{
            width:45px;
            height:45px;
            border-radius:50%;
            border:2px solid #e2e8f0;
        }

        .profile-info{
            text-align:right;
        }

        .profile-info h6{
            margin:0;
            font-weight:600;
        }

        .profile-info small{
            color:#64748b;
        }

        .card-modern{
            border:none;
            border-radius:18px;
            box-shadow:0 2px 20px rgba(0,0,0,.05);
            transition:.3s;
        }

        .card-modern:hover{
            transform:translateY(-3px);
        }

        .logout-box{
            position:absolute;
            bottom:20px;
            left:0;
            width:100%;
            padding:0 15px;
        }

        .btn-logout{
            border-radius:12px;
        }

        footer{
            text-align:center;
            color:#64748b;
            margin-top:30px;
            font-size:14px;
        }

        @media(max-width:991px){

            .sidebar{
                width:80px;
            }

            .sidebar .menu-text,
            .logo p{
                display:none;
            }

            .content{
                margin-left:80px;
            }

            .sidebar-menu a{
                justify-content:center;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- SIDEBAR --}}
    <div class="sidebar">

        <div class="logo">
            <h4>
                <i class="fa-solid fa-graduation-cap"></i>
                SIAKAD
            </h4>
            <p>Portal Mahasiswa</p>
        </div>

        <div class="sidebar-menu">

            <a href="{{ route('user.dashboard') }}"
               class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('user.profil.index') }}"
               class="{{ request()->routeIs('user.profil*') ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i>
                <span class="menu-text">Profil Saya</span>
            </a>

            <a href="{{ route('user.krs.index') }}"
               class="{{ request()->routeIs('user.krs*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines"></i>
                <span class="menu-text">KRS Saya</span>
            </a>

            <a href="{{ route('user.jadwal.index') }}"
               class="{{ request()->routeIs('user.jadwal*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i>
                <span class="menu-text">Jadwal Kuliah</span>
            </a>

            <a href="{{ route('user.nilai.index') }}"
               class="{{ request()->routeIs('user.nilai*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-column"></i>
                <span class="menu-text">Nilai</span>
            </a>

            <a href="{{ route('user.pembayaran.index') }}"
               class="{{ request()->routeIs('user.pembayaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i>
                <span class="menu-text">Pembayaran</span>
            </a>

        </div>

        <div class="logout-box">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-danger btn-logout w-100">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="menu-text">Logout</span>
                </button>
            </form>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="content">

        <div class="topbar">

            <div class="welcome">
                <h5>Portal Mahasiswa</h5>
                <small>Selamat datang kembali</small>
            </div>

            <div class="profile">

                <div class="profile-info">
                    <h6>{{ auth()->user()->name }}</h6>
                    <small>Mahasiswa</small>
                </div>

                <img src="https://ui-avatars.com/api/?background=0F172A&color=ffffff&name={{ urlencode(auth()->user()->name) }}"
                     alt="Profile">

            </div>

        </div>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>
</html>