<?php

//let's get these values which are sent from ajax to php
include "config.php";

$og_url = mysqli_real_escape_string($conn, $_POST['shorten_url']);
$full_url = str_replace(' ', '', $og_url); //removing space from url if user entered
$hidden_url = mysqli_real_escape_string($conn, $_POST['hidden_url']);


if (!empty($full_url)) {
    $domain = "localhost";
    //Let's check user have edited or removed domain name or not
    if (preg_match("/{'$domain'}/i", $full_url) && preg_match("/{\}/i", $full_url)) {
        $explodeURL = explode('/', $full_url);
        $short_url = end($explodeURL); //getting last value of full url
        if ($short_url != "") {

            //let's select randomly created url to update with user entered new value;
            $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$hidden_url}' && shorten_url != '{$shorten_url}'");
            if (mysqli_num_rows($sql) == 0) { // if the user entered url doesn't exist in the database
                //let's update the link or url
                $sql2 = mysqli_query($conn, "UPDATE url SET shorten_url = '{$short_url}' WHERE shorten_url = '{$hidden_url}'");
                if ($sql2) { //if url updated
                    echo "Success";
                } else {
                    "Something went wrong!";
                }
            } else {
                echo "Error - This URL doesn't exist!";
            }

        } else {
            echo "Error - You have to enter short URL!";
        }
    } else {
        echo "Invalid URL - You can't edit domain name!";
    }
} else {
    echo "Error - You have to enter short URL!";
}