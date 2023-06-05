<?php

namespace App\Http\Controllers;

use App\Models\berita;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Notification;
use App\Models\Penghargaan;
use App\Models\sosmed;
use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class tagController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        // dd($katakunci);
        $tag = tag::where('tag', 'LIKE', '%'.$katakunci.'%')
        ->get();
        $beritaid = $tag->pluck('berita_id')->toArray();
        $berita = berita::whereIn('id', $beritaid)->where('status', 'diterima')->paginate(8)->withQueryString();

        $notif = [];
        if (Auth::check()) {
            $notif = Notification::where('induk_user', auth()->user()->id)->where('is_read', 0)->orderBy('created_at', 'desc')->get();
            // dd($notif);
        }
       
    
        $penghargaan = Penghargaan::limit(3)->orderBy('created_at', 'desc')->get();
        $kategori = Kategori::limit(5)->orderBy('created_at', 'desc')->get();
        $kategori2 = Kategori::limit(10)->orderBy('created_at', 'desc')->skip(5)->get();
        $sosmed = sosmed::limit(1)->orderBy('updated_at', 'desc')->get();



        return view('tag.index',[
        'penghargaan' => $penghargaan,
        'tag' => $tag,
        'kategori' => $kategori,
        'kategori2' => $kategori2,
        'sosmed' => $sosmed,
        'berita' => $berita,
        'notif' => $notif,
        'katakunci' => $katakunci,
        ]);
        // return view('tag.index');
    }
}
