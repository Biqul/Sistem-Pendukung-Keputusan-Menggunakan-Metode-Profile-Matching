<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Alternatif;
use App\Models\Pembukaan_seleksi;
use App\Models\Ranking;
use App\Models\Aspek;
use App\Models\Penilaian;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Auth\AuthManager;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StorePembukaan_seleksiRequest;
use App\Http\Requests\UpdatePembukaan_seleksiRequest;
use \Cviebrock\EloquentSluggable\Services\SlugService;



class Pendaftaran_controller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.calon.pendaftaran.index', [
            "title" => "Daftar Seleksi IAAS",
            "pembukaans" => Pembukaan_seleksi::where('status_id', '1')->orderBy('created_at', 'DESC')->filter(request(['search']))->get()
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePendaftaranRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $pembukaan_id = $request->pembukaan_id;
        $alternatif_id = $request->alternatif_id;
        $alternatifs = Alternatif::where('id', $alternatif_id)->get();

        foreach($alternatifs as $alternatif){
            if($alternatif->seleksi_id == null){
                if($alternatif->status_id == '3'){
                    $seleksi = $pembukaan_id;
                    Alternatif::where('id', $alternatif->id)->update(['seleksi_id' => $seleksi]);
                
                    Alert::success('Berhasil mendaftar!');
                }else{
                    Alert::error('Status anda tidak aktif', 'Hubungi bagian HUMAS untuk mengaktifkan status anda');
                }
            }else{
                Alert::error('Anda sudah mendaftar pada seleksi ini atau sebelumnya.');
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembukaan_seleksi  $pembukaan_seleksi
     * @return \Illuminate\Http\Response
     */
    public function show(Pembukaan_seleksi $pembukaan)
    {
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembukaan_seleksi  $pembukaan_seleksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembukaan_seleksi $pembukaan)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembukaan_seleksiRequest  $request
     * @param  \App\Models\Pembukaan_seleksi  $pembukaan_seleksi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePembukaan_seleksiRequest $request, Pembukaan_seleksi $pembukaan)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembukaan_seleksi  $pembukaan_seleksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembukaan_seleksi $pembukaan)
    {
        
    }

    public function hasil()
    {
        $title = "Hasil Seleksi";
        $alter_id = auth()->id();
        $alternatif = Alternatif::where('id', $alter_id)->pluck('seleksi_id');
        $alternatifs = Alternatif::where('id', $alter_id)->get();
        $alter_hasil = Alternatif::where('id', $alter_id)->value('hasil_id');
        $pembukaans = Pembukaan_seleksi::where('id', $alternatif)->get();
        $rankings = Ranking::where('alternatif_id', $alter_id)->where('seleksi_id', $alternatif)->get();
        $penilaians = Penilaian::where('alternatif_id', $alter_id)->where('pembukaan_id', $alternatif)->get();
        $aspekss = Aspek::all();

        if($penilaians->isEmpty()){
            $nilai = "0";
        }else{
            $nilai = "1";
        }

        if($pembukaans->isEmpty()){
            $done = "0";
        }else{
            foreach($pembukaans as $pembukaan){
                if($pembukaan->done == false){
                    $done = "0";
                }else{
                    $done = "1";
                }
            }
        }


        foreach($alternatif as $alter=>$value){
            $key = $value;
        }

        if($key == null){
            $pembukaan_name = null;
        }else{
            foreach($pembukaans as $pembukaan){
                $pembukaan_name = Pembukaan_seleksi::where('id', $pembukaan->id)->value('name');
            }
        }

        if($nilai == 1){
            foreach($aspekss as $aspek){
                foreach($penilaians as $penilaian){
                    if($aspek->id == $penilaian->aspek_id){
                        $aspeks[$penilaian->aspek_id] = $aspek->id;
                    }
                }
            }
        }else{
            $aspeks = 0;
        }
  
        return view('dashboard.calon.hasil.index', [
            "title" => $title,
            "pembukaans" => $pembukaans,
            "pembukaan_name" => $pembukaan_name,
            "alternatifs" => $alternatifs,
            "aspekss" => $aspeks,
            "nilai" => $nilai,
            "alter_hasil" => $alter_hasil,
            "rankings" => $rankings,
            "aspeks" => $aspeks,
            "done" => $done
        ]);

    }

}
