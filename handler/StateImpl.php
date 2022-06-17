<?php
require('../model/State.php');

class StateImpl
{
    /**
     * @return int
     */
    public static function countRelations(State $state)
    {
        $count = 0;
        foreach ($state->getRelations() as $index => $value) {
            foreach ($value as $index2 => $value2) {
                if ($state->getName() == $index2) {
                    $count += 2;
                } else {
                    $count++;
                }
            }
        }
        return $count;
    }
    /**
     * @return bool
     */
    public static function checkAlphabetsExists(State $state, $alphabet)
    {
        if (count($alphabet) != count($state->getRelations())) {
            return false;
        }
        foreach ($alphabet as $index => $value) {
            $exists = false;
            foreach ($state->getRelations() as $index2 => $value2) {
                foreach ($value2 as $index3 => $value3) {
                    if ($value3 == $value) {
                        $exists = true;
                        break;
                    }
                }
                if ($exists) {
                    break;
                }
            }
            if (!$exists) {
                return false;
            }
        }
        return true;
    }
}