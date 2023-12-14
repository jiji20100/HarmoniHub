<?php

namespace Source;

class Renderer
{
    public function __construct(private string $viewsPath) 
    {}

    public function view() 
    {
        ob_start();
        require VIEWS . $this->viewsPath . ".php";
        return ob_get_clean();
    }

    public static function make(string $viewsPath) 
    {
        return new static($viewsPath);
    }

    public function __toString() 
    {
        return $this->view();
    }
}

?>