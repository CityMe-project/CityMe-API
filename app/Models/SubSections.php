<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\Questions;

class SubSections extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['title', 'section_id'];

    protected $primaryKey = 'sub_section_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    protected $with = ['questions'];

    public function questions()
    {
      return $this->hasMany(Questions::class, 'sub_section_id', 'sub_section_id')->orderBy('order');
    }
}
