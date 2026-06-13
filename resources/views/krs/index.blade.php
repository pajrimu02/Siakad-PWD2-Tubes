@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data KRS</h3>
        <a href="{{ route('krs.create') }}" class="btn btn-primary">
            + Tambah KRS
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Tahun Akademik</th>
                            <th>Jadwal</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($krs as $key => $k)
                    <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $k->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $k->tahun_akademik ?? '-' }}</td>
                            <td>{{ $k->jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                            <td>{{ $k->semester ?? '-' }}</td>
                        <td>
                            <a href="{{ route('krs.edit', $k->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

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

</div>

@endsection