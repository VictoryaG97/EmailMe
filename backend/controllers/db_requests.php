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

    function selectAndWhereQuery($table, $columns, $values) {
        global $conn;

        $f = function($value) { return $value . ' = ?'; };
        $whereClause = array_map($f, $columns);
        $query = $conn->prepare('SELECT * FROM ' . $table . ' WHERE ' . implode(' AND ', $whereClause));
        $query->execute($values);
        $result = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            array_push($result, $row);
        }
        return $result;
        // try {
        //     // $query = 'SELECT * FROM ' . $table . ' WHERE ( ' . $column[0] . ' = :v1 ) AND (' . $column[1] . ' = :v2 )';
        //     // $query = 'SELECT * FROM mail_box WHERE ( owner_id = 2 ) AND ( type = 1)';
        //     $stmt = $conn->prepare("SELECT * FROM mail_box WHERE owner_id = 2 AND box_type = 1");
        //     // $stmt->execute(array(":v1" => $value[0], ":v2" => $value[1]));
        //     $stmt->execute();

        //     $result = [];
        //     while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //         $result[] = $row;
        //     }
        //     return $result;
        // } catch (Exception $e) {
        //     http_response_code(500);
        //     echo json_encode(array(
        //         "message" => "Error",
        //         "error" => $e->getMessage()
        //     ));
        // }
    }

?>