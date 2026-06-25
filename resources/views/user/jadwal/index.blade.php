@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.jadwal-wrap * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

/* ── HEADER ── */
.jadwal-header {
    margin-bottom: 22px;
    animation: fadeSlideDown 0.5s ease both;
}
.jadwal-header h3 { font-size: 20px; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.3px; }
.jadwal-header small { font-size: 13px; color: #6b7280; }

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
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px; opacity: 0; transition: opacity 0.22s;
}
.stat-card.sc-blue::after  { background: #1967d2; }
.stat-card.sc-purple::after{ background: #6366f1; }
.stat-card.sc-teal::after  { background: #0d9488; }

.stat-card.sc-blue:hover   { background:#eff6ff; border-color:#bfdbfe; box-shadow:0 8px 24px rgba(25,103,210,0.13); transform:translateY(-3px); }
.stat-card.sc-purple:hover { background:#f5f3ff; border-color:#ddd6fe; box-shadow:0 8px 24px rgba(99,102,241,0.13); transform:translateY(-3px); }
.stat-card.sc-teal:hover   { background:#f0fdfa; border-color:#99f6e4; box-shadow:0 8px 24px rgba(13,148,136,0.13); transform:translateY(-3px); }
.stat-card:hover::after    { opacity: 1; }

.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
    transition: transform 0.22s ease;
}
.stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
.si-blue   { background:#dbeafe; color:#1967d2; }
.si-purple { background:#ede9fe; color:#6366f1; }
.si-teal   { background:#ccfbf1; color:#0d9488; }

.stat-label { font-size:11px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.05em; font-weight:600; margin:0; }
.stat-value { font-size:26px; font-weight:800; color:#111827; margin:3px 0 0; line-height:1; }
.stat-card.sc-blue:hover   .stat-value { color:#1967d2; }
.stat-card.sc-purple:hover .stat-value { color:#6366f1; }
.stat-card.sc-teal:hover   .stat-value { color:#0d9488; }

/* ── TABLE CARD ── */
.jadwal-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    animation: fadeSlideUp 0.55s ease 0.1s both;
    transition: box-shadow 0.25s ease;
}
.jadwal-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.09); }

.jadwal-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.jadwal-card-header-left { display: flex; align-items: center; gap: 10px; }
.jadwal-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #dbeafe; color: #1967d2;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; transition: transform 0.25s ease;
}
.jadwal-card:hover .jadwal-card-icon { transform: rotate(-6deg) scale(1.1); }
.jadwal-card-header h5 { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
.jadwal-card-header small { font-size: 12px; color: #9ca3af; }

/* ── TABLE ── */
.table-jadwal thead th {
    background: #f8fafc; color: #64748b;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.06em;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px; white-space: nowrap;
}
.table-jadwal tbody td {
    padding: 13px 16px; font-size: 13.5px; color: #334155;
    vertical-align: middle; border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
}
.table-jadwal tbody tr:last-child td { border-bottom: none; }
.table-jadwal tbody tr:hover td { background: #fafbff; }
.table-jadwal tbody tr {
    animation: rowIn 0.35s ease both;
}

/* ── HARI BADGE — tiap hari warna beda ── */
.hari-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700; letter-spacing: 0.02em;
}
.hari-senin  { background:#dbeafe; color:#1d4ed8; }
.hari-selasa { background:#fce7f3; color:#9d174d; }
.hari-rabu   { background:#dcfce7; color:#15803d; }
.hari-kamis  { background:#fef3c7; color:#b45309; }
.hari-jumat  { background:#ede9fe; color:#5b21b6; }
.hari-sabtu  { background:#ffedd5; color:#c2410c; }
.hari-other  { background:#f1f5f9; color:#475569; }

/* ── JAM ── */
.jam-wrap {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 600; color: #374151;
}
.jam-wrap i { color: #9ca3af; font-size: 12px; }

/* ── MK ── */
.mk-wrap { display: flex; align-items: center; gap: 7px; }
.mk-wrap i { color: #6366f1; font-size: 12px; flex-shrink: 0; }
.mk-name { font-size: 13.5px; font-weight: 600; color: #1e293b; }

/* ── SKS badge ── */
.sks-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 8px;
    background: #ede9fe; color: #5b21b6;
    font-size: 12px; font-weight: 700;
}

/* ── KELAS badge ── */
.kelas-badge {
    display: inline-flex; align-items: center;
    padding: 3px 10px; border-radius: 20px;
    background: #dcfce7; color: #1e8e3e;
    font-size: 11.5px; font-weight: 600;
}

/* ── RUANGAN ── */
.ruangan-wrap {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 13px; color: #374151;
}
.ruangan-wrap i { color: #9ca3af; font-size: 11px; }

/* ── DOSEN ── */
.dosen-wrap { display: flex; align-items: center; gap: 7px; }
.dosen-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg,#6366f1,#4f46e5);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; color: #fff; font-weight: 700; flex-shrink: 0;
}
.dosen-name { font-size: 13px; color: #374151; font-weight: 500; }

/* ── EMPTY ── */
.empty-state {
    padding: 56px 20px; text-align: center; color: #94a3b8;
}
.empty-state i { font-size: 42px; margin-bottom: 14px; display: block; opacity: 0.4; }
.empty-state p { font-size: 14px; margin: 0; }

/* ── ANIMATIONS ── */
@keyframes fadeSlideDown {
    from { opacity:0; transform:translateY(-12px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fadeSlideUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes rowIn {
    from { opacity:0; transform:translateX(-8px); }
    to   { opacity:1; transform:translateX(0); }
}
</style>

<div class="container-fluid jadwal-wrap">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center jadwal-header">
        <div>
            <h3 class="mb-0">Jadwal Kuliah</h3>
            <small>Daftar jadwal perkuliahan kamu</small>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">

        <div class="stat-card sc-blue" style="animation-delay:.00s">
            <div class="stat-icon si-blue"><i class="fa-solid fa-calendar-days"></i></div>
            <div>
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-value">{{ $jadwal->count() }}</p>
            </div>
        </div>

        <div class="stat-card sc-purple" style="animation-delay:.07s">
            <div class="stat-icon si-purple"><i class="fa-solid fa-book-open"></i></div>
            <div>
                <p class="stat-label">Mata Kuliah</p>
                <p class="stat-value">{{ $jadwal->unique('mata_kuliah_id')->count() }}</p>
            </div>
        </div>

        <div class="stat-card sc-teal" style="animation-delay:.14s">
            <div class="stat-icon si-teal"><i class="fa-solid fa-chalkboard-user"></i></div>
            <div>
                <p class="stat-label">Dosen Pengajar</p>
                <p class="stat-value">{{ $jadwal->unique('dosen_id')->count() }}</p>
            </div>
        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="jadwal-card">

        <div class="jadwal-card-header">
            <div class="jadwal-card-header-left">
                <div class="jadwal-card-icon">
                    <i class="fa-solid fa-calendar-week"></i>
                </div>
                <div>
                    <h5>Detail Jadwal Kuliah</h5>
                    <small>{{ $jadwal->count() }} jadwal aktif terdaftar</small>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-jadwal mb-0">
                <thead>
                    <tr>
                        <th width="52">No</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Kelas</th>
                        <th>Dosen</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($jadwal as $key => $j)
                    @php
                        $hariLower = strtolower($j->hari);
                        $hariClass = match($hariLower) {
                            'senin'  => 'hari-senin',
                            'selasa' => 'hari-selasa',
                            'rabu'   => 'hari-rabu',
                            'kamis'  => 'hari-kamis',
                            'jumat','jum\'at' => 'hari-jumat',
                            'sabtu'  => 'hari-sabtu',
                            default  => 'hari-other',
                        };
                        $dosenNama = $j->dosen->nama ?? '-';
                    @endphp
                    <tr style="animation-delay:{{ $key * 0.04 }}s">
                        <td class="text-muted">{{ $key + 1 }}</td>
                        <td>
                            <span class="hari-badge {{ $hariClass }}">
                                <i class="fa-solid fa-circle" style="font-size:6px;"></i>
                                {{ $j->hari }}
                            </span>
                        </td>
                        <td>
                            <div class="jam-wrap">
                                <i class="fa-regular fa-clock"></i>
                                {{ $j->jam_mulai }} – {{ $j->jam_selesai }}
                            </div>
                        </td>
                        <td>
                            <div class="mk-wrap">
                                <i class="fa-solid fa-book-open-reader"></i>
                                <span class="mk-name">{{ $j->mataKuliah->nama_mk ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="sks-badge">{{ $j->mataKuliah->sks ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="kelas-badge">{{ $j->kelas }}</span>
                        </td>
                        <td>
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
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fa-solid fa-calendar-xmark"></i>
                                <p>Belum ada jadwal kuliah</p>
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