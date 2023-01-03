<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementInteraction extends Notification
{
	use Queueable;

	protected $arr;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(array $arr)
	{
		$this->arr = $arr;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		$type = $this->arr[0];
		$announcement = $this->arr[1];
		$user = $this->arr[2];


		if ($type == 'upvote') {
			return (new MailMessage)
				->subject('Your announcement has been up-voted')
				->greeting('Your announcement has been up-voted')
				->line('Your announcement titled ' . $announcement->title . ' has been up-voted by ' . $user->name)
				->action('View Announcement', route('announcements.show', $announcement->id));
		} else if ($type == 'downvote') {
			return (new MailMessage)
				->subject('Your announcement has been down-voted')
				->greeting('Your announcement has been down-voted')
				->line('Your announcement titled ' . $announcement->title . ' has been down-voted by ' . $user->name)
				->action('View Announcement', route('announcements.show', $announcement->id));
		} else if ($type == 'comment') {
			return (new MailMessage)
				->subject('A user has commented on your announcement')
				->greeting('A user has commented on your announcement')
				->line('The user ' . $user->name . ' has left a comment on the announcement titled ' . $announcement->title)
				->action('View Announcement', route('announcements.show', $announcement->id));
		}
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
