<?php 

$x = false;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>

<?php  



?>

<div class="container mt-2">
    <div class="row">
      <div class="col-md-4 offset-md-4">
        <form action="sign-in.php" id="myForm1" class="needs-validation"  method="POST">
          <div class="form-group">
            Username<input type="text" name="Username" class="form-control" required autofocus>
            <div class="valid-feedback">Valid</div>
            <div id="usernamechech">* 
                <?php 

                
                if(isset($_POST["Submit"]))
                {
                    $message = "";
                    $username = $_POST["Username"];
                
                    if(preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) { // for english chars + numbers only
                        // valid username, alphanumeric & longer than or equals 5 chars
                        $x = true;
                    }
                    else{
                        $message = "invalid username format!";
                        $x = false;
                    }
                    echo $message;
                    
                
                }
                ?>
            </div>
          </div>
          <div class="form-group">
            Password<input type="password" name="Password" class="form-control" required>
            <div class="valid-feedback">Valid</div>
            <div id="passwordcheck">*
            <?php 
                if(isset($_POST["Submit"])  && $x == true)
                {
                    $message = "";
                    $Password = $_POST["Password"];
                
                    if(preg_match('/^[a-zA-Z0-9]{6,}$/', $Password)) { // for english chars + numbers only
                        // valid username, alphanumeric & longer than or equals 6 chars
                    }
                    else{
                        $message = "Enter a strong Password!";
                        $x = false;
                    }
                    echo $message;
                    
                
                }
                ?> </div>
          </div>
          <div class="form-group">
            Confirm Password<input type="password" name="Passwordc" id="cPwdId" class="form-control" required>
            <div id="cPwdValid" class="valid-feedback">Valid</div>
            <div id="cPwdInvalid" class="invalid-feedback">a to z only (2 to 4 long)</div>
            <div id="">* 
            <?php 
                if(isset($_POST["Submit"]) && $x == true)
                {
                    $message = "";
                    $Password = $_POST["Password"];
                    $Passwordc = $_POST["Passwordc"];
                
                    if($Password == $Passwordc) { // for english chars + numbers only
                        // valid username, alphanumeric & longer than or equals 6 chars
                    }
                    else{
                        $message = "Passwords mUst be the same!";
                        $x = false;
                    }
                    echo $message;
                }
                ?>
            </div>
          </div>
          <div class="form-group">
            <input type="submit" value="submit" id="submitBtn" name="Submit" class="btn btn-primary submit-button" >
            <br><br>
            You already signed? <a href="index.php">Log in</a>
          </div>
        </form>
        <?php

        require_once("Includes/connection.php");
                if(isset($_POST["Submit"]) && $x == true){
                  $UserN = $_POST["Username"];
                  $Psswrd = $_POST["Password"];
                  $PsswrdC = $_POST["Passwordc"];
                  global $cn;
                  $query = "INSERT INTO users(username, password, passwordc)
                  values(:UseRName, :_PaSSWoRd, :PaSSWoRdC)";
                  $stmt = $cn->prepare($query);
                  $stmt->bindValue(":UseRName", $UserN);
                  $stmt->bindValue(":_PaSSWoRd", $Psswrd);
                  $stmt->bindValue(":PaSSWoRdC", $PsswrdC);
                  $Exec = $stmt->execute();
                  if($Exec){
                    header("Location: http://localhost/Project/index.php");
                  }
                  else{
                    echo"Somthing went wrog! Sign up again. ";
                  }
                }

        ?>
      </div>
    </div>
  </div>



</body>
</html>