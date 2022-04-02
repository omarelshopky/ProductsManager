<?php
abstract class Model 
{
    /**
     * Automates insert new records
     * 
     * @param string $tablename to be inserted in
     * @param array $data to be inserted containing the attributes for this table
     * 
     * @return bool the status of the insertion process
     */
    protected function insert($tablename, $data) {

        $attributes = $tablename::$attributes;
        
        if (in_array("id", array_keys($data), true)) 
            array_push($attributes, "id");

        $sql = "INSERT INTO " . strtolower($tablename) . " (" . join(", ", $attributes) . ") VALUES (:". join(", :", $attributes) . ")";

        $req = Database::getBdd()->prepare($sql);

        // Create associative array of attributes
        $submited = array();
        foreach ($attributes as $attribute) {
            $submited[$attribute] = $data[$attribute];
        }

        return $req->execute($submited);
    }
}
?>