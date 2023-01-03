<?php

namespace App\Notifications;

use App\Models\UserOrganisation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddedUserToOrg extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
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
		$org = UserOrganisation::where('user_id', $notifiable->id)
			->join('organisations', 'user_organisations.org_id', 'organisations.id')
			->join('users', 'organisations.admin_id', 'users.id')
			->select('user_organisations.*', 'organisations.name as org_name', 'organisations.admin_id', 'users.name as admin_name')->first();

		return (new MailMessage)
			->subject('You have been added to an organisation')
			->greeting('You have been added to an organisation')
			->line('Hello! You have been added to ' . $org->org_name . ' by the admin ' . $org->admin_name . '.')
			->line('You will be able to view the content available in the organisation from your homepage.')
			->action('Go to Homepage', url('/'));
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
