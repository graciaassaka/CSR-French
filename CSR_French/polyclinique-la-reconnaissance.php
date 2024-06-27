<?php
//TODO: Database connection will go here

// start session
session_start();

// Mock-up data
$pageTitle = "Polyclinique la Reconnaissance";
$pageIntro = "La Reconnaissance offre à la population Kanagaise une polyclinique moderne!";

$polyclinicAdTitle_1 = "Soins de Santé";
$polyclinicAdDescription_1 = "À La Reconnaissance, nous comprenons l'importance de la santé pour garantir une éducation de qualité pour nos éléves. C'est pourquoi nous sommes fiers d'offrir à la communauté Kanangaise une polyclinique moderne, dirigée par des médecins et des infirmières expérimentés qui sont dédiés à fournir les meilleurs soins pour vos enfants.";

$polyclinicAdTitle_2 = "Modernite dans le traitement des éléves et de la population";
$polyclinicAdDescription_2 = "Notre polyclinique est ouverte 24 heures sur 24 et offre une infrastructure moderne qui répond aux normes internationales en matière de soins de santé. De plus, nous offrons également un service d'ambulance pour les soins médicaux d'urgence et le transport pour les personnes gravement malades ou blessées.";

$polyclinicAdTitle_3 = "Partenariats";
$polyclinicAdDescription_3 = "Nous sommes fiers d'avoir des partenariats avec des organisations de premier plan telles que Monusco, Cigna et des entreprises locales, ce qui témoigne du succès croissant de notre polyclinique. Faites confiance à La Reconnaissance pour fournir des soins médicaux de premier ordre pour votre famille.";


?>

<!doctype html>
<!-- Gracia Assaka,  -->
<html lang="fr">

<head>
  <!-- Cannonical link -->
  <link rel="canonical" href="https://lareconnaissance.com/polyclinique-la-reconnaissance.php">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Required meta tags, favicon, and CSS -->
  <?php include 'Includes/head.php'; ?>
  <!-- Title -->
  <title>Polyclinique | Complexe Scolaire la Reconnaissance</title>
</head>

<body>

  <!-- Navigation bar -->
  <?php include 'Includes/navbar.php'; ?>


  <!-- Header -->
  <header class="jumbotron-fluid heroPolyclinic">
    <div class="container welcome text-white">
      <h1><?php echo $pageTitle; ?></h1>
      <p class="grid tablet-desktop"><?php echo $pageIntro; ?></p>
    </div>
  </header>


  <!-- Main Content Area -->
  <main class="container mb-5">
    <!-- Introduction -->
    <!-- This part will be populated from database -->
    <hr class="my-5">
    <div class="row">
      <div class="healthcare p-4 p-md-5 mb-4 rounded text-bg-dark">
        <div class="col-md-6 px-0">
          <h2 class="display-3 headingColor"><?php echo $polyclinicAdTitle_1; ?></h2>
          <p class="lead"><?php echo $polyclinicAdDescription_1; ?></p>
        </div>
      </div>

      <hr class="my-5">

      <!-- Advertising -->
      <!-- This part will be populated from database -->
      <div class="row">
        <div class="col-md-7">
          <h3 class="headingColor"><?php echo $polyclinicAdTitle_2; ?></h3>
          <p class="lead"><?php echo $polyclinicAdDescription_2; ?></p>
        </div>
        <div class="col-md-5">
          <!-- Slideshow container -->
          <div class="slideshow-container">

            <!-- Full-width images with number-->
            <!-- These pictures will be populated from the database -->
            <div class="mySlides fade">
              <div class="numbertext">1 / 2</div>
              <img src="images/Outside_Ambulance.jpg" alt="Ambulance" class="round">
            </div>

            <div class="mySlides fade">
              <div class="numbertext">2 / 2</div>
              <img src="images/Inside_Ambulance.jpg" alt="Ambulance" class="round">
            </div>
            <!-- The buttons-->
            <a class="prev" onclick="plusSlides(-1)"></a>
            <a class="next" onclick="plusSlides(1)"></a>
          </div>
          <br>

          <!-- The dots/circles -->
          <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
          </div>
        </div>
      </div>

      <hr class="my-5">
      <!-- Advertising -->
      <!-- This part will be populated from database -->
      <div class="row">
        <div class="partner p-4 p-md-5 mb-4 rounded text-bg-dark">
          <div class="col-md-6 px-0">
            <h2 class="display-3 headingColor"><?php echo $polyclinicAdTitle_3; ?></h2>
            <p class="lead"><?php echo $polyclinicAdDescription_3; ?></p>
          </div>
        </div>
      </div>

  </main>

  <!--Footer-->
  <?php include 'Includes/footer.php'; ?>

  <!-- Scripts -->
  <?php include 'Includes/scripts.php'; ?>
</body>

</html>