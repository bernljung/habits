<?php

class DBAccessor{

    protected $mysqli = null;


    function connectDb(){
        $conf = parse_ini_file("config.php", true);
        $this->mysqli = new mysqli(
                        $conf['database']['db_host'],
                        $conf['database']['db_username'],
                        $conf['database']['db_password'],
                        $conf['database']['db_name']);
    }


    function closeDb(){
        $this->mysqli->close();
        $this->mysqli = null;
    }
}