@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-3 align-items-center">

        {{-- BUTTON KIRI --}}
        <div class="col-md-6">
            <div class="d-flex gap-2">

                <a href="{{ route('matakuliah.create') }}"
                   class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fa fa-plus"></i> Tambah Mata Kuliah
                </a>

                <a href="{{ route('matakuliah.export.excel') }}"
                   class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                <form id="importForm"
                      action="{{ route('matakuliah.import.excel') }}"
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
                           placeholder="Cari mata kuliah...">
                </div>
            </div>
        </div>

    </div>

    {{-- CARD TABLE --}}
    <div class="card shadow border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fa fa-book text-primary"></i>
                Data Mata Kuliah
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No</th>
                            <th>Kode</th>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($matakuliahs as $key => $mk)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $mk->kode_mk }}</td>
                        <td>{{ $mk->nama_mk }}</td>
                        <td>{{ $mk->sks }}</td>
                        <td>{{ $mk->semester }}</td>
                            <td class="text-nowrap">

                                <a href="{{ route('matakuliah.show', $mk->id) }}"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('matakuliah.edit', $mk->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('matakuliah.destroy', $mk->id) }}"
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

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-between align-items-center mt-3">

                <small class="text-muted">
                    Menampilkan
                    {{ $matakuliahs->firstItem() }}
                    -
                    {{ $matakuliahs->lastItem() }}
                    dari
                    {{ $matakuliahs->total() }}
                    data
                </small>

                {{ $matakuliahs->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>

@endsection