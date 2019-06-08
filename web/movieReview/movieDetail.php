<?php
/******************************************
 * Gets and displays selected movie details
 *****************************************/
// header, session, and page setup
session_start();
$PageTitle = "Movie Detail";
require('header.php'); 
require('dbAccess/dbCalls.php'); ?>

<div class="row">
<div class="col-12">

<?php
// get movie_ID for sql query
$id = $_GET['movie'];

// set session for reveiw function
$_SESSION['movie'] = $id;

// if is redirect from review page
if($_SESSION['message']){
  echo "<span class='message'>$_SESSION[message]</span>";
  unset($_SESSION['message']);
}

// get and display movie details
$result = getDetail($id);
foreach ($result as $row) { ?>
  <div class="menu">
  <h2 class="inst">Movie Details</h2>
    <a href="viewMovies.php">
      <div class="menuItem">RETURN TO BROWSE</div></a>
    <a href="searchResults.php">
      <div class="menuItem">SEARCH</div></a>
  </div> <!--END OF .MENU-->

<div class="detail">
<h2 class="detail"><?php echo $row['movie_name']; ?> </h2>
  <img src="<?php echo $row['movie_img']; ?>" alt="Movie Poster"/><br/>
  <p><strong>Released In:</strong> <?php echo $row['movie_year']; ?></p>
  <p><strong>Description:</strong><br/>
    <?php echo $row['movie_desc']; ?>
  </p>
  </div> <!--END OF .DETAIL -->
  <div class="review">
<?php }

  // get and display reveiws
  $result = getReviews($id);
  if($result) {
  ?>
  <p id="review">Reviews - Sorted by score
  <?php if($_SESSION['loggedIn'] == true) { ?>
    <a class="submitR"
     href="#review" onclick="submitReview(<?php echo $id; ?>, 2)">
      Review Movie</a>
  <?php } ?>
  </p>
  <table>
     <tr>
       <th class="num">Score</th>
       <th>Review</th>
       <th>Reviewed By</th>
     </tr>
  <?php foreach ($result as $row) { 
        $score = $row['Score'];
        $review = $row['review'];
        $userID = $row['user_ID'];
        $userName = $row['user_name'];
    ?>
     <tr>
      <td class="num"><?php echo $score; ?></td>
      <td><?php echo $review; ?></td>
      <td><a href="reviewerDetail.php?user=<?php echo $userID; ?>">
        <?php echo $userName; ?></a></td>
    </tr>
      <?php } ?>
  </table>
  <?php } else { // end if($result) ?>
    <p id="review">No reveiws yet - Be the first: 
    <?php if($_SESSION['loggedIn'] == true) { ?>
    <a class="submitR"
     href="#review" onclick="submitReview(<?php echo $id; ?>)">
      Review Movie</a>
  <?php } else { ?>
    <a class="submitR" href="login.php?movie=<?php echo $id; ?>">Sign In</a>
    <?php } ?>
  </p>
    <?php } ?>
  </div> <!--END OF #REVIEW-->
</div> <!--END OF .COL-12 -->
</div> <!--END OF .ROW -->
      
<!----------------------- FOOTER ------------------------->
<?php require('footer.php'); ?>