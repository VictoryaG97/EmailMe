<?php
    include dirname(__FILE__)."\..\config\db_connect.php";

    function insertQuery($table, $columns, $data){
        global $conn;
        $response = array();

        try {
            $query = 'INSERT INTO ' . $table . ' (' . implode(',', $columns) . ') VALUES (' . substr(str_repeat('?,', count($columns)), 0, -1) . ')';
            $stmt = $conn->prepare($query);
            $response["status"] = true;
            $response["queryResponse"] = $stmt->execute($data);
        } catch (Exception $e) {
            $response["status"] = false;
            $response["queryResponse"] = "";
            $response["error"] = $e->getMessage();
        }
        return $response;
    }

    function selectWhereQuery($table, $column, $value) {
        global $conn;
        try {
            $query = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = ?';
            $stmt = $conn->prepare($query);
            $stmt->execute([$value]);

            $result = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    function selectAndWhereQuery($table, $column, $value) {
        global $conn;
        try {
            $query = 'SELECT * FROM ' . $table . ' WHERE ' . $column[0] . ' = ? AND ' . $column[1] . ' = ?';
            $stmt = $conn->prepare($query);
            $stmt->execute($value);

            $result = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

?>