@extends('layouts.app')

@section('title', 'Daftar Jenis Surat')
@section('meta_description', 'Halaman daftar Jenis Surat aplikasi arsip')
@section('meta_author', 'Admin')

@section('content')
    <div class="container mt-4">
        {{-- Hidden element for flash message (Success Alert) --}}
        @if (session('success'))
            <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
        @endif

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Daftar Jenis Surat</h4>
            </div>
            <a href="{{ route('mailtype.create') }}" class="btn btn-primary btn-sm">Tambah Jenis Surat Baru</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- Tabel yang akan diisi oleh DataTables --}}
                    <table id="mailTypeTable" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis Surat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data will be loaded via AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Style untuk DataTables Bootstrap 5 --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <script
        src="https://www.google.com/search?q=https://cdn.jsdelivr.net/npm/bootstrap%405.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // --- SweetAlert for Flash Message (Success after CRUD operation) ---
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

        // --- Yajra DataTables Initialization ---
        $(function() {
            var table = $('#mailTypeTable').DataTable({
                processing: true,
                serverSide: true,
                // PENTING: Memanggil rute yang mengandung method getData()
                ajax: '{{ route('mailtype.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'type_name',
                        name: 'type_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10
            });

            // --- SweetAlert for Delete Confirmation ---
            $('#mailTypeTable').on('click', '.btn-danger', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Yakin Ingin Menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
