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
   
?>
