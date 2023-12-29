<?php

namespace App\Http\Controllers;

use App\Models\Security;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DataSecurityController extends Controller
{
    public function data_security(){
        $dataSecurity = User::where('role','=','Security')->paginate(10);
        return view('admin.pages.data-security',[
            'dataSecurity' => $dataSecurity
        ]);
    }

    public function data_security_add(Request $request){
        try {
            $validatedData = $request->validate([
                'fullname' => 'required',
                'employeeID' => 'required|unique:users',
                'password' => 'required',
                'role' => 'required',
                'gender' => 'required',
                'foto' => '',
            ]);

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $name = date('mdYHis') . uniqid() . $image->getClientOriginalName();
                $image->move(public_path() . '/foto-user/', $name);
                $validatedData['foto'] = $name;
            }

            $validatedData['password'] = bcrypt($validatedData['password']);

            User::create($validatedData);
            return redirect('/data-security')->with('securityTambah','Security berhasil ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-security')->with('securityError', 'Error silahkah ulangi proses');
        }
    }

    public function data_security_edit(Request $request){
        try {

            // if($request->password){
            //     $validatedData = $request->validate([
            //         'fullname' => 'required',
            //         'password' => '',
            //         'gender' => 'required',
            //     ]);
            // }else{
            //     $validatedData = $request->validate([
            //         'fullname' => 'required',
            //         'gender' => 'required',
            //     ]);
            // }

            // if($request->password){
            //     $validatedData['password'] = bcrypt($validatedData['password']);
            //     Security::where('id', $request->id)
            //         ->update($validatedData);
            // }else{
            //     Security::where('id', $request->id)
            //         ->update($validatedData);
            // }

            if($request->password){
                $validatedData = $request->validate([
                    'fullname' => 'required',
                    'employeeID' => '',
                    'password' => '',
                    'role' => 'required',
                    'gender' => 'required',
                    'foto' => ''
                ]);
            }else{
                $validatedData = $request->validate([
                    'fullname' => 'required',
                    'role' => 'required',
                    'gender' => 'required',
                    'foto' => ''
                ]);
            }
            
            if ($request->hasFile('foto')) {
                if ($request->oldImage) {
                    $gmbr = $request->oldImage;
                    $image_path = public_path() . '/foto-user/' . $gmbr;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }

                $image = $request->file('foto');
                $name = date('mdYHis') .'-'. uniqid() .'-'. $image->getClientOriginalName();
                $image->move(public_path() . '/foto-user/', $name);
                $validatedData['foto'] = $name;
            }

            if($request->password){
                $validatedData['password'] = bcrypt($validatedData['password']);
                User::where('id', $request->id)
                    ->update($validatedData);
            }else{
                User::where('id', $request->id)
                    ->update($validatedData);
            }
            return redirect('/data-security')->with('securityEdit', 'Data security berhasil diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-security')->with('securityError', 'Error silahkah ulangi proses');
        }
    }

    public function data_security_delete(Request $request){
        try {
            $gmbr = $request->oldImageDel;
            $image_path = public_path() . '/foto-user/' . $gmbr;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            User::destroy($request->id_del);
            return redirect('/data-security')->with('securityDelete', 'Data security berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-security')->with('securityError', 'Error silahkah ulangi proses');
        }
    }

    public function get_data_security($id){
        $getID = base64_decode($id);
        $dataSecurity = User::findOrFail($getID);
        return response()->json([
            'dataSecurity' => $dataSecurity,
        ]);
    }
}
