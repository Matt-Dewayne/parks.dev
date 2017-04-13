<?php
require __DIR__ . '/db_connect.php' ;
require __DIR__ . "/../Input.php";

// protect from looking at blank pages past the number of results
# of results / limit to get number of total pages, round up
function getLastPage($dbc, $limit) {
	$statement = $dbc->query("SELECT count(*) from national_parks");
	$count = $statement->fetch()[0]; // to get the count
	$lastPage = ceil($count / $limit);
	return $lastPage;
}

function getPaginatedParks($dbc, $page, $limit) {
	$offset = ($page - 1) * $limit;

	$statement = $dbc->prepare('SELECT * FROM national_parks LIMIT :limit OFFSET :offset');
	$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
	$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
	$statement->execute();
	
	return $statement->fetchAll(PDO::FETCH_ASSOC); 
}

function handleOutOfRangeRequests($page, $lastPage) {
	// protect from looking at negative pages, too high pages, and non-numeric pages
	if($page < 1 || !is_numeric($page)) {
		header("location: national_parks.php?page=1");
		die;
	} else if($page > $lastPage) {
		header("location: national_parks.php?page=$lastPage");
		die;
	}
}

function pageController($dbc) {

	$data = [];
	
	$limit = 4;
	$page = Input::get('page', 1);

	$lastPage = getLastPage($dbc, $limit);

	handleOutOfRangeRequests($page, $lastPage);

	$data['parks'] = getPaginatedParks($dbc, $page, $limit);
	$data['page'] = $page;
	$data['lastPage'] = $lastPage;

	return $data;
}

extract(pageController($dbc));


if ($_POST) {
	$insert = "INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (:name, :location, :date_established, :area_in_acres, :description)";
	$statement = $dbc->prepare($insert);
    $statement->bindValue(':name', htmlspecialchars(strip_tags(Input::get("parkName"))), PDO::PARAM_STR);
    $statement->bindValue(':location', htmlspecialchars(strip_tags(Input::get("parkLocation"))), PDO::PARAM_STR);
    $statement->bindValue(':date_established', htmlspecialchars(strip_tags(Input::get("parkDate"))), PDO::PARAM_STR);
    $statement->bindValue(':area_in_acres', htmlspecialchars(strip_tags(Input::get("parkArea"))), PDO::PARAM_STR);
    $statement->bindValue(':description', htmlspecialchars(strip_tags(Input::get("parkDesc"))), PDO::PARAM_STR);

    $statement->execute();
    header("location: national_parks.php?page=$lastPage");
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>National Parks</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Amatica+SC|Averia+Gruesa+Libre|Frijole|Oldenburg|Stalinist+One|Trade+Winds" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/national_parks.css">
</head>
<body>

	<h2>National Parks</h2>

	<form method="GET">	
		<ul class="pagination">
			<li><a <?php if ($page <= 1): ?>style="color: grey;"<?php endif; ?> href="/national_parks.php?page=<?=$page-1?>">Previous</a><li>
			<li><a <?php if ($page >= $lastPage): ?>style="color: grey;"<?php endif; ?> href="/national_parks.php?page=<?=$page+1?>">Next</a><li>
		</ul>
	</form>

	<div id="table">
		<table class="table table-hover table-responsive">
			<tr>
				<th>Name</th>
				<th>Location</th>
				<th>Date Established</th>
				<th>Area in Acres</th>
				<th>Description</th>
			</tr>
			<?php foreach($parks as $park): ?>
				<tr>
					<td><?= $park['name']?></td>
					<td><?= $park['location']?></td>
					<td><?= $park['date_established']?></td>
					<td><?= $park['area_in_acres']?></td>
					<td><?= $park['description']?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>

	<!-- Trigger the modal with a button -->
	<a type="button" href="" data-toggle="modal" data-target="#createNewPark"><i class="fa fa-plus"></i>Add New Park</a>



	<!-- Adding New Park Modal -->
	<div id="createNewPark" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Adding New Park</h4>
				</div>
				<div class="modal-body">
					<form  method="POST">
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label for="parkName">Park Name</label>
								<input type="text" class="form-control" placeholder="Park Name" name="parkName" id="parkName" required data-validation-required-message="Please enter the park name.">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label for="parkLocation">Park Location</label>
								<input type="text" class="form-control" placeholder="Park Location" name="parkLocation" id="parkLocation" required data-validation-required-message="Please enter the park location.">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label for="parkDate">Date Established</label>
								<input type="date" class="form-control" placeholder="YYYY-MM-DD" name="parkDate" id="parkDate" required data-validation-required-message="Please enter the date the park was established.">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label for="parkArea">Area in Acres</label>
								<input type="text" class="form-control" placeholder="ex: 1111.11" name="parkArea" id="parkArea" required data-validation-required-message="Please enter the park's area in acres.">
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="row control-group">
							<div class="form-group col-xs-12 floating-label-form-group controls">
								<label for="parkDesc">Park Description</label>
								<textarea rows="4" class="form-control" placeholder="Park Description" name="parkDesc" id="parkDesc" required data-validation-required-message="Please enter a description of the park."></textarea>
								<p class="help-block text-danger"></p>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-default btn-success">Add Park</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


<script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8yU5lRs-GOxQhZ7boYDTdveBQds32R0c"></script>
<script type="text/javascript" src="/js/national_parks.js"></script>
</body>
</html>