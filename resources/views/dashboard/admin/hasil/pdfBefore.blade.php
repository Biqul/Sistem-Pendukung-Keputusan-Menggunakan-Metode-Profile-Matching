<!DOCTYPE html>
<html>
    <head>
    <link href="C:\xampp\htdocs\applications\iaas\public\css\perhitungan.css" rel="stylesheet">
    <link href="C:\xampp\htdocs\applications\iaas\public\css\dashboard.css" rel="stylesheet">
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  border-radius: 5px;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #323a40;
  color: white;
}

h3{
    font-family: Arial, Helvetica, sans-serif;
}

p{
    font-family: Arial, Helvetica, sans-serif;
}

.panel-heading{
    font-family: Arial, Helvetica, sans-serif;
}
</style>
</head>
<body>
    <h3>Report - {{$seleksi}}</h3>
    <p>Ketersediaan Kuota : {{ $kuota }}</p>
        <div class="table-responsive">
            <table id="customers">
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
                                    <td class="text-primary" style='text-align:center; vertical-align:middle; font-weight: bold; color: blue;'>{{ $rank }}</td>
                            @endif
                        @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>    
        </div>
</body>
</html>
