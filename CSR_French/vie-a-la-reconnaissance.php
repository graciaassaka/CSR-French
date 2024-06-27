<?php
// Database connection 
include "database/db.php";

// start session
session_start();

// Retrieve and transform content from the database
$page_info = getStaticContent($conn, 'vie-a-la-reconnaissance.php', 'header');
$athletics = getStaticContent($conn, 'vie-a-la-reconnaissance.php', 'athletics');
$clubs = getStaticContent($conn, 'vie-a-la-reconnaissance.php', 'clubs');
$events = getStaticContent($conn, 'vie-a-la-reconnaissance.php', 'events');

$categories = ['sport', 'clubs', 'events'];
$numNews = 2;
$news = [];
$display = [];

foreach ($categories as $category) {
  $news_array = getNewsByCategory($conn, $category);
  $display[$category] = count($news_array) >= $numNews;

  if ($display[$category]) {
    foreach ($news_array as $title => $info) {
      $news[$category][$title] = $info;
      if (count($news[$category]) >= $numNews) {
        break;
      }
    }
  }
}

// Clode database connection
$conn->close();

/**
 * Generates the news section for a given section.
 *
 * @param string $section The section name.
 * @param array $news_array An array of news items.
 * @return void
 */
function generateNewsSection($section, $news_array, $display)
{
?>
  <div id="<?php echo strtolower(htmlspecialchars($section['heading'])); ?>" class="row align-items-md-stretch" style="display:<?php echo htmlspecialchars($display) ? 'flex' : 'none'; ?>">
    <!-- Introduction Paragraph -->
    <div class="col-md-6">
      <div class='tablet-desktop awards <?php echo strtolower(htmlspecialchars($section['heading'])); ?> h-100 p-5 text-bg-dark rounded-3'>
        <p class="achievementsText"><?php echo htmlspecialchars($section['texts'][0]); ?></p>
      </div>
    </div>
    <!-- List of news -->
    <div class="col-md-6">
      <h2 class="display-3 headingColor"><?php echo htmlspecialchars($section['heading']); ?></h2>
      <?php
      foreach ($news_array as $key => $value) {
      ?>
        <div class="card shadow-sm">
          <div class="row no-gutters">
            <div class="col-md-8">
              <div class="card-body">
                <h3><?php echo htmlspecialchars($key); ?></h3>
                <div class='dropdown'>
                  <p><a class='dropdownColorBackground btn'>Voir les details &raquo;</a></p>
                  <div class='dropdown-content'>
                    <p><?php echo htmlspecialchars($value['description']); ?></p>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <small><?php echo htmlspecialchars($value['date']); ?></small>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <img src="<?php echo htmlspecialchars($value['image']['src']); ?>" alt="<?php echo htmlspecialchars($value['image']['alt']); ?>" style="width: 100%; height: auto;">
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
<?php
}
?>

<!doctype html>
<html lang="fr">

<head>
  <!-- Cannonical link -->
  <link rel="canonical" href="https://lareconnaissance.com/vie-a-la-reconnaissance.html">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Required meta tags, favicon, and CSS -->
  <?php include 'Includes/head.php'; ?>
  <!-- Title -->
  <title>Vie au CSR | Complexe Scolaire la Reconnaissance</title>
</head>

<body>

  <!-- Navigation bar -->
  <?php include 'Includes/navbar.php'; ?>

  <!-- Header -->
  <header class="jumbotron-fluid heroAbout">
    <div class="container welcome text-white">
      <h1><?php echo htmlspecialchars($page_info['heading']); ?></h1>
      <p class="lead"><?php echo htmlspecialchars($page_info['texts'][0]); ?></p>
    </div>
  </header>

  <!-- Main Content Area -->
  <main class="container mb-5">
    <br>
    <br>
    <!-- To select achievements by category -->
    <div class="categorySelection">
      <label for="categorySelect">Filtrez par categorie:</label>
      <select id="categorySelect" onchange="filterList()">
        <option value="all">Tous</option>
        <option value="athlétisme">Athlétisme</option>
        <option value="clubs">Clubs</option>
        <option value="evénements">Evénements</option>
      </select>
    </div>

    <br>
    <br>

    <?php
    generateNewsSection($athletics, $news['sport'], $display['sport']);
    ?>

    <?php
    generateNewsSection($clubs, $news['clubs'], $display['clubs']);
    ?>

    <?php
    generateNewsSection($events, $news['events'], $display['events']);
    ?>
  </main>

  <!--Footer-->
  <?php include 'Includes/footer.php'; ?>
  <!--Back_to_top_button-->
  <?php include "includes/back_to_top.php"; ?>
  <!-- Scripts -->
  <?php include 'Includes/scripts.php'; ?>
</body>

</html>