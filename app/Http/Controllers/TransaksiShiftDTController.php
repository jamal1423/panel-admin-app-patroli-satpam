<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\MTShift;
use App\Models\Security;
use App\Models\TransaksiShiftDT;
use App\Models\TransaksiShiftHD;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiShiftDTController extends Controller
{
    public function transaksi_shift_detail($id){
        $getID = base64_decode($id);
        $detailShiftHD = TransaksiShiftHD::where('id',$getID)->get();
        
        $masterShift = MTShift::all();
        $dataSecurity = User::where('role','=','Security')->get();

        $detailShiftDT = TransaksiShiftDT::where('idTransaksiHD',$getID)->paginate(10);
        $mtLokasi = Lokasi::all();
        $dtNow = Carbon::now()->format('d-m-Y');

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

    public function transaksi_shift_detail_edit(Request $request){
        try {
            $validatedData = $request->validate([
                'employeeID' => 'required',
                'kode_lokasi' => 'required',
                'keterangan' => '',
            ]);

            // dd($validatedData);
            $dtNow = Carbon::now()->format('d-m-Y');
            TransaksiShiftDT::where('id', $request->id)
            ->update($validatedData);
            return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailEdit','Transaksi detail shift berhasil diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailError', 'Error silahkah ulangi proses');
        }
    }

    public function transaksi_shift_detail_delete(Request $request){
        try {
            TransaksiShiftDT::destroy($request->id_del);
            return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailDelete','Transaksi detail shift berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/transaksi-shift/detail/'.base64_encode($request->idTransaksiHD))->with('shiftDetailError', 'Error silahkah ulangi proses');
        }
    }

    public function get_detail_transaksi($id){
        $getID = base64_decode($id);
        $dataTransaksiDT = TransaksiShiftDT::findOrFail($getID);
        $masterShift = MTShift::all();
        $dataSecurity = User::where('role','=','Security')->get();
        return response()->json([
            'dataTransaksiDT' => $dataTransaksiDT,
            'masterShift' => $masterShift,
            'dataSecurity' => $dataSecurity
        ]);
    }
}
