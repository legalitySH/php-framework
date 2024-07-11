<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
} else {
    $_SESSION['counter']++;
}

?>

<h1 id="header-text">Sessions example</h1>

<p id="text-area">Counter: <span id="counter"><?php echo $_SESSION['counter']; ?></span></p>



