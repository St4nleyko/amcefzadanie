<?php

namespace App\Notifications;

use App\Models\ToDoItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ItemNotification extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
    public function __construct(protected ToDoItem $item, public $eventInfo)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->from(config('mail.from.address'), env('APP_NAME'))
                    ->subject($this->eventInfo['subject'])
                    ->line($this->eventInfo['subject'])
                    ->greeting('Hello!')
                    ->line($this->eventInfo['msg'])
                    ->action('See item', url('/edititem/'.$this->item->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'item_name' => $this->item->name,
            'event_subject' => $this->eventInfo['subject'],
            'event_message' => $this->eventInfo['msg'],
        ];
    }
}
