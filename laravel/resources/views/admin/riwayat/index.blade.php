@php
    $nama = 'Sampah';
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
            <a class="btn btn-success" href="{{ route($route . '.create') }}">Tambah {{ $nama }}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Sampah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Sampah</th>
                            <th>Total</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->user->name ?? 'N/A' }}</td>
                            <td>
                                {{-- Accordion for sampah list --}}
                                <div class="accordion" id="accordion-sampah-{{ $d->id }}">
                                    <div class="card mb-0 border-0">
                                        <div class="card-header p-0" id="heading-sampah-{{ $d->id }}">
                                            <button
                                                class="btn btn-link btn-sm text-left p-1 collapsed"
                                                type="button"
                                                data-toggle="collapse"
                                                data-target="#collapse-sampah-{{ $d->id }}"
                                                aria-expanded="false"
                                                aria-controls="collapse-sampah-{{ $d->id }}"
                                            >
                                                <i class="fas fa-list mr-1"></i>
                                                {{ $d->sampahs->count() }} jenis sampah
                                                <i class="fas fa-chevron-down ml-1 small"></i>
                                            </button>
                                        </div>
                                        <div
                                            id="collapse-sampah-{{ $d->id }}"
                                            class="collapse"
                                            aria-labelledby="heading-sampah-{{ $d->id }}"
                                            data-parent="#accordion-sampah-{{ $d->id }}"
                                        >
                                            <div class="card-body p-1">
                                                <table class="table table-sm table-striped mb-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Nama Sampah</th>
                                                            <th>Total (kg)</th>
                                                            <th>Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($d->sampahs as $sampah)
                                                        <tr>
                                                            <td>{{ $sampah->name }}</td>
                                                            <td>{{ $sampah->pivot->total }}</td>
                                                            <td>Rp. {{ number_format($sampah->pivot->total_harga, 0, ',', '.') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($d->sampahs->sum('pivot.total_harga') ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        // Prevent DataTables from re-ordering collapsed accordion content
        orderCellsTop: true,
        columnDefs: [
            { orderable: false, targets: 2 } // disable sorting on Sampah column
        ]
    });

    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
