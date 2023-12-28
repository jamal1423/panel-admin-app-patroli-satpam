<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TransaksiShiftHD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiShiftController extends Controller
{
    public function data_transaksi_shift($employeeID){
        try {
            $dtNow = Carbon::now()->format('Y-m-d');
            $mnNow = Carbon::now()->format('m');
            $dyNow = Carbon::now()->format('d');
            $yrNow = Carbon::now()->format('Y');
            
            //$cekShiftHD = TransaksiShiftHD::whereDate('masa_berlaku_awal', '>=', $dtNow)
            //->whereDate('masa_berlaku_akhir', '<=', $dtNow)
            // ->whereDay('masa_berlaku_awal','=', $dyNow)
            // ->whereMonth('masa_berlaku_awal','=', $mnNow)
            // ->whereYear('masa_berlaku_awal','=', $yrNow)
            // ->orderBy('tgl_input_shift', 'DESC')
            //->get();
            $cekShiftHD = DB::table('tbl_transaksi_shift_hd')
            ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
            'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
            'tbl_transaksi_shift_hd.masa_berlaku_akhir','tbl_transaksi_shift_dt.idTransaksiHD',
            'tbl_transaksi_shift_dt.employeeID')
            ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
            ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_awal', '>=', $dtNow)
            ->orderBy('tbl_transaksi_shift_hd.tgl_input_shift','DESC')
            ->first();

            $transaksiShift = DB::table('tbl_transaksi_shift_hd')
            ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
            'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
            'tbl_transaksi_shift_hd.masa_berlaku_akhir','tbl_transaksi_shift_dt.*')
            ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
            ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_awal', '>=', $cekShiftHD->masa_berlaku_awal)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_akhir', '<=', $cekShiftHD->masa_berlaku_akhir)
            ->get();

            return response()->json([
                'status' => 'success',
                'results' => $transaksiShift
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }
}
