@extends('layouts.admin')

@section('title', 'Detail Dosen')

@section('content')
<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('dosen.index') }}" class="btn-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Kembali
        </a>
        <div class="header-info">
            <h1>Detail Dosen</h1>
            <p>Informasi lengkap dan jadwal mengajar</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-warning">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST"
                  onsubmit="return confirm('Hapus dosen ini beserta akun login-nya?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="profile-card">
        <div class="profile-avatar">{{ strtoupper(substr($dosen->nama, 0, 2)) }}</div>
        <div class="profile-main">
            <h2>{{ $dosen->nama }}</h2>
            <span class="nidn-badge">NIDN {{ $dosen->nidn }}</span>
            <div class="profile-meta">
                <span>
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    {{ $dosen->email }}
                </span>
                @if($dosen->no_hp)
                <span>
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 012 1.18 2 2 0 014 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z"/>
                    </svg>
                    {{ $dosen->no_hp }}
                </span>
                @endif
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat">
                <span class="stat-val">{{ $dosen->jadwal->count() }}</span>
                <span class="stat-lbl">Jadwal</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $dosen->jadwal->pluck('mata_kuliah_id')->unique()->count() }}</span>
                <span class="stat-lbl">Mata Kuliah</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $dosen->jadwal->pluck('kelas')->unique()->count() }}</span>
                <span class="stat-lbl">Kelas</span>
            </div>
        </div>
    </div>

    {{-- Grid --}}
    <div class="detail-grid">

        {{-- Kolom kiri: Info pribadi --}}
        <div class="col-left">
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                    Informasi Pribadi
                </div>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Email Login</span>
                        <span class="info-val">{{ $dosen->user?->email ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No. HP</span>
                        <span class="info-val">{{ $dosen->no_hp ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-val">{{ $dosen->alamat ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Terdaftar</span>
                        <span class="info-val">{{ $dosen->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: Jadwal --}}
        <div class="col-right">
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Jadwal Mengajar
                </div>
                @if($dosen->jadwal->isEmpty())
                    <p class="empty-text">Belum ada jadwal mengajar.</p>
                @else
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dosen->jadwal as $j)
                            <tr>
                                <td>
                                    <span class="mk-kode">{{ $j->mataKuliah?->kode_mk ?? '-' }}</span>
                                    {{ $j->mataKuliah?->nama_mk ?? '-' }}
                                    <div style="font-size:.75rem;color:#9ca3af;">{{ $j->mataKuliah?->sks ?? '-' }} SKS &bull; Smt {{ $j->mataKuliah?->semester ?? '-' }}</div>
                                </td>
                                <td class="center">
                                    <span style="background:#ede9fe;color:#5b21b6;padding:2px 8px;border-radius:6px;font-size:.78rem;font-weight:600;">
                                        {{ $j->kelas }}
                                    </span>
                                </td>
                                <td>{{ $j->hari }}</td>
                                <td class="nowrap">{{ $j->jam_mulai }} – {{ $j->jam_selesai }}</td>
                                <td>{{ $j->ruangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 1100px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .header-info { flex: 1; }
    .header-info h1 { font-size: 1.3rem; font-weight: 700; color: #111827; margin: 0; }
    .header-info p  { font-size: .83rem; color: #6b7280; margin: 2px 0 0; }
    .header-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: .84rem; color: #6b7280; text-decoration: none; padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all .15s; }
    .btn-back:hover { background: #f3f4f6; color: #111827; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: .45rem 1rem; border-radius: 8px; font-size: .84rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .15s; }
    .btn-warning { background: #fef3c7; color: #92400e; }
    .btn-warning:hover { background: #fde68a; }
    .btn-danger { background: #fee2e2; color: #991b1b; }
    .btn-danger:hover { background: #fecaca; }

    /* Profile */
    .profile-card { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; background: linear-gradient(135deg,#6366f1,#8b5cf6); border-radius: 16px; padding: 1.75rem 2rem; color: #fff; margin-bottom: 1.5rem; box-shadow: 0 4px 20px rgba(99,102,241,.3); }
    .profile-avatar { width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700; flex-shrink: 0; border: 2px solid rgba(255,255,255,.4); }
    .profile-main { flex: 1; min-width: 0; }
    .profile-main h2 { font-size: 1.25rem; font-weight: 700; margin: 0 0 4px; }
    .nidn-badge { display: inline-block; background: rgba(255,255,255,.2); border-radius: 20px; padding: 2px 12px; font-size: .8rem; font-weight: 600; margin-bottom: 8px; }
    .profile-meta { display: flex; gap: 1.25rem; flex-wrap: wrap; font-size: .83rem; opacity: .9; }
    .profile-meta span { display: flex; align-items: center; gap: 4px; }
    .profile-stats { display: flex; gap: 1.5rem; border-left: 1px solid rgba(255,255,255,.2); padding-left: 1.5rem; flex-wrap: wrap; }
    .stat { display: flex; flex-direction: column; align-items: center; gap: 2px; }
    .stat-val { font-size: 1.4rem; font-weight: 700; }
    .stat-lbl { font-size: .72rem; opacity: .8; white-space: nowrap; }

    /* Grid */
    .detail-grid { display: grid; grid-template-columns: 300px 1fr; gap: 1.25rem; }
    .col-left, .col-right { display: flex; flex-direction: column; gap: 1.25rem; }

    /* Section card */
    .section-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
    .section-head { display: flex; align-items: center; gap: 8px; padding: .9rem 1.25rem; border-bottom: 1px solid #f3f4f6; font-size: .88rem; font-weight: 700; color: #374151; background: #fafafa; }

    /* Info list */
    .info-list { padding: .5rem 0; }
    .info-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; padding: .65rem 1.25rem; border-bottom: 1px solid #f9fafb; font-size: .855rem; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6b7280; white-space: nowrap; flex-shrink: 0; }
    .info-val { color: #111827; font-weight: 500; text-align: right; word-break: break-word; }

    /* Table */
    .mini-table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    .mini-table th { padding: .6rem 1rem; text-align: left; font-size: .75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .04em; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
    .mini-table td { padding: .65rem 1rem; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .mini-table tbody tr:last-child td { border-bottom: none; }
    .mini-table tbody tr:hover { background: #fafafa; }
    .mk-kode { display: inline-block; background: #ede9fe; color: #6d28d9; border-radius: 4px; padding: 1px 6px; font-size: .72rem; font-weight: 600; margin-right: 4px; }
    .center { text-align: center; }
    .nowrap { white-space: nowrap; }
    .empty-text { padding: 1.5rem 1.25rem; color: #9ca3af; font-size: .85rem; font-style: italic; margin: 0; }

    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } .profile-stats { border-left: none; padding-left: 0; border-top: 1px solid rgba(255,255,255,.2); padding-top: 1rem; width: 100%; justify-content: space-around; } }
    @media (max-width: 600px) { .profile-card { padding: 1.25rem; } .header-actions { width: 100%; } .btn { flex: 1; justify-content: center; } }
</style>
@endpush