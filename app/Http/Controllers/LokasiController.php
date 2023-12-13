<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function data_lokasi(){
        $dataLokasi = Lokasi::paginate(10);
        $mapApiKey=env('GOOGLE_MAP_API_KEY');
        return view('admin.pages.data-lokasi',[
            'dataLokasi' => $dataLokasi,
            'mapApiKey' => $mapApiKey,
        ]);
    }

    public function lokasi_add(Request $request){
        try {
            $validatedData = $request->validate([
                'kode_lokasi' => 'required|unique:tbl_lokasi',
                'nama_lokasi' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'radius' => 'required',
            ]);

            Lokasi::create($validatedData);
            return redirect('/data-lokasi')->with('lokasiTambah','Lokasi berhasil ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-lokasi')->with('lokasiError', 'Error silahkah ulangi proses');
        }
    }

    public function lokasi_edit(Request $request){
        try {
            $validatedData = $request->validate([
                'nama_lokasi' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'radius' => 'required',
            ]);

            Lokasi::where('id', $request->id)
            ->update($validatedData);
            return redirect('/data-lokasi')->with('lokasiEdit', 'Lokasi berhasil diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-lokasi')->with('lokasiError', 'Error silahkah ulangi proses');
        }
    }

    public function lokasi_delete(Request $request){
        try {
            Lokasi::destroy($request->id_del);
            return redirect('/data-lokasi')->with('lokasiDelete', 'Lokasi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-lokasi')->with('lokasiError', 'Error silahkah ulangi proses');
        }
    }

    public function get_data_lokasi($id){
        $getID = base64_decode($id);
        $dataLokasi = Lokasi::findOrFail($getID);
        return response()->json([
            'dataLokasi' => $dataLokasi,
        ]);
    }
}
