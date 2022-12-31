<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
	//

	public function create()
	{
		return view('announcements.create');
	}

	public function store(Request $request)
	{

		$post = new Announcement;
		$post->user_id = Auth::user()->id;
		$post->org_id = $request->attributes->get('org_data')->id;
		$post->title = $request->announcement_title;
		$post->text = $request->announcement_text;
		$post->save();

		return redirect()->to(route('home'));
	}
}
