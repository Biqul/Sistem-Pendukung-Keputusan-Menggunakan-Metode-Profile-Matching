<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\Alternatif;
use App\Models\Pembukaan_seleksi;
use App\Models\Aspek;
use App\Models\Penilaian;
use App\Models\Hasil_aspek;
use App\Models\Ranking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StorePembukaan_seleksiRequest;
use App\Http\Requests\UpdatePembukaan_seleksiRequest;
use \Cviebrock\EloquentSluggable\Services\SlugService;



class Pembukaan_seleksi_controller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('dashboard.admin.pembukaan.index', [
            "title" => "Pembukaan Seleksi Anggota Baru",
            "pembukaans" => Pembukaan_seleksi::orderBy('status_id', 'ASC')->orderBy('created_at', 'DESC')->filter(request(['search']))->get()
        ]); 

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.pembukaan.add', [
            "title" => "Buat Seleksi Baru",
            "statuses" => Status::take(2)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembukaan_seleksiRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StorePembukaan_seleksiRequest $request)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'max:255', 'unique:pembukaan_seleksis'],
            'slug' => ['required','unique:pembukaan_seleksis'],
            'periode' => ['required','max:20'],
            'status_id' => ['required']
        ]);

        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        Pembukaan_seleksi::create($validatedData);

        toast('Seleksi berhasil dibuat!', 'success');

        return redirect('/pembukaans');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembukaan_seleksi  $pembukaan_seleksi
     * @return \Illuminate\Http\Response
     */
    public function show(Pembukaan_seleksi $pembukaan)
    {
        if($pembukaan->done == 0){
            $title = $pembukaan->name;
            $pembukaan =  $pembukaan;
            $statuses =  Status::all();
            $seleksi = $pembukaan->id;
    
            $alternatifs = Alternatif::where('seleksi_id', $seleksi)->orderBy('hasil_id', 'ASC')->paginate(6);
            $cek = Alternatif::where('seleksi_id', $seleksi)->where('hasil_id', '!=', null)->get();
    
            if($cek->isEmpty()){
                $kosong = 0;
            }else{
                $kosong = 1;
            }

            return view('dashboard.admin.pembukaan.show', compact('title', 'pembukaan', 'statuses', 'alternatifs', 'kosong'));

        }else{
            $pembukaan_id = $pembukaan->id;
            $aspekss = Aspek::all();
            $alternatifs = Alternatif::where('seleksi_id', $pembukaan_id)->orderBy('id', 'ASC')->get();
            $penilaians = Penilaian::where('pembukaan_id', $pembukaan_id)->get();
            $hasilAspeks = Hasil_aspek::where('pembukaan_id', $pembukaan_id)->get();
            $rankings = Ranking::where('seleksi_id', $pembukaan_id)->orderBy('nilai_akhir', 'DESC')->get();
            $pembukaanss = Pembukaan_seleksi::where('id', $pembukaan_id)->get();
            $statuses = Status::all();
    
            foreach($pembukaanss as $pembukaans){
                $kuota = $pembukaans->kuota;
                $title = "Hasil Akhir ".$pembukaans->name;
            }
    
            foreach($aspekss as $aspek){
                foreach($penilaians as $penilaian){
                    if($aspek->id == $penilaian->aspek_id){
                        $aspeks[$penilaian->aspek_id] = $aspek->id;
                    }
                }
            } 
    
            return view('dashboard.admin.pembukaan.showDone',[
                "title" => $title,
                "pembukaan_id" => $pembukaan_id,
                "rankings" => $rankings,
                "aspekss" => $aspekss,
                "alternatifs" => $alternatifs,
                "aspeks" => $aspeks,
                "hasilAspeks" => $hasilAspeks,
                "kuota" => $kuota,
                "statuses" => $statuses
            ]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembukaan_seleksi  $pembukaan_seleksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembukaan_seleksi $pembukaan)
    {
        return view('dashboard.admin.pembukaan.edit', [
            "title" => "Ubah Seleksi",
            "statuses" => Status::take(2)->get(),
            "pembukaan" => $pembukaan
        ]);
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
        $rules = [
            'name' => ['required', 'max:255'],
            'periode' => ['required','max:20'],
            'status_id' => ['required']
        ];

        if($request->slug != $pembukaan->slug){
            $rules['slug'] = 'required|unique:pembukaan_seleksis';
        }
        

        $validatedData = $request->validate($rules);
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        Pembukaan_seleksi::where('id', $pembukaan->id)
            ->update($validatedData);
        
        toast('Seleksi berhasil diubah!', 'success');

        return redirect('/pembukaans');
    }

    public function ganti_status($id){
        $pembukaan = Pembukaan_seleksi::find($id);
        $status = $pembukaan->status_id;
        

        if($status == '1'){
            Pembukaan_seleksi::where('id',$id)->update([
                'status_id'=>'2'
            ]);
        }else{
            Pembukaan_seleksi::where('id',$id)->update([
                'status_id'=>'1'
            ]);
        }

        toast('Status berhasil diubah!', 'success');

        return redirect()->back();
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

    public function delete($id)
    {

        Alternatif::where('id',$id)->update(['seleksi_id'=> null]);

        toast('Alternatif berhasil dihapus!', 'success');

        return redirect()->back();
    }

    public function ganti_ket($id)
    {
        $alternatif = Alternatif::find($id);
        $hasil_id = $alternatif->hasil_id;

        if($hasil_id == '5'){
            Alternatif::where('id',$id)->update([
                'hasil_id'=>'6'
            ]);
        }else{
            Alternatif::where('id',$id)->update([
                'hasil_id'=>'5'
            ]);
        }

        toast('Keterangan berhasil diubah!', 'success');

        return redirect()->back();
    }


}
