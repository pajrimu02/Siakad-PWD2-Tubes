@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">

        <div class="header-left">
            <a href="{{ route('users.index') }}" class="btn-back">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>

            <div class="header-title">
                <h1>Detail User</h1>
                <p>Informasi lengkap akun user</p>
            </div>
        </div>

        <div>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit">
                <i class="fa fa-pen"></i>
                Edit User
            </a>
        </div>

    </div>

    {{-- GRID INFO --}}
    <div class="info-row">

        {{-- USER --}}
        <div class="info-card">
            <div class="info-card-head">
                <div class="ic-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                    <i class="fa fa-user text-white"></i>
                </div>
                <span class="ic-title">User</span>
            </div>

            <div class="ic-body">
                <div class="avatar-lg">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>

                <div class="ic-name">{{ $user->name }}</div>
                <div class="ic-sub">{{ $user->email }}</div>

                <div class="ic-meta-row mt-2">
                    @foreach($user->getRoleNames() as $role)
                        <span class="ic-tag">{{ $role }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- MAHASISWA --}}
        <div class="info-card">
            <div class="info-card-head">
                <div class="ic-icon" style="background:linear-gradient(135deg,#0ea5e9,#0284c7);">
                    <i class="fa fa-graduation-cap text-white"></i>
                </div>
                <span class="ic-title">Mahasiswa</span>
            </div>

            <div class="ic-body">

                @if($user->mahasiswa)
                    <div class="ic-name">{{ $user->mahasiswa->nama }}</div>
                    <div class="ic-sub">NIM: {{ $user->mahasiswa->nim }}</div>

                    <div class="ic-meta-row mt-2">
                        <span class="ic-tag">Angkatan {{ $user->mahasiswa->angkatan ?? '-' }}</span>
                    </div>
                @else
                    <div class="text-muted">Tidak terhubung dengan mahasiswa</div>
                @endif

            </div>
        </div>

        {{-- DOSEN --}}
        <div class="info-card">
            <div class="info-card-head">
                <div class="ic-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                    <i class="fa fa-chalkboard-teacher text-white"></i>
                </div>
                <span class="ic-title">Dosen</span>
            </div>

            <div class="ic-body">

                @if($user->dosen)
                    <div class="ic-name">{{ $user->dosen->nama ?? '-' }}</div>
                    <div class="ic-sub">{{ $user->dosen->nidn ?? '-' }}</div>
                @else
                    <div class="text-muted">Tidak terhubung dengan dosen</div>
                @endif

            </div>
        </div>

    </div>

    {{-- DETAIL TABLE --}}
    <div class="detail-card">

        <div class="detail-head">
            <i class="fa fa-info-circle"></i>
            Informasi Akun
        </div>

        <table class="detail-table">
            <tr>
                <td class="dt-label">Nama</td>
                <td class="dt-val">{{ $user->name }}</td>
            </tr>

            <tr>
                <td class="dt-label">Email</td>
                <td class="dt-val">{{ $user->email }}</td>
            </tr>

            <tr>
                <td class="dt-label">Role</td>
                <td class="dt-val">
                    @foreach($user->getRoleNames() as $role)
                        <span class="badge-role">{{ $role }}</span>
                    @endforeach
                </td>
            </tr>

            <tr>
                <td class="dt-label">Dibuat</td>
                <td class="dt-val">{{ $user->created_at }}</td>
            </tr>

            <tr>
                <td class="dt-label">Update</td>
                <td class="dt-val">{{ $user->updated_at }}</td>
            </tr>
        </table>

    </div>

</div>
@endsection


@push('styles')
<style>
.page-wrapper {
    max-width: 900px;
    margin: 0 auto;
    padding: 1.5rem 1rem 3rem;
}

.page-header {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.header-left {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    color: #6b7280;
    font-size: 13px;
}

.btn-back:hover {
    background: #f3f4f6;
    color: #111827;
}

.btn-edit {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
    padding: 7px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    display: inline-flex;
    gap: 6px;
}

.btn-edit:hover {
    background: #fde68a;
}

.header-title h1 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
}

.header-title p {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
}

/* CARD */
.info-row {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.info-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 1.2rem;
    text-align: center;
}

.info-card-head {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
}

.ic-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ic-title {
    font-size: 11px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
}

.avatar-lg {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #6366f1;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-weight: 700;
    font-size: 18px;
}

.ic-name {
    font-weight: 700;
    font-size: 14px;
}

.ic-sub {
    font-size: 12px;
    color: #94a3b8;
}

.ic-meta-row {
    margin-top: 8px;
    display: flex;
    justify-content: center;
    gap: 5px;
    flex-wrap: wrap;
}

.ic-tag {
    font-size: 11px;
    background: #f1f5f9;
    padding: 3px 8px;
    border-radius: 999px;
    color: #475569;
}

/* DETAIL TABLE */
.detail-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
}

.detail-head {
    padding: 12px 16px;
    background: #f8fafc;
    font-weight: 700;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    gap: 8px;
    align-items: center;
}

.detail-table {
    width: 100%;
    border-collapse: collapse;
}

.dt-label {
    width: 160px;
    padding: 12px 16px;
    font-size: 13px;
    color: #6b7280;
    font-weight: 600;
}

.dt-val {
    padding: 12px 16px;
    font-size: 14px;
    color: #111827;
}

.badge-role {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 12px;
    background: #ede9fe;
    color: #5b21b6;
    margin-right: 5px;
}

@media(max-width:768px){
    .info-row{
        grid-template-columns: 1fr;
    }
}
</style>
@endpush