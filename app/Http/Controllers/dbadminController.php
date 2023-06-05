<?php

namespace App\Http\Controllers;

use App\Charts\KategoriBerita;
use App\Charts\GrafikBeritasChart;
use App\Charts\penulisTerbanyak;
use App\Charts\tahunChart;
use App\Models\Aturan;
use App\Models\berita;
use App\Models\Kategori;
use App\Models\Kontak;
use App\Models\sponsor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class dbadminController extends Controller
{
    public function index(Request $request,KategoriBerita $kategoriBerita, GrafikBeritasChart $GrafikBeritasChart, tahunChart $tahunChart){
        $iklanCount = sponsor::where('status', 'aktif')->count();
        $kategoryCount = Kategori::count();
        $userCount = User::where('status', 'aktif')->count();
        $beritaCount = berita::where('status', 'diterima')->count();
        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
        
        return view('admin.dashboard.index', ['kontak' => $kontak,
        'iklanCount' => $iklanCount,
        'kontak1' => $kontak1,
        'kategoryCount' => $kategoryCount,
        'userCount' => $userCount,
        'beritaCount' => $beritaCount,
        'KategoriBerita' => $kategoriBerita->build(),
        'GrafikBeritasChart' => $GrafikBeritasChart->build(),
        'tahunChart' => $tahunChart->build(),
        ]);
    }
    public function dashboard(Request $request){
        $beritaCount = berita::where('penulis', Auth::user()->id)->count();
        $beritasetuju = berita::where('penulis', Auth::user()->id)
        ->where('status', 'diterima')
        ->count();
        $beritatolak = berita::where('penulis', Auth::user()->id)
        ->where('status', 'ditolak')
        ->count();

        $katakunci = $request->katakunci;
        $kontak = Kontak::all();
        $user = User::all();
        $berita = berita::where('judul', 'LIKE', '%'.$katakunci.'%')
        ->where('penulis', Auth::user()->id)
        ->where('status', 'diterima')
        ->with('users')->orderBy('view', 'desc')->paginate(5)->withQueryString();
        return view('penulis.dashboard.index', ['beritaCount' => $beritaCount,
            'beritasetuju' => $beritasetuju,
            'beritatolak' => $beritatolak,
            'kontak' => $kontak,
            'user' => $user,
            'berita' => $berita
        ]);
    }
    public function pindex(){
        $kontak = Kontak::paginate(6);
        // $pagin = Kontak::;
        $kontak1 = [];
        $user = User::all();
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
        
            return view('admin.pesan.index', ['kontak' => $kontak,'kontak1' => $kontak1,'user' => $user]);
        }
        
        public function tampilsemua(){
            $data = Kontak::where('read', '0')->update(['read' => '1']);

            // return response()->json($data);
            return redirect('pesan');
        }
        public function deleteall(){
            schema::disableForeignKeyConstraints();
            \App\Models\Kontak::truncate();
            schema::disableForeignKeyConstraints();
            // toastr()->success('Berhasil Menghapus Data');
            return redirect()->back();
        }

}
