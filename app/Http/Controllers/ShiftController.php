<?php

namespace App\Http\Controllers;

use App\Models\MTShift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function data_shift(){
        $dataShift = MTShift::paginate(10);
        return view('admin.pages.data-master-shift',[
            'dataShift' => $dataShift
        ]);
    }

    public function shift_add(Request $request){
        try {
            $validatedData = $request->validate([
                'kode_shift' => 'required|unique:tbl_mt_shift',
                'nama_shift' => 'required',
                'jam_masuk' => 'required',
                'jam_pulang' => 'required',
            ]);

            MTShift::create($validatedData);
            return redirect('/master-shift')->with('shiftTambah','Shift berhasil ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/master-shift')->with('shiftError', 'Error silahkah ulangi proses');
        }
    }

    public function shift_edit(Request $request){
        try {
            $validatedData = $request->validate([
                'nama_shift' => 'required',
                'jam_masuk' => 'required',
                'jam_pulang' => 'required',
            ]);

            MTShift::where('id', $request->id)
            ->update($validatedData);
            return redirect('/master-shift')->with('shiftEdit', 'Master shift berhasil diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/master-shift')->with('shiftError', 'Error silahkah ulangi proses');
        }
    }

    public function shift_delete(Request $request){
        try {
            MTShift::destroy($request->id_del);
            return redirect('/master-shift')->with('shiftDelete', 'Master shift berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/master-shift')->with('shiftError', 'Error silahkah ulangi proses');
        }
    }

    public function get_data_master($id){
        $getID = base64_decode($id);
        $dataShift = MTShift::findOrFail($getID);
        return response()->json([
            'dataShift' => $dataShift,
        ]);
    }
}
