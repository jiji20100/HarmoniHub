<?php

namespace Exceptions;

class RouteNotFoundException extends \Exception
{
    public function __construct($message, $code = 404, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

?>