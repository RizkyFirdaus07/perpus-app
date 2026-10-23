<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'judul',
        'pengarang',
        'penerbit',
        'tahun',
        'stok',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
