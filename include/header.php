<div class="header bg-primary w-100 row" style="height:120px">
        <div class=" container col-3">
            <div class="image justify-content-start ms-5 ">
                <img src="image/output-onlinegiftools.gif" class=" justify-content-start" style = "height: 60px; width: 60px;" alt="">
                <h1 class=" justify-content-start">SEcom</h1>
            </div>
            
        </div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary container col-9 mt-5">
            <?php $user_id = $_GET['user_id'] ?>
            <div class="container-fluid text-white">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                    <a class="nav-link active text-white" aria-current="page" href="index.php?user_id=<?php echo $user_id?>">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link text-white" href="find_friend.php?user_id=<?php echo $user_id?>">Find Friend</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link text-white" href="request_friend.php?user_id=<?php echo $user_id?>">Request</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link text-white" href="login.php">Logout</a>
                    </li>
                    
                </ul>
                </div>
            </div>
        </nav>

        </div>