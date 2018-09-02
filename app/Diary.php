<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'user_id' => 'required|integer',
        'datetime' => 'required|date',
        'content' => 'required|string', 
    );

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
