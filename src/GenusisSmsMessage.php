<?php

namespace Sykez\GenusisSms;

class GenusisSmsMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * Recipient
     *
     * @var mixed
     */
    public $to;

    /**
     * Create a new message instance.
     *
     * @param   string $message
     * @return  void
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * to
     *
     * @param  mixed $to
     * @return $this
     */
    public function to(int $to)
    {
        $this->to = $to;

        return $this;
    }
}
