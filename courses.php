<?php

$string = file_get_contents("courses.json");

$json = json_decode($string, true);

echo json_encode($json);