<?php

namespace Laravel\Spark\Configuration;

trait ManagesSupportOptions
{
    /**
     * The e-mail address where customer support e-mails should be sent.
     *
     * @var string
     */
    public static $sendsSupportEmailsTo;

    /**
     * Determine if a support address has been configured.
     *
     * @return bool
     */
    public static function hasSupportAddress()
    {
        return ! is_null(static::$sendsSupportEmailsTo);
    }

    /**
     * Get the e-mail address to send customer support e-mails to.
     *
     * @return string|null
     */
    public static function supportAddress()
    {
        return static::$sendsSupportEmailsTo;
    }

    /**
     * Set the e-mail address to send customer support e-mails to.
     *
     * @param  string  $address
     * @return void
     */
    public static function sendSupportEmailsTo($address)
    {
        static::$sendsSupportEmailsTo = $address;
    }
}
