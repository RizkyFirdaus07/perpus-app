<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loan extends Model
{
    protected $fillable = [
        'book_id',
        'member_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'status',
    ];
    public function book()
    {
        return $this->belongsTo(book::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
