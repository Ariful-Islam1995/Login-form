<?php 
    ob_start();
    session_start();
    require_once('config.php');
 ?>

<?php 
   if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $statement->execute(array($username));
    $usercount= $statement->rowCount();
    $userdata = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach( $userdata as $singledata){
      $db_password = $singledata['password'];
      $email_verify = $singledata['email_verify'];
    }
    
    if(empty($username)){
      $error= "Input your usernmae";
    } 
    else if(empty($password)){
      $error= "input your password";
    }
    else if($usercount == 0){
        $error= "username or password doesn't match";
    }
    else{
       if($db_password == $password){
        if($email_verify == 1){
          $_SESSION['logged_in']='true';

         header('location:index.php');
        }
        else{
          $error = "please verify your email!";
        }
       }
       else{
         $error = "username or password doesn't match";
       }
    }
   }

?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create login page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
  <div class="main-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div style="height:300px; width:500px;" class="form-area">
                  <br>
                  <div class="form-group">
                    <form action="" method="POST">
                      <h4>Login Form</h4>
                        <?php if(isset($error)) : ?>
                          <div class="alert alert-danger">
                              <?php echo $error; ?>
                          </div>

                        <?php endif; ?>


                        <div class="single-form">
                            <label for="username">Username:</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="input your username">
                        </div>
                        <div class="single-form">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="input your password">
                        </div>
                        <br>
                        <div class="single-form">
                            <input type="submit" name="login" class="btn btn-success" value="login" >
                        </div>
                        <br>
                        <a class="btn btn-success" href="registration.php">Register</a>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
  </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>