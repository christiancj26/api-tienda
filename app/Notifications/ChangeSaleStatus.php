<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\ChangeSaleStatusRealizado;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeSaleStatus extends Notification
{
    private $sale;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($sale)
    {
        //
        $this->sale = $sale;
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
        if ($this->sale->status == 'realizado') {
            $text = 'Enhorabuena, tu pedido se ha '.$this->sale->status. ' correctamente';
        }elseif ($this->sale->status == 'cancelado') {
            $text = 'Tu pedido ha sido '.$this->sale->status;
        }elseif ($this->sale->status == 'pendiente') {
            $text = 'Tu pedido está '.$this->sale->status;
        }

        return (new ChangeSaleStatusRealizado($this->sale))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->sale->status == 'realizado') {
            $text = 'Enhorabuena, tu pedido se ha '.$this->sale->status. ' correctamente';
        }elseif ($this->sale->status == 'cancelado') {
            $text = 'Tu pedido ha sido '.$this->sale->status;
        }elseif ($this->sale->status == 'pendiente') {
            $text = 'Tu pedido está '.$this->sale->status;
        }

        return [
            'sale_id' => $this->sale->id,
            'text' => $text
        ];
    }
}
