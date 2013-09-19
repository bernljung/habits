<?php

class Habit {

    private $habitId;
    private $userId;
    private $habitName;
    private $habitDays;

    function __construct($habitId, $userId, $habitName){

        $this->habitId = $habitId;
        $this->userId = $userId;
        $this->habitName = $habitName;

    }


    function getHabitId(){
        return $this->habitId;
    }


    function getUserId(){
        return $this->userId;
    }


    function getHabitName(){
        return $this->habitName;
    }


    function getHabitDays(){
        return $this->habitDays;
    }

    function setHabitDays($days){
        $this->habitDays = $days;
    }
}

?>