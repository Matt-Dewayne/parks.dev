<?php

class Park
{
    /*** our connection to the database */
    public static $dbc = null;


    /*** establish a database connection if we do not have one */
    public static function dbConnect() {
        if (! is_null(self::$dbc)) {
            return;
        }
        self::$dbc = require 'database/db_connect.php';
    }


    /*** returns the number of records in the database */
    public static function count() {
        self::dbConnect();
        $connect = self::$dbc->query("Select count(*) from national_parks");
        $count = $connect->fetch()[0];
        return $count;
    }


    /*** returns all the records*/
    public static function all() {
        self::dbConnect();
        $parks = self::$dbc->query("Select * from national_parks");
        $parkArray = [];
        foreach ($parks as $park) {
            $singlePark = new Park();
            $singlePark->id = $park['id'];
            $singlePark->name = $park['name'];
            $singlePark->location = $park['location'];
            $singlePark->dateEstablished = $park['date_established'];
            $singlePark->areaInAcres = $park['area_in_acres'];
            $singlePark->description = $park['description'];
            array_push($parkArray, $singlePark);
        }
        return $parkArray;
    }


    /*** returns $resultsPerPage number of results for the given page number */
    public static function paginate($pageNo, $resultsPerPage = 4) {
        self::dbConnect();
        $offset = ($pageNo - 1) * $resultsPerPage;
        $statement = self::$dbc->prepare('SELECT * FROM national_parks LIMIT :limit OFFSET :offset');
        $statement->bindValue(':limit', $resultsPerPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $parks = $statement->fetchAll(PDO::FETCH_ASSOC); 
    }


    /*** properties that represent columns from the databases */
    public $id;
    public $name;
    public $location;
    public $dateEstablished;
    public $areaInAcres;
    public $description;


    /*** inserts a record into the database */
    public function insert() {
        self::dbConnect();
        $insertNewPark = "INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_established, :area_in_acres, :description)";
        $statement = self::$dbc->prepare($insertNewPark);
        $statement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $statement->bindValue(':location', $this->location, PDO::PARAM_STR);
        $statement->bindValue(':date_established', $this->dateEstablished, PDO::PARAM_STR);
        $statement->bindValue(':area_in_acres', $this->areaInAcres, PDO::PARAM_STR);
        $statement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $statement->execute();
        $this->id = self::$dbc->lastInsertId();
    }
}
