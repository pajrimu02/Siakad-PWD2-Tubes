@extends('layouts.admin')

@push('styles')
<style>
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        color: #fff;
    }
    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(0,0,0,0.14);
        color: #fff;
    }
    .btn-add    { background: linear-gradient(135deg,#6366f1,#4f46e5); }
    .btn-export { background: linear-gradient(135deg,#22c55e,#16a34a); }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); }

    /* SEARCH */
    .search-wrap { position: relative; }
    .search-wrap .search-ico {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; font-size: 13px; pointer-events: none;
    }
    .search-wrap input {
        padding: 9px 16px 9px 34px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        width: 280px; outline: none; font-size: 13.5px;
        transition: border 0.18s, box-shadow 0.18s;
    }
    .search-wrap input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }

    /* FILTER BAR */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 13px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
    }
    .filter-label {
        font-size: 12px; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap;
    }
    .filter-divider { width: 1px; height: 22px; background: #e2e8f0; margin: 0 2px; }
    .filter-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 16px; border-radius: 999px; font-size: 13px; font-weight: 500;
        border: 1.5px solid #e2e8f0; background: #fff; color: #64748b;
        text-decoration: none; transition: all 0.18s ease; white-space: nowrap;
    }
    .filter-chip:hover {
        border-color: #6366f1; color: #6366f1;
        background: #f5f3ff; transform: translateY(-1px);
    }
    .filter-chip.active {
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        border-color: transparent; color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        transform: translateY(-1px);
    }
    .chip-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.6); display: none;
    }
    .filter-chip.active .chip-dot { display: block; }

    /* CARD */
    .mhs-card {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .mhs-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 15px 20px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .mhs-card .card-header h5 {
        font-size: 15px; font-weight: 700; color: #1e293b;
        margin: 0; display: flex; align-items: center; gap: 8px;
    }

    /* TABLE */
    .table-modern thead th {
        background: #f8fafc; color: #64748b;
        font-size: 11.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.06em;
        border-bottom: 2px solid #e2e8f0;
        padding: 13px 16px; white-space: nowrap;
    }
    .table-modern tbody td {
        padding: 13px 16px; font-size: 14px; color: #334155;
        vertical-align: middle; border-bottom: 1px solid #f1f5f9;
    }
    .table-modern tbody tr:hover td { background: #fafbff; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* AVATAR */
    .mhs-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        color: #fff; font-size: 13px; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* BADGES */
    .badge-smt {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 999px;
        font-size: 12px; font-weight: 600;
        background: #ede9fe; color: #5b21b6;
    }
    .badge-angkatan {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 999px;
        font-size: 12px; font-weight: 600;
        background: #e0f2fe; color: #0369a1;
    }
    .badge-aktif {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 999px;
        font-size: 12px; font-weight: 600;
        background: #dcfce7; color: #15803d;
    }
    .badge-nonaktif {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 999px;
        font-size: 12px; font-weight: 600;
        background: #fee2e2; color: #b91c1c;
    }
    .status-dot {
        width: 6px; height: 6px; border-radius: 50%;
    }
    .dot-aktif    { background: #16a34a; }
    .dot-nonaktif { background: #dc2626; }

    /* ACTION BUTTONS */
    .act-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px; border-radius: 7px;
        font-size: 12.5px; font-weight: 500;
        border: none; cursor: pointer; text-decoration: none;
        transition: all 0.15s;
    }
    .act-btn:hover { transform: translateY(-1px); opacity: 0.88; }
    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    /* EMPTY STATE */
    .empty-state { padding: 56px 20px; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 38px; margin-bottom: 12px; display: block; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- ── HEADER ROW ── --}}
    <div class="row mb-3 align-items-center">

        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('mahasiswa.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Mahasiswa
                </a>

                <a href="{{ route('mahasiswa.export.excel') }}" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form action="{{ route('mahasiswa.import.excel') }}"
                      method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="mhsFile" name="file" accept=".xlsx,.xls" hidden>
                    <button type="button" class="btn-modern btn-import"
                            onclick="document.getElementById('mhsFile').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                </form>

            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">
            <div class="search-wrap">
                <i class="fa fa-search search-ico"></i>
                <input type="text" id="searchInput"
                       placeholder="Cari nama / NIM...">
            </div>
        </div>

    </div>

    {{-- ── FILTER ANGKATAN ── --}}
    <div class="filter-bar">
        <span class="filter-label"><i class="fa fa-filter me-1"></i> Angkatan</span>
        <div class="filter-divider"></div>

        <a href="{{ route('mahasiswa.index') }}"
           class="filter-chip {{ !request('angkatan') ? 'active' : '' }}">
            <span class="chip-dot"></span> Semua
        </a>

        @foreach(range(date('Y'), date('Y') - 5) as $tahun)
        <a href="{{ route('mahasiswa.index', ['angkatan' => $tahun]) }}"
           class="filter-chip {{ request('angkatan') == $tahun ? 'active' : '' }}">
            <span class="chip-dot"></span> {{ $tahun }}
        </a>
        @endforeach
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="card mhs-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-user-graduate" style="color:#6366f1;"></i>
                Data Mahasiswa
                @if(request('angkatan'))
                    <span class="badge-angkatan ms-1">Angkatan {{ request('angkatan') }}</span>
                @endif
            </h5>
            <small class="text-muted" style="font-size:13px;">
                {{ $mahasiswas->total() }} data ditemukan
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($mahasiswas as $key => $m)
                    <tr>
                        <td class="text-muted">{{ $mahasiswas->firstItem() + $key }}</td>

                        {{-- Avatar + Nama --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mhs-avatar">
                                    {{ strtoupper(substr($m->nama ?? 'M', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#1e293b;font-size:13.5px;line-height:1.3;">
                                        {{ $m->nama ?? '-' }}
                                    </div>
                                    <div style="font-size:12px;color:#94a3b8;">
                                        {{ $m->email ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span style="font-family:monospace;font-size:13px;
                                         background:#f1f5f9;padding:3px 8px;
                                         border-radius:6px;color:#475569;">
                                {{ $m->nim ?? '-' }}
                            </span>
                        </td>

                        

                        <td>
                            <span class="badge-angkatan">{{ $m->angkatan ?? '-' }}</span>
                        </td>

                        <td>
                            <span class="badge-smt">Smt {{ $m->semester ?? '-' }}</span>
                        </td>

                        <td>
                            @if(($m->status ?? 'aktif') === 'aktif')
                                <span class="badge-aktif">
                                    <span class="status-dot dot-aktif"></span> Aktif
                                </span>
                            @else
                                <span class="badge-nonaktif">
                                    <span class="status-dot dot-nonaktif"></span> Non-aktif
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('mahasiswa.show', $m->id) }}"
                                   class="act-btn act-detail">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('mahasiswa.edit', $m->id) }}"
                                   class="act-btn act-edit">
                                    <i class="fa fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('mahasiswa.destroy', $m->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn act-delete"
                                            onclick="return confirm('Yakin hapus mahasiswa ini?')">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fa fa-users-slash"></i>
                                <p>Tidak ada data mahasiswa{{ request('angkatan') ? ' angkatan '.request('angkatan') : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center px-4 py-3"
             style="border-top:1px solid #f1f5f9;">
            <small class="text-muted">
                Menampilkan {{ $mahasiswas->firstItem() }}–{{ $mahasiswas->lastItem() }}
                dari {{ $mahasiswas->total() }} data
            </small>
            {{ $mahasiswas->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>
@endsection