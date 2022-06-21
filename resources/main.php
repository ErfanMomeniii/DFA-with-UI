<?php
require ("../handler/DfaImpl.php");
if(isset($_POST['word'])){

    $currentDfa=new Dfa();
    $states=json_decode($_POST['states']);
    $dfa_states=[];
    $alphabets=[];
    foreach ($states as $state){
        $dfa_states[]=new State($state->label,isset($state->isFinal)?$state->isFinal:false,
            isset($state->isInitial)?$state->isInitial:false,[]);
    }
    $transitions=json_decode($_POST['transitions']);
    foreach ($transitions as $transition){
        $from_state='';
        $to_state='';
        foreach ($dfa_states as $state){
            if($transition->from==$state->getName()){
                $from_state=$state;
            }
            if($transition->to==$state->getName()){
                $to_state=$state;
            }
        }
        $from_state->addRelations($to_state,$transition->label);
        $hasAlphabet=false;
        foreach ($alphabets as $alphabet){
            if($alphabet==$transition->label){
                $hasAlphabet=true;
            }
        }
        if(!$hasAlphabet){
            $alphabets[]=$transition->label;
        }
    }
    $currentDfa->setStates($dfa_states);
    $currentDfa->setAlphabet($alphabets);
    try {
        DfaImpl::checkValid($currentDfa);
        $answer=[];
        for($i=0;$i<strlen($_POST['word']);$i++){
            for($j=1;$j<=strlen($_POST['word'])-$i;$j++){
                if(DfaImpl::checkWordExists($currentDfa,substr($_POST['word'],$i,$j))){
                    if(count($answer)==0){
                        $answer[]=substr($_POST['word'],$i,$j);
                    } else if(strlen($answer[count($answer)-1])<$j){
                        $answer=[substr($_POST['word'],$i,$j)];
                    }else if(strlen($answer[count($answer)-1])==$j){
                        $answer[]=substr($_POST['word'],$i,$j);
                    }
                }
            }
        }
    }catch (Exception $e){
        $error=$e->getMessage();
    }
}
include 'template.php';