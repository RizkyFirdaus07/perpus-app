<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nama',
        'nis_nim',
        'no_hp',
    ];
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
