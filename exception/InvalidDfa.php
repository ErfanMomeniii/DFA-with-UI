<?php
class InvalidDfa extends Exception{

    protected $message='your dfa has problem';
    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

}