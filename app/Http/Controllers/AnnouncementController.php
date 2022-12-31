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

		if ($request->hasFile('announcement_image')) {
			$request->validate([
				'image' => 'mimes:png,jpeg,jpg,svg,webp'
			]);

			$request->file('announcement_image')->store('announcement_images', 'public');

			$post->attached_image = $request->file('announcement_image')->hashName();
		}

		$post->save();

		return redirect()->to(route('home'));
	}
}
