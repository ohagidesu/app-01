<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messeage extends Model
{
    use HasFactory;
     public function user() {
         return $this->belongsTo(User::class);
     //     return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
     }
     
     public function admin() {
         return $this->belongsTo(Admin::class);
     //     return $this->belongsTo(User::class, 'foreign_key', 'owner_key');
     }
}
