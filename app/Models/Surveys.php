<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Surveys extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['user_id_related','shared_info', 'modified_date', 'submited', 'submited_date'];

    protected $primaryKey = 'survey_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;
}
