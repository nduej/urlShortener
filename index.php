<!--Let's redirect user to their original link using shorten link -->
<?php
include "php/config.php";
$new_url = "";
if (isset($_GET)) {
  foreach ($_GET as $key => $val) {
    $u = mysqli_real_escape_string($conn, $key);
    $new_url = str_replace('/', '', $u); //Removing / sign from URL
  }

  // Getting the full url of that short url which we are getting from url
  $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");

  if (mysqli_num_rows($sql) > 0) {
    //Let's redirect user
    $full_url = mysqli_fetch_assoc($sql);
    header("Location:" . $full_url['full_url']);
  }
}

?>


<!doctype html>
<html lang="en">

<head>
  <title>URL Shortener in PHP | Michael Ndue</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
  form {
    position: relative;
  }

  .blur-effect {
    position: absolute;
    height: 100%;
    width: 100%;
    backdrop-filter: blur(12px);
    background: rgba(0, 0, 0, 0.01);
    display: none;
  }

  .popup-box {
    position: absolute;
    background: #fff;
    padding: 25px;
    border-radius: 5px;
    max-width: 480px;
    width: 100%;
    top: 50%;
    left: 50%;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
    transform: translate(-50%, -50%) scale(0.9);
    opacity: 0;
    transition: all 0.3s ease;
  }

  //We will show this in the JavaScript
  .popup-box.show {
    opacity: 1 !important;
    display: block;
    transform: translate(-50%, -50%) scale(1) !important;
  }

  .info-box .error {
    color: #0f5753;
    background: #bef4f1;
    border: 1px solid #7de8e3;
    padding: 10px;
    border-radius: 5px;
    font-size: 17px;
    text-align: center;
  }

  .popup-box form {
    position: relative;
    margin-top: 10px;
  }

  .popup-box form label {
    font-size: 10px;
  }

  .popup-box form .copy-icon {
    position: absolute;
    right: 10px;
    z-index: 1;
    top: 50%;
    transform: translateY(-85%);
    font-size: 20px;
    cursor: pointer;
  }

  form .copy-icon:hover {
    color: #20B2AA;

  }

  .popup-box form input {
    height: 45px;
    border: 1px solid #ccc;
    padding: 0 35px 0 15px;
    margin-top: 3px;
  }

  .popup-box form button {
    position: relative;
    right: 0px;
    font-size: 20px;
    margin-top: 10px;
    width: 100%;
  }
</style>


<body class="bg-info">

  <div class="wrapper">
    <form action="">
      <input type="text" name="full-url" placeholder="Enter or paste a long url" required>
      <i class="fa-solid fa-link url-icon"></i>
      <button>Shorten</button>
    </form>

    <?php

    $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
    if (mysqli_num_rows($sql2) > 0) {
      ?>
      <div class="count">
        <span>Total Links: <span>10</span> & Total Clicks: <span>140</span></span>
        <a href="#">Clear All</a>
      </div>

      <div class="urls-area">
        <div class="title">
          <li>Shorten URL</li>
          <li>Original URL</li>
          <li>Clicks</li>
          <li>Action</li>
        </div>
        <?php
        while ($row = mysqli_fetch_assoc($sql2)) {
          ?>
          <div class="data">
            <li>
              <a href="http://localhost/urlShortener/<?php echo $row['shorten_url'];  ?>" target="_blank">
                <?php

                if ('localhost/urlShortener/' . strlen($row['shorten_url'] > 50)) {
                  echo 'localhost/urlShortener/' . substr($row['shorten_url'], 0, 50) . '...';
                } else {
                  echo 'localhost/urlShortener/' . $row['shorten_url'];
                }

                ?>
              </a>
            </li>
            <li>
              <?php

              if (strlen($row['full_url'] > 65)) {
                echo substr($row['full_url'], 0, 65) . '...';
              } else {
                echo $row['full_url'];
              }

              ?>
            </li>
            <li>
              <?php echo $row['clicks'] ?>
            </li>
            <li><a href="#">Delete</a></li>
          </div>
          <?php
        }
    }
    ?>
    </div>



  </div>

  <div class="blur-effect">
  </div>
  <div id="popup-box" class="popup-box">
    <div class="info-box error" style="color: #0f5753; background: #bef4f1; border: 1px solid #7de8e3; 
    padding: 10px; border-radius: 5px; font-size: 17px; text-align: center;">
      Your Short Link is ready. You can also edit your link now but can't edit once saved.</div>
    <form action="">
      <label>Edit Shorten URL</label>
      <input type="text" spellcheck="false" value="">
      <i class="fa-solid fa-copy copy-icon"></i>
      <button id="saveBtn">Save</button>
    </form>
  </div>



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="script.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>