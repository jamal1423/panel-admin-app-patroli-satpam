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
            
            $cekShiftHD = DB::table('tbl_transaksi_shift_hd')
            ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
            'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
            'tbl_transaksi_shift_hd.masa_berlaku_akhir','tbl_transaksi_shift_dt.idTransaksiHD',
            'tbl_transaksi_shift_dt.employeeID')
            ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
            ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
            ->whereMonth('tbl_transaksi_shift_hd.masa_berlaku_awal', '=', $mnNow)
            ->whereYear('tbl_transaksi_shift_hd.masa_berlaku_awal', '=', $yrNow)
            ->get();

            $countShiftHD = DB::table('tbl_transaksi_shift_hd')
            ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
            'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
            'tbl_transaksi_shift_hd.masa_berlaku_akhir','tbl_transaksi_shift_dt.idTransaksiHD',
            'tbl_transaksi_shift_dt.employeeID')
            ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
            ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
            ->whereMonth('tbl_transaksi_shift_hd.masa_berlaku_awal', '=', $mnNow)
            ->whereYear('tbl_transaksi_shift_hd.masa_berlaku_awal', '=', $yrNow)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_akhir', '>=', $dtNow)
            ->count();

            foreach($cekShiftHD as $cekSHD){
                $dtBegin = $cekSHD->masa_berlaku_awal;
                $dtEnd = $cekSHD->masa_berlaku_akhir;
                if (($dtNow >= $dtBegin) && ($dtNow <= $dtEnd)){
                    $a=$dtBegin;
                    $b=$dtEnd;

                    $transaksiShift = DB::table('tbl_transaksi_shift_hd')
                    ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
                    'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
                    'tbl_transaksi_shift_hd.masa_berlaku_akhir',
                    'tbl_transaksi_shift_dt.id','tbl_transaksi_shift_dt.idTransaksiHD','tbl_transaksi_shift_dt.employeeID',
                    'tbl_transaksi_shift_dt.kode_lokasi','tbl_transaksi_shift_dt.keterangan',
                    'tbl_lokasi.kode_lokasi','tbl_lokasi.nama_lokasi','tbl_lokasi.latitude','tbl_lokasi.longitude','tbl_lokasi.radius',
                    'tbl_mt_shift.kode_shift','tbl_mt_shift.nama_shift','tbl_mt_shift.jam_masuk','tbl_mt_shift.jam_pulang',
                    'users.fullname','users.employeeID'
                    )
                    ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
                    ->join('tbl_lokasi','tbl_transaksi_shift_dt.kode_lokasi','=','tbl_lokasi.kode_lokasi')
                    ->join('tbl_mt_shift','tbl_transaksi_shift_hd.kode_shift','=','tbl_mt_shift.id')
                    ->join('users','tbl_transaksi_shift_dt.employeeID','=','users.employeeID')
                    ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
                    ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_awal', '>=', $a)
                    ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_akhir', '<=', $b)
                    ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_akhir', '>=', $dtNow)
                    ->get();
                }
            }
            
            $transaksiShiftNow = DB::table('tbl_transaksi_shift_hd')
            ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
            'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
            'tbl_transaksi_shift_hd.masa_berlaku_akhir',
            'tbl_transaksi_shift_dt.id','tbl_transaksi_shift_dt.idTransaksiHD','tbl_transaksi_shift_dt.employeeID',
            'tbl_transaksi_shift_dt.kode_lokasi','tbl_transaksi_shift_dt.keterangan',
            'tbl_lokasi.kode_lokasi','tbl_lokasi.nama_lokasi','tbl_lokasi.latitude','tbl_lokasi.longitude','tbl_lokasi.radius',
            'tbl_mt_shift.kode_shift','tbl_mt_shift.nama_shift','tbl_mt_shift.jam_masuk','tbl_mt_shift.jam_pulang',
            'users.fullname','users.employeeID'
            )
            ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
            ->join('tbl_lokasi','tbl_transaksi_shift_dt.kode_lokasi','=','tbl_lokasi.kode_lokasi')
            ->join('tbl_mt_shift','tbl_transaksi_shift_hd.kode_shift','=','tbl_mt_shift.id')
            ->join('users','tbl_transaksi_shift_dt.employeeID','=','users.employeeID')
            ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_awal', '>=', $dtNow)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_awal', '<=', $dtNow)
            ->get();

            $countShiftHDNow = DB::table('tbl_transaksi_shift_hd')
            ->select('tbl_transaksi_shift_hd.id','tbl_transaksi_shift_hd.tgl_input_shift',
            'tbl_transaksi_shift_hd.kode_shift','tbl_transaksi_shift_hd.masa_berlaku_awal',
            'tbl_transaksi_shift_hd.masa_berlaku_akhir','tbl_transaksi_shift_dt.idTransaksiHD',
            'tbl_transaksi_shift_dt.employeeID')
            ->join('tbl_transaksi_shift_dt','tbl_transaksi_shift_hd.id','=','tbl_transaksi_shift_dt.idTransaksiHD')
            ->where('tbl_transaksi_shift_dt.employeeID','=', $employeeID)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_awal', '>=', $dtNow)
            ->whereDate('tbl_transaksi_shift_hd.masa_berlaku_akhir', '<=', $dtNow)
            ->count();

            if($countShiftHDNow > 0){
                return response()->json($transaksiShiftNow);
            }else{
                if($countShiftHD > 0){
                    return response()->json($transaksiShift);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'data not found'
                    ]);
                }
            }

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }
}
