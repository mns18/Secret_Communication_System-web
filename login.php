<?php include("include/connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/create_account.css">
</head>
<body>
    <div class="all">
    <video autoplay muted loop id="backgroundVideo"><source src="image/login.mp4" type="video/mp4"></video>
    <div class="header navbar ps-4 pt-2">
        <div class="image float-start">
            <img src="image/output-onlinegiftools.gif" alt="">
        </div>
        <div class="text float-start">
        <h2 class = "text-white">SEcom</h2>
        </div>
        
        
        
        
    </div>
    <div class="position-absolute top-50 start-50 translate-middle" id = "create_space">
        <div class="card p-2">
            <div class="card-title border-bottom border-danger p-2">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    
                    <div class="eemail">
                        <label for="email">Email</label>
                        <input type="email" name="email" class=" form-control mt-2 mb-4" id="">
                    </div>
                    <div class="pass">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control mt-2 mb-4" id="">
                    </div>

                    <button type="submit" class="btn btn-primary" name="login" >Login</button>
                </form>
               <?php 
                    if(isset($_POST['login'])){
                        $input_email = $_POST['email'];
                        $input_pass = $_POST['password'];
                        $email_check_query = "SELECT * FROM users WHERE user_email = '$input_email'";
                        $check_mail_res = mysqli_query($connection, $email_check_query);
                        if(mysqli_num_rows($check_mail_res) > 0){
                            $user = mysqli_fetch_assoc($check_mail_res);
                            $user_password = $user['user_password'];
                            if($input_pass == $user_password){
                                $user_id = $user['user_id'];
                                header("Location: index.php?user_id=$user_id");
                            }else{
                                ?>
                                    <div class="alert bg-danger top-0 position-absolute z-3 ">
                                        <span class="closebtn float-end"style = "font-size: 20px; cursor: pointer;"
                                            onclick="this.parentElement.style.display='none';">&times;</span>
                                        <strong class=" text-white ">Incorrect Pssword!</strong>
                                        <p class=" text-white ">Your password is incorrect please input your wont password for login</p>
                                    </div>
                                    <?php
                            }
                        }?>
                        <div class="alert bg-danger top-0 position-absolute z-3 ">
                            <span class="closebtn float-end"style = "font-size: 20px; cursor: pointer;"
                                onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong class=" text-white ">Email Problem</strong>
                            <p class=" text-white ">Input a mail that you use to create account or create new one</p>
                        </div>
                        <?php
                    }
                    
               ?>
            </div>
            <div class="card-footer">
                <small>Are you new? <a href="create_account.php" class = " text-decoration-none">Create</a></small>
            </div>
        </div>
    </div>
    </div>
</body>
</html>