@extends('layouts.admin')

@push('styles')
<style>
    /* FILTER CHIP */
    .filter-chip {
        display: inline-flex;
        align-items: center;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        text-decoration: none;
        transition: .2s;
    }
    .filter-chip:hover {
        border-color: #6366f1;
        color: #6366f1;
        background: #f5f3ff;
    }
    .filter-chip.active {
        background: linear-gradient(135deg,#6366f1,#4f46e5);
        color: #fff;
        border-color: transparent;
    }

    .filter-bar {
        background: #fff;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 18px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        border: 1px solid #f1f5f9;
    }

    /* BUTTON */
    .btn-modern {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        transition: .2s;
    }
    .btn-modern:hover { transform: translateY(-1px); }

    .btn-add { background:#6366f1; color:#fff; }
    .btn-export { background:#22c55e; color:#fff; }
    .btn-import { background:#0ea5e9; color:#fff; }

    /* SEARCH */
    .search-box input {
        width: 260px;
        padding: 9px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        outline: none;
    }

    /* CARD */
    .card-modern {
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* TABLE */
    .table-modern th {
        background: #f8fafc;
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
    }
    .table-modern td {
        font-size: 14px;
        color: #334155;
    }

    /* ACTION */
    .act-btn {
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 12px;
        text-decoration: none;
        display: inline-block;
    }
    .act-edit { background:#fef9c3; color:#92400e; }
    .act-delete { background:#fee2e2; color:#b91c1c; }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        {{-- LEFT BUTTON GROUP --}}
        <div class="d-flex gap-2 flex-wrap">

            <a href="{{ route('nilai.create') }}" class="btn-modern btn-add">
                <i class="fa fa-plus"></i> Tambah Nilai
            </a>

            <a href="#" class="btn-modern btn-export">
                <i class="fa fa-file-excel"></i> Export Excel
            </a>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" hidden id="fileImport">
                <button type="button" class="btn-modern btn-import"
                        onclick="document.getElementById('fileImport').click()">
                    <i class="fa fa-upload"></i> Import Excel
                </button>
            </form>

        </div>

        {{-- RIGHT SEARCH --}}
        <div class="search-box">
            <input type="text" placeholder="Cari nilai...">
        </div>

    </div>

    {{-- FILTER --}}
    <div class="filter-bar">

        <a href="{{ route('nilai.index') }}"
           class="filter-chip {{ !request('kategori') ? 'active' : '' }}">
            Semua Nilai
        </a>

        <a href="{{ route('nilai.index',['kategori'=>'A']) }}"
           class="filter-chip {{ request('kategori')=='A' ? 'active' : '' }}">
            A (Sangat Baik)
        </a>

        <a href="{{ route('nilai.index',['kategori'=>'B']) }}"
           class="filter-chip {{ request('kategori')=='B' ? 'active' : '' }}">
            B (Baik)
        </a>

        <a href="{{ route('nilai.index',['kategori'=>'C']) }}"
           class="filter-chip {{ request('kategori')=='C' ? 'active' : '' }}">
            C (Cukup)
        </a>

        <a href="{{ route('nilai.index',['kategori'=>'D']) }}"
           class="filter-chip {{ request('kategori')=='D' ? 'active' : '' }}">
            D (Kurang)
        </a>

        <a href="{{ route('nilai.index',['kategori'=>'E']) }}"
           class="filter-chip {{ request('kategori')=='E' ? 'active' : '' }}">
            E (Sangat Kurang)
        </a>

    </div>

    {{-- TABLE --}}
    <div class="card card-modern">

        <div class="card-header bg-white d-flex justify-content-between">
            <b>Data Nilai</b>
            <small class="text-muted">{{ $nilais->total() }} data</small>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-modern mb-0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>Semester</th>
                            <th>Nilai</th>
                            <th>Angka</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($nilais as $n)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $n->mahasiswa->nama }}</td>
                            <td>{{ $n->matakuliah->nama }}</td>
                            <td>{{ $n->semester }}</td>
                            <td><b>{{ $n->nilai }}</b></td>
                            <td>{{ $n->angka }}</td>
                            <td>
                                <a href="{{ route('matakuliah.show', $n->id) }}"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>
                                <a href="{{ route('nilai.edit',$n->id) }}" class="act-btn act-edit">Edit</a>

                                <form action="{{ route('nilai.destroy',$n->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="act-btn act-delete" onclick="return confirm('Hapus data?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-muted">
                                Tidak ada data nilai
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <small>
                {{ $nilais->firstItem() }} - {{ $nilais->lastItem() }}
                dari {{ $nilais->total() }} data
            </small>

            {{ $nilais->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>
@endsection