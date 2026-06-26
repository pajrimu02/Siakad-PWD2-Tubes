@extends('layouts.admin')

@push('styles')
<style>
    .btn-modern {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 500;
        border: none; cursor: pointer; text-decoration: none;
        transition: all 0.18s ease; box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .btn-modern:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(0,0,0,0.14); }
    .btn-add    { background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; }
    .btn-excel  { background: linear-gradient(135deg,#22c55e,#16a34a); color:#fff; }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); color:#fff; }

    .search-wrap { position: relative; }
    .search-wrap .search-ico {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none;
    }
    .search-wrap input {
        padding: 9px 16px 9px 36px; border-radius: 10px;
        border: 1.5px solid #e2e8f0; font-size: 13.5px; width: 280px;
        outline: none; transition: border 0.18s, box-shadow 0.18s; background: #fff;
    }
    .search-wrap input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }

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

    .dosen-card { border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 2px 12px rgba(0,0,0,0.06); overflow: hidden; }
    .dosen-card .card-header {
        background: #fff; border-bottom: 1px solid #f1f5f9;
        padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;
    }
    .dosen-card .card-header h5 { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; }

    .table-modern thead tr th {
        background: #f8fafc; color: #64748b; font-size: 11.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.06em;
        border-bottom: 2px solid #e2e8f0; padding: 13px 16px; white-space: nowrap;
    }
    .table-modern tbody tr td {
        padding: 13px 16px; font-size: 14px; color: #334155;
        vertical-align: middle; border-bottom: 1px solid #f1f5f9;
    }
    .table-modern tbody tr:hover td { background: #fafbff; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    .dosen-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        color: #fff; font-size: 13px; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
    }

    .nidn-badge {
        display: inline-flex; align-items: center; padding: 3px 10px;
        border-radius: 999px; font-size: 12px; font-weight: 600;
        background: #ede9fe; color: #5b21b6; letter-spacing: 0.03em;
    }
    .jadwal-badge {
        display: inline-flex; align-items: center; padding: 3px 10px;
        border-radius: 999px; font-size: 12px; font-weight: 600;
        background: #e0f2fe; color: #0369a1;
    }

    .act-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 7px; font-size: 12.5px; font-weight: 500;
        border: none; cursor: pointer; text-decoration: none; transition: all 0.15s;
    }
    .act-btn:hover { transform: translateY(-1px); opacity: 0.88; }
    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    .empty-state { padding: 56px 20px; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Flash --}}
    @if(session('success'))
        <div class="alert-success-custom"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error-custom"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- Header --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('dosen.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Dosen
                </a>
                <a href="{{ route('dosen.export.excel') }}" class="btn-modern btn-excel">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
                <form id="importForm" action="{{ route('dosen.import.excel') }}"
                      method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="excelFile" name="file" accept=".xlsx,.xls" hidden
                           onchange="this.form.submit()">
                    <button type="button" class="btn-modern btn-import"
                            onclick="document.getElementById('excelFile').click()">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                </form>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">
            <form method="GET" action="{{ route('dosen.index') }}" id="searchForm">
                <div class="search-wrap">
                    <i class="fa fa-search search-ico"></i>
                    <input type="text" name="search" id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Cari nama / NIDN / email..."
                           autocomplete="off">
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card dosen-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-chalkboard-user" style="color:#6366f1;"></i>
                Data Dosen
                @if(request('search'))
                    <span class="nidn-badge ms-1" style="background:#fef9c3;color:#92400e;">
                        "{{ request('search') }}"
                    </span>
                @endif
            </h5>
            <small class="text-muted" style="font-size:13px;">{{ $dosens->total() }} data ditemukan</small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="56">No</th>
                            <th>Dosen</th>
                            <th>NIDN</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Jadwal</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($dosens as $key => $d)
                        <tr>
                            <td class="text-muted">{{ $dosens->firstItem() + $key }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="dosen-avatar">{{ strtoupper(substr($d->nama, 0, 1)) }}</div>
                                    <div>
                                        <div style="font-weight:600;color:#1e293b;font-size:13.5px;line-height:1.3;">{{ $d->nama }}</div>
                                        <div style="font-size:12px;color:#94a3b8;">{{ $d->user?->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="nidn-badge">{{ $d->nidn }}</span></td>
                            <td style="font-size:13px;">{{ $d->email }}</td>
                            <td style="font-size:13px;">{{ $d->no_hp ?? '-' }}</td>
                            <td>
                                <span class="jadwal-badge">
                                    {{ $d->jadwal->count() }} jadwal
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('dosen.show', $d->id) }}" class="act-btn act-detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('dosen.edit', $d->id) }}" class="act-btn act-edit">
                                        <i class="fa fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('dosen.destroy', $d->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="act-btn act-delete"
                                                onclick="return confirm('Yakin hapus dosen ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa fa-user-slash"></i>
                                    <p>Tidak ada data dosen{{ request('search') ? ' dengan kata kunci "'.request('search').'"' : '' }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($dosens->hasPages())
        <div class="d-flex justify-content-between align-items-center px-4 py-3"
             style="border-top:1px solid #f1f5f9;">
            <small class="text-muted">
                Menampilkan {{ $dosens->firstItem() }}–{{ $dosens->lastItem() }}
                dari {{ $dosens->total() }} data
            </small>
            {{ $dosens->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    const inp = document.getElementById('searchInput');
    let t;
    inp?.addEventListener('input', () => {
        clearTimeout(t);
        t = setTimeout(() => document.getElementById('searchForm').submit(), 400);
    });
</script>
@endpush