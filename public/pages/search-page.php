<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="../../css/style.css">
  <link rel="stylesheet" type="text/css" href="../../css/search-page.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Search Result | easyRent</title>
</head>

<body>
  <nav>
    <div class="container">
      <div class="navigation">
        <a href="http://localhost/easyRent/public/index.php">
          <h1 class="logo">easyRent</h1>
        </a>
        <ul class="nav-menu">
          <li><a href="#">Find Rent/PG</a></li>
          <li><a href="./landlord-reg.php">Post Property</a></li>

          <?php 
                require('../../server/connection.php');
                if(isset($_SESSION['logedin']) and $_SESSION['logedin'] == true) :
              ?>
          <li>
            <a
              href="<?php echo ($_SESSION['usertype'] == 'landlord') ?  './pages/landlord-reg.php' : './pages/user-profile.php' ?>">
              <?php 
                      if(isset($_SESSION['usertype']) and $_SESSION['usertype'] == "tenant") {
                        $query = mysqli_query($con, "SELECT * FROM `users` WHERE `email_id`='$_SESSION[username]'");
                        $fetch = mysqli_fetch_array($query);
                        $str = $fetch['username'];
                        $str=substr($str, 0, strpos($str, ' '));
                        echo"<i class='fa-solid fa-user'></i>"."$str";
                      }else if(isset($_SESSION['usertype']) and $_SESSION['usertype'] == "landlord") {
                        $query = mysqli_query($con, "SELECT * FROM `landlord` WHERE `email_id`='$_SESSION[username]'");
                        $fetch = mysqli_fetch_array($query);
                        $str = $fetch['landlord_name'];
                        $str=substr($str, 0, strpos($str, ' '));
                        echo"<i class='fa-solid fa-user'></i>"."$str";
                      }
                     ?>

            </a>
          </li>
          <li>
            <a href="../server/logout.php" class="btn" style="color: white;">Log out</a>
          </li>
          <?php else: ?>
          <li><a href="./pages/log-option.html" class="btn" style="color: white">Sign in</a></li>
          <?php endif; ?>
        </ul>

      </div>
    </div>
  </nav>
  <section>

    <div class="container">
      <h1 class="search-page-heading">Search from thousands of rental listings</h1>
      <p class="subheading">Enter a location. Search through appartment type or price with easy Rent</p>
      <form action="" method="GET">
        <div class="search-box">

          <input type="text" id="location" placeholder="Enter a location" name="location" required>

          <select name="app_type" id="app_type" placeholder="Appartment Type">
            <option value="" disabled selected>Appartment Type</option>
            <option value="2BHK">3BHK</option>
            <option value="2BHK">2BHK</option>
            <option value="2BHK">Studio</option>
            <option value="2BHK">Alcove Studio</option>
            <option value="2BHK">Micro Studio</option>
          </select>

          <select name="price_range">
            <option value="" disabled selected>Price Range</option>
            <option value="2BHK">Below Rs. 10,000</option>
            <option value="2BHK">10,000 to 15,000</option>
            <option value="2BHK">15,000 to 20,000</option>
            <option value="2BHK">more than 20,000</option>
          </select>

          <input type="submit" value="Search" name="search">
        </div>
        <!---- end of search box div-->
      </form>
    </div>
  </section>
  <section>
    <div class="container">
      <h1 class="caption">Results</h1>
      <?php 
        require('../../server/connection.php');
        if(isset($_GET['search'])){
          $requested_location = $_GET['location'];
          
          if(strlen($requested_location) >= 3) { // if the requeted query is greater than 3
            $requested_location = htmlspecialchars($requested_location);
            $requested_location = mysqli_real_escape_string($con, $requested_location);
      
            $raw_results = mysqli_query($con, "SELECT * FROM landlord WHERE `appartment_location` LIKE '%$requested_location%' " );
            $row = mysqli_fetch_assoc($raw_results);
        
            if(mysqli_num_rows($raw_results) == 0) {
              echo "nothing to show here. Try another search term.";
              echo "please checking typing errors";
            }
          }else {
            echo "nothing to show here. Try another search term.";
            echo "please checking typing errors";
          }
        }
        
      ?>
    </div>
  </section>
</body>

</html>