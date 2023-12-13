<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function data_admin(){
        $dataAdmin = User::paginate(10);
        return view('admin.pages.data-admin',[
            'dataAdmin' => $dataAdmin
        ]);
    }

    public function admin_add(Request $request){
        try{
            $validatedData = $request->validate([
                'fullname' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
                'role' => 'required',
                'foto' => ''
            ]);

            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $name = date('mdYHis') . uniqid() . $image->getClientOriginalName();
                $image->move(public_path() . '/foto-admin/', $name);
                $validatedData['foto'] = $name;
            }

            $validatedData['password'] = bcrypt($validatedData['password']);
            User::create($validatedData);
            return redirect('/data-admin')->with('adminTambah','Admin berhasil ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-admin')->with('adminError', 'Error silahkah ulangi proses');
        }
    }

    public function admin_edit(Request $request){
        try {
            if($request->password){
                $validatedData = $request->validate([
                    'fullname' => 'required',
                    'username' => '',
                    'password' => '',
                    'role' => 'required',
                    'foto' => ''
                ]);
            }else{
                $validatedData = $request->validate([
                    'fullname' => 'required',
                    'role' => 'required',
                    'foto' => ''
                ]);
            }
            
            if ($request->hasFile('foto')) {
                if ($request->oldImage) {
                    $gmbr = $request->oldImage;
                    $image_path = public_path() . '/foto-admin/' . $gmbr;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }

                $image = $request->file('foto');
                $name = date('mdYHis') .'-'. uniqid() .'-'. $image->getClientOriginalName();
                $image->move(public_path() . '/foto-admin/', $name);
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
            
            return redirect('/data-admin')->with('adminEdit','Data admin berhasil diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-admin')->with('adminError', 'Error silahkah ulangi proses');
        }
    }

    public function admin_delete(Request $request){
        try {
            $gmbr = $request->oldImageDel;
            $image_path = public_path() . '/foto-admin/' . $gmbr;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            User::destroy($request->id_del);
            return redirect('/data-admin')->with('adminDelete','Data admin berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/data-admin')->with('adminError', 'Error silahkah ulangi proses');
        }
    }

    public function get_data_admin($id){
        $getID = base64_decode($id);
        $dataAdmin = User::findOrFail($getID);
        return response()->json([
            'dataAdmin' => $dataAdmin,
        ]);
    }
}
