<?php
class Database
{
    
    public function selectFromTable($fields, $table, $where = '', $limit = '', $orderBy = '', $multiselect = false)
    {
        $sql = 'SELECT ';
        $sql .=  $fields;
        $sql .= ' FROM ';
        $sql .= $table;
        
        $sql .= ' WHERE deleted=0 ';
        if ($where != '') {
            $sql .= ' AND ';
            $sql .= $where;
        }
        
        if ($orderBy != '') {
            $sql .= ' ORDER BY ';
            $sql .= $orderBy;
        }
        
        if ($limit != '') {
            $sql .= ' LIMIT ';
            $sql .= $limit;
        }
        
        $result = Connection::connect()->prepare($sql);
        $result->execute();
        
        if ($multiselect) {
            $return = $result->fetchAll();
        } else {
            $return = $result->fetch();
        }
        
        return $return;
    }
    
    public function insertIntoTable($values, $table)
    {
        $_keys = array();
        $_values = array();
        
        foreach ($values as $key=>$value) {
            $_keys[] = "`$key`";
            
            if (is_numeric($value)) {
                $_values[] = $value;
            } else if (is_bool($value)) {
                if ($value) {
                    $_values[] = 1;
                } else {
                    $_values[] = 0;
                }
            } else {
                $_values[] = "'$value'";
            }
        }
        
        $sql = 'INSERT INTO ' . $table . ' ';        
        
        $sql .= '(' . implode(', ', $_keys) . ')';
        $sql .= ' VALUES ';
        $sql .= '(' . implode(', ', $_values) . ')';
        
        $result = Connection::connect()->prepare($sql);
        $result->execute();
        
        return Connection::connect()->lastInsertId();
    }
    
    public function updateTable($values, $table, $where, $limit = 0)
    {
        $_update = array();
        
        foreach ($values as $key=>$value) {
            $_key = "`$key`";
        
            if (is_numeric($value)) {
                $_value = $value;
            } else if (is_bool($value)) {
                if ($value) {
                    $_value = 1;
                } else {
                    $_value = 0;
                }
            } else {
                $_value = "'$value'";
            }
            
            $_update[] = $_key .'='.$_value;
        }
        
        $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $_update) . ' WHERE deleted != 1 AND '. $where;
    
        if ($limit != 0) {
            $sql .= ' LIMIT ' . $limit;
        }
    
        $result = Connection::connect()->prepare($sql);
        $result->execute();
    }
    
    public function deleteRow($table, $where, $limit = 0)
    {
        $sql = 'UPDATE ' . $table . ' SET deleted = 1 WHERE deleted != 1 AND '. $where;
        
        if ($limit != 0) {
            $sql .= ' LIMIT ' . $limit;
        }
        
        $result = Connection::connect()->prepare($sql);
        $result->execute();
    }
}