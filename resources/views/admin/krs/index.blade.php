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
        position: absolute;
        left: 12px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; font-size: 13px;
        pointer-events: none;
    }
    .search-wrap input {
        padding: 9px 16px 9px 34px;
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        width: 280px; outline: none;
        font-size: 13.5px;
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
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }
    .filter-divider {
        width: 1px; height: 22px;
        background: #e2e8f0;
        margin: 0 2px;
    }
    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 500;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        text-decoration: none;
        transition: all 0.18s ease;
        white-space: nowrap;
    }
    .filter-chip:hover {
        border-color: #6366f1;
        color: #6366f1;
        background: #f5f3ff;
        transform: translateY(-1px);
    }
    .filter-chip.active {
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        transform: translateY(-1px);
    }
    .chip-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: rgba(255,255,255,0.6);
        display: none;
    }
    .filter-chip.active .chip-dot { display: block; }

    /* CARD */
    .krs-card {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .krs-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .krs-card .card-header h5 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* TABLE */
    .table-modern thead th {
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
    .table-modern tbody td {
        padding: 13px 16px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-modern tbody tr:hover td { background: #fafbff; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* BADGES */
    .badge-semester {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        background: #ede9fe;
        color: #5b21b6;
    }
    .badge-tahun {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        background: #e0f2fe;
        color: #0369a1;
    }

    /* ACTION BUTTONS */
    .act-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 11px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }
    .act-btn:hover { transform: translateY(-1px); opacity: 0.88; }
    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    /* AVATAR */
    .mhs-avatar {
        width: 30px; height: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        flex-shrink: 0;
    }

    /* EMPTY STATE */
    .empty-state {
        padding: 56px 20px;
        text-align: center;
        color: #94a3b8;
    }
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

                <a href="{{ route('krs.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah KRS
                </a>

                <a href="#" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form action="#" method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="krsFile" name="file"
                           accept=".xlsx,.xls" hidden>
                    <button type="button" class="btn-modern btn-import"
                            onclick="document.getElementById('krsFile').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                </form>

            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">
            <div class="search-wrap">
                <i class="fa fa-search search-ico"></i>
                <input type="text" id="searchInput" placeholder="Cari mahasiswa / matakuliah...">
            </div>
        </div>

    </div>

    {{-- ── FILTER SEMESTER ── --}}
    <div class="filter-bar">
        <span class="filter-label"><i class="fa fa-filter me-1"></i> Semester</span>
        <div class="filter-divider"></div>

        <a href="{{ route('krs.index') }}"
           class="filter-chip {{ !request('semester') ? 'active' : '' }}">
            <span class="chip-dot"></span> Semua
        </a>

        @foreach(range(1, 8) as $s)
        <a href="{{ route('krs.index', ['semester' => $s]) }}"
           class="filter-chip {{ request('semester') == $s ? 'active' : '' }}">
            <span class="chip-dot"></span> Semester {{ $s }}
        </a>
        @endforeach
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="card krs-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-file-alt" style="color:#6366f1;"></i>
                Data KRS
                @if(request('semester'))
                    <span class="badge-semester ms-1">Semester {{ request('semester') }}</span>
                @endif
            </h5>
            <small class="text-muted" style="font-size:13px;">
                {{ $krs->total() }} data ditemukan
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Mahasiswa</th>
                            <th>Dosen Wali</th>
                            <th>Mata Kuliah</th>
                            <th>Tahun Akademik</th>
                            <th>Semester</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($krs as $key => $k)
                    <tr>
                        <td class="text-muted">{{ $krs->firstItem() + $key }}</td>

                        {{-- Mahasiswa dengan avatar --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="mhs-avatar">
                                    {{ strtoupper(substr($k->mahasiswa->nama ?? 'M', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#1e293b;font-size:13.5px;">
                                        {{ $k->mahasiswa->nama ?? '-' }}
                                    </div>
                                    <div style="font-size:12px;color:#94a3b8;">
                                        {{ $k->mahasiswa->nim ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>{{ $k->mahasiswa->dosenWali->nama ?? '-' }}</td>

                        <td>
                            <span style="font-weight:500;">
                                {{ $k->jadwal->mataKuliah->nama_mk ?? '-' }}
                            </span>
                            <div style="font-size:12px;color:#94a3b8;">
                                {{ $k->jadwal->hari ?? '' }}
                                {{ $k->jadwal->ruangan ? '· '.$k->jadwal->ruangan : '' }}
                            </div>
                        </td>

                        <td>
                            <span class="badge-tahun">{{ $k->tahun_akademik ?? '-' }}</span>
                        </td>

                        <td>
                            <span class="badge-semester">Smt {{ $k->semester ?? '-' }}</span>
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('krs.show', $k->id) }}" class="act-btn act-detail">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('krs.edit', $k->id) }}" class="act-btn act-edit">
                                    <i class="fa fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('krs.destroy', $k->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn act-delete"
                                            onclick="return confirm('Yakin hapus KRS ini?')">
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
                                <i class="fa fa-folder-open"></i>
                                <p>Tidak ada data KRS{{ request('semester') ? ' untuk Semester '.request('semester') : '' }}</p>
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
                Menampilkan {{ $krs->firstItem() }}–{{ $krs->lastItem() }}
                dari {{ $krs->total() }} data
            </small>
            {{ $krs->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>
@endsection