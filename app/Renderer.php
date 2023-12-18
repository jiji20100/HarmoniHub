<?php

namespace Source;

class Renderer
{
    public function __construct(private string $viewsPath, array $data = []) 
    {
        $this->data = $data;
    }

    public function view() 
    {
        extract($this->data);
        ob_start();
        require VIEWS . $this->viewsPath . ".php";
        return ob_get_clean();
    }

    public static function make(string $viewsPath, array $data = []): Renderer 
    {
        return new static($viewsPath, $data);
    }

    public function __toString() 
    {
        return $this->view();
    }
}

?>