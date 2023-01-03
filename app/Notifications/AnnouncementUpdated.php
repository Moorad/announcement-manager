<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementUpdated extends Notification
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
		$announcement = $this->arr[0];
		return (new MailMessage)
			->subject('An announcement has been updated')
			->greeting('An announcement has been updated')
			->line('The announcement titled ' . $announcement->title . ' has been updated')
			->action('View Announcement', route('announcements.show', $announcement->id))
			->line('You are receiving this because the announcement has a priority of ' . $announcement->priority);
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
