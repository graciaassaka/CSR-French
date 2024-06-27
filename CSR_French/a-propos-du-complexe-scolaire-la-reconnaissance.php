<?php
// Database connection 
include "database/db.php";

// start session
session_start();

// Retrieve and transform content from the database
$page_info = getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'header');

$promotor = getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'promotor');

$slogan = [
	'heading' => getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'slogan')['heading'],
	'items' => [
		"ordre" => getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'ordre'),
		"discipline" => getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'discipline'),
		"travail" => getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'travail')
	]
];

$objectivesArray = getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'objectives');
$objectives = [
	'heading' => $objectivesArray['heading'],
	'description' => $objectivesArray['texts'][0],
	"list" => getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'listOfObjectives')['texts']
];

$classesArray = getStaticContent($conn, 'a-propos-du-complexe-scolaire-la-reconnaissance.php', 'classes');
$classes = ['heading' => $classesArray['heading'], 'description' => $classesArray['texts'][0], 'listOfOptions' => getOptions($conn)];

$class_schedule_data = [];
for ($schoolIndex = 1; $schoolIndex <= countTableEntries($conn, 'Schools'); $schoolIndex++) {
	$schoolDetails = getSchoolDetails($conn, $schoolIndex);
	$class_schedule_data[] = ['school' => $schoolDetails['school'], 'day' => $schoolDetails['day'], 'time' => $schoolDetails['time']];
}

// Clode database connection
$conn->close();

/**
 * Displays the slogan of the school complex.
 *
 * @param string $slogan The slogan to be displayed.
 * @return void
 */
