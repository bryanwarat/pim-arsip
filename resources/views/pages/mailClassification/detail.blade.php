@extends('layouts.app')

@section('title', 'Detail Sifat Surat')

@section('content')
    <div class="container mt-4">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Detail Sifat Surat</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Informasi Lengkap
            </div>
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-md-4"><strong>Nama Sifat Surat</strong></div>
                    <div class="col-md-8">{{ $classification->classification_name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Dibuat Pada</strong></div>
                    <div class="col-md-8">{{ $classification->created_at->format('d F Y H:i:s') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4"><strong>Terakhir Diperbarui</strong></div>
                    <div class="col-md-8">{{ $classification->updated_at->format('d F Y H:i:s') }}</div>
                </div>

                <hr>
                <a href="{{ route('mailclassification.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                <a href="{{ route('mailclassification.edit', $classification->id) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
@endsection
