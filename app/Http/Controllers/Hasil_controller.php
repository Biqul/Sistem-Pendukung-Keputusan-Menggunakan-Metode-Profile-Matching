<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Type;
use App\Models\Aspek;
use App\Models\Bobot;
use App\Models\Status;
use App\Models\Kriteria;
use App\Models\Ranking;
use App\Models\Penilaian;
use App\Models\Hasil_aspek;
use App\Models\Alternatif;
use Illuminate\Http\Request;
use App\Models\Pembukaan_seleksi;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;

class Hasil_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.admin.hasil.index', [
            "title" => "Perhitungan Nilai",
            "pembukaans" => Pembukaan_seleksi::where('done', false)->orderBy('created_at', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function hitung (Request $request)
    {
        $title = "Hasil Perhitungan";
        $pembukaan_id = $request->pembukaan_id;
        $kuota = $request->kuota;
        $nilai_ambang = $request->nilai_ambang;
        $lulus = '5';
        $gagal = '6';

        $penilaians = Penilaian::where('pembukaan_id', $pembukaan_id)->get();
        $aspekss = Aspek::all();
        $kriteriass = Kriteria::all();
        $alternatifs = Alternatif::where('seleksi_id', $pembukaan_id)->orderBy('id', 'ASC')->get();
        $bobots = Bobot::all();
        $types = Type::all();
        $statuses = Status::where('id', $lulus)->orWhere('id', $gagal)->get();


        foreach($penilaians as $penilaian){
            foreach($kriteriass as $kriteria){
                if($penilaian->kriteria_id == $kriteria->id){
                    $kriterias[$penilaian->kriteria_id] = $kriteria->id;
                }
            }
        }

        // Cek alternatif kosong atau tidak
        if($alternatifs->isEmpty()){
            Alert::error('Seleksi tidak memiliki calon anggota');
            return redirect()->back();
        }else{
            if($penilaians->isEmpty()){
                Alert::error('Calon anggota belum memiliki nilai', 'Masukkan nilai terlebih dahulu pada halaman "Input Nilai Calon Anggota".');
                return redirect()->back();
            }else{
                foreach($aspekss as $aspek){
                    foreach($penilaians as $penilaian){
                        if($aspek->id == $penilaian->aspek_id){
                            $aspeks[$penilaian->aspek_id] = $aspek->id;
                        }
                    }
                } 
            
                
                // Perhitungan Gap
                foreach($aspekss as $aspek){
                    foreach($kriteriass as $kriteria){
                        if($kriteria->aspek_id == $aspek->id){
                            if($kriteria->type_id == 1){
                                    foreach($penilaians as $penilaian){
                                        if($penilaian->kriteria_id == $kriteria->id){
                                            $hasilCore[$penilaian->alternatif_id][$penilaian->aspek_id][$penilaian->kriteria_id] = ($penilaian->value - $kriteria->value);
                                        }
                                    }
                            }else{
                                foreach($penilaians as $penilaian){
                                        if($penilaian->kriteria_id == $kriteria->id){
                                            $hasilSecondary[$penilaian->alternatif_id][$penilaian->aspek_id][$penilaian->kriteria_id] = ($penilaian->value - $kriteria->value);
                                        }
                                }
                            }  
                        }     
                    }  
                }

            
                // Pembobotan Core Factor
                if(isset($hasilCore)){
                    foreach($hasilCore as $i => $alternatif_id){
                        foreach($alternatif_id as $j => $aspek_id){
                            foreach($aspek_id as $kriteria_id => $value){
                                foreach($bobots as $bobot){
                                    if($value == $bobot->selisih){
                                        $terbobotCore[$i][$j][$kriteria_id] = $bobot->value_bobot;
                                    }
                                }
                            }
                        }
                    }
                }else{
                    foreach($aspekss as $aspek){
                        foreach($kriteriass as $kriteria){
                            if($kriteria->aspek_id == $aspek->id){
                                        foreach($penilaians as $penilaian){
                                            if($penilaian->kriteria_id == $kriteria->id){
                                                $hasilCore[$penilaian->alternatif_id][$penilaian->aspek_id][$penilaian->kriteria_id] = 0;
                                            }
                                        }
                            }
                        }
                    }

                    foreach($hasilCore as $i => $alternatif_id){
                        foreach($alternatif_id as $j => $aspek_id){
                            foreach($aspek_id as $kriteria_id => $value){
                                foreach($bobots as $bobot){
                                    if($value == $bobot->selisih){
                                        $terbobotCore[$i][$j][$kriteria_id] = 0;
                                    }
                                }
                            }
                        }
                    }
                }

                
                

                // Pembobotan Secondary Factor
                if(isset($hasilSecondary)){
                    foreach($hasilSecondary as $i => $alternatif_id){
                        foreach($alternatif_id as $j => $aspek_id){
                            foreach($aspek_id as $kriteria_id => $value){
                                foreach($bobots as $bobot){
                                    if($value == $bobot->selisih){
                                        $terbobotSecondary[$i][$j][$kriteria_id] = $bobot->value_bobot;
                                    }
                                }
                            }
                        }
                    }
                }else{
                    foreach($aspekss as $aspek){
                        foreach($kriteriass as $kriteria){
                            if($kriteria->aspek_id == $aspek->id){
                                        foreach($penilaians as $penilaian){
                                            if($penilaian->kriteria_id == $kriteria->id){
                                                $hasilSecondary[$penilaian->alternatif_id][$penilaian->aspek_id][$penilaian->kriteria_id] = 0;
                                            }
                                        }
                            }
                        }
                    }

                    foreach($hasilSecondary as $i => $alternatif_id){
                        foreach($alternatif_id as $j => $aspek_id){
                            foreach($aspek_id as $kriteria_id => $value){
                                foreach($bobots as $bobot){
                                    if($value == $bobot->selisih){
                                        $terbobotSecondary[$i][$j][$kriteria_id] = 0;
                                    }
                                }
                            }
                        }
                    }
                }


                // Perhitungan Core Factor
                foreach($aspekss as $aspek){
                    foreach($terbobotCore as $alternatif_id => $i){
                        $temp = 0;
                        foreach($i as $aspek_id => $j){
                            foreach($j as $kriteria_id => $value){
                                if($aspek->id == $aspek_id){
                                    $totalCore = $aspek->core_count;
                                    if($alternatif_id == $alternatif_id){
                                        if($value == 0){
                                            $doneCore[$alternatif_id][$aspek_id] = 0;
                                        }else{
                                            $temp += $value;
                                            $doneCore[$alternatif_id][$aspek_id] = $temp / $totalCore;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                // Perhitungan Secondary Factor
                foreach($aspekss as $aspek){
                    foreach($terbobotSecondary as $alternatif_id => $i){
                        $temp = 0;
                        foreach($i as $aspek_id => $j){
                            foreach($j as $kriteria_id => $value){
                                if($aspek->id == $aspek_id){
                                    $totalSecondary = $aspek->secondary_count;
                                    if($alternatif_id == $alternatif_id){
                                        if($value == 0){
                                            $doneSecondary[$alternatif_id][$aspek_id] = 0;
                                        }else{
                                            $temp += $value;
                                            $doneSecondary[$alternatif_id][$aspek_id] = $temp / $totalSecondary;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // dd($doneCore, $doneSecondary);

                
                // Total Aspek
                foreach($alternatifs as $alternatif){
                    $ceks = Hasil_aspek::where('pembukaan_id', $pembukaan_id)->where('alternatif_id', $alternatif->id)->get();
                    foreach($aspeks as $aspek){
                        foreach($aspekss as $aspekk){
                            $totalCore = 0;
                            $totalSecondary = 0;
                            $totalC = 0;
                            $totalS = 0;
                            $ncf = 0;
                            $nsf = 0;
                            if($aspek == $aspekk->id){
                                

                                // Core Factor
                                foreach($doneCore as $i => $alternatif_id){
                                    foreach($alternatif_id as $aspek_id => $value){
                                        if(($i == $alternatif->id) && ($aspek_id == $aspek)){
                                            $ncf = $value;
                                            $percentCore = $aspekk->core;
                                            $percentFixCore = $percentCore / 100;
                                            $totalCore = $value * $percentFixCore;
                                            $persentaseAspekC = $aspekk->persentase / 100;
                                            $totalC = $totalCore * $persentaseAspekC; 
                                        }
                                    }
                                }

                                if($totalCore > 0){
                                    $totalCore = $totalCore;
                                }else{
                                    $totalCore = 0;
                                }

                                if(isset($totalC)){
                                    $totalC = $totalC;
                                }else{
                                    $totalC = 0;
                                }
                                
                                if(isset($ncf)){
                                    $ncf = $ncf;
                                }else{
                                    $ncf = 0;
                                }

                                // Secondary Factor
                                foreach($doneSecondary as $j => $alternatif_id){
                                    foreach($alternatif_id as $aspek_id => $value){
                                        if(($j == $alternatif->id) && ($aspek_id == $aspek)){
                                            $nsf = $value;
                                            $percentSecondary = $aspekk->secondary;
                                            $percentFixSec = $percentSecondary / 100;
                                            $totalSecondary = $value * $percentFixSec;
                                            $persentaseAspekS = $aspekk->persentase / 100;
                                            $totalS = $totalSecondary * $persentaseAspekS;
                                        }
                                    }
                                }
                        
                                if($totalSecondary > 0){
                                    $totalSecondary = $totalSecondary;
                                }else{
                                    $totalSecondary = 0;
                                }

                                if(isset($totalS)){
                                    $totalS = $totalS;
                                }else{
                                    $totalS = 0;
                                }

                                if(isset($nsf)){
                                    $nsf = $nsf;
                                }else{
                                    $nsf = 0;
                                }
                            
                                if($ceks->isEmpty()){
                                    Hasil_aspek::create([
                                        'pembukaan_id' => $pembukaan_id,
                                        'alternatif_id' => $alternatif->id,
                                        'aspek_id' => $aspekk->id,
                                        'ncf' => $ncf,
                                        'nsf' => $nsf,
                                        'total' => $totalCore + $totalSecondary,
                                        'totalEach' => $totalC + $totalS
                                    ]);
                                            
                                    $hasilAspeks = Hasil_aspek::where('pembukaan_id', $pembukaan_id)->get();
                                }else{
                                    $hasilAspeks = Hasil_aspek::where('pembukaan_id', $pembukaan_id)->get();
                                }

                                // Total Tiap Aspek
                                $totalEachAspek[$alternatif->id][$aspekk->id] = $totalC + $totalS;
                            }
                        }
                    }
                }
            
                
                
                // Total Nilai Tiap Alternatif
                foreach($totalEachAspek as $i => $alternatif_id){
                    $temp = 0;
                    foreach($alternatif_id as $aspekk_id => $value){
                        if($alternatif_id == $alternatif_id){
                            $temp += $value;
                            $totalAll[$i] = $temp;
                        } 
                    }
                }

        
                $cek = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();

                if($cek->isEmpty()){
                    foreach($alternatifs as $alternatif){
                        foreach($totalAll as $index => $value){
                            if($index == $alternatif->id){
                                Ranking::create([
                                    'seleksi_id' => $pembukaan_id,
                                    'alternatif_id' =>  $index,
                                    'nilai_akhir' =>  $value
                                ]);
                            }
                        }
                    }
                    $rankings = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();
                }else{
                    $rankings = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();
                }
                
                
                // Mengembalikan nilai
                return view('dashboard.admin.hasil.hitung', compact('title','pembukaan_id','kuota','nilai_ambang','aspeks','statuses','kriterias', 'kriteriass','hasilCore','terbobotCore', 'hasilSecondary','terbobotSecondary', 'penilaians', 'alternatifs', 'aspekss', 'types', 'hasilAspeks', 'totalEachAspek', 'rankings', 'lulus', 'gagal'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hasil  $hasil
     * @return \Illuminate\Http\Response
     */
    public function show($penilaians)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hasil  $hasil
     * @return \Illuminate\Http\Response
     */
    public function edit(Hasil $hasil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hasil  $hasil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hasil $hasil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hasil  $hasil
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hasil $hasil)
    {
        //
    }

    
    public function export(Request $request)    
    {
        
        $pembukaan_id = $request->pembukaan_id;
        $kuota = $request->kuota;
        $nilai_ambang = $request->nilai_ambang;
        $totalEachAspek = $request->eachAspek;
        $lulus = '5';
        $gagal = '6';
        
        $pembukaan = Pembukaan_seleksi::where('id', $pembukaan_id)->pluck('name');
        foreach($pembukaan as $pmk){
            $seleksi = $pmk;
        }
        $aspekss = Aspek::all();
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::where('seleksi_id', $pembukaan_id)->orderBy('id', 'ASC')->get();
        $statuses = Status::where('id', $lulus)->orWhere('id', $gagal)->get();
        $penilaians = Penilaian::where('pembukaan_id', $pembukaan_id)->get();
        $hasilAspeks = Hasil_aspek::where('pembukaan_id', $pembukaan_id)->get();
        $rankings = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();

        foreach($aspekss as $aspek){
            foreach($penilaians as $penilaian){
                if($aspek->id == $penilaian->aspek_id){
                    $aspeks[$penilaian->aspek_id] = $aspek->id;
                }
            }
        }

        view()->share('seleksi', $seleksi);
        view()->share('aspekss', $aspekss);
        view()->share('kriterias', $kriterias);
        view()->share('alternatifs', $alternatifs);
        view()->share('kuota', $kuota);
        view()->share('nilai_ambang', $nilai_ambang);
        view()->share('totalEachAspek', $totalEachAspek);
        view()->share('aspeks', $aspeks);
        view()->share('penilaians', $penilaians);
        view()->share('statuses', $statuses);
        view()->share('rankings', $rankings);
        view()->share('hasilAspeks', $hasilAspeks);
        $pdf = PDF::loadview('dashboard.admin.hasil.pdf')->setPaper('a4', 'potrait');
        return $pdf->download('Report-'.$seleksi.'.pdf');
    }

    public function exports(Request $request)    
    {
        
        $pembukaan_id = $request->pembukaan_id;
        $kuota = $request->kuota;
        $nilai_ambang = $request->nilai_ambang;
        $totalEachAspek = $request->eachAspek;
        $lulus = '5';
        $gagal = '6';
        
        $pembukaan = Pembukaan_seleksi::where('id', $pembukaan_id)->pluck('name');
        foreach($pembukaan as $pmk){
            $seleksi = $pmk;
        }
        $aspekss = Aspek::all();
        $kriterias = Kriteria::all();
        $alternatifs = Alternatif::where('seleksi_id', $pembukaan_id)->orderBy('id', 'ASC')->get();
        $statuses = Status::where('id', $lulus)->orWhere('id', $gagal)->get();
        $penilaians = Penilaian::where('pembukaan_id', $pembukaan_id)->get();
        $hasilAspeks = Hasil_aspek::where('pembukaan_id', $pembukaan_id)->get();
        $rankings = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();

        foreach($aspekss as $aspek){
            foreach($penilaians as $penilaian){
                if($aspek->id == $penilaian->aspek_id){
                    $aspeks[$penilaian->aspek_id] = $aspek->id;
                }
            }
        }

        view()->share('seleksi', $seleksi);
        view()->share('aspekss', $aspekss);
        view()->share('kriterias', $kriterias);
        view()->share('alternatifs', $alternatifs);
        view()->share('kuota', $kuota);
        view()->share('nilai_ambang', $nilai_ambang);
        view()->share('totalEachAspek', $totalEachAspek);
        view()->share('aspeks', $aspeks);
        view()->share('penilaians', $penilaians);
        view()->share('statuses', $statuses);
        view()->share('rankings', $rankings);
        view()->share('hasilAspeks', $hasilAspeks);
        $pdf = PDF::loadview('dashboard.admin.hasil.pdfBefore')->setPaper('a4', 'potrait');
        return $pdf->download('Report-'.$seleksi.'.pdf');
    }

    public function done(Request $request)
    {
        $pembukaan_id = $request->pembukaan_id;
        $kuota = $request->kuota;
        $nilai_ambang = $request->nilai_ambang;
        $lulus = '5';
        $gagal = '6';
        $tidakAktif = '4';

        $alternatifs = Alternatif::where('seleksi_id', $pembukaan_id)->orderBy('id', 'ASC')->get();
        $rankings = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();

        // Update Status Alternatif
        $i = 0;
        foreach($rankings as $ranking){
            foreach($alternatifs as $alternatif){
                if($ranking->alternatif_id == $alternatif->id){
                    $rank = $i+=1;
                    if($rank <= $kuota && $ranking->nilai_akhir >= $nilai_ambang){
                            $hasil = $lulus; 
                            $status = $tidakAktif;
                            Alternatif::where('id', $alternatif->id)->update(array('hasil_id' => $hasil, 'status_id' => $status));
                    }else{
                            $hasil = $gagal; 
                            $status = $tidakAktif;
                            Alternatif::where('id', $alternatif->id)->update(array('hasil_id' => $hasil, 'status_id' => $status));
                    }
                }
            }
        }

        Pembukaan_seleksi::where('id', $pembukaan_id)->update(array('status_id' => 2, 'done' => true, 'kuota' => $kuota, 'nilai_ambang' => $nilai_ambang));

        toast('Perhitungan selesai!', 'success');
        
        return view('dashboard.admin.hasil.index', [
            "title" => "Hasil Perhitungan",
            "pembukaans" => Pembukaan_seleksi::all()
        ]);
    }

}
