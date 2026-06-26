@extends('layouts.admin')

@section('title', 'Detail Mata Kuliah')

@section('content')
<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('matakuliah.index') }}" class="btn-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Kembali
        </a>
        <div class="header-info">
            <h1>Detail Mata Kuliah</h1>
            <p>Informasi dan jadwal pengampu</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('matakuliah.edit', $mk->id) }}" class="btn btn-warning">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('matakuliah.destroy', $mk->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus mata kuliah ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="profile-card">
        <div class="profile-icon">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
            </svg>
        </div>
        <div class="profile-main">
            <span class="kode-label">{{ $mk->kode_mk }}</span>
            <h2>{{ $mk->nama_mk }}</h2>
            <div class="profile-meta">
                <span class="meta-chip smt-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
                    </svg>
                    Semester {{ $mk->semester }}
                </span>
                <span class="meta-chip sks-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $mk->sks }} SKS
                </span>
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat">
                <span class="stat-val">{{ $mk->jadwal->count() }}</span>
                <span class="stat-lbl">Jadwal</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $mk->jadwal->pluck('dosen_id')->unique()->count() }}</span>
                <span class="stat-lbl">Dosen</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $mk->jadwal->pluck('kelas')->unique()->count() }}</span>
                <span class="stat-lbl">Kelas</span>
            </div>
        </div>
    </div>

    {{-- Jadwal --}}
    <div class="section-card">
        <div class="section-head">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Jadwal Pengampu
        </div>
        @if($mk->jadwal->isEmpty())
            <p class="empty-text">Belum ada jadwal untuk mata kuliah ini.</p>
        @else
            <table class="mini-table">
                <thead>
                    <tr>
                        <th>Dosen</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($mk->jadwal as $j)
                <tr>
                    <td>
                        <div style="font-weight:600;color:#1e293b;">{{ $j->dosen?->nama ?? '-' }}</div>
                        <div style="font-size:.75rem;color:#9ca3af;">NIDN {{ $j->dosen?->nidn ?? '-' }}</div>
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
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 960px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
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
    .profile-icon { width: 64px; height: 64px; border-radius: 14px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid rgba(255,255,255,.3); }
    .profile-main { flex: 1; min-width: 0; }
    .kode-label { display: inline-block; background: rgba(255,255,255,.2); border-radius: 6px; padding: 2px 10px; font-size: .78rem; font-weight: 700; font-family: monospace; letter-spacing: .05em; margin-bottom: 6px; }
    .profile-main h2 { font-size: 1.25rem; font-weight: 700; margin: 0 0 8px; }
    .profile-meta { display: flex; gap: .75rem; flex-wrap: wrap; }
    .meta-chip { display: inline-flex; align-items: center; gap: 5px; padding: 3px 12px; border-radius: 999px; font-size: .8rem; font-weight: 600; }
    .smt-chip { background: rgba(255,255,255,.2); }
    .sks-chip { background: rgba(255,255,255,.15); }
    .profile-stats { display: flex; gap: 1.5rem; border-left: 1px solid rgba(255,255,255,.2); padding-left: 1.5rem; }
    .stat { display: flex; flex-direction: column; align-items: center; gap: 2px; }
    .stat-val { font-size: 1.4rem; font-weight: 700; }
    .stat-lbl { font-size: .72rem; opacity: .8; white-space: nowrap; }

    /* Section */
    .section-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
    .section-head { display: flex; align-items: center; gap: 8px; padding: .9rem 1.25rem; border-bottom: 1px solid #f3f4f6; font-size: .88rem; font-weight: 700; color: #374151; background: #fafafa; }

    /* Table */
    .mini-table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    .mini-table th { padding: .6rem 1rem; text-align: left; font-size: .75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .04em; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
    .mini-table td { padding: .7rem 1rem; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .mini-table tbody tr:last-child td { border-bottom: none; }
    .mini-table tbody tr:hover { background: #fafafa; }
    .center { text-align: center; }
    .nowrap { white-space: nowrap; }
    .empty-text { padding: 1.5rem 1.25rem; color: #9ca3af; font-size: .85rem; font-style: italic; margin: 0; }

    @media (max-width: 768px) { .profile-stats { border-left: none; padding-left: 0; border-top: 1px solid rgba(255,255,255,.2); padding-top: 1rem; width: 100%; justify-content: space-around; } }
    @media (max-width: 600px) { .header-actions { width: 100%; } .btn { flex: 1; justify-content: center; } }
</style>
@endpush