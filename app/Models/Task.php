<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UsesUuid;

class Task extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = ['task_name', 'due_date'];
}
