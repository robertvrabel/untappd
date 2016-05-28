<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'signup_date',
        'checkin_date',
        'username',
        'name',
        'beer',
        'rating',
        'label_art',
    ];
}
