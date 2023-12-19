<?php

namespace Source;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class MailConfig {
    public $mailer;
    public $config;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->config = parse_ini_file(__DIR__ . "/config/config.ini");
        
        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = true;

        $this->mailer->Host = $this->config['mailer_Host'];

        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $this->config['mailer_Port'];
        $this->mailer->Username = $this->config['mailer_Username'];
        $this->mailer->Password = $this->config['mailer_Password'];

        $this->mailer->setFrom($this->config['mailer_Username']);
        $this->mailer->isHtml(true);
    }
}

?>