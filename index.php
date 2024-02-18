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
        <div class="container-fluid">
            <div class="row vh-100">
                <div class="col-3 left-bar" style="overflow-y: scroll;">
                    <?php 
                        $user_id = $_GET['user_id'];
                        $people_quey = "SELECT * FROM connects WHERE request_id = $user_id OR accecpt_id = $user_id AND connect_status = 'accept'";
                        $People_res = mysqli_query($connection, $people_quey);
                        if(mysqli_num_rows($People_res)> 0){
                            while($people = mysqli_fetch_assoc($People_res)){
                                $chat_id;
                                $request_id = $people['request_id'];
                                $accecpt_id = $people['accecpt_id'];
                                if($accecpt_id == $user_id){
                                    $chat_id = $request_id;
                                }else{
                                    $chat_id = $accecpt_id;
                                }
                                $chat_name_query = "SELECT * FROM users WHERE user_id = $chat_id";
                                $chat_name_res = mysqli_query($connection, $chat_name_query);
                                $chat_name_c = mysqli_fetch_assoc($chat_name_res);
                                $chat_name = $chat_name_c['user_name'];
                                ?>
                                <div class="component border-bottom row" style="height: 60px;">
                                    <div class="image col-3">
                                        <img src="image/images.png" class="img-thumbnail rounded-circle" style="height:50px; width: 50px; margin-top:5px;" alt="">
                                    </div>
                                    <div class="text col-9">
                                        <div class="row">
                                            <a href="index.php?user_id=<?php echo $user_id; ?>&select_id=<?php echo $chat_id ?>" class="text-decoration-none p-3"><?php echo $chat_name ?></a>
                                        </div>
                                        <div class="row">
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                                <?php
                            }
                        }
                        
                    ?>
                    

                </div>
                <div class="col-7 border-2 border-end border-start h-100" >
                    
                        <div id="chatHeader" class="">
                            <?php 
                                if(isset($_GET['select_id'])){
                                    $select_id = $_GET['select_id'];
                                    $select_name_query = "SELECT * FROM users WHERE user_id = $select_id";
                                    $select_name_res = mysqli_query($connection, $select_name_query);
                                    $select_components = mysqli_fetch_assoc($select_name_res);
                                    $select_name = $select_components['user_name'];
                                    echo "<a href='#'>$select_name</a>";

                                }else{
                                    echo "<a href='#'>Name</a>";
                                }
                            ?>
                            
                            
                        </div>
                    
                        <div class="main card-body" style="height: 93%; overflow-y: scroll; overflow-x: hidden; margin-top: 20px;">
                        <?php 
                            if(isset($_GET['user_id']) && isset($_GET['select_id'])){
                                $user_id = $_GET['user_id'];
                                $select_id = $_GET['select_id'];
                                $selected_chat_query = "SELECT * FROM chats WHERE sender_id = $user_id AND receiver_id = $select_id OR receiver_id = $user_id AND sender_id = $select_id";
                                $selected_chat_res = mysqli_query($connection, $selected_chat_query);
                                if(mysqli_num_rows($selected_chat_res) > 0){
                                    while($chat = mysqli_fetch_assoc($selected_chat_res)){
                                        $chat_id = $chat['chat_id'];
                                        $sender_id = $chat['sender_id'];
                                        $receiver_id = $chat['receiver_id'];
                                        $chat_content = $chat['chat_content'];
                                        $chat_image = $chat['chat_image'];
                                        $chat_type = $chat['chat_type'];
                                        $chat_status = $chat['chat_status'];
                                        $chat_time = $chat['chat_time'];

                                        $get_key1_query = "SELECT * FROM users WHERE user_id = $user_id";
                                        $get_key1_res = mysqli_query($connection, $get_key1_query);
                                        $key1_com = mysqli_fetch_assoc($get_key1_res);
                                        $sender_public_key = $key1_com['user_public_key'];
                                        $sender_privet_key = $key1_com['user_privet_kay'];

                                        //decrypt Message
                                        if (!function_exists('decrypt')) {
                                            function decrypt($encryptedMessage, $privateKey)
                                                {
                                                $encryptedMessage = base64_decode($encryptedMessage);
                                                openssl_private_decrypt($encryptedMessage, $decrypted, $privateKey);
                                                return $decrypted;
                                            }
                                            }
                                        $decryptedMessage = decrypt($chat_content, $sender_privet_key);

                                        //Important path fixed.....
                                        $inputImagePath = "image/encImage/";
                                        $inputImagePath .= $chat_image;

                                        $parts = explode(".", $chat_image);
                                        $image_name = $parts[0];
                                        $image_name .= ".jpg";
                                        $outputImagePath = "image/decImage/";
                                        $outputImagePath .=$image_name;
                                        
                                        
                                        if (!function_exists('decryptImage')) {
                                                function decryptImage($inputImagePath, $outputImagePath, $key) {
                                                    $encryptedData = file_get_contents($inputImagePath);
                                                    $iv = substr($encryptedData, 0, 16);
                                                    $encryptedData = substr($encryptedData, 16);
                                                    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
                                                    file_put_contents($outputImagePath, $decryptedData);
                                                }
                                            }






                                        //Sender chat point
                                        if($sender_id == $user_id && $select_id == $receiver_id){
                                            //Get Private and Public Key From server
                                            $get_key1_query = "SELECT * FROM users WHERE user_id = $user_id";
                                            $get_key1_res = mysqli_query($connection, $get_key1_query);
                                            $key1_com = mysqli_fetch_assoc($get_key1_res);
                                            $sender_public_key = $key1_com['user_public_key'];
                                            $sender_privet_key = $key1_com['user_privet_kay'];

                                            //decrypt message text
                                            if (!function_exists('decrypt')) {
                                                function decrypt($encryptedMessage, $privateKey)
                                                    {
                                                    $encryptedMessage = base64_decode($encryptedMessage);
                                                    openssl_private_decrypt($encryptedMessage, $decrypted, $privateKey);
                                                    return $decrypted;
                                                }
                                                }
                                            $decryptedMessage = decrypt($chat_content, $sender_privet_key);
                                            

                                            
                                            
                                            
                                            
                                            ?>
                                            <div class="row justify-content-end w-100 mb-2">
                                                <div class="right-chat float-end  me-2 bg-primary rounded" style="max-width: 75%;">
                                                    
                                                        <?php 
                                                            if($chat_type == "both" || $chat_type == "image" ){
                                                                echo "<div class='image w-100 p3 bg-primary pt-5'>";
                                                                    echo "<img class=' img-thumbnail w-100' src='image/encImage/$image_name'>";
                                                                echo "</div>";
                                                            }
                                                            
                                                        ?>
                                                    <p class=" p-2 bg-primary rounded " ><?php echo $decryptedMessage ?> </p>
                                                </div>
                                            </div>
                                            <?php
                                        }else{
                                            //Get Private and public kay of SENDER
                                            $get_key1_query = "SELECT * FROM users WHERE user_id = $select_id";
                                            $get_key1_res = mysqli_query($connection, $get_key1_query);
                                            $key1_com = mysqli_fetch_assoc($get_key1_res);
                                            $sender_public_key = $key1_com['user_public_key'];
                                            $sender_privet_key = $key1_com['user_privet_kay'];

                                            //Decrypt Message SENDER text
                                            if (!function_exists('decrypt')) {
                                                function decrypt($encryptedMessage, $privateKey){
                                                    $encryptedMessage = base64_decode($encryptedMessage);
                                                    openssl_private_decrypt($encryptedMessage, $decrypted, $privateKey);
                                                    return $decrypted;
                                                }
                                            }
                                            $decryptedMessage = decrypt($chat_content, $sender_privet_key);

                                            
                                            
                                            



                                            ?>
                                            <div class="row">
                                                <div class="left_chat w-75 float-start  rounded p-2">
                                                    <div class="image float-start">
                                                        <img src="image/images.png" style="height: 35px; width: 35px;" class="rounded-circle" alt="">
                                                    </div>
                                                    <div class="text bg-light float-start ms-2" style="width: calc(100% - 100px);">
                                                        <?php 
                                                        if($chat_type == "both" || $chat_type == "image" ){
                                                            echo "<div class='image w-100 p-3 bg-light pt-5'>";
                                                                if (file_exists($outputImagePath)) {
                                                                    echo "<img class=' img-thumbnail w-100' src='image/decImage/$image_name'>";
                                                                    
                                                                }else {
                                                                    ?>
                                                                    <form action="" method = "POST">
                                                                        <div class="form-group">
                                                                        <label for=""> To See Input Your Key</label>
                                                                        <input type="text" name="input_key" id="">
                                                                        <button type="submit"class = "btn" name = "img_decode">View image</button>
                                                                        </div>
                                                                    </form>
                                                                    <?php

                                                                    if(isset($_POST['img_decode'])){
                                                                        $key = $_POST['input_key'];
                                                                        decryptImage($inputImagePath, $outputImagePath, $key);
                                                                    }
                                                                }
                                                                echo "</div>";
                                                        }
                                                        ?>
                                                        <p class="text-star pt-3 ps-3 pe-3"><?php echo $decryptedMessage ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                }
                            }else{
                                echo "No chat selected";
                            }
                            
                        ?>
                        <?php 
                            
                        ?>
                    </div>
                    <div class="footer">
                        <div class="footer">
                            <form action="" method = "POST" enctype="multipart/form-data">
                                <div class="input-group mb-3 top-0 pb-3 pe-3">
                                    <div class="form-group">
                                    <input type="file" class="form-control" name="image" id="">
                                    <input type="text" class="form-control" placeholder="Input image key" name="key" id="">
                                    </div>
                                    <textarea class="form-control" name="input_text" style="resize: none;" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2"> </textarea>
                                    <button class="btn btn-outline-secondary" name = "sent_text" type="submit" id="button-addon2"><img src="image/sent-mail.png" style="height: 50px;" alt=""></button>
                                </div>
                            </form>

                        </div>
                        <?php 
                        if(isset($_POST['sent_text'])){
                            $input_text = $_POST['input_text'];
                            $sender_id = $_GET['user_id'];
                            $receiver_id = $_GET['select_id'];
                            $image = $_FILES['image']['name'];
                            $image_temp = $_FILES['image']['tmp_name'];
                            $key = $_POST['key'];
                            
                            
                            move_uploaded_file($image_temp, "image/encImage/$image");
                            function encryptImage($inputImagePath, $outputImagePath, $key) {
                                $inputData = file_get_contents($inputImagePath);
                                $iv = openssl_random_pseudo_bytes(16);
                                $encryptedData = openssl_encrypt($inputData, 'aes-256-cbc', $key, 0, $iv);
                                file_put_contents($outputImagePath, $iv . $encryptedData);
                            }

                            function chatType($image, $input_text){
                                if(!empty($input_text) && !empty($image)){
                                    $chat_type = "both";
                                    return $chat_type;
                                }elseif(empty($input_text) && !empty($image)){
                                    $chat_type = "image";
                                    return $chat_type;
                                }elseif(!empty($input_text) && empty($image)){
                                    $chat_type = "text";
                                    return $chat_type;
                                }else{
                                    $chat_type = 'empty';
                                    return $chat_type;
                                }
                            }
                            $parts = explode(".", $image);
                            $image_name = $parts[0];
                            $inputImage = "image/encImage/";
                            $inputImage .= $image;
                            $chat_image = $image_name;
                            $chat_image .= ".enc";
                            $encryptedImage = "image/encImage/";
                            $encryptedImage .=$chat_image;
                            $chat_type = chatType($image, $input_text);
                            encryptImage($inputImage, $encryptedImage, $key);
                            

                            $get_key1_query = "SELECT * FROM users WHERE user_id = $sender_id";
                            $get_key1_res = mysqli_query($connection, $get_key1_query);
                            $key1_com = mysqli_fetch_assoc($get_key1_res);
                            $sender_public_key = $key1_com['user_public_key'];
                            $sender_privet_key = $key1_com['user_privet_kay'];


                            function encrypt($message, $publicKey){
                                openssl_public_encrypt($message, $encrypted, $publicKey);
                                return base64_encode($encrypted);
                            }
                            $encryptedMessage = encrypt($input_text, $sender_public_key);
                            
                        
                           
                                $sent_query = "INSERT INTO chats (sender_id, receiver_id, chat_content, chat_image, chat_type, chat_status)";
                                $sent_query .= " VALUES ($sender_id, $receiver_id, '$encryptedMessage', '$chat_image', '$chat_type', 'sent')";
                                $sent_res = mysqli_query($connection, $sent_query);
                                if($sent_res){
                                    header("Location: index.php?user_id=$sender_id&select_id=$receiver_id");
                                }
                            
                            
                            
                        }
                    ?>
                    </div>
                </div>
                <div class="col-2 style=" style ="overflow-y: scroll;">
                    <div class="image">
                        <img src="image/images.png" class="img-thumbnail rounded-circle" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
window.onscroll = function() {myFunction()};
var navbar = document.getElementById("chatHeader");
var sticky = navbar.offsetTop;
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
    </script>
</body>
</html>

 