function displaySlogan($slogan)
{
	$key = $slogan['key'];
	$value = $slogan['value'];
?>
	<div class="col">
		<div class="<?php echo htmlspecialchars($key) === 'discipline' ? 'white' : 'black'; ?> card shadow-sm">
			<img src="<?php echo htmlspecialchars($value['images'][0]['src']); ?>" alt="<?php echo htmlspecialchars($value['images'][0]['alt']); ?>" class="<?php echo htmlspecialchars($value['images'][0]['class']); ?>">
			<div class="card-body">
				<h3 class="<?php echo htmlspecialchars($key) === 'discipline' ? 'headingColor' : ''; ?>"><?php echo htmlspecialchars($value['heading']); ?></h3>
				<p class="card-text"><?php echo htmlspecialchars($value['texts'][0]); ?></p>
				<div class="d-flex justify-content-between align-items-center">
					<small><?php echo htmlspecialchars($value['notes']); ?></small>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
<!doctype html>
<html lang="fr">

<head>
	<link rel="canonical" href="https://lareconnaissance.com/a-propos-du-complexe-scolaire-la-reconnaissance.php">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Required meta tags, favicon, and CSS -->
	<?php include 'Includes/head.php'; ?>
	<!-- Title -->
	<title>A Propos | Complexe Scolaire la Reconnaissance </title>
</head>

<body>

	<!-- Navigation bar -->
	<?php include 'Includes/navbar.php'; ?>

	<!--Header and Hero Image-->
	<header class="jumbotron-fluid heroAbout">
		<div class="container welcome text-white">
			<h1><?php echo htmlspecialchars($page_info['heading']); ?></h1>
			<p class="grid tablet-desktop"><?php echo htmlspecialchars($page_info['texts'][0]); ?></p>
			<p class="grid tablet-desktop">Écoutez l'audio suivant pour mieux comprendre qui nous sommes!</p>
			<!-- Audio will be populated from the database -->
			<div id="advertisment-skit">
				<audio controls>
					<source src="media/advertisment.wav" type="audio/wav">
					<p>Votre navigateur ne supporte pas l'élément audio.</p>
				</audio>
			</div>
		</div>
	</header>

	<!-- Main Content Area -->
	<main class="container mb-5">
		<br>
		<!-- Slogan -->
		<div class="p-5 mb-4 rounded-3">
			<h2 class="display-3 tablet-desktop headingColor"><?php echo htmlspecialchars($slogan['heading']); ?></h2>
			<div class="album py-5 tablet-desktop">
				<div class="container">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
						<?php
						foreach ($slogan['items'] as $key => $value) {
							displaySlogan(['key' => $key, 'value' => $value]);
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<hr class="my-5">

		<!-- Promoter section -->
		<div class="row">
			<div class="col-md-7">
				<h2 class="display-3 headingColor"><?php echo htmlspecialchars($promotor['heading']); ?></h2>
				<p class="lead"><?php echo htmlspecialchars($promotor['texts'][0]); ?></p>
				<p class="lead"> <?php echo htmlspecialchars($promotor['notes']); ?></p>
			</div>
			<div class="col-md-5">
				<img src="<?php echo htmlspecialchars($promotor['images'][0]['src']); ?>" alt="<?php echo htmlspecialchars($promotor['images'][0]['alt']); ?>" class="<?php echo htmlspecialchars($promotor['images'][0]['class']); ?>">
			</div>
		</div>

		<hr class="my-5">

		<!-- Objectives section -->
		<div class="row">
			<div class="objectives p-4 p-md-5 mb-4 rounded text-bg-dark">
				<div class="col-md-6 px-0">
					<h2 class="display-3"><?php echo htmlspecialchars($objectives['heading']); ?></h2>
					<p class="lead"><?php echo htmlspecialchars($objectives['description']); ?></p>
					<ul>
						<?php
						foreach ($objectives['list'] as $objective) {
							echo "<li>" . htmlspecialchars($objective) . "</li>";
						}
						?>
					</ul>
				</div>
			</div>
		</div>

		<hr class="my-5">

		<!-- Classes section -->
		<div class="row">
			<div class="col-md-7">
				<h2 class="display-3 headingColor"><?php echo htmlspecialchars($classes['heading']); ?></h2>
				<p class="lead"><?php echo htmlspecialchars($classes['description']); ?></p>
				<ul>
					<?php
					foreach ($classes['listOfOptions'] as $key => $option) {
						echo "<li>" . htmlspecialchars($option['name']) . "</li>";
					}
					?>
				</ul>
			</div>
			<div class="col-md-5">
				<div class="slideshow-container">
					<?php
					$n = count($classes['listOfOptions']);
					$schoolIndex = 0;
					foreach ($classes['listOfOptions'] as $key => $option) {
						$schoolIndex = ($schoolIndex > $n) ? 1 : $schoolIndex;
						echo "<div class='mySlides fade'>";
						echo "<div class='black card shadow-sm'>";
						echo "<div class='numbertext'>" . ++$schoolIndex . "/" . $n . "</div>";
						echo "<div class='card-body'>";
						echo "<h3>" . htmlspecialchars($option['name']) . "</h3>";
						echo "<p class='options card-text'>" . htmlspecialchars($option['description']) . "</p>";
						echo "</div></div></div>";
					}
					?>
					<!-- The buttons-->
					<a class="prev" onclick="plusSlides(-1)"></a>
					<a class="next" onclick="plusSlides(1)"></a>
				</div>

			</div>
		</div>
		</div>

		<div class="tablet-desktop">

			<hr class="my-5">

			<!-- Classes schedule section -->
			<table>
				<caption>Horaire de cours</caption>
				<tr>
					<th>Cycles</th>
					<th>Jours</th>
					<th>Heures</th>
				</tr>
				<?php foreach ($class_schedule_data as $row) {
					echo "<tr>";
					foreach ($row as $key => $value) {
						echo "<td>" . htmlspecialchars($value) . "</td>";
					}
					echo "</tr>";
				}
				?>
			</table>
		</div>

		<hr class="my-5">

		<form class="comment" action="mailto:assakagracia@gmail.com" method="post" enctype="text/plain">
			<label for="questions">Commentaires et questions:</label>
			<textarea id="questions" name="questions" rows="4" cols="40"></textarea>

			<input class="button-basic" type="submit" value="Envoyez" id="finish">
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