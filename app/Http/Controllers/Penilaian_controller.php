<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use App\Models\Kriteria;
use App\Models\Penilaian;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Alternatif;
use App\Models\Pembukaan_seleksi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenilaianRequest;
use App\Http\Requests\UpdatePenilaianRequest;

class Penilaian_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.admin.penilaian.index', [
            "title" => "Penilaian Calon Anggota",
            "pembukaans" => Pembukaan_seleksi::where('done', false)->orderBy('created_at', 'DESC')->get(),
            "aspeks" => Aspek::all(),
            "kriterias" => Kriteria::all(),
            "alternatifs" => Alternatif::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenilaianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePenilaianRequest $request)
    {
        $values = $request->value;
        $pembukaan_id = $request->pembukaan_id;
        $aspek_id = $request->aspek_id;
        // dd($pembukaan_id, $aspek_id);

        foreach($values as $index => $alternatif_id){
            foreach($alternatif_id as $kriteria_id => $value){
                Penilaian::create([
                    'pembukaan_id' =>  $pembukaan_id,
                    'aspek_id' =>  $aspek_id,
                    'alternatif_id' =>  $index,
                    'kriteria_id' =>  $kriteria_id,
                    'value' =>  $value
                ]);
            }
        }

        toast('Nilai berhasil dimasukkan!', 'success');
        return redirect('penilaians');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function show(Penilaian $penilaian, Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function edit(Penilaian $penilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePenilaianRequest  $request
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePenilaianRequest $request, Penilaian $penilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penilaian  $penilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penilaian $penilaian)
    {
        //
    }

    public function input(Request $request)
    {
        $pembukaan_id = $request->pembukaan_id;
        $aspek_id = $request->aspek_id;
        $penilaians = Penilaian::where('pembukaan_id', $pembukaan_id)->where('aspek_id', $aspek_id)->get();
        $aspeks = Aspek::where('status_id', '3')->get();
        $alternatifs = Alternatif::where('seleksi_id', $pembukaan_id)->get();
        $kriterias = Kriteria::where('aspek_id', $aspek_id)->where('status_id', '=', '3')->orderBy('id', 'ASC')->get();

        

        $temp = 0;
        foreach($aspeks as $aspek){
            $persentase = $aspek->persentase;
            $temp += $persentase;
            $totalAll = $temp;
        }

        if($alternatifs->isEmpty()){
            Alert::error('Seleksi tidak memiliki calon anggota');
            return redirect()->back();
        }else{
            if($totalAll < 100 || $totalAll > 100){
                Alert::error('Persentase Tidak Sesuai', 'Periksa kembali jumlah persentase aspek pada halaman "Aspek Penilaian". Pastikan jumlah persentase mencapai 100');
                return redirect()->back();
            }else{
                if($penilaians->isEmpty()){
                    if($kriterias->isEmpty()){
                        Alert::error('Tidak Dapat Mengisi', 'Tidak memiliki kriteria/Tidak ada kriteria yang aktif pada aspek ini. Periksa kembali pada halaman "Kriteira Penilaian".');
                        return redirect()->back();
                    }else{
                        return view('dashboard.admin.penilaian.input', [
                            "title" => "Input Nilai",
                            "pembukaan_id" => $pembukaan_id,
                            "aspek_id" => $aspek_id,
                            "alternatifs" => Alternatif::where('seleksi_id', $pembukaan_id)->where('id', '!=', '1')->orderBy('name', 'ASC')->get(),
                            "kriterias" => $kriterias,
                            "jumlahkriterias" => Kriteria::where('aspek_id', $aspek_id)->count()
                        ]);
                    }
                }else{
                    Alert::error('Tidak Dapat Mengisi', 'Sudah memiliki nilai');
                    return redirect()->back();
                }
            }
        }
    }
}
