<?php
class mySqlRepo {
    private $db;
    private $table;
    function setDB($db) {
        $this->db = $db;
    }
    function setTable($table) {
        $this->table = $table;
    }

    function createRow($model) {
        function addQuotes($str) {
            return '"'.$str.'"';
        }
        $fields = implode(', ', array_keys((array)$model));
        $values = implode(', ', array_map('addQuotes', array_values((array)$model)));


        $this->db->conn->query('INSERT INTO '.$this->table.'('.$fields.') VALUES ('.$values.');');

        $id = mysqli_insert_id($this->db->conn);

        return $this->getByID($id);
    }
    function deleteRow($id) {
        $this->db->conn->query('DELETE FROM '.$this->table.' WHERE id='.$id.';');
    }

    function getAllRows($limit=100, $offset=0) {
        $response = [];
        $rows = $this->db->conn->query('SELECT * FROM '.$this->table.' ORDER BY id DESC LIMIT '.$limit.' OFFSET '.$offset);
        while ($row = $rows->fetch_object()) {
            array_push($response, $row);
        }

        return $response;
    }

    function getByID($id) {
        return $this->db->conn->query('SELECT * FROM '.$this->table.' WHERE id='.$id.'')->fetch_object();
    }

    function updateById($model) {

        function addValue($field) {
            global $model;
            return ''.$field.'="'.$model->$field.'"';
        }
        $pairs =[];
        $fields = implode(', ', array_keys((array)$model));
        foreach (array_keys((array)$model) as $field) {
            array_push($pairs, ''.$field.'="'.$model->$field.'"');
        }
        
        $pairs = implode(', ', $pairs);


        return $this->db->conn->query('UPDATE '.$this->table.' SET '.$pairs.' WHERE id='.$model->id.'');
    }

    function selectWithFilters($filters) {
        function addQuotes($str) {
            return '"'.$str.'"';
        }

        $fields = implode(', ', array_keys((array)$filters));
        $values = implode(', ', array_map('addQuotes', array_values((array)$filters)));
        return $this->db->conn->query('SELECT * FROM '.$this->table.' WHERE ('.$fields.') = ('.$values.');')->fetch_object();
    }

    function selectAllByFilters($filters) {
        function addQuotes($str) {
            return '"'.$str.'"';
        }

        $fields = implode(', ', array_keys((array)$filters));
        $values = implode(', ', array_map('addQuotes', array_values((array)$filters)));
        $response = [];
        $rows = $this->db->conn->query('SELECT * FROM '.$this->table.' WHERE ('.$fields.') = ('.$values.');');
        while ($row = $rows->fetch_object()) {
            array_push($response, $row);
        }

        return $response;
    }
}
// CREATE TABLE `test_blogs`.`users` (
//    `id` INT NOT NULL AUTO_INCREMENT,
//    `login` VARCHAR(45) NOT NULL,
//    `name` VARCHAR(100) NOT NULL,
//    `password` VARCHAR(45) NOT NULL,
//    PRIMARY KEY (`id`),
//    UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
//    UNIQUE INDEX `login_UNIQUE` (`login` ASC) VISIBLE);

// INSERT INTO `bruh-app`.`users-tmp` (login, name, password) VALUES ('asd', 'ASd asd', '1234');

    
// CREATE TABLE `test_blogs`.`posts` (
//     `id` INT NOT NULL AUTO_INCREMENT,
//     `title` VARCHAR(100) NOT NULL,
//     `text` TEXT(1000) NOT NULL,
//     `userId` VARCHAR(45) NULL,
//     `userName` VARCHAR(45) NOT NULL,
//     `likesCount` INT NULL DEFAULT 0,
//     UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
//     PRIMARY KEY (`id`)); 


// CREATE TABLE `test_blogs`.`comments` (
//     `id` INT NOT NULL AUTO_INCREMENT,
//     `text` TEXT(1000) NOT NULL,
//     `userId` VARCHAR(45) NOT NULL,
//     `userName` VARCHAR(45) NOT NULL,
//     PRIMARY KEY (`id`));
   
?>
