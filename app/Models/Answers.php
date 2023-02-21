<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Options;

class Answers extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['survey_id', 'option_id', 'complement'];

    protected $primaryKey = 'answer_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

}
