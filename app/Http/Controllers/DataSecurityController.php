<?php

namespace App\Http\Controllers;

use App\Models\Security;
use Illuminate\Http\Request;

class DataSecurityController extends Controller
{
    public function data_security(){
        $dataSecurity = Security::paginate(10);
        return view('admin.pages.data-security',[
            'dataSecurity' => $dataSecurity
        ]);
    }

    public function data_security_add(Request $request){
        try {
            $validatedData = $request->validate([
                'employeeID' => 'required|unique:tbl_data_security',
                'fullname' => 'required',
                'password' => 'required',
                'gender' => 'required',
            ]);

            Security::create($validatedData);
            return redirect('/data-security')->with('securityTambah','Security berhasil ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-security')->with('securityError', 'Error silahkah ulangi proses');
        }
    }

    public function data_security_edit(Request $request){
        try {

            if($request->password){
                $validatedData = $request->validate([
                    'fullname' => 'required',
                    'password' => '',
                    'gender' => 'required',
                ]);
            }else{
                $validatedData = $request->validate([
                    'fullname' => 'required',
                    'gender' => 'required',
                ]);
            }
            
            // $validatedData = $request->validate([
            //     'fullname' => 'required',
            //     'password' => 'required',
            //     'gender' => 'required',
            // ]);

            if($request->password){
                $validatedData['password'] = bcrypt($validatedData['password']);
                Security::where('id', $request->id)
                    ->update($validatedData);
            }else{
                Security::where('id', $request->id)
                    ->update($validatedData);
            }

            // Security::where('id', $request->id)
            // ->update($validatedData);
            return redirect('/data-security')->with('securityEdit', 'Data security berhasil diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-security')->with('securityError', 'Error silahkah ulangi proses');
        }
    }

    public function data_security_delete(Request $request){
        try {
            Security::destroy($request->id_del);
            return redirect('/data-security')->with('securityDelete', 'Data security berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-security')->with('securityError', 'Error silahkah ulangi proses');
        }
    }

    public function get_data_security($id){
        $getID = base64_decode($id);
        $dataSecurity = Security::findOrFail($getID);
        return response()->json([
            'dataSecurity' => $dataSecurity,
        ]);
    }
}
