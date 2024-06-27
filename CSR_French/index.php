<?php
// Database connection 
include "database/db.php";

// start session
session_start();

// Retrieve and transform content from the database
$introduction = getStaticContent($conn, 'index.php', 'introduction');
$inscription = getStaticContent($conn, 'index.php', 'inscription');
$mission = getStaticContent($conn, 'index.php', 'mission');
$infrastructure = getStaticContent($conn, 'index.php', 'infrastructure');
$buildings = [
	'Dibanda' => getStaticContent($conn, 'index.php', 'dibanda'),
	'Concorde' => getStaticContent($conn, 'index.php', 'concorde'),
	'Gecamine' => getStaticContent($conn, 'index.php', 'gecamine')
];
$polyclinic = getStaticContent($conn, 'index.php', 'polyclinic');
$achievement = getStaticContent($conn, 'index.php', 'achievement');

// Clode database connection
$conn->close();

/**
 * Generates the main section of the webpage.
 *
 * @param string $section The section to generate.
 * @return void
 */
function generateMainSection($section)
{
?>
	<div class="col-sm-4">
		<figure>
			<a href="<?php echo htmlspecialchars($section['link']); ?>">
				<img src="<?php echo htmlspecialchars($section['images'][0]['src']); ?>" alt="<?php echo htmlspecialchars($section['images'][0]['alt']); ?>" loading="<?php echo htmlspecialchars($section['images'][0]['loading']); ?>" class="<?php echo htmlspecialchars($section['images'][0]['class']); ?>">
			</a>
		</figure>
		<h2 class="headingColor"><?php echo htmlspecialchars($section['heading']); ?></h2>
		<p class="lead"><?php echo htmlspecialchars($section['texts'][0]); ?></p>
	</div>
<?php
}

/**
 * Generates a building card.
 *
 * @param string $key The key of the building.
 * @param array $building The building data.
 * @return void
 */
function generateBuildingCard($key, $building)
{
?>
	<div class="col-md-4"> 
		<div class="<?php echo htmlspecialchars($key) === 'Concorde' ? 'white' : 'black'; ?> card shadow-sm">
			<img src="<?php echo htmlspecialchars($building['images'][0]['src']); ?>" alt="<?php echo htmlspecialchars($building['images'][0]['alt']); ?>" loading="<?php echo htmlspecialchars($building['images'][0]['loading']); ?>" class="<?php echo htmlspecialchars($building['images'][0]['class']); ?> img-fluid"> 
			<div class="card-body">
				<p class="card-text"><?php echo htmlspecialchars($building['texts'][0]); ?></p>
				<div class="d-flex justify-content-between align-items-center">
					<a href="visite.php?site=<?php echo htmlspecialchars($key); ?>" class="button-rounded" role="button"><small>Visitez <?php echo htmlspecialchars($key); ?></small></a>
				</div>
			</div>
		</div>
	</div>
<?php
}


/**
 * Generates an additional section with the given parameters.
 *
 * @param string $section The section content.
 * @param string $sectionClass The CSS class for the section.
 * @param string $button The button content.
 * @return void
 */
function generateAdditionalSection($section, $sectionClass, $button)
{
?>
	<div class="col-md-6">
		<div class="<?php echo htmlspecialchars($sectionClass); ?> h-100 p-5 text-bg-dark rounded-3">
			<h2><?php echo htmlspecialchars($section['heading']); ?></h2>
			<p><?php echo htmlspecialchars($section['texts'][0]); ?></p>
			<a href="<?php echo htmlspecialchars($section['link']); ?>" class="button-basic btn-outline-light" role="button"><?php echo htmlspecialchars($button); ?></a>
		</div>
	</div>
<?php
}
?>
<!doctype html>
<html lang="fr">

<head>
	<!-- Canonical link -->
	<link rel="canonical" href="https://lareconnaissance.com">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Required meta tags, favicon, and CSS -->
	<?php include 'Includes/head.php'; ?>
	<!-- Title -->
	<title>Complexe Scolaire la Reconnaissance</title>
</head>

<body>
	<!-- Message -->
    <?php if (isset($_SESSION['message'])) : ?>
        <div class="toast">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

	<!-- Navigation bar -->
	<?php include 'includes/navbar.php'; ?>

	<!--Header and Hero Image-->
	<header class="jumbotron-fluid heroIndex">
		<div class="container welcome text-white">
			<img src="images/CSR_logo.png" alt="Complexe Scolaire la Reconnaissance Logo" loading="lazy" class="float-left mr-3 img-fluid">
			<?php
			if (isset($_SESSION['name'])) {
				printf("<h1>Bienvenue, %s</h1>", $_SESSION['name']);
			}
			?>
			<p class="grid tablet-desktop">Obtenez une éducation abordable et excellente!</p>
			<a href="admission-au-complexe-scolaire-la-reconnaissance.php" class="button-basic btn btn btn-outline-light" role="button">Inscrivez vous maintenant!</a>
		</div>
	</header>

	<!--Main Content Area-->
	<main class="container-fluid mt-5">

		<div class="row">
			<!-- Introduction -->
			<div class="col-sm-4">
				<!-- Slideshow container -->
				<a href="a-propos-du-complexe-scolaire-la-reconnaissance.php">
					<div class="slideshow-container">
						<?php foreach ($introduction['images'] as $image) : ?>
							<div class="mySlides_1 fade">
								<img src="<?php echo htmlspecialchars($image['src']); ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>" loading="<?php echo htmlspecialchars($image['loading']); ?>" class="<?php echo htmlspecialchars($image['class']); ?>">
							</div>
						<?php endforeach; ?>
					</div>
				</a>
				<br>
				<!-- The dots/circles -->
				<div style="text-align:center">
					<?php for ($i = 0; $i < count($introduction['images']); $i++) : ?>
						<span class="dot_1"></span>
					<?php endfor; ?>
				</div>

				<h2 class="headingColor"><?php echo htmlspecialchars($introduction['heading']); ?></h2>
				<p class="lead"><?php echo htmlspecialchars($introduction['texts'][0]); ?></p>
			</div>
			<!-- Inscription -->
			<?php
			generateMainSection($inscription);
			?>
			<!-- Mission -->
			<?php
			generateMainSection($mission);
			?>
		</div>

		<!-- Infrastructures -->
		<div class="p-5 mb-4 rounded-3 tablet-desktop">

			<div class="infrastructure p-4 p-md-5 mb-4 rounded text-bg-dark">

				<div class="col-md-6 px-0">
					<h1 class="display-4 fst-italic"><?php echo htmlspecialchars($infrastructure['heading']); ?></h1>
					<p class="lead my-3"><?php echo htmlspecialchars($infrastructure['texts'][0]); ?></p>
				</div>
			</div>

			<div class="album py-5">
				<div class="container">
					<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
						<?php foreach ($buildings as $key => $building) : ?>
							<?php generateBuildingCard($key, $building); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<br>
			<br>
			<br>
			<div class="row align-items-md-stretch">
				<!-- Polyclinique -->
				<?php generateAdditionalSection($polyclinic, 'polyclinic', 'Visitez notre polyclinique'); ?>
				<!-- Accomplissements -->
				<?php generateAdditionalSection($achievement, 'achievement', 'Nos accomplissements'); ?>
			</div>
		</div>
	</main>

	<!--Footer-->
	<?php include "includes/footer.php"; ?>
	<!--Back_to_top_button-->
	<?php include "includes/back_to_top.php"; ?>
	<!-- Scripts -->
	<?php include "includes/scripts.php"; ?>
	<?php if (isset($_SESSION['message'])) : ?>
        <script>
            showToast();
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</body>

</html>