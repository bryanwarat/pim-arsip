@extends('layouts.app')

@section('title', 'Tambah Jenis Surat')

@section('content')
    <div class="container mt-4">
        {{-- Hidden element for flash message (Success Alert, used if redirect comes back to this page) --}}
        @if (session('success'))
            <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
        @endif

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Tambah Jenis Surat Baru</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Form Data Jenis Surat
            </div>
            <div class="card-body">
                {{-- Form action diarahkan ke route store --}}
                <form action="{{ route('mailtype.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="type_name" class="form-label">Nama Jenis Surat</label>
                        {{-- Field input untuk nama Jenis Surat --}}
                        <input type="text" class="form-control @error('type_name') is-invalid @enderror" id="type_name"
                            name="type_name" value="{{ old('type_name') }}" required>
                        @error('type_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('mailtype.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tampilkan SweetAlert jika ada pesan sukses dari session 
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
