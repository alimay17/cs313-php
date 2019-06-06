<?php
/********************************************
 * Gets and displays selected reviewer details
 *******************************************/
// dabase access
require('dbAccess.php');
$db = getDatabase();

// get reviewer id for QUERY
$id = $_POST['reviewer'];

// First QUERY for reveiwer details
try{ 
  $sql = 'SELECT * FROM mv_user WHERE "user_ID" =' . $id;
  $statement = $db->query($sql);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
}catch (\PDOException $e) {
  echo $e->getMessage();
}
// display results
foreach ($result as $row) { ?>
  <div>
    <h2><?php echo $row['reviewer_name']; ?> </h2>
<?php }
  
  // Second Query for number of reveiws by reviewer
  try{
  $sql = 'SELECT * FROM movie_review AS m Join movie As movie ON m."movie_ID" = movie."movie_ID" JOIN mv_user AS r ON m."reviewer_ID" = r."user_ID" WHERE m."reviewer_ID" =' . $id;
  $statement = $db->query($sql);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  }catch (\PDOException $e) {
    echo $e->getMessage();
  }

  // display 2nd query results in table
  // movie_name links to movie details 
  if($result) {
  ?>
  <h4>Movies Reviewed</h4>
  <table>
     <tr>
       <th>Movie Name</th>
       <th>Score</th>
       <th>Reveiw</th>
     </tr>
  <?php foreach ($result as $row) { ?>
     <tr>
      <td class="link" onclick="getMovie(<?php echo $row['movie_ID']; ?>)">
        <?php echo $row['movie_name']; ?></td>
      <td><?php echo $row['Score']; ?></td>
      <td><?php echo $row['review']; ?></td>
    </tr>
      <?php } ?>
  </table>
  <a href="viewReviewers.php">Return to Browse</a>
  <?php } // end if($result) ?>