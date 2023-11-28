<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PostRequest extends FormRequest
{
     use HasFactory;
    use SoftDeletes;
    
    
    
   
    public function rules()
    {
        return [
            'post.title' => 'required|string|max:100',
            'post.content' => 'required|string|max:4000',
        ];
    }
}