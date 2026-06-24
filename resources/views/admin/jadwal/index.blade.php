@extends('layouts.admin')

@push('styles')
<style>
    /* ── Filter Chip ── */
    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 18px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 500;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        white-space: nowrap;
    }
    .filter-chip:hover {
        border-color: #6366f1;
        color: #6366f1;
        background: #f5f3ff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.15);
    }
    .filter-chip.active {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        transform: translateY(-1px);
    }
    .filter-chip .chip-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: rgba(255,255,255,0.5);
        display: none;
    }
    .filter-chip.active .chip-dot { display: block; }

    /* ── Filter wrapper ── */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
    }
    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-right: 4px;
        white-space: nowrap;
    }
    .filter-divider {
        width: 1px;
        height: 24px;
        background: #e2e8f0;
        margin: 0 4px;
    }

    /* ── Header buttons ── */
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(0,0,0,0.14);
    }
    .btn-modern:active { transform: translateY(0); }

    .btn-add   { background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; }
    .btn-excel { background: linear-gradient(135deg,#22c55e,#16a34a); color:#fff; }
    .btn-import{ background: linear-gradient(135deg,#0ea5e9,#0284c7); color:#fff; }

    /* ── Search ── */
    .search-wrap {
        position: relative;
    }
    .search-wrap .search-ico {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 13px;
        pointer-events: none;
    }
    .search-wrap input {
        padding: 9px 16px 9px 36px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        font-size: 13.5px;
        width: 280px;
        outline: none;
        transition: border 0.18s, box-shadow 0.18s;
        background: #fff;
    }
    .search-wrap input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }

    /* ── Card ── */
    .jadwal-card {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .jadwal-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .jadwal-card .card-header h5 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ── Table ── */
    .table-modern thead tr th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 2px solid #e2e8f0;
        padding: 13px 16px;
        white-space: nowrap;
    }
    .table-modern tbody tr td {
        padding: 13px 16px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-modern tbody tr:hover td {
        background: #fafbff;
    }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* ── Action buttons in table ── */
    .act-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }
    .act-btn:hover { transform: translateY(-1px); opacity: 0.88; }
    .act-detail  { background:#e0f2fe; color:#0369a1; }
    .act-edit    { background:#fef9c3; color:#92400e; }
    .act-delete  { background:#fee2e2; color:#b91c1c; }

    /* ── Badge kelas ── */
    .kelas-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        background: #ede9fe;
        color: #5b21b6;
    }

    /* ── Empty state ── */
    .empty-state {
        padding: 56px 20px;
        text-align: center;
        color: #94a3b8;
    }
    .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- ── HEADER ROW ── --}}
    <div class="row mb-3 align-items-center">

        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('jadwal.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Jadwal
                </a>

                <a href="#" class="btn-modern btn-excel">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form id="importForm" action="#" method="POST"
                      enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="excelFile" name="file"
                           accept=".xlsx,.xls" hidden>
                    <button type="button" class="btn-modern btn-import"
                            onclick="document.getElementById('excelFile').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                </form>

            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">
            <div class="search-wrap">
                <i class="fa fa-search search-ico"></i>
                <input type="text" id="searchInput" placeholder="Cari jadwal...">
            </div>
        </div>

    </div>

    {{-- ── FILTER BAR ── --}}
    <div class="filter-bar">
        <span class="filter-label"><i class="fa fa-layer-group me-1"></i> Kelas</span>
        <div class="filter-divider"></div>

        <a href="{{ route('jadwal.index') }}"
           class="filter-chip {{ !request('kelas') ? 'active' : '' }}">
            <span class="chip-dot"></span>
            Semua Kelas
        </a>

        @foreach(['A','B','C','D'] as $k)
        <a href="{{ route('jadwal.index', ['kelas' => $k]) }}"
           class="filter-chip {{ request('kelas') == $k ? 'active' : '' }}">
            <span class="chip-dot"></span>
            Kelas {{ $k }}
        </a>
        @endforeach

    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="card jadwal-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-calendar" style="color:#6366f1;"></i>
                Data Jadwal
                @if(request('kelas'))
                    <span class="kelas-badge ms-1">Kelas {{ request('kelas') }}</span>
                @endif
            </h5>
            <small class="text-muted" style="font-size:13px;">
                {{ $jadwal->total() }} 
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th width="56">No</th>
                            <th>Nama Matakuliah</th>
                            <th>Hari</th>
                            <th>Ruangan</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($jadwal as $key => $j)
                    <tr>
                        <td class="text-muted">{{ $jadwal->firstItem() + $key }}</td>
                        <td><span style="font-weight:500;color:#1e293b;">{{ $j->mataKuliah->nama_mk ?? '-' }}</span></td>
                        <td>{{ $j->hari }}</td>
                        <td>{{ $j->ruangan }}</td>
                        <td>
                            <div class="d-flex gap-1">

                                <a href="{{ route('jadwal.show', $j->id) }}" class="act-btn act-detail">
                                    <i class="fa fa-eye"></i> Detail
                                </a>

                                <a href="{{ route('jadwal.edit', $j->id) }}" class="act-btn act-edit">
                                    <i class="fa fa-pen"></i> Edit
                                </a>

                                <form action="{{ route('jadwal.destroy', $j->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn act-delete"
                                            onclick="return confirm('Yakin hapus jadwal ini?')">
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
                                <i class="fa fa-calendar-xmark"></i>
                                <p>Tidak ada jadwal{{ request('kelas') ? ' untuk Kelas '.request('kelas') : '' }}</p>
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
                Menampilkan {{ $jadwal->firstItem() }}–{{ $jadwal->lastItem() }}
                dari {{ $jadwal->total() }} data
            </small>
            {{ $jadwal->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>
@endsection