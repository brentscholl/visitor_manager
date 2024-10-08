<?php

namespace App\Notifications\FlashMessages;


class OverlayMessage extends Message
{
    /**
     * The title of the message.
     *
     * @var string
     */
    public $title = null;

    /**
     * Whether the message is an overlay.
     *
     * @var bool
     */
    public $overlay = true;
}
