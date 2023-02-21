<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Options;

class Questions extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['title', 'sub_section_id', 'question_id_related', 'option_id_related', 'order', 'required', 'note'];

    protected $primaryKey = 'question_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected $with = ['options'];

    public function options()
    {
      return $this->hasMany(Options::class, 'question_id');
    }
}
