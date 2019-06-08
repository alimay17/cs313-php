<?php
require('header.php');
require('dbAccess/dbInsert.php');
$db = getDatabase();

// check if input is valid & set local variable
if(isset($_POST['password']) && isset($_POST['username'])
  && isset($_POST['email'])){
  $password = pg_escape_string($_POST['password']);
  $username = pg_escape_string($_POST['username']);
  $email = pg_escape_string($_POST['email']);
  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  $newUser = getNewUser($username, $email, $password_hash);
  if($newUser) {
    $_SESSION['user'] = $newUser;
    $_SESSION['loggedIn'] = true;
    heading("Location: landing.php");
    die();
  }
}

?>
<div class="row">
<div class="col-12">
<div class="menu">
  <h2 class="inst">REGISTER</h2>
</div> 
  <div class="login">
    <p class="message">All Fields are Required</p>
    <form method="post" onsubmit="return validateLogin()"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      <span>Username:</span>
      <input type="text" name="username"/>
      <span class="error" id="uNameError"></span><br/>

      <span>Email:</span>
      <input type="email" name="email"/>
      <span class="error" id="emailError"></span><br/>

      <span>Password:</span>
      <input type="password" name="password"/>
      <span class="error" id="passError"></span><br/>

      <input class="button" type="submit" name="register" value="REGISTER"/>
    </form>
  </div>
</div>
</div>
<!----------------------- FOOTER ------------------------->
<?php require('footer.php'); ?>
  