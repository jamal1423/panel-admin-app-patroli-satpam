<?php

namespace App\Http\Controllers;

use App\Models\MTShift;
use App\Models\TransaksiShiftHD;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiShiftHDController extends Controller
{
    public function data_transaksi_shift_hd(){
        $dataTransaksiHD = TransaksiShiftHD::orderBy('tgl_input_shift','DESC')->paginate(10);
        $masterShift = MTShift::all();
        return view('admin.pages.data-transaksi-shift',[
            'dataTransaksiHD' => $dataTransaksiHD,
            'masterShift' => $masterShift,
        ]);
    }

    public function transaksi_shift_hd_add(Request $request){
        try {
            $validatedData = $request->validate([
                'kode_shift' => 'required',
                'tgl_input_shift' => '',
                'masa_berlaku_awal' => 'required',
                'masa_berlaku_akhir' => 'required',
            ]);

            $cekEksisData = TransaksiShiftHD::where('kode_shift','=',$request->kode_shift)
            ->where('masa_berlaku_awal','=',$request->masa_berlaku_awal)
            ->where('masa_berlaku_akhir','=',$request->masa_berlaku_akhir)->count();

            $dtNow = Carbon::now();

            if($request->masa_berlaku_akhir < $request->masa_berlaku_awal){
                // dd('tgl akhir tidak boleh kurang dari tgl awal');
                return redirect('/transaksi-shift')->with('transaksiShiftLess','Transaksi shift less');
            }else{
                if($request->masa_berlaku_awal < $dtNow || $request->masa_berlaku_akhir < $dtNow){
                    return redirect('/transaksi-shift')->with('transaksiShiftExp','Transaksi shift exp');
                }else{
                    if($cekEksisData > 0){
                        return redirect('/transaksi-shift')->with('transaksiShiftEksis','Transaksi shift sudah ada');
                    }else{
                        $validatedData['tgl_input_shift'] = Carbon::now();
                        TransaksiShiftHD::create($validatedData);
                        return redirect('/transaksi-shift')->with('transaksiShiftTambah','Transaksi shift berhasil ditambahkan');
                    }
                }
            } 
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/transaksi-shift')->with('transaksiShiftError', 'Error silahkah ulangi proses');
        }
    }
}
