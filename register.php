<?php
    require 'php/vendor/autoload.php';
    use Google\Cloud\BigQuery\BigQueryClient;
    ?>
<?php
    $text= $username= $pass= $credentials= "";
    if(isset($_POST["submit"])){

        $username=($_POST["username"]);
        $password=($_POST["pass"]);
         $role=($_POST["role"]);
            if($role=="Admin" || $role=="Customer"){
                $projectId='cloudlab3-249301';
                $datasetId='Testing';
                $bigQuery = new BigQueryClient([
                                               'projectId' => $projectId,
                                               ]);
                $dataset = $bigQuery->dataset($datasetId);
                
                $query="SELECT max(user_id) as user_id FROM `Testing.user_credential`";
                
                $queryJobConfig = $bigQuery->query($query);
                $queryResults = $bigQuery->runQuery($queryJobConfig);
                if($queryResults->isComplete())
                {
                    foreach ($queryResults as $maxuserid)
                    $userid=$maxuserid['user_id']+1;
                }
                else
                {
                    $userid=1;
                }
                
                $sql="INSERT INTO `user_credential` (`user_id`,`user`, `password`,`role`) VALUES ($userid,'$username','$password','$role')";
                
                $queryConfig = $bigQuery->query($sql)->defaultDataset($dataset);
                $response=$bigQuery->runQuery($queryConfig);
                
                if($response->isComplete())
                {
                    header("location:login.php");
                }
            }
            else
                echo "Role has to be either Admin or Customer!"."\n"." Please check your spelling and retry";
    }
    ?>
<html>
<body>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
body {
    background-image: url("https://storage.cloud.google.com/s3811346-storage/1433452-1440x900-%5BDesktopNexus.com%5D.jpg");
width: 100%;
}
</style>
<form action="" class="form-container" method="post" style="right : 500px; left: 500px; top: 300px; botton: 300px; position: absolute;">
<label><input type="text" name="username" placeholder="Enter Username" required></label> <br>
<label><input type="password" name="pass" placeholder="Enter Password"> </label><br>
<div class="input-group">
<div class="title">
<label>Role: </label>
<select name="role">
<option disabled="disabled" selected="selected">Select</option>
<option>Admin</option>
<option>Customer</option>
</select>
<div class="select-dropdown"></div> <br>
</div>
</div>
<button type="submit" style="height : 100 px; width : 100px;" name="submit" class="btn btn-success">Register</button>
<label><a href="login.php">Cancel</a></label>
</form>
</div>
</body>
</html>

