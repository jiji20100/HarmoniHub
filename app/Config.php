<?php

namespace Source;

class Config {
    public function __construct()
    {
        $this->config = parse_ini_file(__DIR__ . "/config/config.ini");
        $this->DB_HOST = $this->config['host'];
        $this->DB_NAME = $this->config['name'];
        $this->DB_USERNAME = $this->config['username'];
        $this->DB_PASSWORD = $this->config['password'];
    }
}

?>