<?php

namespace HomedoctorEs\Laravel\Intercom\Notifications\Channel;

use GuzzleHttp\Exception\BadResponseException;
use HomedoctorEs\Laravel\Intercom\Exceptions\MessageIsNotCompleteException;
use HomedoctorEs\Laravel\Intercom\Exceptions\RequestException;
use HomedoctorEs\Laravel\Intercom\Intercom;
use Illuminate\Notifications\Notification;

class IntercomChannel
{

    /**
     * @var Intercom
     */
    private $client;

    /**
     * @param Intercom $client
     */
    public function __construct(Intercom $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification via Intercom API.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @return void
     *
     * @throws MessageIsNotCompleteException When message is not filled correctly
     * @throws RequestException When server responses with a bad HTTP code
     * @see https://developers.intercom.com/intercom-api-reference/reference#admin-initiated-conversation
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $this->sendNotification($notifiable, $notification);
        } catch (BadResponseException $exception) {
            throw new RequestException($exception, $exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @return Intercom
     */
    public function getClient(): Intercom
    {
        return $this->client;
    }

    /**
     * @param mixed $notifiable
     * @param Notification $notification
     *
     * @throws MessageIsNotCompleteException
     */
    protected function sendNotification($notifiable, Notification $notification)
    {
        $message = $notification->toIntercom($notifiable);
        if (!$message->toIsGiven()) {
            if (null === $to = $notifiable->routeNotificationFor('intercom')) {
                throw new MessageIsNotCompleteException($message, 'Recipient is not provided');
            }

            $message->to($to);
        }

        if (!$message->isValid()) {
            throw new MessageIsNotCompleteException(
                $message,
                'The message is not valid. Please check that you have filled required params'
            );
        }

        if (config('intercom.is_channel_active') === false) {
            return null;
        }
        
        return $this->client->messages()->create(
            $message->toArray()
        );
    }

}