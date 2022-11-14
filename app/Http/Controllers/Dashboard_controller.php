<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Alternatif;
use App\Models\Aspek;
use App\Models\Pembukaan_seleksi;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class Dashboard_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Dashboard";
        $total_aspek = Aspek::count();
        $total_alternatif = Alternatif::where('id', '!=', '1')->where('status_id', '3')->count();
        $total_seleksi = Pembukaan_seleksi::where('status_id', '1')->count();
        $total_kriteria = Kriteria::count();
        return view('dashboard.index', [
            "title" => $title,
            "total_aspek" => $total_aspek,
            "total_alternatif" => $total_alternatif,
            "total_seleksi" => $total_seleksi,
            "total_kriteria" => $total_kriteria
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
