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

        $sql = "INSERT INTO " . $tablename . " (" . join(", ", array_keys($data)) . ") VALUES (:". join(", :", array_keys($data)) . ")";

        $req = Database::getBdd()->prepare($sql);

        return $req->execute($data);
    }
}
?>