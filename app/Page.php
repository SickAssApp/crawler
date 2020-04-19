<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'astroName', 'totalScore', 'totalDesc', 'loveScore',
        'loveDesc', 'buissScore', 'buissDesc', 'finScore',
        'finDesc','isCrawled',
    ];
}
