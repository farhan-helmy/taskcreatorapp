<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\UsesUuid;
use DateTimeInterface;


class Workspace extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = ['workspace_name'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
