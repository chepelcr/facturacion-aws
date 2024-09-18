<?php

namespace Core\Errors;

class ApiError {
    private $code;

    private $message;

    public function __construct($code, $message) {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode() {
        return $this->code;
    }

    public function getMessage() {
        return $this->message;
    }
}