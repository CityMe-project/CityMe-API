<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Geometries extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['geom', 'answer_id', 'tags'];

    protected $primaryKey = 'geometry_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;
}
