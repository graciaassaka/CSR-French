<?php
// Database connection 
include "database/db.php";

// start session
session_start();

// Retrieve and transform content from the database
$introduction = getStaticContent($conn, 'achievements.php', 'introduction');
$academic_awards_info = getStaticContent($conn, 'achievements.php', 'academic');
$sport_victories_info = getStaticContent($conn, 'achievements.php', 'sport');
$cultural_events_info = getStaticContent($conn, 'achievements.php', 'culture');
$academic_awards = getAchievementsByCategory($conn, 'academic');
$sport_victories = getAchievementsByCategory($conn, 'sport');
$cultural_events = getAchievementsByCategory($conn, 'culture');
$conclusion = getStaticContent($conn, 'achievements.php', 'conclusion');

// Clode database connection
$conn->close();


/**
 * Display a section with the given parameters.
 *
 * @param int $id The ID of the section.
 * @param string $heading The heading of the section.
 * @param string $text The text content of the section.
 * @param array $items The items to be displayed in the section.
 * @param bool $isTextFirst (optional) Whether the text should be displayed before the items. Default is true.
 * @return void
 */
function displaySection($id, $heading, $text, $items, $isTextFirst = true)
{
?>
    <div id="<?php echo htmlspecialchars($id); ?>" class="row align-items-md-stretch">
        <?php if ($isTextFirst) { ?>
            <div class="col-md-6">
                <div class='tablet-desktop awards <?php echo htmlspecialchars($id); ?>-awards h-100 p-5 text-bg-dark rounded-3'>
                    <p class="achievementsText"><?php echo htmlspecialchars($text); ?></p>
                </div>
            </div>
        <?php } ?>

        <div class="col-md-6">
            <h3 class="headingColor"><?php echo htmlspecialchars($heading); ?></h3>
            <ul>
                <?php
                foreach ($items as $year => $subItems) {
                    echo "<li>" . $year . "</li>";
                    echo "<ul>";
                    for ($i = 0; $i < count($subItems); $i++) {
                        echo "<li>" . htmlspecialchars($subItems[$i]) . "</li>";
                    }
                    echo "</ul>";
                }
                ?>
            </ul>
        </div>

        <?php if (!$isTextFirst) { ?>
            <div class="col-md-6">
                <div class='tablet-desktop awards <?php echo htmlspecialchars($id); ?>-victories h-100 p-5 text-bg-dark rounded-3'>
                    <p class="achievementsText"><?php echo htmlspecialchars($text); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
}
?>
<!doctype html>
<html lang="fr">

<head>
    <!-- Canonical link -->
    <link rel="canonical" href="https://lareconnaissance.com/achievements.php">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Required meta tags, favicon, and CSS -->
    <?php include 'Includes/head.php'; ?>
    <!-- Title -->
    <title>Achievements | Complexe Scolaire la Reconnaissance</title>
</head>

<body>
    <!-- Navigation bar -->
    <?php include 'includes/navbar.php'; ?>

    <!--Header and Hero Image-->
    <header class="jumbotron-fluid heroAccomplishments">
        <div class="container welcome text-white">
            <h1>Nos Réalisations et Accomplissements</h1>
            <p>Célébrant l'excellence à la Reconnaissance</p>
        </div>
    </header>

    <!--Main Content Area-->
    <!-- These sections will be populated by the database -->
    <main class="container-fluid mt-5">
        <!-- Introduction -->
        <h2 class="headingColor text-center"><?php echo htmlspecialchars($introduction["heading"]); ?></h2>
        <p class="lead"><?php echo htmlspecialchars($introduction["texts"][0]); ?></p>

        <br>

        <!-- To select achievements by category -->
        <div class="categorySelection">
            <label for="categorySelect">Filtrez nos accomplissements par categorie:</label>
            <select id="categorySelect" onchange="filterList()">
                <option value="all">Tous</option>
                <option value="academic">Academiques</option>
                <option value="sport">Sport</option>
                <option value="cultural">Cutlure</option>
            </select>
        </div>

        <hr class="my-5">
        <?php
        displaySection('academic', $academic_awards_info["heading"], $academic_awards_info["texts"][0], $academic_awards);
        displaySection('sport', $sport_victories_info["heading"], $sport_victories_info["texts"][0], $sport_victories, false);
        displaySection('cultural', $cultural_events_info["heading"], $cultural_events_info["texts"][0], $cultural_events);
        ?>

        <hr class="my-5">

        <!-- conclusion -->
        <h2 class="headingColor text-center"><?php echo htmlspecialchars($conclusion["heading"]); ?></h2>
        <p class="lead"><?php echo htmlspecialchars($conclusion["texts"][0]); ?></p>

    </main>

    <!--Footer-->
    <?php include "includes/footer.php"; ?>
    <!--Back_to_top_button-->
    <?php include "includes/back_to_top.php"; ?>
    <!-- Scripts -->
    <?php include "includes/scripts.php"; ?>

</body>

</html>