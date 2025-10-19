@extends('layouts.app')

@section('title', 'Daftar Surat Masuk')
@section('meta_description', 'Halaman daftar surat masuk aplikasi arsip')
@section('meta_author', 'Admin')

@section('content')
    <div class="container mt-4">
        {{-- Hidden element for flash message (Success Alert) --}}
        @if (session('success'))
            <div id="success-alert" class="d-none" data-message="{{ session('success') }}"></div>
        @endif

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Daftar Surat Masuk</h4>
            </div>
            <a href="{{ route('incomingmail.create') }}" class="btn btn-primary btn-sm">Input Surat Masuk Baru</a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Tabel Surat Masuk</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="incomingMailTable" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nomor Surat</th>
                                <th>Asal</th>
                                <th>Perihal</th>
                                <th>Tipe</th>
                                <th>Sifat</th>
                                <th>Tgl Terima</th>
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
            var table = $('#incomingMailTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('incomingmail.data') }}', // PENTING: Memanggil rute getData()
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
                        data: 'origin',
                        name: 'origin'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'mail_type_name',
                        name: 'mail_types.type_name' // Kolom join dari tabel mail_types
                    },
                    {
                        data: 'classification_name',
                        name: 'mail_classifications.classification_name' // Kolom join dari tabel mail_classifications
                    },
                    {
                        data: 'received_date',
                        name: 'received_date'
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
                    [6, 'desc'] // Urutkan berdasarkan tanggal terima
                ],
                pageLength: 10
            });

            // --- SweetAlert for Delete Confirmation ---
            $('#incomingMailTable').on('click', '.btn-danger', function(e) {
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
