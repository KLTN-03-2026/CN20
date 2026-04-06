<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Str;

class MovieController extends Controller
{

    public function index()
    {
        return Movie::all();
    }

    public function store(Request $request)
    {
        $movie = Movie::create([
            'ten_phim' => $request->ten_phim,
            'slug' => Str::slug($request->ten_phim),
            'dien_vien' => $request->dien_vien,
            'ngay_chieu' => $request->ngay_chieu,
            'thoi_luong' => $request->thoi_luong,
            'dao_dien' => $request->dao_dien,
            'nha_san_xuat' => $request->nha_san_xuat,
            'the_loai' => $request->the_loai,
            'gioi_han_do_tuoi' => $request->gioi_han_do_tuoi,
            'hinh_anh' => $request->hinh_anh,
            'trailer' => $request->trailer,
            'ngon_ngu' => $request->ngon_ngu,
            'chi_tiet' => $request->chi_tiet,
            'tinh_trang' => $request->tinh_trang,
            'active' => 1
        ]);

        return response()->json($movie);
    }

    public function update(Request $request,$id)
    {
        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        return response()->json($movie);
    }

    public function destroy($id)
    {
        Movie::destroy($id);
        return response()->json(['message'=>'Deleted']);
    }

}
