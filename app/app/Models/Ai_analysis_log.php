<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ai_analysis_log extends Model
{
    protected $table = 'ai_analysis_log';
    protected $guarded = array('id');
    use HasFactory;

    public static $rules = array(
        'path' => 'required',
    );
}
