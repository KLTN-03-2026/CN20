<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [

            'ten_phim',
            'slug',
            'dien_vien',
            'ngay_chieu',
            'thoi_luong',
            'dao_dien',
            'nha_san_xuat',
            'the_loai',
            'gioi_han_do_tuoi',
            'hinh_anh',
            'trailer',
            'ngon_ngu',
            'chi_tiet',
            'tinh_trang',
            'active'

];public function showtimes()
{
    return $this->hasMany(Showtime::class);
}
}
