<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use App\Models\Kriteria;
use App\Models\Type;
use App\Models\Status;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreKriteriaRequest;
use App\Http\Requests\UpdateKriteriaRequest;

class Kriteria_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.admin.kriteria.index', [
            "title" => "Kriteria Penilaian",
            "aspeks" => Aspek::all(),
            "kriterias" => Kriteria::orderBy('status_id', 'ASC')->orderBy('created_at', 'DESC')->orderBy('aspek_id', 'ASC')->filter(request(['search']))->get()
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.kriteria.add', [
            "title" => "Tambah Kriteria Baru",
            $aktif = '3',
            $tidak = '4',
            "types" => Type::all(),
            "aspeks" => Aspek::all(),
            "statuses" => Status::where('id', $aktif)
                        ->orWhere('id', $tidak)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKriteriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKriteriaRequest $request)
    {
        $validatedData = $request->validate([
            'aspek_id' => ['required'],
            'name' => ['required', 'max:115', 'unique:kriterias'],
            'kode_kriteria' => ['required', 'max:20', 'unique:kriterias'],
            'slug' => ['required','unique:kriterias'],
            'type_id' => ['required'],
            'value' => ['required'],
            'status_id' => ['required']
        ]);
    
        $validatedData['created_at'] = date('Y-m-d H:i:s');
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        if($validatedData['type_id'] == 1){
            $aspeks = Aspek::where('id', $validatedData['aspek_id'])->get();
            foreach($aspeks as $aspek){
                if($aspek->core_count == null){
                    $core = 1;
                    Aspek::where('id', $validatedData['aspek_id'])->update(array('core_count' => $core));
                }else{
                    $temp = $aspek->core_count;
                    $core = $temp + 1;
                    Aspek::where('id', $validatedData['aspek_id'])->update(array('core_count' => $core));
                }
            }
        }else{
            $aspeks = Aspek::where('id', $validatedData['aspek_id'])->get();
            foreach($aspeks as $aspek){
                if($aspek->secondary_count == null){
                    $secondary = 1;
                    Aspek::where('id', $validatedData['aspek_id'])->update(array('secondary_count' => $secondary));
                }else{
                    $temp = $aspek->secondary_count;
                    $secondary = $temp + 1;
                    Aspek::where('id', $validatedData['aspek_id'])->update(array('secondary_count' => $secondary));
                }
            }
        }

        Kriteria::create($validatedData);

        toast('Kriteria berhasil ditambahkan!', 'success');

        return redirect('/kriterias');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function edit(Kriteria $kriteria)
    {
        return view('dashboard.admin.kriteria.edit', [
            "title" => "Ubah Data Kriteria",
            $aktif = '3',
            $tidak = '4',
            "kriteria" => $kriteria,
            "types" => Type::all(),
            "aspeks" => Aspek::all(),
            "statuses" => Status::where('id', $aktif)
                        ->orWhere('id', $tidak)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKriteriaRequest  $request
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKriteriaRequest $request, Kriteria $kriteria)
    {
        $rules = [
            'aspek_id' => ['required'],
            'name' => ['required', 'max:115'],
            'value' => ['required'],
            'type_id' => ['required'],
            'status_id' => ['required']
        ];

        if($request->kode_kriteria != $kriteria->kode_kriteria){
            $rules['kode_kriteria'] = 'required|max:20|unique:kriterias';
        }

        if($request->slug != $kriteria->slug){
            $rules['slug'] = 'required|unique:kriterias';
        }
        
        $old_aspek = $request->old_aspek;
        $old_type = $request->old_type;

        if($request->aspek_id == $old_aspek){
            if($request->type_id != $kriteria->type_id){
                $rules['type_id'] = 'required';
                $new = $request->type_id;
            
                if($new == 1){
                    $aspeks = Aspek::where('id', $request->aspek_id)->get();
                    foreach($aspeks as $aspek){
                        if($aspek->core_count == null){
                            $core = 1;
                            $temps = $aspek->secondary_count;
                            $secondary = $temps - 1;
                            Aspek::where('id', $request->aspek_id)->update(array('core_count' => $core, 'secondary_count' => $secondary));
                        }else{
                            $temp = $aspek->core_count;
                            $core = $temp + 1;
                            $temps = $aspek->secondary_count;
                            $secondary = $temps - 1;
                            Aspek::where('id', $request->aspek_id)->update(array('core_count' => $core, 'secondary_count' => $secondary));
                        }
                    }
                }else{
                    $aspeks = Aspek::where('id', $request->aspek_id)->get();
                    foreach($aspeks as $aspek){
                        if($aspek->secondary_count == null){
                            $secondary = 1;
                            $temps = $aspek->core_count;
                            $core = $temps - 1;
                            Aspek::where('id', $request->aspek_id)->update(array('core_count' => $core, 'secondary_count' => $secondary));
                        }else{
                            $temp = $aspek->secondary_count;
                            $secondary = $temp + 1;
                            $temps = $aspek->core_count;
                            $core = $temps - 1;
                            Aspek::where('id', $request->aspek_id)->update(array('core_count' => $core, 'secondary_count' => $secondary));
                        }
                    }
                }
            }
        }else if($request->aspek_id != $old_aspek){
            if($request->type_id != $old_type){
                $rules['type_id'] = 'required';
                $new = $request->type_id;

                if($new == 1){
                    $aspeks = Aspek::where('id', $request->aspek_id)->get();
                    $old_aspeks = Aspek::where('id', $old_aspek)->get();
                    foreach($aspeks as $aspek){
                        foreach($old_aspeks as $old){
                            if($aspek->core_count == null){
                                $core = 1;
                                Aspek::where('id', $request->aspek_id)->update(['core_count' => $core]);
                            }else{
                                $temp = $aspek->core_count;
                                $core = $temp + 1;
                                Aspek::where('id', $request->aspek_id)->update(['core_count' => $core]);
                            }
                            $temps = $old->secondary_count;
                            $secondary = $temps - 1;
                            Aspek::where('id', $old_aspek)->update(['secondary_count' => $secondary]);
                        }
                    }
                }else{
                    $aspeks = Aspek::where('id', $request->aspek_id)->get();
                    $old_aspeks = Aspek::where('id', $old_aspek)->get();
                    foreach($aspeks as $aspek){
                        foreach($old_aspeks as $old){
                            if($aspek->secondary_count == null){
                                $secondary = 1;
                                Aspek::where('id', $request->aspek_id)->update(['secondary_count' => $secondary]);
                            }else{
                                $temp = $aspek->secondary_count;
                                $secondary = $temp + 1;
                                Aspek::where('id', $request->aspek_id)->update(['secondary_count' => $secondary]);
                            }
                            $temps = $old->core_count;
                            $core = $temps - 1;
                            Aspek::where('id', $old_aspek)->update(['core_count' => $core]);
                        }
                    }
                }
            }else{
                $rules['type_id'] = 'required';
                $new = $request->type_id;

                if($new == 1){
                    $aspeks = Aspek::where('id', $request->aspek_id)->get();
                    $old_aspeks = Aspek::where('id', $old_aspek)->get();
                    foreach($aspeks as $aspek){
                        foreach($old_aspeks as $old){
                            if($aspek->core_count == null){
                                $core = 1;
                                Aspek::where('id', $request->aspek_id)->update(['core_count' => $core]);
                            }else{
                                $temp = $aspek->core_count;
                                $core = $temp + 1;
                                Aspek::where('id', $request->aspek_id)->update(['core_count' => $core]);
                            }
                            $temps = $old->core_count;
                            $cores = $temps - 1;
                            Aspek::where('id', $old_aspek)->update(['core_count' => $cores]);
                        }
                    }
                }else{
                    $aspeks = Aspek::where('id', $request->aspek_id)->get();
                    $old_aspeks = Aspek::where('id', $old_aspek)->get();
                    foreach($aspeks as $aspek){
                        foreach($old_aspeks as $old){
                            if($aspek->secondary_count == null){
                                $secondary = 1;
                                Aspek::where('id', $request->aspek_id)->update(['secondary_count' => $secondary]);
                            }else{
                                $temp = $aspek->secondary_count;
                                $secondary = $temp + 1;
                                Aspek::where('id', $request->aspek_id)->update(['secondary_count' => $secondary]);
                            }
                            $temps = $old->secondary_count;
                            $secondarys = $temps - 1;
                            Aspek::where('id', $old_aspek)->update(['secondary_count' => $secondarys]);
                        }
                    }
                }
            }
        }
    


        $validatedData = $request->validate($rules);
        $validatedData['updated_at'] = date('Y-m-d H:i:s');

        Kriteria::where('id', $kriteria->id)
            ->update($validatedData);
        
        toast('Kriteria berhasil diubah!', 'success');

        return redirect('/kriterias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kriteria  $kriteria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kriteria $kriteria)
    {
        //
    }

    public function ganti_status($id){
        $kriteria = Kriteria::find($id);
        $status = $kriteria->status_id;
        
        if($status == '3'){
            Kriteria::where('id',$id)->update([
                'status_id'=>'4'
            ]);
        }else{
            Kriteria::where('id',$id)->update([
                'status_id'=>'3'
            ]);
        }

        toast('Status berhasil diubah!', 'success');

        return redirect()->back();
        
    }
}
