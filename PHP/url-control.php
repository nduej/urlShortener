<?php
include "config.php";

if (isset($_POST['full-url'])) {
    $full_url = mysqli_real_escape_string($conn, $_POST['full-url']);

    if (!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)) {
        $ran_url = substr(md5(microtime()), rand(0, 26), 5);

        $sql = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");

        if (mysqli_num_rows($sql) > 0) {
            echo "Something went wrong. Kindly regenerate the URL again!";
        } else {
            $sql2 = mysqli_query($conn, "INSERT INTO url (shorten_url, full_url, clicks)
                                         VALUES ('{$ran_url}', '{$full_url}', '0')");
            if ($sql2) {
                $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
                if (mysqli_num_rows($sql3) > 0) {
                    $shorten_url = mysqli_fetch_assoc($sql3);
                    echo $shorten_url['shorten_url'];
                }
            } else {
                echo "Something went wrong! Try again.";
            }
        }
    } else {
        echo "Invalid URL";
    }
} else if (isset($_GET['hash'])) {
    $hash = isset($_GET['hash']) ? mysqli_real_escape_string($conn, $_GET['hash']) : '';

    if ($hash != '') {
        $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$hash}'");

        if (mysqli_num_rows($sql) > 0) {
            $result = mysqli_fetch_assoc($sql);
            echo $result['full_url'];
            exit();
        } else {
            echo "Short URL not found";
            exit();
        }
    } else {
        echo "Hash not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}
?>
