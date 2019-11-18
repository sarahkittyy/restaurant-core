<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	//
	public function restaurant()
	{
		return $this->belongsTo('App\Restaurant');
	}
}
