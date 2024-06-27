<?php
// Database connection 
include "database/db.php";

// start session
session_start();

$site = $_GET['site'];

// Retrieve and transform content from the database
$dibanda = getStaticContent($conn, 'visite.php', 'dibanda');
$concorde = getStaticContent($conn, 'visite.php', 'concorde');
$gecamine = getStaticContent($conn, 'visite.php', 'gecamine');

// TODO: Query the database to get available timeslots for the chosen site.

// Clode database connection
$conn->close();

?>

<!DOCTYPE html>
<html>

<head>
	<!-- Canonical link -->
	<link rel="canonical" href="https://lareconnaissance.com/visite.php">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Required meta tags, favicon, and CSS -->
	<?php include 'Includes/head.php'; ?>
	<!-- Title -->
	<title>Visite | Complexe Scolaire la Reconnaissance</title>
</head>

<body>
	<!-- Navigation bar -->
	<?php include 'includes/navbar.php'; ?>

	<!-- Header -->
	<!-- Schedule a Site Visit Header -->
	<header class="bg-light text-center py-5">
		<h1 class="display-4 headingColor">Planifiez une Visite a <?php echo htmlspecialchars($site); ?></h1>
	</header>

	<main class="container-fluid mt-5">

		<div class="row align-items-md-stretch">
			<!-- Locations -->
			<div class="col-md-6">
				<!-- Dynamic Introduction -->
				<?php
				switch ($site) {
					case "Dibanda": ?>
						<div class='building-dibanda h-100 p-5 text-bg-dark rounded-3'>
							<h2><?= htmlspecialchars($dibanda['heading']) ?></h2>
							<p><?= htmlspecialchars($dibanda['texts'][0]) ?></p>
						</div>
					<?php break;

					case "Concorde": ?>
						<div class='building-concorde h-100 p-5 text-bg-dark rounded-3'>
							<h2><?= htmlspecialchars($concorde['heading']) ?></h2>
							<p><?= htmlspecialchars($concorde['texts'][0]) ?></p>
						</div>
					<?php break;

					case "Gecamine": ?>
						<div class='building-gecamine h-100 p-5 text-bg-dark rounded-3'>
							<h2><?= htmlspecialchars($gecamine['heading']) ?></h2>
							<p><?= htmlspecialchars($gecamine['texts'][0]) ?></p>
						</div>
				<?php break;
				} ?>
			</div>
			<!-- Form -->
			<div class="col-md-6">
				<!-- Available Timeslots -->
				<!-- TODO: Populate this section from the database -->
				<!-- Personal Information Form -->
				<!-- TODO: Add server-side validation -->
				<form id="myForm" action="enregistrer_visite.php" method="post">
					<div id="timeslots">
						<h2 class="headingColor">Disponibilite</h2>
					</div>
					<!-- Date Picker -->
					<label for="visitDate">Select Date:</label>
					<input type="date" id="visitDate" name="visitDate" required>

					<label for="name" data-original-text="Nom">Name:</label>
					<input type="text" id="name" name="name" required>

					<label for="email" data-original-text="Email">Email:</label>
					<input type="email" id="email" name="email" placeholder="example@example.com" required>

					<label for="phone" data-original-text="Phone">Phone:</label>
					<input type="tel" id="phone" name="phone" placeholder="+243 xxx-xxx-xxx" required>

					<input id="finish" type="submit" value="Schedule Visit">
				</form>

				<!-- Confirmation Message -->
				<div id="confirmation"></div>

			</div>
		</div>



	</main>

	<!-- Footer -->
	<?php include "includes/footer.php"; ?>
	<!--Back_to_top_button-->
	<?php include "includes/back_to_top.php"; ?>
	<!-- Scripts -->
	<?php include "includes/scripts.php"; ?>

</body>

</html>