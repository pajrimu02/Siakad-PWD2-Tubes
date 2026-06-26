@extends('layouts.admin')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<div class="page-wrapper">

    <div class="page-header">
        <div class="header-left">
             
            <div class="header-title">
                <h1>Tambah Mata Kuliah</h1>
                <p>Isi form untuk menambahkan mata kuliah baru</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('matakuliah.store') }}" method="POST">
            @csrf

            <div class="form-grid">

                {{-- Kode MK --}}
                <div class="form-group">
                    <label for="kode_mk">Kode MK <span class="required">*</span></label>
                    <input type="text" id="kode_mk" name="kode_mk"
                           value="{{ old('kode_mk') }}"
                           placeholder="Contoh: MKB101"
                           class="form-control @error('kode_mk') is-invalid @enderror"
                           style="font-family:monospace;" required>
                    @error('kode_mk')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Nama MK --}}
                <div class="form-group">
                    <label for="nama_mk">Nama Mata Kuliah <span class="required">*</span></label>
                    <input type="text" id="nama_mk" name="nama_mk"
                           value="{{ old('nama_mk') }}"
                           placeholder="Contoh: Algoritma dan Pemrograman"
                           class="form-control @error('nama_mk') is-invalid @enderror" required>
                    @error('nama_mk')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- SKS --}}
                <div class="form-group">
                    <label for="sks">SKS <span class="required">*</span></label>
                    <select id="sks" name="sks"
                            class="form-control @error('sks') is-invalid @enderror" required>
                        <option value="" disabled {{ old('sks') === null ? 'selected' : '' }}>-- Pilih --</option>
                        @foreach([1,2,3,4,5,6] as $s)
                            <option value="{{ $s }}" {{ old('sks') == $s ? 'selected' : '' }}>
                                {{ $s }} SKS
                            </option>
                        @endforeach
                    </select>
                    @error('sks')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Semester --}}
                <div class="form-group">
                    <label for="semester">Semester <span class="required">*</span></label>
                    <select id="semester" name="semester"
                            class="form-control @error('semester') is-invalid @enderror" required>
                        <option value="" disabled {{ old('semester') === null ? 'selected' : '' }}>-- Pilih Semester --</option>
                        @foreach(range(1, 8) as $s)
                            <option value="{{ $s }}" {{ old('semester') == $s ? 'selected' : '' }}>
                                Semester {{ $s }}
                            </option>
                        @endforeach
                    </select>
                    @error('semester')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('matakuliah.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Mata Kuliah
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 720px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
    .header-left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: .85rem; color: #6b7280; text-decoration: none; padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all .15s; }
    .btn-back:hover { background: #f3f4f6; color: #111827; }
    .header-title h1 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 0; }
    .header-title p  { font-size: .85rem; color: #6b7280; margin: 2px 0 0; }
    .alert-danger { display: flex; align-items: flex-start; gap: .75rem; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 10px; padding: .9rem 1.1rem; margin-bottom: 1.25rem; font-size: .875rem; }
    .form-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem 1.5rem; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    label { font-size: .84rem; font-weight: 600; color: #374151; }
    .required { color: #ef4444; }
    .form-control { padding: .55rem .85rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: .9rem; color: #111827; background: #fff; transition: border-color .15s, box-shadow .15s; outline: none; width: 100%; box-sizing: border-box; }
    .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
    .form-control.is-invalid { border-color: #f87171; }
    select.form-control { cursor: pointer; }
    .invalid-feedback { font-size: .78rem; color: #ef4444; }
    .form-actions { display: flex; justify-content: flex-end; gap: .75rem; margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid #f3f4f6; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: .55rem 1.25rem; border-radius: 8px; font-size: .88rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .15s; }
    .btn-primary { background: #6366f1; color: #fff; }
    .btn-primary:hover { background: #4f46e5; }
    .btn-secondary { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
    .btn-secondary:hover { background: #e5e7eb; }
    @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .form-actions { flex-direction: column-reverse; } .btn { justify-content: center; } }
</style>
@endpush