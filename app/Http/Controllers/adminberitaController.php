<?php

namespace App\Http\Controllers;

use App\Models\berita;
use App\Models\Kontak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class adminberitaController extends Controller
{
    public function dibuat(Request $request,)
    {
        $katakunci = $request->katakunci;

      
        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
        $data = User::query()
        ->withCount('berita')
        ->where('role_id', 2)
        ->where('username', 'LIKE', '%'.$katakunci.'%')
        ->where('status', 'aktif')
        ->withSum('berita', 'view')
        ->orderByDesc('berita_sum_view')
        ->paginate(5)->withQueryString();

        return view('admin.penulis berita.index', ['data' => $data, 'kontak' => $kontak, 'kontak1' => $kontak1]);
    }

    public function naikjabatan($id)
    {
        $data = User::find($id);
        $data->update(
            [
                'role_id' => 3
            ]
        );
        return redirect()->back();
    }
    public function daftar_editor(Request $request,)
    {
        $katakunci = $request->katakunci;

        $data = User::query()
            ->with(['tolak', 'diterima'])
            ->withCount('berita')
            ->where('username', 'LIKE', '%' . $katakunci . '%')
            ->where('role_id', 3)
            ->where('status', 'aktif')
            ->orderBy('berita_count', 'desc')
            ->paginate(5)->withQueryString();


        // $diterima = berita::query()
        //     ->select(DB::raw('count(*) as total'))
        //     ->groupBy('editor')
        // ->where('status', 'diterima')
        //     ->get()->pluck('total');
        // $ditolak = berita::query()
        //     ->select(DB::raw('count(*) as total'))
        //     ->groupBy('editor')
            // ->where('status', 'ditolak')
        //     ->get()->pluck('total');

        

        $kontak = Kontak::all();
        $kontak1 = [];
        if (Auth::check()) {
            $kontak1 = Kontak::where('read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }

        return view('admin.daftar_editor.index', ['data' => $data, 'kontak' => $kontak, 'kontak1' => $kontak1]);
    }
    public function turunjabatan($id)
    {
        $data = User::find($id);
        $data->update(
            [
                'role_id' => 2
            ]
        );
        return redirect()->back();
    }
}
