<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenomItem extends Model
{
    use HasFactory;
    protected $guraded = [];
    public function locus(){
        return $this->belongsTo(Locus::class);
    }
}
