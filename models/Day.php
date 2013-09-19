<?php

class Day {

    private $dayId;
    private $habitId;
    private $dayNumber;
    private $statusId;

    function __construct($dayId, $habitId, $dayNumber, $statusId){

        $this->dayId = $dayId;
        $this->habitId = $habitId;
        $this->dayNumber = $dayNumber;
        $this->statusId = $statusId;

    }


    function getDayId(){
        return $this->dayId;
    }


    function getHabitId(){
        return $this->habitId;
    }


    function getDayNumber(){
        return $this->dayNumber;
    }


    function getStatusId(){
        return $this->statusId;
    }
}

?>