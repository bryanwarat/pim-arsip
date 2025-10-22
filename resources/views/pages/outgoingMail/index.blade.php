@extends('layouts.app')

@section('title', 'Daftar Surat Keluar')
@section('meta_description', 'Halaman daftar surat keluar aplikasi arsip')
@section('meta_author', 'Admin')

@section('content')
    <div class="container mt-4">
        {{-- Hidden element for flash message (Success Alert) --}}
        @if (session('success'))
            <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
        @endif

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Daftar Surat Keluar</h4>
            </div>
            <a href="{{ route('outgoingmail.create') }}" class="btn btn-primary btn-sm">Input Surat Keluar</a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tabel Surat Keluar</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="outgoingMailTable" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nomor Surat</th>
                                <th>Tujuan</th>
                                <th>Perihal</th>
                                <th>Tipe</th>
                                <th>Sifat</th>
                                <th>Tgl Surat</th>
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
        // --- SweetAlert for Flash Message ---
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
            var table = $('#outgoingMailTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('outgoingmail.data') }}', // PENTING: Memanggil rute getData()
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '5%'
                    },
                    {
                        data: 'mail_number',
                        name: 'mail_number'
                    },
                    {
                        data: 'destination', // Digunakan untuk kolom Tujuan
                        name: 'destination'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'mail_type_name',
                        name: 'mail_types.type_name'
                    },
                    {
                        data: 'classification_name',
                        name: 'mail_classifications.classification_name'
                    },
                    {
                        data: 'mail_date',
                        name: 'mail_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    },
                ],
                order: [
                    [6, 'desc']
                ],
                pageLength: 10
            });

            // --- SweetAlert for Delete Confirmation ---
            $('#outgoingMailTable').on('click', '.btn-danger', function(e) {
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
