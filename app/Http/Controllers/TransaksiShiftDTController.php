<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\MTShift;
use App\Models\Security;
use App\Models\TransaksiShiftDT;
use App\Models\TransaksiShiftHD;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiShiftDTController extends Controller
{
    public function transaksi_shift_detail($id){
        $getID = base64_decode($id);
        $detailShiftHD = TransaksiShiftHD::where('id',$getID)->get();
        
        $masterShift = MTShift::all();
        $dataSecurity = Security::all();

        $detailShiftDT = TransaksiShiftDT::where('idTransaksiHD',$getID)->paginate(10);
        $mtLokasi = Lokasi::all();
        $dtNow = Carbon::now();

        return view('admin.pages.data-transaksi-shift-detail',[
            'detailShiftHD' => $detailShiftHD,
            'masterShift' => $masterShift,
            'detailShiftDT' => $detailShiftDT,
            'mtLokasi' => $mtLokasi,
            'dataSecurity' => $dataSecurity,
            'idHD' => $getID,
            'dtNow' => $dtNow
        ]);
    }

    public function transaksi_shift_detail_add(Request $request){
        try {
            $validatedData = $request->validate([
                'idTransaksiHD' => 'required',
                'employeeID' => 'required',
                'kode_lokasi' => 'required',
                'keterangan' => '',
            ]);

            $cekEksisData = TransaksiShiftDT::where('idTransaksiHD',$request->idTransaksiHD)
            ->where('kode_lokasi',$request->kode_lokasi)
            ->where('employeeID',$request->employeeID)->count();

            if($cekEksisData > 0){
                return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailEksis','Data detail shift tersedia');
            }else{
                TransaksiShiftDT::create($validatedData);
                return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailTambah','Shift detail berhasil ditambahkan');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailError', 'Error silahkah ulangi proses');
        }
    }
}
