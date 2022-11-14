@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap mb-3 flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-1">
  <div class="d-flex" style="margin-left: 0;">
  </div>
  <div>
    <a href="{{ url('pembukaans') }}" class="btn btn-primary mb-2" style="border-radius: 20px; margin-right: 18px;"><i class="fa-solid fa-angle-left fa-fw"></i> Kembali</a> 
  </div>
</div>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>HASIL AKHIR</strong></div>
            <div class="panel-body" style=" border: 1px solid #e7e7e7;">
                <div class="table-responsive" id="cetak">
                    <p>Ketersediaan Kuota : {{ $kuota }} </p>
                    <p>Nilai Ambang : {{ $nilai_ambang }} </p>
                    <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th scope="col">Nama Calon Anggota</th>
                                @foreach($aspekss as $aspekk)
                                    @if($aspekk->status_id == 3)
                                        <th scope="col" style='text-align:center; vertical-align:middle'>{{ $aspekk->name }} ({{ $aspekk->persentase }}%)</th>
                                    @endif
                                @endforeach
                                <th scope="col" style='text-align:center; vertical-align:middle'>Total</th>
                                <th scope="col" style='text-align:center; vertical-align:middle'>Rank</th>
                                <th scope="col" style='text-align:center; vertical-align:middle'>Keterangan</th>
                            </tr>
                            
                            <!-- {{ $e = 0 }} -->
                            @foreach($rankings as $ranking)
                            <tr>
                                @foreach($alternatifs as $alternatif)
                                    @if($ranking->alternatif_id == $alternatif->id)
                                        <td>{{ $alternatif->name }}</td>
                                        @foreach($aspeks as $aspek)
                                            @foreach($aspekss as $aspekk)
                                                @if($aspek == $aspekk->id)
                                                <form method="post" action="{{ url('exportPDF') }}">
                                                @csrf
                                                    @foreach($hasilAspeks as $hasilAspek)
                                                        @if($hasilAspek->alternatif_id == $alternatif->id && $hasilAspek->aspek_id == $aspek)
                                                                <td style='text-align:center; vertical-align:middle'>{{ $hasilAspek->totalEach }}</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endforeach
                                        
                                                <!-- Total -->
                                                <td style='text-align:center; vertical-align:middle; font-weight: bold;'>{{ $ranking->nilai_akhir }}</td>
                                        
                                        <!-- Rank -->
                                        <!-- {{ $rank = $e+=1}} -->
                                        <td class="text-primary" style='text-align:center; vertical-align:middle; font-weight: bold;'>{{ $rank }}</td>

                                        @if($alternatif->hasil_id == 5)
                                            @foreach($statuses as $status)
                                                @if($status->id == 5)
                                                <!-- Keterangan -->
                                                    <td class="text-success" style='text-align:center; vertical-align:middle; font-weight: bold;'>
                                                        <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-success ganti" data-id="{{ $alternatif->id }}"><i class="fa-regular fa-circle-check fa-fw"></i> {{ $status->name }}</a>
                                                    </td>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($statuses as $status)
                                                @if($status->id == 6)
                                                <!-- Keterangan -->
                                                    <td class="text-success" style='text-align:center; vertical-align:middle; font-weight: bold;'>
                                                        <a style="text-decoration: none; border-radius: 20px;" href="#" class="badge bg-danger ganti" data-id="{{ $alternatif->id }}"><i class="fa-regular fa-circle-check fa-fw"></i> {{ $status->name }}</a>
                                                    </td>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <input type="hidden" class="form-control" id="pembukaan_id" name="pembukaan_id" value="{{ $pembukaan_id }}">
                        <input type="hidden" class="form-control" id="kuota" name="kuota" value="{{ $kuota }}">
                        <button type="submit" class="btn btn-success mb-2 mt-2" style="float: right; border-radius: 20px;"><i class="fa-solid fa-print fa-fw"></i> Cetak</button> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('.ganti').click(function(){
        var status_id = $(this).attr('data-id');
        Swal.fire({
            title: 'Ubah keterangan?',
            text: "Apakah anda yakin ingin mengubah keterangan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ubah',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = "ganti-ket/"+status_id+""
            }
        })
    })
</script>

@endsection
@extends('dashboard.layouts.footer')