<?php require_once('config.php'); ?>

<?php 

if(isset($_POST['registration'])){
  $username = $_POST['username'];
  $name     = $_POST['name'];
  $email    = $_POST['email'];
  $phone    = $_POST['phone'];
  $password  = $_POST['password'];


  // databage username
  $statement = $pdo->prepare("SELECT username FROM users WHERE username=?");
  $statement->execute(array($username));
  $usercount = $statement->rowCount();

  // databage email

  $stm = $pdo->prepare("SELECT email FROM users WHERE email=?");
  $stm->execute(array($email));
  $useremail = $stm->rowCount();



  if(empty($username)){
    $error = "Input your username";
  }
  elseif($usercount == 1){
    $error = "This username already used!";
  }
  elseif(empty($name)){
    $error = "Input your name";
  }
  elseif(empty($email)){
    $error= "Input your email";
  }
  elseif($useremail == 1){
    $error = "This email already used";
  }
  elseif(empty($phone)){
    $error = "Enter your phone number";
  }
  elseif(empty($password)){
    $error= "Input your password";
  }
  else{
    $tmp_verify_code = rand(1,1000).rand(1,1000);
    $stm = $pdo->prepare("INSERT INTO users(username,name,email,phone,password,email_verify,tmp_verify_code) VALUES(?, ?, ?, ?, ?, ?, ?)");
    $stm->execute(array($username, $name,$email,$phone, $password,0,$tmp_verify_code));


    $email_text = "Hello! Your registration successful!";
    $email_text .= "Your verification code is : ";
    $email_text .= $tmp_verify_code;
 
    mail($email,"Verify your email", $email_text);
    
    header("location:emailverify.php?username=$username");
  }


}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create login page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="register-area">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <div style="height:500px; width:500px; margin: 0 auto;" class="form-area">
          <br><br>
          <form class="form-control" action="" method="POST">
            <h3 style="text-align:center; border-bottom: 1px dashed #000; padding-bottom: 5px;" >Registration Form</h3>

            <?php if(isset($error)) : ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if(isset($success)) : ?>
              <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>


            <div class="single-form">
               <label for="username">Username:</label>
               <input type="text" name="username" class="form-control" id="username">
            </div>
            <div class="single-form">
               <label for="name">Name:</label>
               <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="single-form">
               <label for="email">Email:</label>
               <input type="email" name="email" class="form-control" id="email">
            </div>
            <div class="single-form">
               <label for="phone">Phone:</label>
               <input type="text" name="phone" class="form-control" id="phone">
            </div>
            <div class="single-form">
               <label for="password">Password:</label>
               <input type="password" name="password" class="form-control" id="password">
            </div>
            <br>
            <div class="single-form">
               <input type="submit" name="registration" class="btn btn-success" value="Registration">
            </div>
            <br>
            <a class="btn btn-success" href="login.php">Login</a>
          </form>
         </div>
      </div>
    </div>
  </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>