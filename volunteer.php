<!-- <?php
  
      function  createConfirmationmbox()
      {
        echo '<script type="text/javascript"> ';
        echo ' function openulr(idCard) {';
        echo '  if (confirm("You are successfully registered. If you want to generate your ID card please click on OK button.")) {';
        echo '    document.location = idCard;';
        echo '  }';
        echo '}';
        echo '</script>';
      }
      ?> -->
<?php
$firstNameError = $lastNameError = $emailError = $addressError = $countryError = $stateError = $zipError = $interestError = $uploadError = "";
require('mysqli_connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (empty($_POST['firstname'])) {
    $firstNameError = 'You forgot to enter your first name.';
  } else {
    $fn = mysqli_real_escape_string($db, trim($_POST['firstname']));
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/", $fn)) {
      $firstNameError = "Only letters and white space allowed";
    }
  }

  if (empty($_POST['lastname'])) {
    $lastNameError = 'You forgot to enter your last name.';
  } else {
    $ln = mysqli_real_escape_string($db, trim($_POST['lastname']));
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/", $ln)) {
      $lastNameError = "Only letters and white space allowed";
    }
  }

  if (empty($_POST['email'])) {
    $emailError = 'You forgot to enter your email address.';
  } else {
    $e = mysqli_real_escape_string($db, trim($_POST['email']));
    // check if e-mail address is well-formed
    if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid email format";
    }
  }

  if (empty($_POST['address'])) {
    $addressError = 'You forgot to enter your address.';
  } else {
    $a = mysqli_real_escape_string($db, trim($_POST['address']));
  }

  if (empty($_POST['country'])) {
    $countryError = 'You forgot to enter your country.';
  } else {
    $c = mysqli_real_escape_string($db, trim($_POST['country']));
  }

  if (empty($_POST['state'])) {
    $stateError = 'You forgot to enter your state.';
  } else {
    $s = mysqli_real_escape_string($db, trim($_POST['state']));
  }

  if (empty($_POST['zip'])) {
    $zipError = 'You forgot to enter your zip.';
  } else {
    $z = mysqli_real_escape_string($db, trim($_POST['zip']));
  }

  if (empty($_POST['interest'])) {
    $interestError = 'You forgot to enter your area to volunteer.';
  } else {
    // $checkbox1 = mysqli_real_escape_string($db, trim($_POST['interest']));
    $checkbox1 = $_POST['interest'];
    $chk = "";
    foreach ($checkbox1 as $chk1) {
      $chk .= $chk1 . ", ";
    }
  }

  if (empty($_POST['upload'])) {
    $uploadError = 'You forgot to upload your photo.';
  }


  if (isset($_FILES['upload']) && empty($firstNameError) && empty($lastNameError) && empty($emailError) && empty($addressError) && empty($countryError) && empty($stateError) && empty($zipError) && empty($interestError)) {

    $image = mysqli_real_escape_string($db, trim($_FILES['upload']['name']));
    if (!file_exists("uploads")) {
      mkdir("uploads");
    }
    if (!file_exists("uploads/" . $fn)) {
      mkdir("uploads/" . $fn);
    }
    if (move_uploaded_file($_FILES['upload']['tmp_name'], "uploads/$fn/{$_FILES['upload']['name']}")) {
      // Make the query:
      $q = "INSERT INTO volunteers (firstname, lastname, email, address, country, state, zip, interest, photo) VALUES ('$fn', '$ln', '$e','$a', '$c', '$s', '$z', '$chk', '$image')";
      $r = @mysqli_query($db, $q); // Run the query.
      if ($r) {
        // header("Location: idCard.html");
        $_SESSION['first_name'] = $fn;
        $_SESSION['last_name'] = $ln;
        $_SESSION['email'] = $e;
        $_SESSION['address'] = $a;
        $_SESSION['country'] = $c;
        $_SESSION['state'] = $s;
        $_SESSION['zip'] = $z;
        $_SESSION['interest'] = $chk;
        $_SESSION['photo'] = $image;
        echo "<script>if(confirm('You are successfully registered. If you want to generate your ID card please click on OK button.')){document.location.href='idCardNew.php'};</script>";
      } else {

        echo '<script type="text/javascript">';
        echo ' alert("System Error\n Your details are not saved due to a system error. We apologize for any inconvenience.")';  //not showing an alert box.
        echo '</script>';

        // echo '<h1>System Error</h1>
        // <p class="error">Your details are not saved due to a system error. We apologize for any inconvenience.</p>';

        // Debugging message:
        echo '<p>' . mysqli_error($db) . '<br><br>Query: ' . $q . '</p>';
      } // End of if ($r) IF.
    } else {
      echo "<strong>File not moved into the folder</strong>";
    }


    mysqli_close($db); // Close the database connection.

    exit();
  }

  // mysqli_close($db); // Close the database connection.


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Care Club</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style1.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .error {
      color: #FF0000;
    }

    .role {
      /* width: 200px; */
      max-width: 70%;
      text-align: center;
      margin-left: auto;
      margin-right: auto;
      line-height: 30px;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" style="	font-weight: bold;font-size: 1.6rem; ">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"> <img src="images/logo_white.png" alt="Care_club_Logo" class="logo" style="width: 99px;" > </a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li ><a href="donations.html" style = "background-color: #CD9703; color: #fff">Donate!</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="volunteer.php">Become a Volunteer</a></li>
    </ul>
    <!-- <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul> -->
  </div>
</nav>

  <div class="container">
    <header class="home">
      <div class="container-volunteer">
        <div class="hero-text-box">
          <!-- <div id="span"><span>Become a Volunteer</span></div> -->
          <h1>Volunteers don’t just do the work, they make it work.</h1>
          <br />
          <a class="btn-h" href="#registrationForm">Register Now</a>
        </div>
        <!-- <div class="shape"></div> -->
      </div>
    </header>

    <!-- <p>Being a volunteer means feeling useful by donating your time, and by sharing your knowledge and experience. Its role is to take concrete action within a cohesive and supporting team.</p> -->

    <br>
    <br>
    <div class="album py-5 bg-light">
      <h1>VOLUNTEER'S ROLE</h1>
      <h3 class="role">Being a volunteer means feeling useful by donating your time, and by sharing your knowledge and experience. Its role is to take concrete action within a cohesive and supporting team. It also helps to create a new network of relationships. Come help with our fundraising and/or public awareness efforts. We always need help leading up to and on the day of the big event.</< /h3>
    </div>
    <br>
    <br>
    <br>
    <div class="album bg-light">
      <h1>VOLUNTEER HEADS</h1>
      <h3 class="section-title">These are the volunteer heads of different categories.</h3>
      <div class="container_events">
        <div class="row">
          <div class="col-md-3">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="images/vipul.jpg" alt="Food Donation Event" style="height: 300px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22208%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20208%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18221f284f2%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A11pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18221f284f2%22%3E%3Crect%20width%3D%22208%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2266.9453125%22%20y%3D%22117.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
              <div class="card-body">
                <p class="card-text"><strong>Vipul Gupta</strong></p>
                <h5 class="card-text">Volunteer in Hospitals</h5>
                <p class="card-text">Organizes activities associated with hospitals. Working with hospital workers and spending time with patients. Access to medications and free healthcare to the underprivileged.</p>
                <p class="card-text"><strong>Contact: 548-333-3717</strong></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="images/binali3.jpg" alt="Cloth Donation Event" style="height: 300px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22208%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20208%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18221f284f2%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A11pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18221f284f2%22%3E%3Crect%20width%3D%22208%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2266.9453125%22%20y%3D%22117.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
              <div class="card-body">
                <p class="card-text"><strong>Binali Patel</strong></p>
                <h5 class="card-text">Volunteer in Orphanages</h5>
                <p class="card-text">Conducting games, painting, singing, dancing, and other extracurricular activities. Assisting children with their homework, keeping track of their academic and physical development.</p>
                <p class="card-text"><strong>Contact: 647-355-2204</strong></p>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="images/hemika.jpeg" alt="Art Work Event" style="height: 300px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22208%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20208%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18221f284f2%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A11pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18221f284f2%22%3E%3Crect%20width%3D%22208%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2266.9453125%22%20y%3D%22117.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
              <div class="card-body">
                <p class="card-text"><strong>Hemika Jakhar</strong></p>
                <h5 class="card-text">Volunteer in Community Services</h5>
                <p class="card-text">Plan events to provide the homeless with food and clothing. Make crafts to donate to nursing home residents. Collect donated items to host a yard sale to raise money for a good cause.</p>
                <p class="card-text"><strong>Contact: 365-440-3786</strong></p>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card mb-4 box-shadow">
              <img class="card-img-top" src="images/venkata.jpeg" alt="Art Work Event" style="height: 300px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22208%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20208%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18221f284f2%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A11pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18221f284f2%22%3E%3Crect%20width%3D%22208%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2266.9453125%22%20y%3D%22117.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
              <div class="card-body">
                <p class="card-text"><strong>VenkataSaiKumar</strong></p>
                <h5 class="card-text">Volunteer in Arts and Entertainment</h5>
                <p class="card-text">Teach kids how to complete age-appropriate craft projects. Plant and maintain a butterfly garden at school. Grow veggies at school or home to donate to the local food bank.</p>
                <p class="card-text"><strong>Contact: 226-724-4344</strong></p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <section id="registrationForm" class="h-100 bg-dark">
      <div class="container_form ">
        <div class="row d-flex justify-content-center align-items-center h-100 " style="justify-content: center;">
          <div class="col">
            <div class="card_form card-registration my-4">
              <div class="row align_form">
                <div class="col-xl-6">
                  <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-uppercase">Register to become a Volunteer</h3>

                    <div class=" col-md-12 order-md-1">
                      <form enctype="multipart/form-data" action="volunteer.php" method="post" class="needs-validation" novalidate="">
                        <div class="row">
                          <div class="col-md-6 mb-3">
                            <label for="firstName">First name</label>
                            <input type="text" name="firstname" class="form-control" id="firstName" placeholder="" value="" required="">
                            <span class="error"><?php echo $firstNameError; ?></span>
                            <div class="invalid-feedback">
                              Valid first name is required.
                            </div>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="lastName">Last name</label>
                            <input type="text" name="lastname" class="form-control" id="lastName" placeholder="" value="" required="">
                            <span class="error"><?php echo $lastNameError; ?></span>
                            <div class="invalid-feedback">
                              Valid last name is required.
                            </div>
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="email">Email <span class="text-muted"></span></label>
                          <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                          <span class="error"><?php echo $emailError; ?></span>
                          <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="address">Address</label>
                          <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St" required="">
                          <span class="error"><?php echo $addressError; ?></span>
                          <div class="invalid-feedback">
                            Please enter your address.
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select name="country" class="custom-select d-block w-100" id="country" required="">
                              <option value="">Choose...</option>
                              <option>Canada</option>
                            </select>
                            <span class="error"><?php echo $countryError; ?></span>
                            <div class="invalid-feedback">
                              Please select a valid country.
                            </div>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label for="state">State</label>
                            <select name="state" class="custom-select d-block w-100" id="state" required="">
                              <option value="">Choose...</option>
                              <option>Alberta</option>
                              <option>British Columbia</option>
                              <option>Manitoba</option>
                              <option>New Brunswick</option>
                              <option>Newfoundland and Labrador</option>
                              <option>Nova Scotia</option>
                              <option>Ontario</option>
                              <option>Prince Edward Island</option>
                              <option>Quebec</option>
                              <option>Saskatchewan</option>
                              <option>Northwest Territories</option>
                              <option>Nunavut</option>
                              <option>Yukon</option>
                            </select>
                            <span class="error"><?php echo $stateError; ?></span>
                            <div class="invalid-feedback">
                              Please provide a valid state.
                            </div>
                          </div>
                          <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" name="zip" class="form-control" id="zip" placeholder="" required="">
                            <span class="error"><?php echo $zipError; ?></span>
                            <div class="invalid-feedback">
                              Zip code required.
                            </div>
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="upload">Upload Your Photo</label>
                          <input type="file" name="upload" class="form-control" id="upload" required="">
                          <span class="error"><?php echo $uploadError; ?></span>
                          <div class="invalid-feedback">
                            Please upload a valid file.
                          </div>
                        </div>

                        <h4 class="mb-3">Please indicate the areas to volunteer according to your skills</h4>
                        <span class="error"><?php echo $interestError; ?></span>

                        <div class="d-block my-3">
                          <div class="custom-control custom-checkbox">
                            <input id="hospitals" name="interest[]" type="checkbox" class="custom-control-input" value="Hospitals" required="">
                            <label class="custom-control-label" for="hospitals">Hospitals</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input id="orphanages" name="interest[]" type="checkbox" class="custom-control-input" value="Orphanages" required="">
                            <label class="custom-control-label" for="orphanages">Orphanages</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input id="schools" name="interest[]" type="checkbox" class="custom-control-input" value="Schools" required="">
                            <label class="custom-control-label" for="schools">Schools</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input id="communityServices" name="interest[]" type="checkbox" class="custom-control-input" value="Community Services" required="">
                            <label class="custom-control-label" for="communityServices">Community Services</label>
                          </div>
                          <div class="custom-control custom-checkbox">
                            <input id="artsAndEntertainment" name="interest[]" type="checkbox" class="custom-control-input" value="Arts And Entertainment" required="">
                            <label class="custom-control-label" for="artsAndEntertainment">Arts And Entertainment</label>
                          </div>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block btn-register" type="submit" data-toggle="modal" data-target="#myModal">Register</button>


                      </form>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


  </div>
  <section class="section-meals">
            <ul class="meals-showcase clearfix">
                <li>
                    <figure class="meal-photo">
                        <img src="images/1.jpg" alt="Korean bibimbap with egg and vegetables">
                    </figure>
                </li>
                <li>
                    <figure class="meal-photo">
                        <img src="images/2.jpg" alt="Simple italian pizza with cherry tomatoes">
                    </figure>
                </li>
                <li>
                    <figure class="meal-photo">
                        <img src="images/3.jpg" alt="Chicken breast steak with vegetables">
                    </figure>
                </li>
                <li>
                    <figure class="meal-photo">
                        <img src="images/4.jpg" alt="Autumn pumpkin soup">
                    </figure>
                </li>
            </ul>
            <ul class="meals-showcase clearfix">
                <li>
                    <figure class="meal-photo">
                        <img src="images/5.jpg" alt="Paleo beef steak with vegetables">
                    </figure>
                </li>
                <li>
                    <figure class="meal-photo">
                        <img src="images/6.jpg" alt="Healthy baguette with egg and vegetables">
                    </figure>
                </li>
                <li>
                    <figure class="meal-photo">
                        <img src="images/7.jpg" alt="Burger with cheddar and bacon">
                    </figure>
                </li>
                <li>
                    <figure class="meal-photo">
                        <img src="images/8.jpg" alt="Granola with cherries and strawberries">
                    </figure>
                </li>
            </ul>
        </section>
  <footer>
    <div class="container-footer">
        <div class="upper-footer">
         
                <ul>
                    <li><a href="#">About Us </a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Become a Volunteer</a></li>
                    <li><a href="#">Shipping services</a></li>
                    <li><a href="#">FAQ's</a></li>
                </ul>
        
                <ul class="social-links">
                    <li><a href="https://twitter.com/login?lang=en" target="_blank"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://in.pinterest.com/" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                    <li><a href="https://plus.google.com/" target="_blank"><i class="fab fa-google-plus-g"></i></a></li>
               
                </ul>
        </div>

        <hr>
    <div class="copyright">
        <p>Care Club © 2022 - ALL RIGHTS RESERVED </p>
    </div>
</div>
</footer>

</body>

</html>