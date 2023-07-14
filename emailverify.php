<?php 
 require_once('config.php');

if(!isset($_REQUEST['username'])){
    header('location:registration.php');
}

 $username = $_REQUEST['username'];

 $stm = $pdo->prepare("SELECT * FROM users WHERE username=?");
 $stm->execute(array($username));
 $result = $stm->fetchAll(PDO::FETCH_ASSOC);
 foreach($result as $row){
    $db_email_verify_status = $row['email_verify'];
    $db_tmp_verify_code = $row['tmp_verify_code'];
 }

 if($db_email_verify_status == 1){
    header('location:login.php');
 }
  if(isset($_POST['email_verify_submit'])){
    $email_verify_code = $_POST['email_verify_code'];


    if($db_tmp_verify_code == $email_verify_code){
        $stm = $pdo->prepare("UPDATE users SET email_verify=? WHERE username=?");
        $stm->execute(array(1,$username));
        $success = "Your email verification successful!";
      }
      else{
        $error = "Invalid code! Please try again!";
      }
  }
  



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>email verify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <h3 class="alert-heading">Registration successful! Please verify your email</h3>
                    </div>
                    <?php if(isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?> 
                    <?php if(!isset($success)) : ?>   
                    <div class="alert alert-danger" role="alert">
                        <p>Verify your email address:</p>
                        <p>Please check your email and submit the code here</p>
                        <br>
                        <form action="" method="POST">
                            <div class="form-group">
                            <input style="width:150px;" class="form-control" type="text" name="email_verify_code" id="" placeholder="input your code">
                            </div>
                            <br>
                            <input class="btn btn-success" type="submit" name="email_verify_submit" value="verify">
                        </form>
                    </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>