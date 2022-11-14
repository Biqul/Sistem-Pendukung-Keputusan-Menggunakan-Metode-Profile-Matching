<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreAlternatifRequest;
use App\Http\Requests\UpdateAlternatifRequest;

class Alternatif_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.admin.alternatif.index', [
            "title" => "Data Calon Anggota",
            "alternatifs" => Alternatif::where('id', '!=', '1')->orderBy('status_id', 'ASC')->orderBy('name', 'ASC')->filter(request(['search']))->get()
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
     * @param  \App\Http\Requests\StoreAlternatifRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlternatifRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function show(Alternatif $alternatif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function edit(Alternatif $alternatif)
    {
        return view('dashboard.admin.alternatif.edit', [
            "title" => "Ubah Data Calon Anggota",
            "alternatif" => $alternatif
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlternatifRequest  $request
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlternatifRequest $request, Alternatif $alternatif)
    {
        $rules = [
            'name' => ['required', 'max:115']
        ];

        $rulesAlter = [
            'name' => ['required', 'max:115']
        ];

        if($request->email != $alternatif->email){
            $rules['email'] = ['required', 'email:dns', 'max:115', 'unique:users'];
        }

        if($request->email != $alternatif->email){
            $rulesAlter['email'] = ['required', 'email:dns', 'max:115', 'unique:users'];
        }
        
        if($request->no_hp != $alternatif->no_hp){
            $rulesAlter['no_hp'] = ['required', 'max:20', 'unique:alternatifs'];
        }

        $validatedData = $request->validate($rulesAlter);
        $validatedDataUser = $request->validate($rules);
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        Alternatif::where('id', $alternatif->id)
            ->update($validatedData);

        User::where('id',$alternatif->user_id)
            ->update($validatedDataUser);
        
        toast('Data Alternatif berhasil diubah!', 'success');

        return redirect('/alternatifs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alternatif $alternatif)
    {
       
    }

    public function ganti_status($id){
        $alternatif = Alternatif::find($id);
        $status = $alternatif->status_id;
        
        if($status == '3'){
            Alternatif::where('id',$id)->update([
                'status_id'=>'4'
            ]);
        }else{
            Alternatif::where('id',$id)->update([
                'status_id'=>'3'
            ]);
        }

        toast('Status berhasil diubah!', 'success');

        return redirect()->back();
        
    }
}
