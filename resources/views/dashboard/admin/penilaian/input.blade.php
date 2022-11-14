@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
  <div class="d-flex" style="margin-left: 0;">
  </div>
  <div>
    <a href="{{ url('penilaians') }}" class="btn btn-primary mb-2" style="border-radius: 20px;"><i class="fa-solid fa-angle-left fa-fw"></i> Kembali</a> 
  </div>
</div>

<form action="{{ url('penilaians') }}" id="penilaianForm" method="post">
    @csrf
    <input type="hidden" class="form-control" id="pembukaan_id" name="pembukaan_id" value="{{ $pembukaan_id }}" readonly>
    <input type="hidden" class="form-control" id="aspek_id" name="aspek_id" value="{{ $aspek_id }}" readonly>
        <div class="card rounded shadow border-0">
            <div class="card-body p-5 bg-white rounded">
                <div class="table-responsive" style="height: 450px;">
                    <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                    @if ($alternatifs->count())
                        <thead align="center" style="position: sticky; top: -1px; background: #ffffff">
                            <tr>
                                <th scope="col">Nama Calon Anggota</th>
                                @foreach($kriterias as $kriteria)
                                    <th scope="col">{{ $kriteria->name  }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody align="center">
                        @foreach ($alternatifs as $alternatif)
                            <tr>
                                <td style='text-align:left; vertical-align:middle'>{{ $alternatif->name }}</td>
                                @foreach($kriterias as $kriteria)
                                <td>
                                    <select class="form-select" name="value[{{$alternatif->id}}][{{$kriteria->id}}]" id="value">
                                        <option value="1" selected>1 - Sangat Kurang</option>
                                        <option value="2">2 - Kurang</option>
                                        <option value="3">3 - Cukup</option>
                                        <option value="4">4 - Baik</option>
                                        <option value="5">5 - Sangat Baik</option>
                                    </select>
                                </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    @else
                        <p class="text-center fs-4">Seleksi tidak memilki alternatif.</p>
                    @endif
                    </table>
                        <button type="submit" class="btn btn-primary input" style="float: right; border-radius: 20px;">Submit</button>
                </div>
            </div>
        </div>
</form>

<script type="text/javascript">
    $('.input').click(function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Submit nilai?',
            text: "Periksa kembali sebelum melakukan submit karena hanya dapat dilakukan 1x penilaian",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Submit',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#penilaianForm').submit();
            }
        })
    })
</script>

@endsection
@extends('dashboard.layouts.footer')