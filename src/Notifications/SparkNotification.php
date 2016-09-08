<?php

namespace Laravel\Spark\Notifications;

use Laravel\Spark\User as SparkUser;

class SparkNotification
{
    /**
     * The message icon.
     *
     * @var string
     */
    public $icon = 'fa-bell';

    /**
     * The message body.
     *
     * @var string
     */
    public $body;

    /**
     * The user that created the message.
     *
     * @var string
     */
    public $from;

    /**
     * The text for the action button.
     *
     * @var string
     */
    public $actionText;

    /**
     * The URL for the action button.
     *
     * @var string
     */
    public $actionUrl;

    /**
     * Create a new message instance.
     *
     * @param  string  $body
     * @return void
     */
    public function __construct($body = '')
    {
        $this->body = $body;
    }

    /**
     * Set the message icon.
     *
     * @param  string  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set the message body.
     *
     * @param  string  $body
     * @return $this
     */
    public function body($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set the message body.
     *
     * @param  SparkUser  $from
     * @return $this
     */
    public function from(SparkUser $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the button text.
     *
     * @param  string  $text
     * @param  string  $url
     * @return $this
     */
    public function action($text, $url)
    {
        $this->actionText = $text;
        $this->actionUrl = $url;

        return $this;
    }
}