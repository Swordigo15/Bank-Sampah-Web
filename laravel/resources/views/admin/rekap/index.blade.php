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
            {{-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> --}}
            <a class="btn btn-success" href="{{ route($route . '.create') }}">Tambah {{ $nama }}</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Sampah</th>

                            @foreach ($months as $month)
                                <th>{{ $month }}</th>
                            @endforeach

                            <th>Total Keseluruhan</th>
                            <th>Total Pemasukan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama Sampah</th>

                            @foreach ($months as $month)
                                <th>{{ $month }}</th>
                            @endforeach

                            <th>Total Keseluruhan</th>
                            <th>Total Pemasukan</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $d->id }}</td>

                                <td>
                                    {{ $d->name }} <br>
                                    <small>
                                        Rp. {{ number_format($d->harga) }}
                                        / {{ $d->jumlah_satuan . ' ' . $d->satuan }}
                                    </small>
                                </td>

                                @foreach ($months as $month)
                                    @php
                                        $totalPerMonth = $d->inputHistory
                                            ->filter(function ($item) use ($month) {
                                                return \Carbon\Carbon::parse($item->pivot->created_at)
                                                    ->format('F Y') == $month;
                                            })
                                            ->sum('pivot.total');
                                    @endphp

                                    <td>
                                        {{ $totalPerMonth }} {{ $d->satuan }}
                                    </td>
                                @endforeach

                                <td>
                                    {{ $d->inputHistory->sum('pivot.total') }}
                                    {{ $d->satuan }}
                                </td>
                                <td>
                                    Rp. {{ number_format($d->inputHistory->sum('pivot.total_harga') ?? 0, 0, ',', '.') }}
                                </td>
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
    $('#dataTable').DataTable();

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
