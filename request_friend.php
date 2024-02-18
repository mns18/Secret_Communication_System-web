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
    <link rel="stylesheet" href="css/chat.css">
</head>
<body>
    <div class="all">
    <?php include("include/header.php") ?>
        <div class=" container bg-gray vh-100">
            <div class="component row p-4">
                
                <table class="table table-hover">
                    <tbody>
                        <?php 
                        $user_id = $_GET['user_id'];
                            $users_quey = "SELECT * FROM connects WHERE accecpt_id = $user_id AND connect_status= 'request'";
                            $login_id = $_GET['user_id'];
                            $user_res  = mysqli_query($connection, $users_quey);
                            if(mysqli_num_rows($user_res)> 0){
                                while($user = mysqli_fetch_assoc($user_res)){
                                    $accept_id = $user['request_id'];
                                    $connect_id = $user['connect_id' ];

                                    $req = "SELECT * FROM users WHERE user_id = $accept_id";
                                    $req_res = mysqli_query($connection, $req);
                                    $name_d = mysqli_fetch_assoc($req_res);
                                    $sender_name = $name_d['user_name'];
                                    $user_id = $user['connect_id'];
                                    
                                    ?>
                                        <tr>
                        
                                            <td><div class="col-2">
                                                <img class=" img-thumbnail" src="image/images.png" alt="" style = " height: 60px; width: 60px;">
                                            </div></td>
                                            <td><div class="col-8"><?php echo $sender_name ?></div></td>
                                            <td><div class="col-2"> <a class="btn btn-primary" href="request_friend.php?user_id=<?php echo $login_id ?>&request_id=<?php echo $connect_id ?>">Accept</a> </div></td>
                                            </tr>
                                    <?php
                                }
                            }else{
                                echo "No user available for this moment";
                            }
                        ?>
                        
                        
                    </tbody>
                </table>
                <?php 
                    if(isset($_GET['user_id'])&& isset($_GET['request_id'])){
                        $user_id = $_GET['user_id'];
                        $request_id = $_GET['request_id'];
                        $request_query = "UPDATE connects SET connect_status = 'accept' WHERE connect_id = $request_id";
                        $request_res = mysqli_query($connection, $request_query);
                        if($request_res){
                            header("Location: request_friend.php?user_id=$user_id");
                        }
                    }
                ?>

                
            </div>
        </div>
</body>
</html>

 