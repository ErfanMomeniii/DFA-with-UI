<?php

require ('../model/Dfa.php');
require ('StateImpl.php');
require('../exception/InvalidDfa.php');

class DfaImpl{
    /**
     * @throws InvalidDfa
     */
    public static function checkValid(Dfa $dfa){
        $states=$dfa->getStates();
        $alphabet=$dfa->getAlphabet();

        $relation_count=0;

        if((!self::hasStartState($dfa)) || (!self::hasFinalState($dfa)) || (self::hasSeveralStartState($dfa))){
            $e=(new InvalidDfa());
            $e->setMessage('YOUR DFA HAS PROBLEM');
            throw $e;
        }

        foreach ($states as $index => $value){
            $relation_count+=StateImpl::countRelations($value);
        }

        if($relation_count != count($alphabet) * count($states)){
             $e=(new InvalidDfa());
             $e->setMessage('YOUR DFA HAS NOT SPECIFIC COUNT FOR ALPHABET');
             throw $e;
        }

        foreach($states as $index => $value){
            if(!StateImpl::checkAlphabetsExists($value,$alphabet)){
                $e=(new InvalidDfa());
                $e->setMessage('AT LEAST ONE NODE NOT HAVE ALL ALPHABET');
                throw $e;
            }
        }
    }
    /**
     * @return bool
     */
    public static function dfs(Dfa $dfa,State $root,$count,$word){
        if($count==strlen($word) && $root->isFinalState()){
            return true;
        }
        if($count==strlen($word)){
            return false;
        }

        $currentChar=substr($word,$count,1);
        $relations=$root->getRelations();

        foreach ($relations as $index => $value){

            foreach ($value as $state => $alphabet) {
                if($alphabet===$currentChar){
                    return self::dfs($dfa,self::findStateByName($dfa,$state),$count+1,$word);
                }
            }
        }
        return false;
    }
    /**
     * @return State
     */
    public static function findStateByName(Dfa $dfa,$name){
        foreach ($dfa->getStates() as $index => $state){
            if($state->getName()===$name){
                return $state;
            }
        }
        return null;
    }
    /**
     * @return bool
     */
    public static function checkWordExists(Dfa $dfa, $word){
        return self::dfs($dfa,self::getStartState($dfa),0,$word);
    }
    /**
     * @return bool
     */
    public static function hasStartState(Dfa $dfa){
        foreach ($dfa->getStates() as $index => $state){
            if($state->isStartState()){
                return true;
            }
        }
        return false;
    }
    /**
     * @return bool
     */
    public static function hasFinalState(Dfa $dfa){
        foreach ($dfa->getStates() as $index => $state){
            if($state->isFinalState()){
                return true;
            }
        }
        return false;
    }
    /**
     * @return bool
     */
    public static function hasSeveralStartState(Dfa $dfa){
        $startState=[];
        foreach ($dfa->getStates() as $index => $state){
            if($state->isStartState()){
                $startState[]=$state;
            }
        }

        if(count($startState)>1){
            return true;
        }
        return false;
    }
    /**
     * @return State
     */
    public static function getStartState(Dfa $dfa){
        if(!self::hasStartState($dfa)){
            return null;
        }
        $states=$dfa->getStates();
        foreach ($states as $index => $state){
            if($state->isStartState()){
                return $state;
            }
        }
    }
}