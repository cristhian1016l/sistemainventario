<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalDisk extends Model
{
    use HasFactory;
    protected $table="external_disks";

    protected $primaryKey = "id";
}
