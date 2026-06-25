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
        display: inline-flex; align-items: center; gap: 7px;
        padding: 6px 16px; border-radius: 999px; font-size: 13px; font-weight: 500;
        border: 1.5px solid #e2e8f0; background: #fff; color: #64748b;
        text-decoration: none; transition: all 0.18s ease; white-space: nowrap;
    }
    .filter-chip:hover {
        border-color: #6366f1; color: #6366f1;
        background: #f5f3ff; transform: translateY(-1px);
    }
    .filter-chip.active {
        border-color: transparent; color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transform: translateY(-1px);
    }
    .chip-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: rgba(255,255,255,0.7); display: none;
    }
    .filter-chip.active .chip-dot { display: block; }

    /* Per-grade chip colors */
    .chip-all.active   { background: linear-gradient(135deg,#6366f1,#4f46e5); }
    .chip-a.active     { background: linear-gradient(135deg,#22c55e,#16a34a); }
    .chip-b.active     { background: linear-gradient(135deg,#0ea5e9,#0284c7); }
    .chip-c.active     { background: linear-gradient(135deg,#f59e0b,#d97706); }
    .chip-d.active     { background: linear-gradient(135deg,#f97316,#ea580c); }
    .chip-e.active     { background: linear-gradient(135deg,#ef4444,#dc2626); }

    /* CARD */
    .nilai-card {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .nilai-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 15px 20px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nilai-card .card-header h5 {
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
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        color: #fff; font-size: 13px; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* NILAI BADGE */
    .nilai-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; border-radius: 10px;
        font-size: 15px; font-weight: 800;
    }
    .nilai-A { background:#dcfce7; color:#15803d; }
    .nilai-B { background:#dbeafe; color:#1d4ed8; }
    .nilai-C { background:#fef9c3; color:#92400e; }
    .nilai-D { background:#ffedd5; color:#c2410c; }
    .nilai-E { background:#fee2e2; color:#b91c1c; }

    /* ANGKA BADGE */
    .angka-badge {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 999px;
        font-size: 12.5px; font-weight: 600;
        background: #f1f5f9; color: #475569;
    }

    /* SEMESTER BADGE */
    .badge-smt {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 999px;
        font-size: 12px; font-weight: 600;
        background: #ede9fe; color: #5b21b6;
    }

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

                <a href="{{ route('nilai.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Nilai
                </a>

                <a href="#" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form action="#" method="POST"
                      enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="nilaiFile" name="file"
                           accept=".xlsx,.xls" hidden>
                    <button type="button" class="btn-modern btn-import"
                            onclick="document.getElementById('nilaiFile').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                </form>

            </div>
        </div>

        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">
            <div class="search-wrap">
                <i class="fa fa-search search-ico"></i>
                <input type="text" id="searchInput"
                       placeholder="Cari mahasiswa / matakuliah...">
            </div>
        </div>

    </div>

    {{-- ── FILTER GRADE ── --}}
    <div class="filter-bar">
        <span class="filter-label"><i class="fa fa-filter me-1"></i> Grade</span>
        <div class="filter-divider"></div>

        <a href="{{ route('nilai.index') }}"
           class="filter-chip chip-all {{ !request('kategori') ? 'active' : '' }}">
            <span class="chip-dot"></span>
            Semua Nilai
        </a>

        @foreach([
            'A' => ['label' => 'A — Sangat Baik',  'sub' => '≥ 85'],
            'B' => ['label' => 'B — Baik',          'sub' => '70–84'],
            'C' => ['label' => 'C — Cukup',         'sub' => '55–69'],
            'D' => ['label' => 'D — Kurang',        'sub' => '40–54'],
            'E' => ['label' => 'E — Tidak Lulus',   'sub' => '< 40'],
        ] as $grade => $info)
        <a href="{{ route('nilai.index', ['kategori' => $grade]) }}"
           class="filter-chip chip-{{ strtolower($grade) }} {{ request('kategori') == $grade ? 'active' : '' }}"
           title="{{ $info['sub'] }}">
            <span class="chip-dot"></span>
            {{ $info['label'] }}
        </a>
        @endforeach
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="card nilai-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-star-half-alt" style="color:#6366f1;"></i>
                Data Nilai
                @if(request('kategori'))
                    @php
                        $gradeColors = [
                            'A' => 'background:#dcfce7;color:#15803d;',
                            'B' => 'background:#dbeafe;color:#1d4ed8;',
                            'C' => 'background:#fef9c3;color:#92400e;',
                            'D' => 'background:#ffedd5;color:#c2410c;',
                            'E' => 'background:#fee2e2;color:#b91c1c;',
                        ];
                        $gc = $gradeColors[request('kategori')] ?? '';
                    @endphp
                    <span style="display:inline-flex;align-items:center;
                                 padding:3px 12px;border-radius:999px;
                                 font-size:12px;font-weight:700;{{ $gc }}">
                        Grade {{ request('kategori') }}
                    </span>
                @endif
            </h5>
            <small class="text-muted" style="font-size:13px;">
                {{ $nilais->total() }} data ditemukan
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>Semester</th>
                            <th>Grade</th>
                            <th>Angka</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($nilais as $key => $n)
                    <tr>
                        <td class="text-muted">{{ $nilais->firstItem() + $key }}</td>

                        {{-- Mahasiswa --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mhs-avatar">
                                    {{ strtoupper(substr($n->mahasiswa->nama ?? 'M', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;color:#1e293b;font-size:13.5px;line-height:1.3;">
                                        {{ $n->mahasiswa->nama ?? '-' }}
                                    </div>
                                    <div style="font-size:12px;color:#94a3b8;">
                                        {{ $n->mahasiswa->nim ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Mata Kuliah --}}
                        <td>
                            <div style="font-weight:500;color:#1e293b;">
                                {{ $n->matakuliah->nama_mk ?? '-' }}
                            </div>
                            <div style="font-size:12px;color:#94a3b8;">
                                {{ $n->matakuliah->kode_mk ?? '' }}
                            </div>
                        </td>

                        <td>
                            <span class="badge-smt">Smt {{ $n->semester ?? '-' }}</span>
                        </td>

                        {{-- Grade Badge --}}
                        <td>
                            <span class="nilai-badge nilai-{{ $n->nilai ?? 'E' }}">
                                {{ $n->nilai ?? '-' }}
                            </span>
                        </td>

                        {{-- Angka --}}
                        <td>
                            <span class="angka-badge">{{ $n->angka ?? '-' }}</span>
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('nilai.show', $n->id) }}"
                                   class="act-btn act-detail">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('nilai.edit', $n->id) }}"
                                   class="act-btn act-edit">
                                    <i class="fa fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('nilai.destroy', $n->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn act-delete"
                                            onclick="return confirm('Yakin hapus nilai ini?')">
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
                                <i class="fa fa-chart-bar"></i>
                                <p>Tidak ada data nilai{{ request('kategori') ? ' untuk Grade '.request('kategori') : '' }}</p>
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
                Menampilkan {{ $nilais->firstItem() }}–{{ $nilais->lastItem() }}
                dari {{ $nilais->total() }} data
            </small>
            {{ $nilais->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>
@endsection