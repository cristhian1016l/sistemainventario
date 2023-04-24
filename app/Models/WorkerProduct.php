<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerProduct extends Model
{
    use HasFactory;
    protected $table="worker_product";

    protected $primaryKey = "id";
}
