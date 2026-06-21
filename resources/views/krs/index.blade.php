@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-3 align-items-center">

        {{-- BUTTON KIRI --}}
        <div class="col-md-6">
            <div class="d-flex gap-2">

                <a href="{{ route('krs.create') }}"
                   class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fa fa-plus"></i> Tambah KRS
                </a>

                {{-- EXPORT --}}
                <a href="#"
                   class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>

                {{-- IMPORT --}}
                <form id="importForm"
                      action="#"
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
                           placeholder="Cari KRS...">
                </div>
            </div>
        </div>

    </div>

    {{-- CARD TABLE --}}
    <div class="card shadow border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fa fa-file text-primary"></i>
                Data KRS
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No</th>
                            <th>Mahasiswa</th>
                            <th>Tahun Akademik</th>
                            <th>Mata Kuliah</th>
                            <th>Semester</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($krs as $key => $k)
                        <tr>
                            <td>{{ $krs->firstItem() + $key }}</td>

                            <td>{{ $k->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $k->tahun_akademik ?? '-' }}</td>
                            <td>{{ $k->jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                            <td>{{ $k->semester ?? '-' }}</td>

                            <td class="text-nowrap">

                                {{-- DETAIL (kalau ada nanti) --}}
                                <a href="#"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('krs.edit', $k->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('krs.destroy', $k->id) }}"
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
                {{ $krs->firstItem() }}
                -
                {{ $krs->lastItem() }}
                dari
                {{ $krs->total() }}
                data
            </small>

            {{ $krs->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection