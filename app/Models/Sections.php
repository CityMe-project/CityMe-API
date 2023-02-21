<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;
use App\Models\SubSections;

class Sections extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = ['title'];

    protected $primaryKey = 'section_id';

    protected $keyType = 'string';

    public $incrementing = false;
    public $timestamps = false;

    public function subsections()
    {
      return $this->hasMany(SubSections::class, 'section_id')->orderBy('order');;
    }
}
