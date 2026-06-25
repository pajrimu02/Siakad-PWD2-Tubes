@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.bayar-wrap * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

/* ── HEADER ── */
.bayar-header { margin-bottom: 22px; animation: fadeSlideDown .5s ease both; }
.bayar-header h3 { font-size: 20px; font-weight: 800; color: #111827; margin: 0; letter-spacing: -.3px; }
.bayar-header small { font-size: 13px; color: #6b7280; }

/* ── STAT CARDS ── */
.stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 20px; }

.stat-card {
    background: #fff; border-radius: 14px; border: 1px solid #e5e7eb;
    padding: 0; overflow: hidden;
    transition: transform .22s ease, box-shadow .22s ease;
    animation: fadeSlideUp .5s ease both; position: relative;
}
.stat-card:hover { transform: translateY(-3px); }
.stat-card.sc-blue:hover  { box-shadow: 0 8px 24px rgba(25,103,210,.13); }
.stat-card.sc-green:hover { box-shadow: 0 8px 24px rgba(30,142,62,.13);  }
.stat-card.sc-red:hover   { box-shadow: 0 8px 24px rgba(220,38,38,.13);  }

/* top accent bar */
.stat-card .accent-bar { height: 4px; width: 100%; }
.sc-blue  .accent-bar { background: linear-gradient(90deg,#1967d2,#60a5fa); }
.sc-green .accent-bar { background: linear-gradient(90deg,#1e8e3e,#4ade80); }
.sc-red   .accent-bar { background: linear-gradient(90deg,#dc2626,#f87171); }

.stat-inner { padding: 18px 20px; display: flex; align-items: center; gap: 14px; }

.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0; transition: transform .22s ease;
}
.stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
.si-blue  { background:#dbeafe; color:#1967d2; }
.si-green { background:#dcfce7; color:#1e8e3e; }
.si-red   { background:#fee2e2; color:#dc2626; }

.stat-label { font-size:11px; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; font-weight:600; margin:0; }
.stat-value { font-size:19px; font-weight:800; margin:4px 0 0; line-height:1; }
.sc-blue  .stat-value { color:#1967d2; }
.sc-green .stat-value { color:#1e8e3e; }
.sc-red   .stat-value { color:#dc2626; }

/* ── PROGRESS BAR (total vs sudah dibayar) ── */
.payment-progress {
    background: #fff; border-radius: 14px; border: 1px solid #e5e7eb;
    padding: 18px 22px; margin-bottom: 20px;
    animation: fadeSlideUp .5s ease .12s both;
    transition: box-shadow .22s ease;
}
.payment-progress:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.pp-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
.pp-title { font-size:13px; font-weight:700; color:#1e293b; display:flex; align-items:center; gap:7px; }
.pp-title i { color:#1e8e3e; }
.pp-pct { font-size:13px; font-weight:800; color:#1e8e3e; }
.pp-track { height:10px; background:#f1f5f9; border-radius:99px; overflow:hidden; }
.pp-fill {
    height:100%; border-radius:99px;
    background: linear-gradient(90deg,#22c55e,#16a34a);
    transition: width 1.2s ease;
}
.pp-labels { display:flex; justify-content:space-between; margin-top:7px; }
.pp-labels span { font-size:11.5px; color:#9ca3af; }

/* ── TABLE CARD ── */
.bayar-card {
    background: #fff; border-radius: 16px; border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,.06); overflow: hidden;
    animation: fadeSlideUp .55s ease .18s both; transition: box-shadow .25s ease;
}
.bayar-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,.09); }

.bayar-card-header {
    padding: 16px 22px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.bayar-card-header-left { display: flex; align-items: center; gap: 10px; }
.bayar-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: #dbeafe; color: #1967d2;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; transition: transform .25s ease;
}
.bayar-card:hover .bayar-card-icon { transform: rotate(-6deg) scale(1.1); }
.bayar-card-header h5 { font-size: 14px; font-weight: 700; color: #1e293b; margin: 0; }
.bayar-card-header small { font-size: 12px; color: #9ca3af; }

/* ── TABLE ── */
.table-bayar thead th {
    background: #f8fafc; color: #64748b;
    font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px; white-space: nowrap;
}
.table-bayar tbody td {
    padding: 14px 16px; font-size: 13.5px; color: #334155;
    vertical-align: middle; border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.table-bayar tbody tr:last-child td { border-bottom: none; }
.table-bayar tbody tr:hover td { background: #f8faff; }
.table-bayar tbody tr { animation: rowIn .35s ease both; }

/* ── SEMESTER badge ── */
.sem-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 20px;
    background: #ede9fe; color: #5b21b6;
    font-size: 12px; font-weight: 700;
}

/* ── TAGIHAN ── */
.tagihan-wrap { display:flex; align-items:center; gap:6px; }
.tagihan-wrap i { color:#9ca3af; font-size:12px; }
.tagihan-val { font-size:14px; font-weight:700; color:#1e293b; }

/* ── STATUS badge ── */
.status-lunas {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px;
    background: #f0fdf4; border: 1px solid #a7f3d0;
    font-size: 12px; font-weight: 700; color: #065f46;
    transition: transform .2s, box-shadow .2s;
}
.status-lunas:hover { transform:translateY(-1px); box-shadow:0 3px 10px rgba(16,185,129,.2); }
.status-lunas .dot { width:7px; height:7px; border-radius:50%; background:#10b981; animation:pulseDot 2s infinite; }

.status-belum {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 20px;
    background: #fff5f5; border: 1px solid #fecaca;
    font-size: 12px; font-weight: 700; color: #991b1b;
    transition: transform .2s, box-shadow .2s;
}
.status-belum:hover { transform:translateY(-1px); box-shadow:0 3px 10px rgba(220,38,38,.2); }
.status-belum .dot { width:7px; height:7px; border-radius:50%; background:#ef4444; animation:pulseDot 2s infinite; }

@keyframes pulseDot {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.5; transform:scale(1.4); }
}

/* ── TANGGAL ── */
.tgl-wrap { display:flex; align-items:center; gap:6px; font-size:13px; color:#374151; }
.tgl-wrap i { color:#9ca3af; font-size:11px; }

/* ── EMPTY ── */
.empty-state { padding:56px 20px; text-align:center; color:#94a3b8; }
.empty-state i { font-size:42px; margin-bottom:14px; display:block; opacity:.4; }
.empty-state p { font-size:14px; margin:0; }

/* ── ANIMATIONS ── */
@keyframes fadeSlideDown { from{opacity:0;transform:translateY(-12px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeSlideUp   { from{opacity:0;transform:translateY(14px)}  to{opacity:1;transform:translateY(0)} }
@keyframes rowIn         { from{opacity:0;transform:translateX(-8px)}  to{opacity:1;transform:translateX(0)} }
</style>

@php
    $totalTagihan  = 5000000;
    $sudahDibayar  = 2500000;
    $sisaTagihan   = $totalTagihan - $sudahDibayar;
    $pct           = $totalTagihan > 0 ? round(($sudahDibayar / $totalTagihan) * 100) : 0;
@endphp

<div class="container-fluid bayar-wrap">

    {{-- HEADER --}}
    <div class="bayar-header">
        <h3 class="mb-0">Pembayaran Kuliah</h3>
        <small>Status pembayaran mahasiswa</small>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">

        <div class="stat-card sc-blue" style="animation-delay:.00s">
            <div class="accent-bar"></div>
            <div class="stat-inner">
                <div class="stat-icon si-blue"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                <div>
                    <p class="stat-label">Total Tagihan</p>
                    <p class="stat-value">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card sc-green" style="animation-delay:.07s">
            <div class="accent-bar"></div>
            <div class="stat-inner">
                <div class="stat-icon si-green"><i class="fa-solid fa-circle-check"></i></div>
                <div>
                    <p class="stat-label">Sudah Dibayar</p>
                    <p class="stat-value">Rp {{ number_format($sudahDibayar, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="stat-card sc-red" style="animation-delay:.14s">
            <div class="accent-bar"></div>
            <div class="stat-inner">
                <div class="stat-icon si-red"><i class="fa-solid fa-circle-exclamation"></i></div>
                <div>
                    <p class="stat-label">Sisa Tagihan</p>
                    <p class="stat-value">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- PROGRESS BAR --}}
    <div class="payment-progress">
        <div class="pp-header">
            <div class="pp-title">
                <i class="fa-solid fa-money-bill-trend-up"></i>
                Progress Pembayaran
            </div>
            <span class="pp-pct">{{ $pct }}% Lunas</span>
        </div>
        <div class="pp-track">
            <div class="pp-fill" style="width: {{ $pct }}%"></div>
        </div>
        <div class="pp-labels">
            <span>Rp 0</span>
            <span>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bayar-card">

        <div class="bayar-card-header">
            <div class="bayar-card-header-left">
                <div class="bayar-card-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h5>Riwayat Pembayaran</h5>
                    <small>{{ count($pembayaran) }} transaksi tercatat</small>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bayar mb-0">
                <thead>
                    <tr>
                        <th width="52">No</th>
                        <th>Semester</th>
                        <th>Tagihan</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pembayaran as $key => $p)
                    <tr style="animation-delay:{{ $key * 0.05 }}s">
                        <td class="text-muted">{{ $key + 1 }}</td>
                        <td>
                            <span class="sem-badge">
                                <i class="fa-solid fa-layer-group" style="font-size:10px;"></i>
                                Sem {{ $p->semester }}
                            </span>
                        </td>
                        <td>
                            <div class="tagihan-wrap">
                                <i class="fa-solid fa-coins"></i>
                                <span class="tagihan-val">Rp {{ number_format($p->tagihan, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td>
                            @if($p->status == 'Lunas')
                                <span class="status-lunas">
                                    <span class="dot"></span>
                                    Lunas
                                </span>
                            @else
                                <span class="status-belum">
                                    <span class="dot"></span>
                                    Belum Lunas
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($p->tanggal)
                                <div class="tgl-wrap">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    {{ $p->tanggal }}
                                </div>
                            @else
                                <span style="color:#9ca3af;font-size:13px;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fa-solid fa-receipt"></i>
                                <p>Belum ada riwayat pembayaran</p>
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