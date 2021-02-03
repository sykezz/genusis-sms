<?php

namespace Sykez\GenusisSms;

class GenusisSmsMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content, $to;
    /**
     * Create a new message instance.
     *
     * @param   string $message
     * @return  void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }
    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * to
     *
     * @param  mixed $to
     * @return void
     */
    public function to($to)
    {
        return $this->to = $to;
    }
}
