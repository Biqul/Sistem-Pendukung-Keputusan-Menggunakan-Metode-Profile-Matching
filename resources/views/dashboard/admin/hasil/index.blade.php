@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pilih Seleksi</h6>
    </div>
    <div class="card-body">
        <i><p>Pilihan seleksi akan muncul jika <strong>status seleksi sudah tutup</strong>. Perhitungan juga hanya dapat dilakukan apabila <strong>seleksi memiliki alternatif dan alternatif sudah memiliki nilai</strong>.</p>
            <p>Silahkan periksa kembali dua hal tersebut sebelum melakukan perhitungan.</p></i>
        <div class="mb-3">
            <form class="mt-4" method="post" action="{{ url('hasils/hitung') }}">
            @csrf
                <div class="mb-3">
                    <label for="pembukaan_id" class="form-label"><b>Pilih Seleksi</b></label>
                    <select class="form-select" name="pembukaan_id"  id="pembukaan_id" required>
                        <option value="" disabled selected></option>
                        @foreach($pembukaans as $pembukaan)
                            @if($pembukaan->status_id == 2)
                                <option value="{{ $pembukaan->id }}">{{ $pembukaan->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kuota" class="form-label"><b>Jumlah Kuota Yang Dicari</b></label>
                    <input type="text" class="form-control @error('kuota') is-invalid @enderror" id="kuota" name="kuota" required value="{{ old('kuota') }}">
                    @error('kuota')
                        <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nilai_ambang" class="form-label"><b>Nilai Ambang Batas</b></label>
                    <input type="text" class="form-control @error('nilai_ambang') is-invalid @enderror" id="nilai_ambang" name="nilai_ambang" required value="{{ old('nilai_ambang') }}">
                    @error('nilai_ambang')
                        <div class="invalid-feedback">
                        {{ $message }}
                        </div>
                    @enderror
                </div>
                    <button type="submit" class="btn btn-primary" style="float: right; border-radius: 20px;"><i class="fa-solid fa-rotate fa-fw"></i> Hitung</button>
            </form>
        </div>
    </div>
</div>


@endsection
@extends('dashboard.layouts.footer')