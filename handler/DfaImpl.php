<?php
require ('../model/Dfa.php');
require ('../model/State.php');
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
        foreach ($states as $index => $value){
            $relation_count+=StateImpl::countRelations($value);
        }
        if($relation_count != count($alphabet) * count($states)){
            throw new InvalidDfa();
        }
        foreach($states as $index => $value){
            if(!StateImpl::checkAlphabetsExists($value,$alphabet)){
                throw new InvalidDfa();
            }
        }
    }
}