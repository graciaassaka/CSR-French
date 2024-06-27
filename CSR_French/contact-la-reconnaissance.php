<?php
//TODO: Database connection will go here

// start session
session_start();

?>

<!doctype html>
<!-- Student Name, Current Date -->
<html lang="fr">

<head>
  <!-- Cannonical link -->
  <link rel="canonical" href="https://lareconnaissance.com/contact-la-reconnaissance.html">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Required meta tags, favicon, and CSS -->
  <?php include 'Includes/head.php'; ?>
  <!-- Title -->
  <title>Contact - Location | Complexe Scolaire la Reconnaissance</title>
</head>

<body>

  <!-- Navigation bar -->
  <?php include 'Includes/navbar.php'; ?>

  <!-- Main Content Area -->
  <main class="container mt-5">

    <div class="text-center">

      <h2 class="py-3">Prêt à vous inscrire? Contactez-nous aujourd'hui.</h2>
      <h4 class="mobile mb-3"><a href="tel:8145559608" role="button" class="btn btn-outline-secondary btn-lg bg-dark text-white">(814) 555-9608</a></h4>
      <h4 class="tablet-desktop tel-num mb-3">+ 243 998 424 559</h4>
      <h4>Email: <a href="mailto:maisonjeanassaka@yahoo.fr" class="contact-email-link">maisonjeanassaka@yahoo.fr</a></h4>
      <h4>Visitez nous: </h4>

      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2948.8517572084897!2d-71.05362748503984!3d42.34568384400281!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e37a7dc2b67e7b%3A0x36ec93427cd9c5f1!2sChannel+Center+St%2C+Boston%2C+MA+02210!5e0!3m2!1sen!2sus!4v1558137213400!5m2!1sen!2sus" width="600" height="450" allowfullscreen class="map"></iframe>

    </div>

  </main>

  <!--Footer-->
  <?php include 'Includes/footer.php'; ?>
  
  <!-- Scripts -->
  <?php include 'Includes/scripts.php'; ?>
</body>

</html>