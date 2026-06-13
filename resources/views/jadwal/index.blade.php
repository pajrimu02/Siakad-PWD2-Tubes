@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Jadwal</h3>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
            + Tambah Jadwal
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>NO</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Hari</th>
                        <th>Kelas</th>
                        <th>Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($jadwal as $key => $jadwal)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $jadwal->id }}</td>
                        <td>{{ $jadwal->nama_jadwal }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->kelas }}</td>
                        <td>{{ $jadwal->ruangan }}</td>
                        <td>
                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}"
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