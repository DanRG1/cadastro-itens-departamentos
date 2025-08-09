<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department; 

class Items extends Model
{
    protected $table = 'items';

    protected $fillable = ['name', 'quantity', 'description', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}