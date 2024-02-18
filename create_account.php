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
    <video autoplay muted loop id="backgroundVideo"><source src="image/create.mp4" type="video/mp4"></video>
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
                <h4>Create Account</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="name">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control mt-2 mb-4" id="">
                    </div>
                    <div class="eemail">
                        <label for="email">Email</label>
                        <input type="email" name="email" class=" form-control mt-2 mb-4" id="">
                    </div>
                    <div class="pass">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control mt-2 mb-4" id="">
                    </div>
                    <div class="conf-pass">
                        <label for="conf_pass">Confirm Password</label>
                        <input type="password" name="conf_pass" class="form-control mt-2 mb-4" id="">
                    </div>

                    <button type="submit" class="btn btn-primary" name="create" >Create</button>
                </form>
                <?php 
                    if(isset($_POST['create'])){
                        $input_name = $_POST['name'];
                        $input_email = $_POST['email'];
                        $input_pass = $_POST['password'];
                        $input_repass = $_POST['conf_pass'];
                        $check_mail_query = "SELECT * FROM users WHERE user_email = '$input_email'";
                        $check_mail_res = mysqli_query($connection, $check_mail_query);
                        if(mysqli_num_rows($check_mail_res) < 1){
                            if($input_pass == $input_repass){
                                class RSA{
                                    private $publicKey;
                                    private $privateKey;
                                    private $keyLength;

                                    public function __construct($keyLength = 1024)
                                    {
                                        $this->keyLength = $keyLength;
                                        $this->generateKeys();
                                    }

                                    public function getPublicKey()
                                    {
                                        return $this->publicKey;
                                    }

                                    public function getPrivateKey()
                                    {
                                        return $this->privateKey;
                                    }

                                    public function encrypt($message, $publicKey)
                                    {
                                        openssl_public_encrypt($message, $encrypted, $publicKey);
                                        return base64_encode($encrypted);
                                    }

                                    public function decrypt($encryptedMessage, $privateKey)
                                    {
                                        $encryptedMessage = base64_decode($encryptedMessage);
                                        openssl_private_decrypt($encryptedMessage, $decrypted, $privateKey);
                                        return $decrypted;
                                    }

                                    private function generateKeys()
                                    {
                                        $config = array(
                                            "digest_alg" => "sha512",
                                            "private_key_bits" => $this->keyLength,
                                            "private_key_type" => OPENSSL_KEYTYPE_RSA,
                                        );

                                        $keyPair = openssl_pkey_new($config);

                                        openssl_pkey_export($keyPair, $privateKey);

                                        $publicKeyDetails = openssl_pkey_get_details($keyPair);
                                        $publicKey = $publicKeyDetails['key'];

                                        $this->publicKey = $publicKey;
                                        $this->privateKey = $privateKey;
                                    }
                                }

                                $keys = new RSA(1024);
                                $publicKey = $keys->getPublicKey();
                                $privateKey = $keys->getPrivateKey();


                                $create_query = "INSERT INTO users (user_name, user_email, user_password, user_privet_kay, user_public_key, user_status)";
                                $create_query .= " VALUES ('$input_name', '$input_email', '$input_pass', '$privateKey', '$publicKey', 'Active')";
                                $create_res = mysqli_query($connection, $create_query);
                            }
                        }
                    }
                ?>
            </div>
            <div class="card-footer">
                <small>Already have an account? <a href="login.php" class = " text-decoration-none">
                    Login
                </a></small>
            </div>
        </div>
    </div>
    </div>
</body>
</html>