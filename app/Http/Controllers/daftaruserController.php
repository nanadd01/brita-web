<?php

namespace App\Http\Controllers;

use App\Models\berita;
use App\Models\Kontak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class daftaruserController extends Controller
{
    

    public function delete($id){
        //dd($request->all());
        $data = User::find($id);
        $data->delete();
        return redirect('user')->with('sukses','Data Berhasil Di Hapus');

    }
    public function banned($id)
    {
        

        $data = User::find($id);
        $data->update([
            'status' => 'banned',
        ]);
        $berita = berita::where('penulis', $id);
        $berita->update([
            'statususer' => 'banned',
        ]);

       

        return redirect()->route('dibanned')->with('sukses','Data Berhasil Di Perbarui');

    }
    public function dibanned(Request $request)
    {   
        
        $data = User::query()
        ->with('Role')
        ->where("status", "banned")
        ->orderBy('created_at', 'desc')
        ->where('role_id', '!=',1);
        // ->appends($request->all());
        if( $katakunci = $request->katakunci){
            $data = $data->where('username', 'LIKE', '%'.$katakunci.'%')->paginate(5)->withQueryString();
        }else{
            $data = $data->paginate(5)->withQueryString();
        }
        // $datap = peminjaman::with('nama', 'buku')->orderBy('id', 'desc')->paginate(5);
        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
       
        return view('admin.dibanned.index',['data' => $data, 'kontak' => $kontak, 'kontak1' => $kontak1]);
    }
    public function rebanned($id){
        $data = User::find($id);
        $data->update([
            'status' => 'aktif',
        ]);
        $berita = berita::where('penulis', $id);
        $berita->update([
            'statususer' => 'aman',
        ]);

        
       
        return redirect()->back()->with('sukses','Data Berhasil Di Perbarui');

    }
    public function daftarbanned(Request $request){

        $katakunci = $request->katakunci;
        $data = User::where('username', 'LIKE', '%'.$katakunci.'%')
        ->where('status', 'banned')
        ->paginate(5);
        
        
        return view('admin.banned.index', compact('data'));
    }
    public function aktifkan($id){
        $data = User::find($id);
        $data->update([
            'status' => 'aktif'
        ]
        );
        return redirect()->route('daftarbanned')->with('sukses','Data Berhasil Di Perbarui');

    }
}
