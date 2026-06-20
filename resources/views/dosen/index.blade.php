@extends('layouts.admin')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="row mb-3 align-items-center">

        {{-- BUTTON KIRI --}}
        <div class="col-md-6">
            <div class="d-flex gap-2">

                <button href="{{ route('dosen.create') }}"
                    class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fa fa-plus"></i> Tambah Dosen
                </button>

                <button href="{{ route('dosen.export.excel') }}"
                    class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="fa fa-file-excel"></i> Export Excel
                </button>

                <form id="importForm"
                    action="{{ route('dosen.import.excel') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="d-inline">

                    @csrf

                    <input type="file"
                        id="excelFile"
                        name="file"
                        accept=".xlsx,.xls"
                        hidden>

                    <button type="button"
                        class="btn btn-info d-inline-flex align-items-center gap-2"
                        onclick="document.getElementById('excelFile').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>

                </form>

            </div>
        </div>

        {{-- SEARCH KANAN --}}
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <div class="input-group" style="max-width:300px;">
                    <span class="input-group-text bg-white">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="Cari dosen...">
                </div>
            </div>
        </div>

    </div>

    {{-- CARD TABLE DOSEN --}}
    <div class="card shadow border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fa fa-user-graduate text-primary"></i>
                Data Dosen
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($dosens as $key => $d)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $d->nidn }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->no_hp }}</td>

                            <td class="text-nowrap">
                                <a href="{{ route('dosen.edit', $d->id) }}"
                                    class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('dosen.edit', $d->id) }}"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('dosen.destroy', $d->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus?')">
                                        Hapus
                                    </button>

                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">

            <small class="text-muted">
                Menampilkan
                {{ $dosens->firstItem() }}
                -
                {{ $dosens->lastItem() }}
                dari
                {{ $dosens->total() }}
                data
            </small>

            {{ $dosens->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection