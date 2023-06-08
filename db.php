<?php
class DB {

    private $servername = "localhost";
    private $username = "root";
    private $password = "123";
    public $name = 'test-blog';

    
    public $conn;

    function setConnection() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->name);
    }
}