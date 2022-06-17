<?php
class State
{
    private $name;
    private $isFinalState = false;
    private $isStartState=false;

    /**
     * @return bool
     */
    public function isFinalState()
    {
        return $this->isFinalState;
    }

    /**
     * @param bool $isFinalState
     */
    public function setIsFinalState($isFinalState)
    {
        $this->isFinalState = $isFinalState;
    }

    /**
     * @return bool
     */
    public function isStartState()
    {
        return $this->isStartState;
    }

    /**
     * @param bool $isStartState
     */
    public function setIsStartState($isStartState)
    {
        $this->isStartState = $isStartState;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}