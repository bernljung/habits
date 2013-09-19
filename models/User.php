<?php

include_once("DBAccessor.php");
include_once("Habit.php");
include_once("Day.php");

class User extends DBAccessor{

    function isLoggedIn(){
        if (isset($_SESSION['userid'])){
            return true;
        }
        return false;
    }


    function getLoggedInUserId(){
        if ($this->isLoggedIn()){
            return $_SESSION['userid'];
        }
        return 0;
    }


    function getHabitsByUserId($userId){
        $this->connectDb();

        $query = $this->mysqli->query("SELECT habitid, userid, habitname
                                        FROM Habits
                                        WHERE userid=$userId");

        $userHabits = array();
        while($row = $query->fetch_array(MYSQLI_ASSOC)){
            array_push($userHabits, new Habit($row["habitid"], $row["userid"],
                                                $row["habitname"]));
        }

        return $userHabits;
    }


    function getUserIdByEmail($email){
        $this->connectDb();

        $query = $this->mysqli->prepare("SELECT userid FROM Users
                                            WHERE email=?");
        $query->bind_param("s", $email);
        $query->execute();
        $query->bind_result($userId);
        $query->fetch();

        if ($userId == null){
            $query = $this->mysqli->prepare("INSERT INTO Users (email)
                                                VALUES (?)");
            $query->bind_param("s", $email);
            $query->execute();
            $userId = $this->mysqli->insert_id;
        }

        $this->closeDb();
        return $userId;
    }


    function getUserHabitByHabitId($habitId){

        // Get habit info
        $this->connectDb();

        $query = $this->mysqli->prepare("SELECT userid, habitname
                                            FROM Habits
                                            WHERE habitid=?");
        $query->bind_param("i", $habitId);
        $query->execute();
        $query->bind_result($userId, $habitName);
        $query->fetch();

        // Not your habit!
        if ($userId != $_SESSION['userid']){
            return false;
        }

        $this->closeDb();

        // Get Habit days info
        $this->connectDb();
        $query = $this->mysqli->query("SELECT dayid, habitid, daynumber, statusid
                                        FROM Days
                                        WHERE habitid=$habitId");

        $habitDays = array();
        while($row = $query->fetch_array(MYSQLI_ASSOC)){
            array_push($habitDays, new Day($row["dayid"], $row["habitid"],
                                            $row["daynumber"], $row["statusid"]));
        }

        $this->closeDb();

        $habit = new Habit($habitId, $userId, $habitName);
        $habit->setHabitDays($habitDays);
        return $habit;
    }


    function createUserHabit($habitName){

        // Insert habit
        $this->connectDb();

        $userId = $this->getLoggedInUserId();
        $query = $this->mysqli->prepare("INSERT INTO Habits (userid, habitname)
                                                VALUES (?,?)");
        $query->bind_param("is", $userId, $habitName);
        $query->execute();
        $habitId = $this->mysqli->insert_id;
        $this->closeDb();


        // Insert days for habit
        $this->connectDb();
        $query = $this->mysqli->prepare("INSERT INTO  Days (habitid, daynumber, statusid)
                                            VALUES (?, '1', '1'), (?,  '2',  '1'),
                                                (?,  '3',  '1'), (?,  '4',  '1'),
                                                (?,  '5',  '1'), (?,  '6',  '1'),
                                                (?,  '7',  '1'), (?,  '8',  '1'),
                                                (?,  '9',  '1'), (?,  '10',  '1'),
                                                (?,  '11',  '1'), (?,  '12',  '1'),
                                                (?,  '13',  '1'), (?,  '14',  '1'),
                                                (?,  '15',  '1'), (?,  '16',  '1'),
                                                (?,  '17',  '1'), (?,  '18',  '1'),
                                                (?,  '19',  '1'), (?,  '20',  '1'),
                                                (?,  '21',  '1')");


        // Clean up??
        // $params = array();
        // for (i=0; i<21; i++){
        //     array_push($params, $habitId);
        // }
        $query->bind_param("iiiiiiiiiiiiiiiiiiiii", $habitId, $habitId, $habitId,
                            $habitId, $habitId, $habitId, $habitId, $habitId,
                            $habitId, $habitId, $habitId, $habitId, $habitId,
                            $habitId, $habitId, $habitId, $habitId, $habitId,
                            $habitId, $habitId, $habitId);
        $query->execute();
        $this->closeDb();

        return $habitId;
    }


    function changeUserHabitDayStatus($dayId){

        // Get all available statuses
        $this->connectDb();
        $query = $this->mysqli->query("SELECT statusid, statusname
                                        FROM Status
                                        ORDER BY statusid ASC");

        $statusNames = array();
        $statusIds = array();
        while($row = $query->fetch_array(MYSQLI_ASSOC)){
            array_push($statusNames, $row['statusname']);
            array_push($statusIds, $row['statusid']);
        }
        $this->closeDb();

        // Get current status
        $this->connectDb();
        $query = $this->mysqli->prepare("SELECT statusid FROM Days
                                            WHERE dayid=?");
        $query->bind_param("i", $dayId);
        $query->execute();
        $query->bind_result($statusId);
        $query->fetch();
        $this->closeDb();

        // Calculate new status
        $currentIndex = array_search($statusId, $statusIds);
        $newStatusId = $statusIds[0];
        $newStatusIndex = 0;
        if (isset($statusIds[$currentIndex+1])){
            $newStatusId = $statusIds[$currentIndex+1];
            $newStatusIndex = $currentIndex+1;
        }

        // Update status in DB
        $this->connectDb();
        $query = $this->mysqli->prepare("UPDATE Days SET statusid=?
                                            WHERE dayid=?");

        $query->bind_param("ii", $newStatusId, $dayId);
        $query->execute();
        $this->closeDb();

        return $statusNames[$newStatusIndex];
    }

    function login($email){
        $_SESSION['userid'] = $this->getUserIdByEmail($email);
    }


    function logout(){
        unset($_SESSION['userid']);
    }


}