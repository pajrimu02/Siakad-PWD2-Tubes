@extends('layouts.admin')

@section('content')

<div class="row g-3">

    <div class="col-md-3">
        <div class="card shadow-sm border-0 card-stat active" data-target="mahasiswa">
            <div class="card-body">
                <i class="fa fa-user-graduate fa-2x text-primary"></i>
                <h6>Mahasiswa</h6>
                <h3>{{ \App\Models\Mahasiswa::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 card-stat" data-target="dosen">
            <div class="card-body">
                <i class="fa fa-chalkboard-teacher fa-2x text-success"></i>
                <h6>Dosen</h6>
                <h3>{{ \App\Models\Dosen::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 card-stat" data-target="matakuliah">
            <div class="card-body">
                <i class="fa fa-book fa-2x text-warning"></i>
                <h6>Mata Kuliah</h6>
                <h3>{{ \App\Models\MataKuliah::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 card-stat" data-target="krs">
            <div class="card-body">
                <i class="fa fa-file fa-2x text-danger"></i>
                <h6>KRS</h6>
                <h3>{{ \App\Models\Krs::count() }}</h3>
            </div>
        </div>
    </div>

</div>

{{-- SEARCH BAR --}}
<div class="row mt-4 mb-2">
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
        </div>
    </div>
</div>

{{-- ====================== TABEL MAHASISWA ====================== --}}
<div class="table-section" id="table-mahasiswa">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Data Mahasiswa</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Angkatan</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mahasiswa as $key => $m)
                        <tr class="row-mahasiswa" data-page="{{ floor($key / 15) + 1 }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->jk }}</td>
                            <td>{{ $m->angkatan }}</td>
                            <td>{{ $m->user->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination justify-content-center" id="pagination-mahasiswa"></ul>
            </nav>
        </div>
    </div>
</div>

{{-- ====================== TABEL DOSEN ====================== --}}
<div class="table-section d-none" id="table-dosen">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Data Dosen</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dosen as $key => $d)
                        <tr class="row-dosen" data-page="{{ floor($key / 15) + 1 }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $d->nidn }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->no_hp }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination justify-content-center" id="pagination-dosen"></ul>
            </nav>
        </div>
    </div>
</div>

{{-- ====================== TABEL MATA KULIAH ====================== --}}
<div class="table-section d-none" id="table-matakuliah">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Data Mata Kuliah</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matakuliah as $key => $mk)
                        <tr class="row-matakuliah" data-page="{{ floor($key / 15) + 1 }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_mk }}</td>
                            <td>{{ $mk->sks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination justify-content-center" id="pagination-matakuliah"></ul>
            </nav>
        </div>
    </div>
</div>

{{-- ====================== TABEL KRS ====================== --}}
<div class="table-section d-none" id="table-krs">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Data KRS</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($krs as $key => $k)
                        <tr class="row-krs" data-page="{{ floor($key / 15) + 1 }}">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $k->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $k->mataKuliah->nama ?? '-' }}</td>
                            <td>{{ $k->semester }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav>
                <ul class="pagination justify-content-center" id="pagination-krs"></ul>
            </nav>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.card-stat {
    cursor: pointer;
    transition: all .2s ease;
    border: 2px solid transparent !important;
}
.card-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important;
}
.card-stat.active {
    border-color: #0d6efd !important;
    background-color: #f0f6ff;
}
.card-stat.active i,
.card-stat.active h3,
.card-stat.active h6 {
    color: #0d6efd !important;
}
</style>
@endpush

@push('scripts')
<script>
const perPage = 15;
let currentTarget = 'mahasiswa';

function setupPagination(target) {
    const rows = document.querySelectorAll('.row-' + target);
    const totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    const pagination = document.getElementById('pagination-' + target);
    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const li = document.createElement('li');
        li.className = 'page-item' + (i === 1 ? ' active' : '');
        li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        li.addEventListener('click', function(e) {
            e.preventDefault();
            goToPage(target, i);
        });
        pagination.appendChild(li);
    }

    goToPage(target, 1);
}

function goToPage(target, page) {
    const rows = document.querySelectorAll('.row-' + target);
    rows.forEach(row => {
        row.style.display = (parseInt(row.dataset.page) === page) ? '' : 'none';
    });

    const pagination = document.getElementById('pagination-' + target);
    pagination.querySelectorAll('.page-item').forEach((li, idx) => {
        li.classList.toggle('active', (idx + 1) === page);
    });
}

function showTable(target) {
    document.querySelectorAll('.table-section').forEach(sec => sec.classList.add('d-none'));
    document.getElementById('table-' + target).classList.remove('d-none');

    document.querySelectorAll('.card-stat').forEach(c => c.classList.remove('active'));
    document.querySelector('.card-stat[data-target="' + target + '"]').classList.add('active');

    currentTarget = target;
    setupPagination(target);
    document.getElementById('searchInput').value = '';
}

document.querySelectorAll('.card-stat').forEach(card => {
    card.addEventListener('click', function() {
        showTable(this.dataset.target);
    });
});

document.getElementById('searchInput').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('.row-' + currentTarget);

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.dataset.matched = text.includes(value) ? '1' : '0';
    });

    if (value === '') {
        setupPagination(currentTarget);
    } else {
        let visible = 0;
        rows.forEach(row => {
            row.style.display = row.dataset.matched === '1' ? '' : 'none';
        });
        document.getElementById('pagination-' + currentTarget).innerHTML = '';
    }
});

// init
setupPagination('mahasiswa');
</script>
@endpush