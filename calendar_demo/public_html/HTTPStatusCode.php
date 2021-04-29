<?php
class HTTPStatusCode {
    public function __construct($code, $msg)
    {
        http_response_code($code);
        echo $msg;
        exit();
    }
}
?>