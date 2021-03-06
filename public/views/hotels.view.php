<?php

include_once "includes/_header.php"; 
require $_SERVER['DOCUMENT_ROOT'].'/hotels/core/database/connection.php';

//getting the userID from login.php, need ID to make a reservation
$user_id = $_GET['user_id'];

$pdo = Connection::connect();
$sql="SELECT * FROM hotel;";

$hotels_results=$pdo->prepare($sql);
$hotels_results->execute();


if($hotels_results->rowCount() < 1)
    // if no hotels are in the database
    echo"<h1 style='color:red';>No hotels available</h1>";
else{
?>
<div class="container">
  <h1>Hotels available</h1>
     <!--display success message after user reserves a hotel-->
         <div class="alert alert-success <?php echo isset($_GET['success']) ? 'alert-dismissible fade show' : 'd-none' ?>" role="alert" id="success-alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
             </button>
Hotel successfully reserved.</div>
    <a class="btn btn-secondary" href="../../index.php" role="button">Back</a>

    <div class="row">

<?php
while ($hotels=$hotels_results->fetch(PDO::FETCH_ASSOC)){
    
    $hotel_name = $hotels['name'];
    $hotel_desc = $hotels['desc'];
    $hotel_image = $hotels['image'];
    $hotel_id = $hotels['id'];


    
    
echo"
    <div class='col-md-4'>
      <div class='thumbnail'>
          <img src='../assets/".$hotel_image."' alt='".hotel_name."' style='width:100%'>
          <h3>".$hotel_name."</h3>
          <div class='caption'>
            <p>".$hotel_desc."</p>
          </div>
           <form action='../actions/booking.php'>
            <button type='submit' class='btn btn-primary btn-lg btn-block'>RESERVE</button>
        <input type='hidden' name='hotel_id' value=".$hotel_id.">
        <input type='hidden' name='user_id' value=".$user_id.">
        </form>
      </div>
    </div>
    
    ";
}
}
?>

  </div>
</div>

<?php include_once "includes/_footer.php"; ?>