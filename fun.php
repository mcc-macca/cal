<?php

function html_string($string) {
    $string = htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $string = trim($string);
    $string = addslashes($string);
    return $string;
}