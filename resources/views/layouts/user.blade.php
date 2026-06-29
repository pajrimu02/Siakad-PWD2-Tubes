@extends('layouts.admin')

@push('styles')
<style>
    .btn-modern {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 500;
        border: none; cursor: pointer; text-decoration: none;
        transition: all 0.18s ease; box-shadow: 0 1px 4px rgba(0,0,0,0.08); color: #fff;
    }
    .btn-modern:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(0,0,0,0.14); }
    .btn-add    { background: linear-gradient(135deg,#6366f1,#4f46e5); }
    .btn-export { background: linear-gradient(135deg,#22c55e,#16a34a); }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); }

    /* ALERT */
    .alert-success-custom {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
        border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 13.5px;
    }
    .alert-error-custom {
        display: flex; align-items: center; gap: 10px;
        background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;
        border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 13.5px;
    }

    /* SEARCH */
    .search-wrap { position: relative; }
    .search-wrap .search-ico {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none;
    }
    .search-wrap input {
        padding: 9px 16px 9px 34px; border-radius: 10px;
        border: 1.5px solid #e2e8f0; width: 280px; outline: none; font-size: 13.5px;
        transition: border 0.18s, box-shadow 0.18s; background: #fff;
    }
    .search-wrap input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }

    /* FILTER */
    .filter-bar { background: #fff; border-radius: 14px; padding: 13px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; }
    .filter-label { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap; }
    .filter-divider { width: 1px; height: 22px; background: #e2e8f0; margin: 0 2px; }
    .filter-chip { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 999px; font-size: 13px; font-weight: 500; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; text-decoration: none; transition: all 0.18s ease; white-space: nowrap; }
    .filter-chip:hover { border-color: #6366f1; color: #6366f1; background: #f5f3ff; transform: translateY(-1px); }
    .filter-chip.active { background: linear-gradient(135deg,#6366f1,#4f46e5); border-color: transparent; color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.35); transform: translateY(-1px); }
    .chip-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.6); display: none; }
    .filter-chip.active .chip-dot { display: block; }

    /* CARD */
    .card-modern { border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 2px 12px rgba(0,0,0,0.06); overflow: hidden; }
    .card-modern .card-header { background: #fff; border-bottom: 1px solid #f1f5f9; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
    .card-modern .card-header h5 { margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }

    /* TABLE */
    .table-modern thead th { background: #f8fafc; color: #64748b; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; padding: 13px 14px; white-space: nowrap; border-bottom: 2px solid #e2e8f0; }
    .table-modern tbody td { padding: 13px 14px; font-size: 14px; color: #334155; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .table-modern tbody tr:hover td { background: #fafbff; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* ROLE BADGE */
    .badge-role { display: inline-flex; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .role-admin      { background: #fee2e2; color: #b91c1c; }
    .role-mahasiswa  { background: #dbeafe; color: #1d4ed8; }
    .role-dosen      { background: #dcfce7; color: #15803d; }
    .role-default    { background: #f1f5f9; color: #475569; }

    /* USER AVATAR */
    .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }

    /* ACTION */
    .action-wrap { display: flex; justify-content: flex-end; gap: 6px; width: 100%; }
    .act-btn { display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 7px; font-size: 12.5px; font-weight: 500; text-decoration: none; border: none; cursor: pointer; transition: 0.15s; white-space: nowrap; }
    .act-btn:hover { transform: translateY(-1px); opacity: 0.9; }
    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    /* EMPTY */
    .empty-state { padding: 50px; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 38px; display: block; margin-bottom: 12px; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- ── FLASH ── --}}
    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error-custom">
            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- ── HEADER ── --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('users.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah User
                </a>

                <a href="{{ route('users.export.excel') }}" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export
                </a>

                {{-- Import: pilih file → auto submit --}}
                <form id="importForm" action="{{ route('users.import.excel') }}"
                      method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="userFile" name="file" accept=".xlsx,.xls" hidden
                           onchange="this.form.submit()">
                    <button type="button" class="btn-modern btn-import"
                            onclick="document.getElementById('userFile').click()">
                        <i class="fa fa-upload"></i> Import
                    </button>
                </form>

            </div>
        </div>

        {{-- Search debounce --}}
        <div class="col-md-6 d-flex justify-content: end mt-2 mt-md-0 justify-content-end">
            <form method="GET" action="{{ route('users.index') }}" id="searchForm" class="d-flex gap-2">
                <input type="hidden" name="role" value="{{ request('role') }}">
                <div class="search-wrap">
                    <i class="fa fa-search search-ico"></i>
                    <input type="text" name="search" id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Cari nama / email..."
                           autocomplete="off">
                </div>
                @if(request('search'))
                    <a href="{{ route('users.index', ['role' => request('role')]) }}"
                       class="btn-modern" style="background:#94a3b8;padding:9px 14px;">
                        <i class="fa fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- ── FILTER ROLE ── --}}
    <div class="filter-bar">
        <span class="filter-label"><i class="fa fa-filter me-1"></i> Role</span>
        <div class="filter-divider"></div>

        <a href="{{ route('users.index', ['search' => request('search')]) }}"
           class="filter-chip {{ !request('role') ? 'active' : '' }}">
            <span class="chip-dot"></span> Semua
        </a>

        @foreach($roles as $r)
        <a href="{{ route('users.index', ['role' => $r, 'search' => request('search')]) }}"
           class="filter-chip {{ request('role') == $r ? 'active' : '' }}">
            <span class="chip-dot"></span> {{ ucfirst($r) }}
        </a>
        @endforeach
    </div>

    {{-- ── TABLE ── --}}
    <div class="card card-modern">

        <div class="card-header">
            <h5>
                <i class="fa fa-users" style="color:#6366f1;"></i>
                Data User
                @if(request('role'))
                    <span class="badge-role role-{{ request('role') }} ms-1">{{ ucfirst(request('role')) }}</span>
                @endif
                @if(request('search'))
                    <span class="badge-role role-default ms-1">"{{ request('search') }}"</span>
                @endif
            </h5>
            <small class="text-muted">{{ $users->total() }} data</small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-end" width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $key => $user)
                        <tr>
                            <td class="text-muted">{{ $users->firstItem() + $key }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <span style="font-weight:600;color:#1e293b;">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="font-size:13px;">{{ $user->email }}</td>
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    @php
                                        $cls = match($role) {
                                            'admin'     => 'role-admin',
                                            'mahasiswa' => 'role-mahasiswa',
                                            'dosen'     => 'role-dosen',
                                            default     => 'role-default',
                                        };
                                    @endphp
                                    <span class="badge-role {{ $cls }}">{{ ucfirst($role) }}</span>
                                @endforeach
                            </td>
                            <td class="text-end">
                                <div class="action-wrap">
                                    <a href="{{ route('users.show', $user->id) }}" class="act-btn act-detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="act-btn act-edit">
                                        <i class="fa fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="act-btn act-delete"
                                                onclick="return confirm('Hapus user ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fa fa-users"></i>
                                    <p>Tidak ada data user{{ request('search') ? ' dengan kata kunci "'.request('search').'"' : '' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center px-4 py-3"
             style="border-top:1px solid #f1f5f9;">
            <small class="text-muted">
                Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                dari {{ $users->total() }} data
            </small>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search debounce 400ms
    const inp = document.getElementById('searchInput');
    let t;
    inp?.addEventListener('input', () => {
        clearTimeout(t);
        t = setTimeout(() => document.getElementById('searchForm').submit(), 400);
    });
</script>
@endpush