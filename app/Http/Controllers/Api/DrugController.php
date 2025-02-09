<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $pas = Obat::all();
        return response()->json([
            'medicines' => $pas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        //
        if($request == $id.'/hrg'){
            return response()->json([
                'medicines' => ['1', '2']
            ]);
        }
        $pars = DB::table('obats')->join('prices', 'obats.id', '=', 'prices.obat_id')
        ->select('obats.id as idob', 'prices.harga as harga','prices.id as id', 'prices.tanggal_berlaku as start_date','prices.tanggal_akhir as end_date')
        ->where('obat_id', '=', $id)->get();
    
        return response()->json([
            'prices' => $pars
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function hrg(string $id, Request $request)
    {
       
        $fg = Obat::findorfail($id);
        $pars = "unknown request";
        if($request->segment(6) == "kategori")
        {
            $pars = $fg->kategori->kategori;
        }
        elseif($request->segment(6) == "satuan")
        {
            $pars = $fg->satuan->nama;
        }
        elseif($request->segment(6) == "prices")
        {
            $pars = DB::table('obats')->join('prices', 'obats.id', '=', 'prices.obat_id')
            ->select('obats.id as idob', 'prices.harga as harga','prices.id as id', 'prices.tanggal_berlaku as start_date','prices.tanggal_akhir as end_date')
            ->where('obat_id', '=', $id)->get();
        }
        return response()->json([
            'prices' => $pars
        ]);
    }
}
