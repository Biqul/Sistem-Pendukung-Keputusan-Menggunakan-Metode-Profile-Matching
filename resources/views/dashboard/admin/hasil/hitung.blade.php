@extends('dashboard.layouts.main')

@section('container')
@include('sweetalert::alert')

<div class="d-flex justify-content-between flex-wrap mb-3 flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
    <h1 class="h2">{{ $title }}</h1>
</div>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>PERHITUNGAN</strong></div>
            <div class="panel-body" style=" border: 1px solid #e7e7e7;">
                <div class="panel panel-default">
                    @foreach($aspeks as $aspek)
                        @foreach($aspekss as $aspekk)
                            @if($aspek == $aspekk->id)
                            <div class="panel-heading" style="text-align:center; vertical-align:middle; background: #2B4252; color: white;"><h6><strong>{{ ucfirst(strtoupper($aspekk->name)) }}</strong></h6></div>
                                <div class="table-responsive">
                                    <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="col">Nama Calon Anggota</th>
                                                @foreach($kriteriass as $kriteria)
                                                    @foreach($kriterias as $kriteriaa => $value)
                                                        @if($kriteria->aspek_id == $aspek)
                                                            @if($value == $kriteria->id)
                                                                <th scope="col" style='text-align:center; vertical-align:middle'>{{ ucfirst(strtoupper($kriteria->kode_kriteria)) }}</th>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                            @foreach($alternatifs as $alternatif)
                                            <tr>
                                                <td>{{ $alternatif->name }}</td>
                                                @foreach($kriteriass as $kriteria)
                                                    @foreach($kriterias as $kriteriaa => $value)
                                                        @if($kriteria->aspek_id == $aspek)
                                                            @if($value == $kriteria->id)
                                                        
                                                                @foreach($penilaians as $penilaian)
                                                                    @if(($penilaian->kriteria_id == $kriteria->id) && ($penilaian->alternatif->id == $alternatif->id))
                                                                        <td style='text-align:center; vertical-align:middle'>{{ $penilaian->value }}</td>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                                <tr>
                                                    <th>Nilai Kriteria</th>
                                                        @foreach($kriteriass as $kriteria)
                                                            @foreach($kriterias as $kriteriaa => $value)
                                                                @if($kriteria->aspek_id == $aspek)
                                                                    @if($value == $kriteria->id)
                                                                        <td class="text-primary" style='text-align:center; vertical-align:middle;'>{{ $kriteria->value }}</td>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <div class="panel-body"><strong>Perhitungan Pemetaan GAP :</strong> (Nilai Calon Anggota - Nilai Standar)</div>
                                <div class="table-responsive">
                                    <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="col">Nama Calon Anggota</th>
                                                @foreach($kriteriass as $kriteria)
                                                    @foreach($kriterias as $kriteriaa => $value)
                                                        @if($kriteria->aspek_id == $aspek)
                                                            @if($value == $kriteria->id)
                                                            <th scope="col" style='text-align:center; vertical-align:middle'>{{ ucfirst(strtoupper($kriteria->kode_kriteria))  }}</th>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                            @foreach($alternatifs as $alternatif)
                                            <tr>
                                                <td>{{ $alternatif->name }}</td>
                                                    @foreach($kriteriass as $kriteria)
                                                        @foreach($kriterias as $kriteriaa => $value)
                                                            @if($kriteria->aspek_id == $aspek)
                                                                @if($value == $kriteria->id)
                                                                    @if($kriteria->type_id == 1)
                                                                        @foreach($hasilCore as $i => $alternatif_id)
                                                                            @foreach($alternatif_id as $j => $aspek_id)
                                                                                @foreach($aspek_id as $kriteria_id => $value)
                                                                                    @if(($kriteria_id == $kriteria->id) && ($i == $alternatif->id))
                                                                                    <td style='text-align:center; vertical-align:middle'>{{ $value }}</td>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($hasilSecondary as $i => $alternatif_id)
                                                                            @foreach($alternatif_id as $j => $aspek_id)
                                                                                @foreach($aspek_id as $kriteria_id => $value)
                                                                                    @if(($kriteria_id == $kriteria->id) && ($i == $alternatif->id))
                                                                                    <td style='text-align:center; vertical-align:middle'>{{ $value }}</td>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <div class="panel-body"><strong>Pembobotan Nilai GAP :</strong></div>
                                <div class="table-responsive">
                                    <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="col">Nama Calon Anggota</th>
                                                @foreach($kriteriass as $kriteria)
                                                    @foreach($kriterias as $kriteriaa => $value)
                                                        @if($kriteria->aspek_id == $aspek)
                                                            @if($value == $kriteria->id)
                                                                <th scope="col" style='text-align:center; vertical-align:middle'>{{ ucfirst(strtoupper($kriteria->kode_kriteria))  }}</th>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                            @foreach($alternatifs as $alternatif)
                                            <tr>
                                                <td>{{ $alternatif->name }}</td>
                                                    @foreach($kriteriass as $kriteria)
                                                        @foreach($kriterias as $kriteriaa => $value)
                                                            @if($kriteria->aspek_id == $aspek)
                                                                @if($value == $kriteria->id)
                                                                    @if($kriteria->type_id == 1)
                                                                        @foreach($terbobotCore as $alternatif_id => $i)
                                                                            @foreach($i as $aspek_id => $j)
                                                                                @foreach($j as $kriteria_id => $value)
                                                                                    @if(($kriteria_id == $kriteria->id) && ($alternatif_id == $alternatif->id))
                                                                                    <td style='text-align:center; vertical-align:middle'>{{ $value }}</td>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($terbobotSecondary as $alternatif_id => $i)
                                                                            @foreach($i as $aspek_id => $j)
                                                                                @foreach($j as $kriteria_id => $value)
                                                                                    @if(($kriteria_id == $kriteria->id) && ($alternatif_id == $alternatif->id))
                                                                                    <td style='text-align:center; vertical-align:middle'>{{ $value }}</td>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <div class="panel-body"><strong>Perhitungan Factor :</strong> (Jumlah total nilai Core Factor atau Secondary Factor / Jumlah item Core Factor atau Secondary Factor)</div>
                                <div class="table-responsive">
                                    <table id="example" style="width:100%; overflow: scroll;" class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="col">Nama Calon Anggota</th>
                                                @foreach($kriteriass as $kriteria)
                                                    @foreach($kriterias as $kriteriaa => $value)
                                                        @if($kriteria->aspek_id == $aspek)
                                                            @if($value == $kriteria->id)
                                                                <th scope="col" style='text-align:center; vertical-align:middle'>{{ ucfirst(strtoupper($kriteria->kode_kriteria))  }}</th>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                <th scope="col" style='text-align:center; vertical-align:middle'>NCF</th>
                                                <th scope="col" style='text-align:center; vertical-align:middle'>NSF</th>           
                                                <th scope="col" style='text-align:center; vertical-align:middle'>Total</th>
                                            </tr>
                                            @foreach($alternatifs as $alternatif)
                                            <tr>
                                                <td>{{ $alternatif->name }}</td>
                                                    @foreach($kriteriass as $kriteria)
                                                        @foreach($kriterias as $kriteriaa => $value)
                                                            @if($kriteria->aspek_id == $aspek)
                                                                @if($value == $kriteria->id)
                                                                    @if($kriteria->type_id == 1)
                                                                        @foreach($terbobotCore as $alternatif_id => $i)
                                                                            @foreach($i as $aspek_id => $j)
                                                                                @foreach($j as $kriteria_id => $value)
                                                                                    @if(($kriteria_id == $kriteria->id) && ($alternatif_id == $alternatif->id))
                                                                                    <td style='text-align:center; vertical-align:middle'>{{ $value }}</td>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    @else
                                                                        @foreach($terbobotSecondary as $alternatif_id => $i)
                                                                            @foreach($i as $aspek_id => $j)
                                                                                @foreach($j as $kriteria_id => $value)
                                                                                    @if(($kriteria_id == $kriteria->id) && ($alternatif_id == $alternatif->id))
                                                                                    <td style='text-align:center; vertical-align:middle'>{{ $value }}</td>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                            
                                                    @foreach($hasilAspeks as $hasilAspek)
                                                        @if($hasilAspek->alternatif_id == $alternatif->id && $hasilAspek->aspek_id == $aspek)
                                                                <td style='text-align:center; vertical-align:middle'>{{ $hasilAspek->ncf }}</td>
                                                                <td style='text-align:center; vertical-align:middle'>{{ $hasilAspek->nsf }}</td>
                                                                <td style='text-align:center; vertical-align:middle'>{{ $hasilAspek->total }}</td>
                                                        @endif
                                                    @endforeach
                                                    
                                            </tr>
                                            @endforeach 
                                            <tr>
                                                <td></td>
                                                @foreach($kriteriass as $kriteria)
                                                    @foreach($kriterias as $kriteriaa => $value)
                                                        @if($kriteria->aspek_id == $aspek)
                                                            @if($value == $kriteria->id)
                                                                @foreach($types as $type)
                                                                        @if($kriteria->type_id == $type->id)
                                                                            <td style='text-align:center; vertical-align:middle; font-weight: bold;'>{{ $type->name }}</td>
                                                                        @endif
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr style="height:10px; background-color: #2B4252">
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                    </div>
            </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>HASIL AKHIR</strong></div>
            <div class="panel-body" style=" border: 1px solid #e7e7e7;">
                <div class="panel panel-default">
                    <div class="table-responsive" id="cetak">
                        <div class="d-flex">
                            <p style="margin: 5px 3px 8px 10px;"><strong>Ketersediaan Kuota : {{ $kuota }}</strong></p>
                            <p style="margin: 5px 3px 8px 20px;"><strong>Nilai Ambang : {{ $nilai_ambang }}</strong></p>
                        </div>
                    
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
                                    <th scope="col" style='text-align:center; vertical-align:middle'>Ket.</th>
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
                                                    <form method="post" action="{{ url('exportsPDF') }}">
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
                                            @if($rank <= $kuota && $ranking->nilai_akhir >= $nilai_ambang)
                                                <td class="text" style='text-align:center; vertical-align:middle; font-weight: bold; color: green;'>LULUS</td>
                                            @else
                                                <td class="text" style='text-align:center; vertical-align:middle; font-weight: bold; color: red;'>GAGAL</td>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </form>
                        <form method="post" action="{{ url('selesaiHitung') }}">
                            @csrf
                            <input type="hidden" class="form-control" id="pembukaan_id" name="pembukaan_id" value="{{ $pembukaan_id }}">
                            <input type="hidden" class="form-control" id="kuota" name="kuota" value="{{ $kuota }}">
                            <input type="hidden" class="form-control" id="nilai_ambang" name="nilai_ambang" value="{{ $nilai_ambang }}">
                            <button type="submit" class="btn btn-success mb-2" style="float: right; margin-right: 10px; border-radius: 20px;"><i class="fa-solid fa-check fa-fw"></i> Selesai</button> 
                        </form>
                    </div>
                    </div>
                </div>
            </div>
    </div>
</div>


@endsection
@extends('dashboard.layouts.footer')