<?php

namespace App;

use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Diary extends Model
{
    protected $guarded = ['id'];
    
    protected $fillable = ['datetime', 'content'];

    protected $rules = [
        'user_id' => 'required|integer',
        'datetime' => 'required|date',
        'content' => 'required|string', 
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function validator() 
    {
        return Validator::make($this->attributes, $this->rules);
    }

    public function scopeAuthUserDiaries($query)
    {
        $user = Auth::user();
        return $query->where('user_id', $user->id);
    }

    public function scopeOrderByTime($query)
    {
        return $query->orderBy('datetime', 'desc')->orderBy('updated_at', 'desc');
    }
}
