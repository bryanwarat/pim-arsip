@extends('layouts.app')

@section('title', 'Detail Jenis Surat')

@section('content')
    <div class="container mt-4">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Detail Jenis Surat</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Informasi Lengkap Jenis Surat
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4"><strong>ID</strong></div>
                    <div class="col-md-8">{{ $mailType->id }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Nama Jenis Surat</strong></div>
                    <div class="col-md-8">{{ $mailType->type_name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Dibuat Pada</strong></div>
                    <div class="col-md-8">{{ $mailType->created_at->format('d F Y H:i:s') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Terakhir Diperbarui</strong></div>
                    <div class="col-md-8">{{ $mailType->updated_at->format('d F Y H:i:s') }}</div>
                </div>

                <hr>
                <a href="{{ route('mailtype.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                {{-- Memastikan rute edit menggunakan ID --}}
                <a href="{{ route('mailtype.edit', $mailType->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
@endsection
