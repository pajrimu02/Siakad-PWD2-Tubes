@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.krs-wrap * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

/* ── HEADER ── */
.krs-header {
    margin-bottom: 22px;
    animation: fadeSlideDown 0.5s ease both;
}
.krs-header h3 {
    font-size: 20px; font-weight: 800; color: #111827;
    margin: 0; letter-spacing: -0.3px;
}
.krs-header small { font-size: 13px; color: #6b7280; }

.btn-cetak {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    border-radius: 11px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff; font-size: 13.5px; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 3px 12px rgba(99,102,241,0.3);
    position: relative; overflow: hidden;
}
.btn-cetak::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.13), transparent);
    opacity: 0; transition: opacity 0.2s;
}
.btn-cetak:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 22px rgba(99,102,241,0.45);
    color: #fff;
}
.btn-cetak:hover::before { opacity: 1; }
.btn-cetak:active { transform: translateY(0); }

/* ── STAT CARDS ── */
.stat-row {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 12px; margin-bottom: 20px;
}

.stat-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease, border-color 0.22s ease;
    animation: fadeSlideUp 0.5s ease both;
    position: relative; overflow: hidden;
}
.stat-card::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px;
    opacity: 0; transition: opacity 0.22s;
}
.stat-card.sc-blue::after  { background: #1967d2; }
.stat-card.sc-green::after { background: #1e8e3e; }
.stat-card.sc-amber::after { background: #d97706; }

.stat-card.sc-blue:hover  { background:#eff6ff; border-color:#bfdbfe; box-shadow:0 8px 24px rgba(25,103,210,0.13); transform:translateY(-3px); }
.stat-card.sc-green:hover { background:#f0fdf4; border-color:#a7f3c0; box-shadow:0 8px 24px rgba(30,142,62,0.13);  transform:translateY(-3px); }
.stat-card.sc-amber:hover { background:#fffbeb; border-color:#fcd34d; box-shadow:0 8px 24px rgba(217,119,6,0.13);  transform:translateY(-3px); }
.stat-card::after { opacity:0; }
.stat-card:hover::after { opacity:1; }

.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
    transition: transform 0.22s ease;
}
.stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
.si-blue  { background:#dbeafe; color:#1967d2; }
.si-green { background:#dcfce7; color:#1e8e3e; }
.si-amber { background:#fef3c7; color:#d97706; }

.stat-label { font-size:11px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; font-weight:600; margin:0; }
.stat-value { font-size:26px; font-weight:800; color:#111827; margin:3px 0 0; line-height:1; }
.stat-card.sc-blue:hover  .stat-value { color:#1967d2; }
.stat-card.sc-green:hover .stat-value { color:#1e8e3e; }
.stat-card.sc-amber:hover .stat-value { color:#d97706; }

/* ── TABLE CARD ── */
.krs-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: fadeSlideUp 0.55s ease 0.1s both;
    transition: box-shadow 0.25s ease;
}
.krs-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.09); }

.krs-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.krs-card-header-left {
    display: flex; align-items: center; gap: 10px;
}
.krs-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #ede9fe; color: #6366f1;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    transition: transform 0.25s ease;
}
.krs-card:hover .krs-card-icon { transform: rotate(-6deg) scale(1.1); }
.krs-card-header h5 {
    font-size: 14px; font-weight: 700; color: #1e293b; margin: 0;
}
.krs-card-header small { font-size: 12px; color: #9ca3af; }

/* ── TABLE ── */
.table-krs thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.06em;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px; white-space: nowrap;
}
.table-krs tbody td {
    padding: 13px 16px;
    font-size: 13.5px; color: #334155;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
}
.table-krs tbody tr:last-child td { border-bottom: none; }
.table-krs tbody tr:hover td { background: #fafbff; }

/* row entrance */
.table-krs tbody tr {
    animation: rowIn 0.35s ease both;
}
@keyframes rowIn {
    from { opacity:0; transform:translateX(-8px); }
    to   { opacity:1; transform:translateX(0); }
}

/* badges */
.badge-mk {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 600; color: #1e293b;
}
.badge-mk i { color: #6366f1; font-size: 12px; }

.badge-sks {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 8px;
    background: #ede9fe; color: #5b21b6;
    font-size: 12px; font-weight: 700;
}

.badge-semester {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 20px;
    background: #dbeafe; color: #1967d2;
    font-size: 11.5px; font-weight: 600;
}

.badge-kelas {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 20px;
    background: #dcfce7; color: #1e8e3e;
    font-size: 11.5px; font-weight: 600;
}

.dosen-wrap {
    display: flex; align-items: center; gap: 7px;
}
.dosen-avatar {
    width: 26px; height: 26px; border-radius: 50%;
    background: linear-gradient(135deg,#6366f1,#4f46e5);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; color: #fff; font-weight: 700; flex-shrink: 0;
}
.dosen-name { font-size: 13px; color: #374151; font-weight: 500; }

/* empty */
.empty-state {
    padding: 56px 20px; text-align: center; color: #94a3b8;
}
.empty-state i { font-size: 42px; margin-bottom: 14px; display: block; opacity: 0.4; }
.empty-state p { font-size: 14px; margin: 0; }

/* animations */
@keyframes fadeSlideDown {
    from { opacity:0; transform:translateY(-12px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fadeSlideUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<div class="container-fluid krs-wrap">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center krs-header">
        <div>
            <h3 class="mb-0">Kartu Rencana Studi (KRS)</h3>
            <small>Daftar mata kuliah yang kamu ambil</small>
        </div>
        <a href="{{ route('user.krs.cetak') }}" class="btn-cetak">
            <i class="fa-solid fa-print"></i> Cetak KRS
        </a>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">

        <div class="stat-card sc-blue" style="animation-delay:.0s">
            <div class="stat-icon si-blue"><i class="fa-solid fa-file-signature"></i></div>
            <div>
                <p class="stat-label">Total KRS</p>
                <p class="stat-value">{{ $krs->count() }}</p>
            </div>
        </div>

        <div class="stat-card sc-green" style="animation-delay:.07s">
            <div class="stat-icon si-green"><i class="fa-solid fa-star-half-stroke"></i></div>
            <div>
                <p class="stat-label">Total SKS</p>
                <p class="stat-value">{{ $krs->sum(fn($k) => $k->jadwal->mataKuliah->sks ?? 0) }}</p>
            </div>
        </div>

        <div class="stat-card sc-amber" style="animation-delay:.14s">
            <div class="stat-icon si-amber"><i class="fa-solid fa-layer-group"></i></div>
            <div>
                <p class="stat-label">Semester Aktif</p>
                <p class="stat-value">{{ $krs->max('semester') ?? 1 }}</p>
            </div>
        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="krs-card">

        <div class="krs-card-header">
            <div class="krs-card-header-left">
                <div class="krs-card-icon">
                    <i class="fa-solid fa-table-list"></i>
                </div>
                <div>
                    <h5>Daftar KRS</h5>
                    <small>{{ $krs->count() }} mata kuliah terdaftar</small>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-krs mb-0">
                <thead>
                    <tr>
                        <th width="52">No</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Kelas</th>
                        <th>Dosen</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($krs as $key => $k)
                    <tr style="animation-delay:{{ $key * 0.04 }}s">
                        <td class="text-muted">{{ $key + 1 }}</td>
                        <td>
                            <div class="badge-mk">
                                <i class="fa-solid fa-book-open-reader"></i>
                                {{ $k->jadwal->mataKuliah->nama_mk ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge-sks">{{ $k->jadwal->mataKuliah->sks ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge-semester">Sem {{ $k->semester }}</span>
                        </td>
                        <td>
                            <span class="badge-kelas">{{ $k->jadwal->kelas ?? '-' }}</span>
                        </td>
                        <td>
                            @php $dosenNama = $k->jadwal->dosen->nama ?? '-'; @endphp
                            <div class="dosen-wrap">
                                <div class="dosen-avatar">
                                    {{ strtoupper(substr($dosenNama, 0, 1)) }}
                                </div>
                                <span class="dosen-name">{{ $dosenNama }}</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa-solid fa-folder-open"></i>
                                <p>Belum ada KRS yang diambil</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection