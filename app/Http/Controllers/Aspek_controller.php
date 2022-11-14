<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use App\Models\Status;
use App\Models\Pembukaan_seleksi;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAspekRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\UpdateAspekRequest;

class Aspek_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.admin.aspek.index', [
            "title" => "Aspek Penilaian",
            "aspeks" => Aspek::orderBy('status_id', 'ASC')->orderBy('created_at', 'DESC')->filter(request(['search']))->get()
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.aspek.add', [
            "title" => "Tambah Aspek Baru",
            $aktif = '3',
            $tidak = '4',
            "statuses" => Status::where('id', $aktif)
                        ->orWhere('id', $tidak)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAspekRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAspekRequest $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255', 'unique:aspeks'],
            'slug' => ['required','unique:aspeks'],
            'persentase' => ['required', 'integer'],
            'core' => ['required', 'integer'],
            'secondary' => ['required', 'integer'],
            'status_id' => ['required']
        ]);

        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        $totalCS = $request->core + $request->secondary;

        if($totalCS == 100){
            Aspek::create($validatedData);

            toast('Aspek berhasil ditambahkan!', 'success');
            return redirect('/aspeks');
        }else{
            Alert::error('Jumlah Core dan Secondary Tidak Sesuai', 'Periksa kembali jumlah core dan secondary. Pastikan jumlahnya mencapai 100');
            return redirect()->back();
        }
       

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aspek  $aspek
     * @return \Illuminate\Http\Response
     */
    public function show(Aspek $aspek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aspek  $aspek
     * @return \Illuminate\Http\Response
     */
    public function edit(Aspek $aspek)
    {
        return view('dashboard.admin.aspek.edit', [
            "title" => "Ubah Data Aspek",
            "aspek" => $aspek,
            $aktif = '3',
            $tidak = '4',
            "statuses" => Status::where('id', $aktif)
                        ->orWhere('id', $tidak)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAspekRequest  $request
     * @param  \App\Models\Aspek  $aspek
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAspekRequest $request, Aspek $aspek)
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'persentase' => ['required', 'integer'],
            'core' => ['required', 'integer'],
            'secondary' => ['required', 'integer'],
            'status_id' => ['required']
        ];

        if($request->slug != $aspek->slug){
            $rules['slug'] = 'required|unique:aspeks';
        }

        $validatedData = $request->validate($rules);
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        $totalCS = $request->core + $request->secondary;

        if($totalCS == 100){
            Aspek::where('id', $aspek->id)
            ->update($validatedData);
        
            toast('Aspek berhasil diubah!', 'success');

            return redirect('/aspeks');
        }else{
            Alert::error('Jumlah Core dan Secondary Tidak Sesuai', 'Periksa kembali jumlah core dan secondary. Pastikan jumlahnya mencapai 100');
            return redirect()->back();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aspek  $aspek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aspek $aspek)
    {
        //
    }

    public function ganti_status($id){
        $aspek = Aspek::find($id);
        $status = $aspek->status_id;
        
        if($status == '3'){
            Aspek::where('id',$id)->update([
                'status_id'=>'4'
            ]);
        }else{
            Aspek::where('id',$id)->update([
                'status_id'=>'3'
            ]);
        }

        toast('Status berhasil diubah!', 'success');

        return redirect()->back();
        
    }

}
