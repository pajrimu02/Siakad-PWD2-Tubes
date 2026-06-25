@extends('layouts.admin')

@push('styles')
<style>
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

    .btn-add    { background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; }
    .btn-excel  { background: linear-gradient(135deg,#22c55e,#16a34a); color:#fff; }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); color:#fff; }

    /* ── Search ── */
    .search-wrap { position: relative; }
    .search-wrap .search-ico {
        position: absolute; left: 13px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8; font-size: 13px; pointer-events: none;
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
    .dosen-card {
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .dosen-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .dosen-card .card-header h5 {
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
    .table-modern tbody tr:hover td { background: #fafbff; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* ── Action buttons ── */
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
    .act-detail { background:#e0f2fe; color:#0369a1; }
    .act-edit   { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }

    /* ── NIDN badge ── */
    .nidn-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        background: #ede9fe;
        color: #5b21b6;
        letter-spacing: 0.03em;
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

                <a href="{{ route('dosen.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Dosen
                </a>

                <a href="{{ route('dosen.export.excel') }}" class="btn-modern btn-excel">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form action="{{ route('dosen.import.excel') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="d-inline">
                    @csrf
                    <input type="file" id="excelFile" name="file" hidden>
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
                <input type="text" id="searchInput" placeholder="Cari dosen...">
            </div>
        </div>

    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="card dosen-card border-0">

        <div class="card-header">
            <h5>
                <i class="fa fa-chalkboard-user" style="color:#6366f1;"></i>
                Data Dosen
            </h5>
            <small class="text-muted" style="font-size:13px;">
                {{ $dosens->total() }} data
            </small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th width="56">No</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($dosens as $key => $d)
                        <tr>
                            <td class="text-muted">{{ $dosens->firstItem() + $key }}</td>
                            <td><span class="nidn-badge">{{ $d->nidn }}</span></td>
                            <td><span style="font-weight:500;color:#1e293b;">{{ $d->nama }}</span></td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->no_hp }}</td>
                            <td>
                                <div class="d-flex gap-1">

                                    <a href="#" class="act-btn act-detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>

                                    <a href="{{ route('dosen.edit', $d->id) }}" class="act-btn act-edit">
                                        <i class="fa fa-pen"></i> Edit
                                    </a>

                                    <form action="{{ route('dosen.destroy', $d->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="act-btn act-delete"
                                                onclick="return confirm('Yakin hapus?')">
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
                                    <i class="fa fa-user-slash"></i>
                                    <p>Tidak ada data dosen</p>
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
                Menampilkan {{ $dosens->firstItem() }}–{{ $dosens->lastItem() }}
                dari {{ $dosens->total() }} data
            </small>
            {{ $dosens->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection