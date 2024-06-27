<!-- This file contains the navigation bar for the website. -->

<nav class=" site-header navbar navbar-expand-sm navbar-dark fixed-top">
    <a class="navbar-brand" href="index.php">Complexe Scolaire la Reconnaissance</a>

    <!-- Hamburger menu icon -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse site-header" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="a-propos-du-complexe-scolaire-la-reconnaissance.php">A Propos du CSR</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admission-au-complexe-scolaire-la-reconnaissance.php">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vie-a-la-reconnaissance.php">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="polyclinique-la-reconnaissance.php">Polyclinique</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact-la-reconnaissance.php">Contacts</a>
            </li>

            <?php if (isset($_SESSION['name'])) : ?>

                <li class="nav-item">
                    <a href="shopping.php" class="button-signin" role="button">
                        <img src="images/store.png" alt="Shopping Store" class="icon">
                    </a>
                </li>

                <li class="nav-item">
                    <a href="cart.php" class="button-signin" role="button">
                        <img src="images/online-shopping.png" alt="Shopping Cart" class="icon">
                    </a>
                </li>

                <li class="nav-item">
                    <a href="sign-out.php" class="button-signin" role="button"> Sign-out </a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a href="sign-in.php" class="button-signin" role="button"> Sign-in </a>
                </li>
            <?php endif ?>

        </ul>
    </div>
</nav>