@extends('layouts.app')

@section('title', 'Edit Jenis Surat')

@section('content')
    <div class="container mt-4">
        {{-- Hidden element untuk menangkap pesan sukses dari session --}}
        @if (session('success'))
            <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
        @endif

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Jenis Surat: {{ $mailType->type_name }}</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Form Edit Data Jenis Surat
            </div>
            <div class="card-body">
                {{-- Form action menggunakan ID dan method PUT --}}
                <form action="{{ route('mailtype.update', $mailType->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="type_name" class="form-label">Nama Jenis Surat</label>
                        {{-- Memastikan value terisi dari data model atau old input --}}
                        <input type="text" class="form-control @error('type_name') is-invalid @enderror" id="type_name"
                            name="type_name" value="{{ old('type_name', $mailType->type_name) }}" required>
                        @error('type_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Perbarui</button>
                    <a href="{{ route('mailtype.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Memastikan SweetAlert tersedia (jika belum ada di layouts.admin.app) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tampilkan SweetAlert jika ada pesan sukses dari session (setelah redirect update)
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successAlert.dataset.message,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endpush
