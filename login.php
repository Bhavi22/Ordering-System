<?php
    if(isset($_SESSION['username']))
    {
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
    }
    require 'php/vendor/autoload.php';
    use Google\Cloud\BigQuery\BigQueryClient;
    ?>
<?php
    session_start();
    $userid = $password = "";
    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        $username=($_POST["username"]);
        $password=($_POST["password"]);
        $projectId='cloudlab3-249301';
        $bigQuery = new BigQueryClient([
                                       'projectId' => $projectId,
                                       ]);
    
        $str = '';
        
        $query="SELECT user,password,role,user_id FROM `Testing.user_credential` where user='$username' and password='$password' LIMIT 10";
        
        $queryJobConfig = $bigQuery->query($query);
        $queryResults = $bigQuery->runQuery($queryJobConfig);
        if($queryResults->isComplete())
        {
            foreach ($queryResults as $row)
            {
                if($row['role']=="Admin")
                {
                    $_SESSION['username']=$username;
                    $_SESSION['role']="Admin";
                    $_SESSION['userid']=$row['user_id'];
                    header("location:main.php");
                }
                else
                    if($row['role']=="Customer")
                    {
                        $_SESSION['username']=$username;
                        $_SESSION['role']="Admin";
                        $_SESSION['userid']=$row['user_id'];
                        header("location:customer.php");
                    }
            }
        }
            echo "Invalid Username or Password";
    }
    ?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<body>
<style>
body {
    background-image: url("https://storage.cloud.google.com/s3811346-storage/1433452-1440x900-%5BDesktopNexus.com%5D.jpg");
width: 100%;
    background-color: #cccccc;
}
</style>
<img src="" style="right : 500px; left: 500px; top: 300px; botton: 300px; position: absolute;">
<form action="" class="form-container" method="post" style="right : 500px; left: 500px; top: 300px; botton: 300px; position: absolute;">
<input type="text" name="username" placeholder="Username" required> <br> </br>
<input type="password" name="password" placeholder="Password" required> <br>
<button type="submit" class="btn btn-success">Log in</button>
<a href="register.php">Register</a>
</form>
</body>
</html>
