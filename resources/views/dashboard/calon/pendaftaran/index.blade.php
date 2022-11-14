@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="card shadow mb-4 mt-3">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Seleksi Yang Dibuka</h6>
    </div>
    <div class="card-body">
        <i><p>Silahkan mendaftar pada seleksi yang sedang dibuka. Jika sudah mendaftar, Anda dapat memantau alur seleksi pada halaman "Hasil Seleksi".</p></i>
        <div class="mb-3">
        @if ($pembukaans->count())
                <form class="mt-4" method="post" id="daftarForm"  action="{{ url('pendaftarans') }}" >
                @csrf
                    <div class="mb-3">
                        <label for="pembukaan_id" class="form-label"><b>Pilih Seleksi</b></label>
                            <select class="form-select" name="pembukaan_id"  id="pembukaan_id" required>
                                <option value="" disabled selected></option>
                                @foreach($pembukaans as $pembukaan)
                                    @if($pembukaan->status_id == 1)
                                        <option value="{{ $pembukaan->id }}">{{ $pembukaan->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                    </div>
                <input type="hidden" class="form-control" id="alternatif_id" name="alternatif_id" value="{{ auth()->user()->id }}">
                <button type="submit" class="mb-2 btn btn-primary input" data-id="{{ $pembukaan->name }}" style="float: right; border-radius: 20px;">Daftar</button>
                </form>
            </div>
        @else
            <p class="text-center fs-4"><b>Belum ada seleksi yang dibuka.</b></p>
        @endif
        </div>
    </div>
</div>



<script type="text/javascript">
    $('.input').click(function(e){
        e.preventDefault();
        var pembukaan_name = $(this).attr('data-id');
        Swal.fire({
            title: 'Daftar Seleksi ini?',
            text: "Anda akan mendaftar pada seleksi "+pembukaan_name+".",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Daftar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#daftarForm').submit();
            }
        })
    })
</script>
@endsection
@extends('dashboard.layouts.footer')