<?php

namespace App\Notifications;

use App\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TodoMoved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var \App\Todo
     */
    public $todo;

    /**
     * Create a new notification instance.
     *
     * @param \App\Todo $todo
     */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
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
        return (new MailMessage)
            ->subject('Todo moved')
            ->line(sprintf('Your todo is now in the %s pile.', $this->todo->status));
    }
}
