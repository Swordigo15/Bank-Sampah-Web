@extends('main')
@section('title')
    @lang('Bank Sampah - Sampah')
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Input Sampah</h6>
            {{-- <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div> --}}
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{ route('input.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="form-label">Nama User</label>
                    <select
                        class="form-select select2"
                        name="user_id"
                        id="user_id"
                        style="width: 100%;"
                        required
                    >
                        <option value="">Pilih User...</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="card-body">
                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input
                                type="text"
                                id="searchSampah"
                                class="form-control border-start-0"
                                placeholder="Cari jenis sampah..."
                                oninput="filterSampah(this.value)"
                            >
                            <button
                                class="btn btn-danger"
                                type="button"
                                onclick="document.getElementById('searchSampah').value=''; filterSampah('')"
                                title="Hapus pencarian"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Cards Grid --}}
                    <div class="row" id="sampahGrid">
                        @foreach ($sampah as $s)
                            <div class="col-md-4 mb-4 sampah-item"
                                data-name="{{ strtolower($s->name) }}"
                                data-harga="{{ $s->harga }}"
                                data-satuan="{{ $s->jumlah_satuan }}">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex flex-column">

                                        <div class="mb-3">
                                            <h5 class="fw-bold mb-2">{{ $s->name }}</h5>

                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="badge bg-success fs-6 px-3 py-2">
                                                    <p class="text-white mb-0">Rp {{ number_format($s->harga, 0, ',', '.') }}</p>
                                                </span>

                                                <small class="text-muted mx-2">per</small>

                                                <span class="badge bg-light text-dark border fs-6 px-3 py-2">
                                                    {{ $s->jumlah_satuan }} {{ $s->satuan }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="mt-auto">
                                            <label class="form-label text-muted small">
                                                Jumlah {{ $s->satuan }}
                                            </label>

                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    class="form-control"
                                                    name="jumlah[{{ $s->id }}]"
                                                    id="{{ $s->name }}_jumlah"
                                                    placeholder="Masukkan jumlah..."
                                                >
                                                <span class="input-group-text">
                                                    {{ $s->satuan }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Empty State --}}
                    <div id="emptySearch" class="text-center py-5 d-none">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Tidak ada sampah yang cocok dengan "<span id="searchKeyword"></span>"</p>
                    </div>
                </div>

                <div class="flex width-100">
                    <h2 class="h5 text-muted">Total: <span id="totalHarga">Rp 0</span></h2>
                    <button type="submit" class="btn btn-success">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: 'Cari User...',
        allowClear: true
    });

    // Add event listeners to all quantity inputs
    document.querySelectorAll('input[name^="jumlah"]').forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
});

function filterSampah(query) {
    const keyword = query.trim().toLowerCase();
    const items = document.querySelectorAll('.sampah-item');
    const emptyState = document.getElementById('emptySearch');
    const keywordSpan = document.getElementById('searchKeyword');

    let visibleCount = 0;

    items.forEach(item => {
        const name = item.getAttribute('data-name');
        const match = name.includes(keyword);
        item.classList.toggle('d-none', !match);
        if (match) visibleCount++;
    });

    if (visibleCount === 0 && keyword !== '') {
        keywordSpan.textContent = query;
        emptyState.classList.remove('d-none');
    } else {
        emptyState.classList.add('d-none');
    }
}

function calculateTotal() {
    let total = 0;

    document.querySelectorAll('.sampah-item').forEach(item => {
        const input = item.querySelector('input[name^="jumlah"]');
        const harga = parseFloat(item.getAttribute('data-harga')) || 0;
        const jumlahSatuan = parseFloat(item.getAttribute('data-satuan')) || 1;
        const jumlah = parseFloat(input.value) || 0;

        total += harga * (jumlah / jumlahSatuan);
    });

    document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
@endpush
