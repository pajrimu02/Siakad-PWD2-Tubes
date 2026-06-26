@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('users.index') }}" class="btn-back">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>

            <div class="header-title">
                <h1>Edit User</h1>
                <p>Perbarui data user (Admin / Mahasiswa)</p>
            </div>
        </div>
    </div>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert-danger">
            <i class="fa fa-exclamation-circle"></i>
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD FORM --}}
    <div class="form-card">

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- NAME --}}
                <div class="form-group full-width">
                    <label>Nama User <span class="required">*</span></label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama user">
                    @error('name')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="form-group full-width">
                    <label>Email <span class="required">*</span></label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="example@mail.com">
                    @error('email')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Kosongkan jika tidak diubah">
                    @error('password')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- ROLE --}}
                <div class="form-group">
                    <label>Role <span class="required">*</span></label>
                    <select name="role"
                            class="form-control @error('role') is-invalid @enderror">

                        <option value="">-- Pilih Role --</option>

                        <option value="admin"
                            {{ old('role', $user->getRoleNames()->first()) == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="mahasiswa"
                            {{ old('role', $user->getRoleNames()->first()) == 'mahasiswa' ? 'selected' : '' }}>
                            Mahasiswa
                        </option>

                    </select>

                    @error('role')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            {{-- ACTION --}}
            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Update User
                </button>
            </div>

        </form>

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

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-title h1 {
    font-size: 1.4rem;
    font-weight: 700;
    margin: 0;
}

.header-title p {
    font-size: .85rem;
    color: #6b7280;
    margin: 2px 0 0;
}

/* BACK BUTTON */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    color: #6b7280;
    font-size: .85rem;
}

.btn-back:hover {
    background: #f3f4f6;
}

/* ERROR */
.alert-danger {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 15px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
}

.alert-danger ul {
    margin: 0;
    padding-left: 18px;
    font-size: .85rem;
}

/* CARD */
.form-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 2rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

/* GRID */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.2rem;
}

.full-width {
    grid-column: 1 / -1;
}

/* FORM */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

label {
    font-size: .85rem;
    font-weight: 600;
    color: #374151;
}

.required {
    color: #ef4444;
}

.form-control {
    padding: .6rem .85rem;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    outline: none;
    font-size: .9rem;
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.15);
}

.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    font-size: .78rem;
    color: #ef4444;
}

/* ACTION */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 2rem;
    padding-top: 1.2rem;
    border-top: 1px solid #f1f5f9;
}

/* BUTTON */
.btn {
    padding: .55rem 1.2rem;
    border-radius: 10px;
    font-size: .88rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-primary {
    background: #6366f1;
    color: #fff;
}

.btn-primary:hover {
    background: #4f46e5;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
}

/* RESPONSIVE */
@media(max-width:700px){
    .form-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush