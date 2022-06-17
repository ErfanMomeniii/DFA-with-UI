<?php
class state
{
    private $name;
    private $isFinalState = false;
    private $isStartState=false;
    private $relations=[];

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

    /**
     * @param state $state
     * @param $alphabet
     */
    public function addRelations(State $state,$alphabet){
        $this->relations[]=[$state->name=>$alphabet];
    }

    /**
     * @param state $state
     * @param $alphabet
     */
    public function deleteRelations(State $state,$alphabet){
        foreach ($this->relations as $index => $value){
            if(isset($value[$state])){
                if($value[$state]==$alphabet){
                    unset($this->relations[$index]);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getRelations()
    {
        return $this->relations;
    }
}