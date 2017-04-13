<?php
require __DIR__ . "/park_migration.php";

$truncateParks = "TRUNCATE national_parks;";
$dbc->exec($truncateParks);


$parks = [
	['name'=>'Acadia', 'location'=>'Maine', 'date_established'=>'1919-02-26', 'area_in_acres'=>'48995.91', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'American Samoa', 'location'=>'American Samoa', 'date_established'=>'1988-10-31', 'area_in_acres'=>'8256.67', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Arches', 'location'=>'Utah', 'date_established'=>'1971-11-12', 'area_in_acres'=>'76678.98', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Badlands', 'location'=>'South Dakota', 'date_established'=>'1978-11-10', 'area_in_acres'=>'242755.94', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Big Bend', 'location'=>'Texas', 'date_established'=>'1944-06-12', 'area_in_acres'=>'801163.21', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Biscayne', 'location'=>'Florida', 'date_established'=>'1980-06-28', 'area_in_acres'=>'172971.11', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Black Canyon of the Gunnison', 'location'=>'Colorado', 'date_established'=>'1999-10-21', 'area_in_acres'=>'30749.75', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Bryce Canyon', 'location'=>'Utah', 'date_established'=>'1928-02-25', 'area_in_acres'=>'35835.08', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Canyonlands', 'location'=>'Utah', 'date_established'=>'1964-09-12', 'area_in_acres'=>'337597.83', 'description'=>'a long time ago, in a galaxy far, far away'],
	['name'=>'Capitol Reef', 'location'=>'Utah', 'date_established'=>'1971-12-18', 'area_in_acres'=>'241904.26', 'description'=>'a long time ago, in a galaxy far, far away']
];


$stmt = $dbc->prepare("INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_established, :area_in_acres, :description)");

foreach ($parks as $park) {
    $stmt->bindValue(':name', $park['name'], PDO::PARAM_STR);
    $stmt->bindValue(':location', $park['location'], PDO::PARAM_STR);
    $stmt->bindValue(':date_established', $park['date_established'], PDO::PARAM_STR);
    $stmt->bindValue(':area_in_acres', $park['area_in_acres'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $park['description'], PDO::PARAM_STR);

    $stmt->execute();
}

	
?>
