<?php
// Database connection 
include "database/db.php";

// start session
session_start();

// Retrieve and transform content from the database
$page_info = getStaticContent($conn, 'admission-au-complexe-scolaire-la-reconnaissance.php', 'header');
$introduction = getStaticContent($conn, 'admission-au-complexe-scolaire-la-reconnaissance.php', 'introduction');
$admissionConditions = getStaticContent($conn, 'admission-au-complexe-scolaire-la-reconnaissance.php', 'conditions');

$levels = ['Maternelle' => 1, 'Primaire' => 2, 'Secondaire' => 3, 'Humanite' => 4];
$conditions = [];
$schools = [];

foreach ($levels as $level => $id) {
	$schoolDetails = getSchoolDetails($conn, $id);
	$conditions[$level] = [
		'conditions' => getAdmissionConditions($conn, $id),
		'more' => $schoolDetails['conditions'],
		'image' => getStaticContent($conn, 'admission-au-complexe-scolaire-la-reconnaissance.php', strtolower($level))['images'][0],
	];
	$schools[$level] = [
		'classes' => $schoolDetails['classes']
	];
}

$options = getOptions($conn);

// Clode database connection
$conn->close();

// Mock-up data
?>

<!doctype html>
<html lang="fr">

<head>
	<!-- Cannonical link -->
	<link rel="canonical" href="https://lareconnaissance.com/admission-au-complexe-scolaire-la-reconnaissance.php">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Required meta tags, favicon, and CSS -->
	<?php include 'Includes/head.php'; ?>
	<!-- Title -->
	<title>Admission | Complexe Scolaire la Reconnaissance</title>
</head>

<body>

	<!-- Navigation bar -->
	<?php include 'Includes/navbar.php'; ?>

	<!--Header-->
	<header class="jumbotron-fluid heroAdmission">
		<div class="container welcome text-white">
			<h1><?= htmlspecialchars($page_info['heading']) ?></h1>
			<p class="lead"><?= htmlspecialchars($page_info['texts'][0]) ?></p>
		</div>
	</header>

	<!-- Main Content Area -->
	<main class="container-fluid mt-5">
		<!-- Introduction -->
		<h2 class="headingColor text-center"><?= htmlspecialchars($introduction['heading']) ?></h2>
		<p class="introductionText lead"><?= htmlspecialchars($introduction['texts'][0]) ?></p>
		<hr class="my-5">
		<!-- Conditions -->
		<h2 class="headingColor text-center tablet-desktop"><?= htmlspecialchars($admissionConditions['heading']) ?></h2>
		<p class="introductionText text-center lead"><?= htmlspecialchars($admissionConditions['texts'][0]) ?></p>
		<!-- Cycle buttons -->
		<div class="cycleButtons">
			<?php foreach ($conditions as $cycle => $details): ?>
				<button class='button-rounded' value='<?= htmlspecialchars($cycle) ?>' onclick='displayConditions("<?= htmlspecialchars($cycle) ?>")'><?= htmlspecialchars($cycle) ?></button>
			<?php endforeach; ?>
		</div>

		<br>

		<?php foreach ($conditions as $cycle => $details) : ?>
			<div id="<?= htmlspecialchars($cycle) ?>" class='row align-items-md-stretch' style='display: none;'>
				<div class='col-md-6 tablet-desktop'>
					<?php if ($details['image'] !== null) : ?>
						<img class="<?= htmlspecialchars($details['image']['class']) ?>" src="<?= htmlspecialchars($details['image']['src']) ?>" alt="<?= htmlspecialchars($details['image']['alt']) ?>">
					<?php endif; ?>
				</div>
				<div class='col-md-6'>
					<h3 class='headingColor fw-normal'><?= htmlspecialchars($cycle) ?></h3>
					<?php if ($details['conditions'] !== null && $details['more']) : ?>
						<ul>
							<?php for ($i = 0; $i < count($details["conditions"]); $i++) : ?>
								<li class='important'><?= htmlspecialchars($details['conditions'][$i]) ?></li>
							<?php endfor; ?>
							<li style='list-style-type: none;'>
								<div class='dropdown'>
									<p><a class='dropdownColorBackground btn'>Voir les details &raquo;</a></p>
									<div class='dropdown-content'>
										<p><?= htmlspecialchars($details['more']) ?></p>
									</div>
								</div>
							</li>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

		<hr class="my-5 tablet-desktop">

		<!-- Application form -->
		<h2 class="headingColor text-center tablet-desktop">Inscrivez vous:</h2>
		<form action="mailto:assakagracia@gmail.com" id="myForm" method="post" enctype="text/plain">
			<label for="name" data-original-text="Nom">Nom</label>
			<input type="text" name="name" id="name" placeholder="First and last name" required>

			<label for="birthdate" data-original-text="Né(e) le">Né(e) le</label>
			<input type="date" name="birthdate" id="birthdate">

			<label for="email" data-original-text="Email">Email</label>
			<input type="email" name="email" placeholder="example@example.com" id="email">

			<label for="phone" data-original-text="Téléphone">Téléphone</label>
			<input type="tel" name="phone" placeholder="+243 xxx-xxx-xxx" id="phone">

			<div class="row">
				<div class="col-md-6">
					<label>Choisissez votre cycle:</label>
					<?php foreach ($schools as $school => $classes) : ?>
						<label>
							<input type="radio" name="cycle" value="<?php echo htmlspecialchars($school); ?>" data-classes='<?php echo htmlspecialchars(json_encode($classes)); ?>'>
							<?php echo htmlspecialchars($school); ?>
						</label>
					<?php endforeach; ?>
				</div>
				<div class="col-md-6">
					<div id="optionList" style="display:none;">
						<p class="choiceParagraph">Choisissez une option:</p>
						<ul class="animatedOptions expandable-list">
							<?php foreach ($options as $option => $description) : ?>
								<li>
									<label><input type="radio" name="option" value="<?php $description['name']; ?>"><?php echo htmlspecialchars($description['name']); ?></label>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<p class="choiceParagraph" id="classChoiceParagraph" style="display:none;">Choisissez une classe:</p>
					<ul class="expandable-list" id="classList"></ul>
				</div>
			</div>

			<div class="categorySelection">
				<label for="reference">Source de référence:</label>
				<select name="reference" id="reference">
					<option value="ad">Publicité</option>
					<option value="friend">Ami</option>
					<option value="google">Google</option>
					<option value="social">Médias sociaux</option>
					<option value="other">Autre</option>
				</select>
			</div>

			<label for="questions">Commentaires et questions:</label>
			<textarea id="questions" name="questions" rows="4" cols="40"></textarea>

			<input type="submit" value="Envoyez votre inscription" id="finish">
		</form>
	</main>

	<!--Footer-->
	<?php include 'Includes/footer.php'; ?>
	<!--Back_to_top_button-->
	<?php include "includes/back_to_top.php"; ?>
	<!-- Scripts -->
	<?php include 'Includes/scripts.php'; ?>
</body>

</html>