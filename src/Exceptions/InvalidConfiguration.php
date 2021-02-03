<?php

namespace Sykez\GenusisSms\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     * @return static
     */
    public static function configNotSet()
    {
        return new static('In order to send sms via Genusis Gensuite API you need to add credential information in the `genusis_sms` key of `config.services`.');
    }
}