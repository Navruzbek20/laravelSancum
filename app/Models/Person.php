<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
   protected $guarded = [];

   protected $table = 'persons';
    public function code()
{
    return $this->belongsTo(Code::class, 'code_id');
}
}
