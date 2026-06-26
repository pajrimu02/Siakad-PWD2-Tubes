@extends('layouts.admin')

@push('styles')
<style>
    .btn-modern { display: inline-flex; align-items: center; gap: 7px; padding: 9px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; border: none; cursor: pointer; text-decoration: none; transition: all 0.18s ease; box-shadow: 0 1px 4px rgba(0,0,0,0.08); color: #fff; }
    .btn-modern:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(0,0,0,0.14); color: #fff; }
    .btn-add    { background: linear-gradient(135deg,#6366f1,#4f46e5); }
    .btn-export { background: linear-gradient(135deg,#22c55e,#16a34a); }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); }

    .search-wrap { position: relative; }
    .search-wrap .search-ico { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 13px; pointer-events: none; }
    .search-wrap input { padding: 9px 16px 9px 34px; border-radius: 10px; border: 1.5px solid #e2e8f0; width: 280px; outline: none; font-size: 13.5px; transition: border 0.18s, box-shadow 0.18s; background: #fff; }
    .search-wrap input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }

    .filter-bar { background: #fff; border-radius: 14px; padding: 13px 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; }
    .filter-label { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap; }
    .filter-divider { width: 1px; height: 22px; background: #e2e8f0; margin: 0 2px; }
    .filter-chip { display: inline-flex; align-items: center; gap: 6px; padding: 6px 16px; border-radius: 999px; font-size: 13px; font-weight: 500; border: 1.5px solid #e2e8f0; background: #fff; color: #64748b; text-decoration: none; transition: all 0.18s ease; white-space: nowrap; }
    .filter-chip:hover { border-color: #6366f1; color: #6366f1; background: #f5f3ff; transform: translateY(-1px); }
    .filter-chip.active { background: linear-gradient(135deg,#6366f1,#4f46e5); border-color: transparent; color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.35); transform: translateY(-1px); }
    .chip-dot { width: 6px; height: 6px; border-radius: 50%; background: rgba(255,255,255,0.6); display: none; }
    .filter-chip.active .chip-dot { display: block; }

    .alert-success-custom { display: flex; align-items: center; gap: 10px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 13.5px; }
    .alert-error-custom { display: flex; align-items: center; gap: 10px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; font-size: 13.5px; }

    .mk-card { border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 2px 12px rgba(0,0,0,0.06); overflow: hidden; }
    .mk-card .card-header { background: #fff; border-bottom: 1px solid #f1f5f9; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; }
    .mk-card .card-header h5 { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px; }

    .table-modern thead th { background: #f8fafc; color: #64748b; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; border-bottom: 2px solid #e2e8f0; padding: 13px 16px; white-space: nowrap; }
    .table-modern tbody td { padding: 13px 16px; font-size: 14px; color: #334155; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .table-modern tbody tr:hover td { background: #fafbff; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    .badge-smt  { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; background: #ede9fe; color: #5b21b6; }
    .badge-sks  { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 8px; font-size: 13px; font-weight: 700; background: #fef9c3; color: #92400e; }
    .badge-kode { font-family: monospace; font-size: 12.5px; background: #f1f5f9; padding: 3px 10px; border-radius: 6px; color: #475569; font-weight: 600; }

    .mk-icon { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; font-size: 14px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }

    .act-btn { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 7px; font-size: 12.5px; font-weight: 500; border: none; cursor: pointer; text-decoration: none; transition: all 0.15s; }
    .act-btn:hover { transform: translateY(-1px); opacity: 0.88; }
    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    .empty-state { padding: 56px 20px; text-align: center; color: #94a3b8; }
    .empty-state i { font-size: 38px; margin-bottom: 12px; display: block; }
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

    {{-- Header Row --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('matakuliah.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Matakuliah
                </a>
                <a href="{{ route('matakuliah.export.excel') }}" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
                <form id="importForm" action="{{ route('matakuliah.import.excel') }}"
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
            <form method="GET" action="{{ route('matakuliah.index') }}" id="searchForm">
                <input type="hidden" name="semester" value="{{ request('semester') }}">
                <div class="search-wrap">
                    <i class="fa fa-search search-ico"></i>
                    <input type="text" name="search" id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Cari kode / nama matakuliah..."
                           autocomplete="off">
                </div>
            </form>
        </div>
    </div>

    {{-- Filter Semester --}}
    <div class="filter-bar">
        <span class="filter-label"><i class="fa fa-filter me-1"></i> Semester</span>
        <div class="filter-divider"></div>

        <a href="{{ route('matakuliah.index', ['search' => request('search')]) }}"
           class="filter-chip {{ !request('semester') ? 'active' : '' }}">
            <span class="chip-dot"></span> Semua
        </a>

        @foreach(range(1, 8) as $s)
        <a href="{{ route('matakuliah.index', ['semester' => $s, 'search' => request('search')]) }}"
           class="filter-chip {{ request('semester') == $s ? 'active' : '' }}">
            <span class="chip-dot"></span> Semester {{ $s }}
        </a>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="card mk-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-book" style="color:#6366f1;"></i>
                Data Matakuliah
                @if(request('semester'))
                    <span class="badge-smt ms-1">Semester {{ request('semester') }}</span>
                @endif
                @if(request('search'))
                    <span class="badge-smt ms-1" style="background:#fef9c3;color:#92400e;">
                        "{{ request('search') }}"
                    </span>
                @endif
            </h5>
            <small class="text-muted" style="font-size:13px;">{{ $matakuliahs->total() }} data ditemukan</small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Matakuliah</th>
                            <th>Kode MK</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($matakuliahs as $key => $mk)
                    <tr>
                        <td class="text-muted">{{ $matakuliahs->firstItem() + $key }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mk-icon"><i class="fa fa-book-open"></i></div>
                                <div>
                                    <div style="font-weight:600;color:#1e293b;font-size:13.5px;line-height:1.3;">{{ $mk->nama_mk }}</div>
                                    <div style="font-size:12px;color:#94a3b8;">Mata Kuliah Wajib</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-kode">{{ $mk->kode_mk }}</span></td>
                        <td><span class="badge-sks">{{ $mk->sks }}</span></td>
                        <td><span class="badge-smt">Smt {{ $mk->semester }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('matakuliah.show', $mk->id) }}" class="act-btn act-detail">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('matakuliah.edit', $mk->id) }}" class="act-btn act-edit">
                                    <i class="fa fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="act-btn act-delete"
                                            onclick="return confirm('Yakin hapus matakuliah ini?')">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa fa-book-open"></i>
                                <p>
                                    Tidak ada matakuliah
                                    @if(request('search')) dengan kata kunci "{{ request('search') }}"@endif
                                    @if(request('semester')) pada Semester {{ request('semester') }}@endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($matakuliahs->hasPages())
        <div class="d-flex justify-content-between align-items-center px-4 py-3"
             style="border-top:1px solid #f1f5f9;">
            <small class="text-muted">
                Menampilkan {{ $matakuliahs->firstItem() }}–{{ $matakuliahs->lastItem() }}
                dari {{ $matakuliahs->total() }} data
            </small>
            {{ $matakuliahs->links('pagination::bootstrap-5') }}
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