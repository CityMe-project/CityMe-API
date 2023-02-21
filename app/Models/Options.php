<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Options extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['question_id', 'text', 'type', 'order', 'complement'];

    protected $primaryKey = 'option_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(fn ($query) => $query->orderBy('order'));
    }
}
