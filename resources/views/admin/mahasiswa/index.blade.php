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
        transition: 0.2s;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        color: #fff;
    }

    .btn-modern:hover {
        transform: translateY(-1px);
        opacity: 0.9;
    }

    .btn-add { background: linear-gradient(135deg,#6366f1,#4f46e5); }
    .btn-export { background: linear-gradient(135deg,#22c55e,#16a34a); }
    .btn-import { background: linear-gradient(135deg,#0ea5e9,#0284c7); }

    .search-wrap {
        position: relative;
        max-width: 300px;
    }

    .search-wrap i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-wrap input {
        padding: 9px 12px 9px 34px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        width: 100%;
        outline: none;
    }

    .search-wrap input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }

    .card-modern {
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    table th {
        font-size: 12px;
        text-transform: uppercase;
        background: #f8fafc;
    }

    table td {
        font-size: 14px;
        color: #334155;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-3 align-items-center">

        {{-- LEFT BUTTON --}}
        <div class="col-md-6">
            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('mahasiswa.create') }}" class="btn-modern btn-add">
                    <i class="fa fa-plus"></i> Tambah Mahasiswa
                </a>

                <a href="#" class="btn-modern btn-export">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form action="#" method="POST" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    <input type="file" id="file" hidden>

                    <button type="button" class="btn-modern btn-import"
                        onclick="document.getElementById('file').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>
                </form>

            </div>
        </div>

        {{-- SEARCH RIGHT --}}
        <div class="col-md-6 d-flex justify-content-end mt-2 mt-md-0">

            <div class="search-wrap">
                <i class="fa fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari mahasiswa...">
            </div>

        </div>

    </div>

    {{-- TABLE --}}
    <div class="card card-modern">

        <div class="card-header d-flex justify-content-between">
            <span>
                <i class="fa fa-user-graduate text-primary"></i>
                Data Mahasiswa
            </span>
            <small class="text-muted">
                {{ $mahasiswas->total() }} data
            </small>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($mahasiswas as $key => $m)
                        <tr>
                            <td>{{ $mahasiswas->firstItem() + $key }}</td>
                            <td>{{ $m->nim ?? '-' }}</td>
                            <td>{{ $m->nama ?? '-' }}</td>
                            <td>{{ $m->jk}}</td>
                            <td>{{ $m->angkatan}}</td>

                            <td class="text-nowrap">

                                <a href="#" class="btn btn-info btn-sm">Detail</a>

                                <a href="{{ route('mahasiswa.edit', $m->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('mahasiswa.destroy', $m->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus data ini?')">
                                        Hapus
                                    </button>

                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data mahasiswa
                            </td>
                        </tr>
                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">

            <small class="text-muted">
                Menampilkan {{ $mahasiswas->firstItem() }} - {{ $mahasiswas->lastItem() }}
                dari {{ $mahasiswas->total() }} data
            </small>

            {{ $mahasiswas->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection