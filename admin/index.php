<?php 
    session_start();
    if($_POST){
        // metod php
        if(($_POST["user-name"] == "angel") && ($_POST["password-input"] == "123") ){
            $_SESSION["user"] = "ok";
            $_SESSION["userName"] = "angel";
            header("Location:Home.php");
        } else {
            $msgError = "ERROR: El usuario o contraseña son incorrectos";
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-4">
                <br><br><br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        
                        <?php if(isset($msgError) ) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo "$msgError"; ?>
                        </div> 
                        <?php } ?>

                        <form method="POST">
                            <div class = "form-group">
                                 <label for="username-input">User Name</label>
                                <input type="text" class="form-control" id="username-input" name="user-name" placeholder="Enter User Name">
                            </div>
                            <div class="form-group">
                                <label for="password-input">Password: </label>
                                <input type="password" class="form-control" id="password-input" name="password-input" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>