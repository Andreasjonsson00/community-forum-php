<?php

require "groups.php";

$groups = get_Groups();

$id = $_GET['id'];

foreach ($groups as $group) {
    if ($group['id'] == $id) {
        echo "<h1>" . $group['name'] . "</h1>";
        echo "<p>" . $group['description'] . "</p>";
    }
}