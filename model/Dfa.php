<?php
class Dfa
{
    public $alphabet = [];
    public $states = [];

    /**
     * @return array
     */
    public function getAlphabet()
    {
        return $this->alphabet;
    }

    /**
     * @param array $alphabet
     */
    public function setAlphabet($alphabet)
    {
        $this->alphabet = $alphabet;
    }

    /**
     * @return array
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param array $states
     */
    public function setStates($states)
    {
        $this->states = $states;
    }

    /**
     * @param State $state
     */
    public function addState(State $state){
        $this->states[]=$state;
    }

    /**
     * @param String $alphabet
     */
    public function addAlphabet($alphabet){
        $this->alphabet[]=$alphabet;
    }
}
?>
