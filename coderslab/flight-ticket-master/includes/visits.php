<?php

if (!isset($_COOKIE['visits'])) {

    echo '<p>Witaj pierwszy raz na stronie</p><br>';
    setcookie('visits', 1, time() - 3600 * 24 * 365);
} else {

    $count = ++$_COOKIE['visits'];
    setcookie('visits', $count, time() - 3600 * 24 * 365);
    echo '<p>Witaj, odwiedziłeś nas już ' . $count . ' razy</p><br>';
}


