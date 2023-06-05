<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenghargaanController extends Controller
{
    public function peindex(Request $request){

        $katakunci = $request->katakunci;
        $data = Penghargaan::where('penghargaan', 'LIKE', '%'.$katakunci.'%')->paginate(5)->withQueryString();
        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
       
        return view('admin.penghargaan.index',['data' => $data, 'kontak' => $kontak, 'kontak1' => $kontak1]);
    }

    public function tambahpenghargaan(){
        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
        return view('admin.penghargaan.tambahpenghargaan', compact('kontak','kontak1'));
    }

    public function insertpenghargaan(Request $request){
        //dd($request->all());
        Session::flash('penghargaan', $request->penghargaan);
        Session::flash('tanggal', $request->penghargaan);

        $request->validate([

            'penghargaan' => 'required|unique:penghargaan',
            // 'penghargaan'=>'required',
            'foto'=>'required|mimes:jpg, jpeg, png',
            'foto' => 'dimensions:width=1000,height=600',
            'tanggal'=>'required',
        ],[
            'penghargaan.unique' => 'Penghargaan dengan nama tersebut sudah ada',
            // 'penghargaan.required'=>'Kolom Penghargaan Wajib Diisi',
            'foto.required'=>'Kolom Foto Wajib Diisi',
            'foto.mimes'=>'Foto Wajib Berformat JPG, JPEG & PNG',
            'foto.dimensions' => 'Sesuaikan Ukuran Foto',       
            'tanggal.required'=>'Kolom Tanggal Wajib Diisi',
        ]);
        $foto_file = $request->file('foto');
        $foto_ekstensi = $foto_file->extension();
        $foto_nama = date('ymdhis').".".$foto_ekstensi;
        $foto_file->move(public_path('fotopenghargaan'), $foto_nama);

        $data = Penghargaan::create([
            'penghargaan' => $request->penghargaan,
            'foto' => $foto_nama,
            'tanggal' => $request->tanggal,
           ]);
       return redirect()->route('penghargaan')->with('success','Data Berhasil Di Tambahkan');
    }

    public function tampilpenghargaan($id){

        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
        $data = Penghargaan::find($id);
        return view('admin.penghargaan.tampilpenghargaan', compact('data', 'kontak', 'kontak1'));
    }
    
    // public function tampilaturan($id){

    //     $data = Aturannews::find($id);
    //     // dd($data);
    //     return view('tampilaturan', compact('data'));
    // }
    
    public function updatepenghargaan(Request $request, $id){
        $data = Penghargaan::find($id);
        if ($request->hasFile('foto')) {
            unlink(public_path('fotopenghargaan/' . $data->foto));
            $file = $request->file('foto');
            $filename = hash_file('md5', $file->path()) . '.' . $file->getClientOriginalExtension();
            $file->move('fotopenghargaan/', $filename);
            $data->foto = $filename;
            $data->save();
        }        
        $data->update([
            'penghargaan' => $request -> penghargaan,
            'tanggal' => $request -> tanggal,
        ]);

        return redirect()->route('penghargaan')->with('success','Data Berhasil Di Update');

    }

    public function deletepenghargaan($id){
        $data = Penghargaan::find($id);
        unlink(public_path('fotopenghargaan/' . $data->foto));
        $data->delete();
        return redirect()->route('penghargaan')->with('success', 'Data Berhasil Di Delete' );
    }
}
