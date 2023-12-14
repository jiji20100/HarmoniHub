<?php

namespace Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = "La page n'existe pas";
}

?>