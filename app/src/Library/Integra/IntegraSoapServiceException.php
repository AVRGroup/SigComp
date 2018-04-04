<?php

namespace App\Library\Integra;

class IntegraSoapServiceException
{

    /**
     * @var string $userMessage
     */
    protected $userMessage = null;

    /**
     * @var string $message
     */
    protected $message = null;


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getUserMessage()
    {
        return $this->userMessage;
    }

    /**
     * @param string $userMessage
     * @return \App\Library\Integra\IntegraSoapServiceException
     */
    public function setUserMessage($userMessage)
    {
        $this->userMessage = $userMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return \App\Library\Integra\IntegraSoapServiceException
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

}
