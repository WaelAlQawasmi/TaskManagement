<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'creator_user_id',
        'assigned_user_id',
        'status'
     ];

     public function assignedUser(){
        return $this->belongsTo(User::class,"assigned_user_id");
     }

    public function creatorUser(){
        return $this->belongsTo(User::class,"creator_user_id");
     }

}
