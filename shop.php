<?php
    ob_start();
    // include header.php file
    include ('header.php');
?>

<?php
 /*  include special price section  */
 include ('Template/_banner-area.php');
 

  
  include ('Template/_artists.html');
  
    
         include ('Template/_special-price.php');
include ('Template/_aboutus.html');

    /*  include top sale section */
    include ('Template/_new-products.php');
    /*  include top sale section */
?>


<?php
// include footer.php file
include ('footer.php');
?>