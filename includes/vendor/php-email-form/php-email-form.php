<?php

class PHP_Email_Form {
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $smtp = [];
    public $ajax = false;
    private $messages = [];

    public function add_message($content, $label, $priority = 0) {
        $this->messages[] = [
            'content' => $content,
            'label' => $label,
            'priority' => $priority
        ];
    }

    public function send() {
        $email_content = "";
        foreach ($this->messages as $message) {
            $email_content .= $message['label'] . ": " . $message['content'] . "\n";
        }

        $headers = "From: " . $this->from_name . " <" . $this->from_email . ">\r\n";
        $headers .= "Reply-To: " . $this->from_email . "\r\n";

        if (!empty($this->smtp)) {
            return $this->send_via_smtp($email_content, $headers);
        } else {
            return mail($this->to, $this->subject, $email_content, $headers);
        }
    }

    private function send_via_smtp($email_content, $headers) {
        // Example SMTP implementation (you can replace this with PHPMailer or similar)
        // This is a placeholder and should be replaced with a proper SMTP library.
        return false; // SMTP functionality not implemented in this example.
    }
} 

?>
