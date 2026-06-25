@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.nilai-wrap * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

/* ── HEADER ── */
.nilai-header { margin-bottom: 22px; animation: fadeSlideDown 0.5s ease both; }
.nilai-header h3 { font-size: 20px; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.3px; }
.nilai-header small { font-size: 13px; color: #6b7280; }

/* ── STAT CARDS ── */
.stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 20px; }

.stat-card {
    background: #fff; border-radius: 14px; border: 1px solid #e5e7eb;
    padding: 18px 20px; display: flex; align-items: center; gap: 14px;
    transition: transform .22s ease, box-shadow .22s ease, background .22s ease, border-color .22s ease;
    animation: fadeSlideUp .5s ease both; position: relative; overflow: hidden;
}
.stat-card::after {
    content: ''; position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px; opacity: 0; transition: opacity .22s;
}
.stat-card.sc-blue::after   { background: #1967d2; }
.stat-card.sc-green::after  { background: #1e8e3e; }
.stat-card.sc-amber::after  { background: #d97706; }
.stat-card.sc-blue:hover    { background:#eff6ff; border-color:#bfdbfe; box-shadow:0 8px 24px rgba(25,103,210,.13); transform:translateY(-3px); }
.stat-card.sc-green:hover   { background:#f0fdf4; border-color:#a7f3c0; box-shadow:0 8px 24px rgba(30,142,62,.13);  transform:translateY(-3px); }
.stat-card.sc-amber:hover   { background:#fffbeb; border-color:#fcd34d; box-shadow:0 8px 24px rgba(217,119,6,.13);  transform:translateY(-3px); }
.stat-card:hover::after { opacity: 1; }

.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0; transition: transform .22s ease;
}
.stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
.si-blue  { background:#dbeafe; color:#1967d2; }
.si-green { background:#dcfce7; color:#1e8e3e; }
.si-amber { background:#fef3c7; color:#d97706; }

.stat-label { font-size:11px; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; font-weight:600; margin:0; }
.stat-value { font-size:26px; font-weight:800; color:#111827; margin:3px 0 0; line-height:1; }
.stat-card.sc-blue:hover  .stat-value { color:#1967d2; }
.stat-card.sc-green:hover .stat-value { color:#1e8e3e; }
.stat-card.sc-amber:hover .stat-value { color:#d97706; }

/* IPK ring */
.ipk-ring {
    width: 46px; height: 46px; flex-shrink: 0;
    position: relative; display: flex; align-items: center; justify-content: center;
}
.ipk-ring svg { position: absolute; top:0; left:0; width:100%; height:100%; transform:rotate(-90deg); }
.ipk-ring svg circle { fill: none; stroke-width: 4; }
.ipk-ring svg .track  { stroke: #fef3c7; }
.ipk-ring svg .fill   {
    stroke: #d97706;
    stroke-dasharray: 120;
    stroke-dashoffset: {{ 120 - (min(($ipk ?? 0) / 4, 1) * 120) }};
    stroke-linecap: round;
    transition: stroke-dashoffset 1.2s ease;
}
.ipk-ring-val { font-size: 11px; font-weight: 800; color: #d97706; position: relative; z-index:1; }

/* ── TABLE CARD ── */
.nilai-card {
    background: #fff; border-radius: 16px; border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); overflow: hidden;
    animation: fadeSlideUp .55s ease .1s both; transition: box-shadow .25s ease;
}
.nilai-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.09); }

.nilai-card-header {
    padding: 16px 22px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.nilai-card-header-left { display: flex; align-items: center; gap: 10px; }
.nilai-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #fef3c7; color: #d97706;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; transition: transform .25s ease;
}
.nilai-card:hover .nilai-card-icon { transform: rotate(-6deg) scale(1.1); }
.nilai-card-header h5 { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
.nilai-card-header small { font-size: 12px; color: #9ca3af; }

/* ── TABLE ── */
.table-nilai thead th {
    background: #f8fafc; color: #64748b;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px; white-space: nowrap;
}
.table-nilai tbody td {
    padding: 13px 16px; font-size: 13.5px; color: #334155;
    vertical-align: middle; border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.table-nilai tbody tr:last-child td { border-bottom: none; }
.table-nilai tbody tr:hover td { background: #fffdf0; }
.table-nilai tbody tr { animation: rowIn .35s ease both; }

/* ── MK ── */
.mk-wrap { display: flex; align-items: center; gap: 7px; }
.mk-wrap i { color: #6366f1; font-size: 12px; flex-shrink: 0; }
.mk-name { font-size: 13.5px; font-weight: 600; color: #1e293b; }

/* ── SKS ── */
.sks-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 8px;
    background: #ede9fe; color: #5b21b6;
    font-size: 12px; font-weight: 700;
}

/* ── SCORE BAR ── */
.score-wrap { display: flex; align-items: center; gap: 10px; min-width: 140px; }
.score-num  { font-size: 15px; font-weight: 800; color: #1e293b; min-width: 30px; }
.score-bar-bg {
    flex: 1; height: 7px; border-radius: 99px; background: #f1f5f9; overflow: hidden;
}
.score-bar-fill {
    height: 100%; border-radius: 99px;
    transition: width 1s ease;
}
.fill-a { background: linear-gradient(90deg,#22c55e,#16a34a); }
.fill-b { background: linear-gradient(90deg,#3b82f6,#1d4ed8); }
.fill-c { background: linear-gradient(90deg,#f59e0b,#d97706); }
.fill-d { background: linear-gradient(90deg,#94a3b8,#64748b); }
.fill-e { background: linear-gradient(90deg,#f87171,#dc2626); }

/* ── GRADE BADGE ── */
.grade-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 10px;
    font-size: 15px; font-weight: 800; letter-spacing: -.5px;
    transition: transform .2s ease, box-shadow .2s ease;
}
.grade-badge:hover { transform: scale(1.15); }

.grade-A { background:#dcfce7; color:#15803d; box-shadow:0 2px 8px rgba(21,128,61,.18); }
.grade-B { background:#dbeafe; color:#1d4ed8; box-shadow:0 2px 8px rgba(29,78,216,.18); }
.grade-C { background:#fef3c7; color:#b45309; box-shadow:0 2px 8px rgba(180,83,9,.18);  }
.grade-D { background:#f1f5f9; color:#475569; box-shadow:0 2px 8px rgba(71,85,105,.12); }
.grade-E { background:#fee2e2; color:#b91c1c; box-shadow:0 2px 8px rgba(185,28,28,.18); }

/* ── EMPTY ── */
.empty-state { padding: 56px 20px; text-align: center; color: #94a3b8; }
.empty-state i { font-size: 42px; margin-bottom: 14px; display: block; opacity: .4; }
.empty-state p { font-size: 14px; margin: 0; }

/* ── FOOTER SUMMARY ── */
.table-footer {
    padding: 14px 22px; border-top: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;
}
.ipk-summary {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: #6b7280;
}
.ipk-summary strong { color: #1e293b; font-size: 14px; }
.ipk-chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 20px;
    background: #fef3c7; color: #92400e;
    font-size: 12px; font-weight: 700;
}

/* ── ANIMATIONS ── */
@keyframes fadeSlideDown { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeSlideUp   { from{opacity:0;transform:translateY(14px)}  to{opacity:1;transform:translateY(0)} }
@keyframes rowIn         { from{opacity:0;transform:translateX(-8px)}  to{opacity:1;transform:translateX(0)} }
</style>

<div class="container-fluid nilai-wrap">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center nilai-header">
        <div>
            <h3 class="mb-0">Nilai Akademik</h3>
            <small>Rekap nilai mata kuliah kamu</small>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">

        <div class="stat-card sc-blue" style="animation-delay:.00s">
            <div class="stat-icon si-blue"><i class="fa-solid fa-book-open"></i></div>
            <div>
                <p class="stat-label">Total Mata Kuliah</p>
                <p class="stat-value">{{ $nilai->count() }}</p>
            </div>
        </div>

        <div class="stat-card sc-green" style="animation-delay:.07s">
            <div class="stat-icon si-green"><i class="fa-solid fa-star-half-stroke"></i></div>
            <div>
                <p class="stat-label">Total SKS</p>
                <p class="stat-value">{{ $nilai->sum(fn($n) => $n->jadwal->mataKuliah->sks ?? 0) }}</p>
            </div>
        </div>

        <div class="stat-card sc-amber" style="animation-delay:.14s">
            <div class="stat-icon si-amber">
                <div class="ipk-ring">
                    <svg viewBox="0 0 46 46">
                        <circle class="track" cx="23" cy="23" r="19"/>
                        <circle class="fill"  cx="23" cy="23" r="19"/>
                    </svg>
                    <span class="ipk-ring-val">{{ number_format($ipk ?? 0, 2) }}</span>
                </div>
            </div>
            <div>
                <p class="stat-label">IPK Sementara</p>
                <p class="stat-value">{{ number_format($ipk ?? 0, 2) }}</p>
            </div>
        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="nilai-card">

        <div class="nilai-card-header">
            <div class="nilai-card-header-left">
                <div class="nilai-card-icon">
                    <i class="fa-solid fa-chart-bar"></i>
                </div>
                <div>
                    <h5>Daftar Nilai</h5>
                    <small>{{ $nilai->count() }} mata kuliah dinilai</small>
                </div>
            </div>
            @if($nilai->count() > 0)
            <div class="ipk-chip">
                <i class="fa-solid fa-award"></i>
                IPK {{ number_format($ipk ?? 0, 2) }}
            </div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-nilai mb-0">
                <thead>
                    <tr>
                        <th width="52">No</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($nilai as $key => $n)
                    @php
                        $angka = $n->nilai;
                        if ($angka >= 85)      { $huruf = 'A'; $fillClass = 'fill-a'; }
                        elseif ($angka >= 70)  { $huruf = 'B'; $fillClass = 'fill-b'; }
                        elseif ($angka >= 55)  { $huruf = 'C'; $fillClass = 'fill-c'; }
                        elseif ($angka >= 40)  { $huruf = 'D'; $fillClass = 'fill-d'; }
                        else                   { $huruf = 'E'; $fillClass = 'fill-e'; }
                        $pct = min($angka, 100);
                    @endphp
                    <tr style="animation-delay:{{ $key * 0.04 }}s">
                        <td class="text-muted">{{ $key + 1 }}</td>
                        <td>
                            <div class="mk-wrap">
                                <i class="fa-solid fa-book-open-reader"></i>
                                <span class="mk-name">{{ $n->jadwal->mataKuliah->nama_mk ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="sks-badge">{{ $n->jadwal->mataKuliah->sks ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="score-wrap">
                                <span class="score-num">{{ $angka }}</span>
                                <div class="score-bar-bg">
                                    <div class="score-bar-fill {{ $fillClass }}"
                                         style="width:{{ $pct }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="grade-badge grade-{{ $huruf }}">{{ $huruf }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fa-solid fa-chart-simple"></i>
                                <p>Belum ada nilai yang tersedia</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($nilai->count() > 0)
        <div class="table-footer">
            <div class="ipk-summary">
                <i class="fa-solid fa-graduation-cap" style="color:#d97706"></i>
                IPK Sementara:
                <strong>{{ number_format($ipk ?? 0, 2) }} / 4.00</strong>
            </div>
            <small class="text-muted">
                {{ $nilai->count() }} MK ·
                {{ $nilai->sum(fn($n) => $n->jadwal->mataKuliah->sks ?? 0) }} SKS
            </small>
        </div>
        @endif

    </div>

</div>

@endsection