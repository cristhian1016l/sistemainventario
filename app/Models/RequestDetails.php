<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDetails extends Model
{
    use HasFactory;
    protected $table="requests_details";

    protected $primaryKey = "id";
}
