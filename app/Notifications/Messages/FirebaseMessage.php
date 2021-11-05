<?php

namespace App\Notifications\Messages;

use Illuminate\Notifications\Action;

class FirebaseMessage
{
    /**
     * The icon of the notification.
     *
     * @var string
     */
    public $icon;

    /**
     * The title of the notification.
     *
     * @var string
     */
    public $title;

    /**
     * The text / label for the action.
     *
     * @var string
     */
    public $actionText;

    /**
     * The action URL.
     *
     * @var string
     */
    public $actionUrl;

    /**
     * The data that should be stored with the notification.
     *
     * @var array
     */
    public $data = [];


    /**
     * The "body" lines of the notification.
     *
     * @var array
     */
    public $body = [];


    /**
     * Create a new database message.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Set the title of the notification.
     *
     * @param  string  $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function action($text, $url)
    {
        $this->actionText = $text;
        $this->actionUrl = $url;
        return $this;
    }

    /**
     * Add a line of text to the notification.
     *
     * @param  mixed  $line
     * @return $this
     */
    public function line($line)
    {
        return $this->with($line);
    }

    /**
     * Add a line of text to the notification.
     *
     * @param  mixed  $line
     * @return $this
     */
    public function with($line)
    {
        if ($line instanceof Action) {
            $this->action($line->text, $line->url);
        } else {
            $this->body[] = $line;
        }

        return $this;
    }

    /**
     * Get an array representation of the message.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'icon' => $this->icon,
            'title' => $this->title,
            'body' => $this->body . $this->outroLines,
            'actions' => [
                'actionText' => $this->actionText,
                'actionUrl' => $this->actionUrl,
                'displayableActionUrl' => str_replace(['mailto:', 'tel:'], '', $this->actionUrl ?? ''),
            ],
        ];
    }
}
