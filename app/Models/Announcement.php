<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
	use HasFactory;

	public function vote()
	{
		return $this->morphMany(Vote::class, 'votable');
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
