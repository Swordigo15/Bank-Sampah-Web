@php
    $nama = 'Edit Sampah';
    $item = 'sampah';
    $route = 'admin.sampah';
@endphp

@extends('main')
@section('title')
    @lang('Bank Sampah - ' . $nama)
@endsection

@section('content')
<!-- Page Heading -->
<div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">{{ $nama }}</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}

                </div>
                <div class="card-body">
                    <form action="{{ route($route . '.update', $sampah->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $sampah->name }}" required
                                placeholder="Masukkan nama sampah">
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ $sampah->harga }}" required
                                placeholder="Masukkan harga sampah">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_satuan" class="form-label">Jumlah Satuan</label>
                            <input type="number" class="form-control" step="0.1" min="0"
                                id="jumlah_satuan" name="jumlah_satuan" value="{{ $sampah->jumlah_satuan }}" required
                                placeholder="Masukkan jumlah satuan">
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select name="satuan" id="satuan" class="form-control" required>
                                <option value="">-- Pilih Satuan --</option>
                                <option value="kg" {{ $sampah->satuan == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                <option value="gram" {{ $sampah->satuan == 'gram' ? 'selected' : '' }}>Gram (g)</option>
                                <option value="pcs" {{ $sampah->satuan == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                <option value="liter" {{ $sampah->satuan == 'liter' ? 'selected' : '' }}>Liter (L)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush
