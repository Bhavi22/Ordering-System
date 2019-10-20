<?php
    session_start();
    require 'php/vendor/autoload.php';
    use Google\Cloud\BigQuery\BigQueryClient;
    use Google\Cloud\PubSub\PubSubClient;
    use Google\Cloud\Datastore\DatastoreClient;
    use \google\appengine\api\mail\Message;
    ?>
<?php
    $userid=$_SESSION['userid'];
    ?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link type="text/css" rel="stylesheet" href="/bootstrap/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="/bootstrap/css/bootstrap-responsive.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
html
{
    background-image: url("https://storage.cloud.google.com/s3811346-storage/CueSa0.jpg");
width: 100%;
    background-color: #cccccc;
}
body {font-family: Arial, Helvetica, sans-serif; position: relative;
    background-image: url("https://storage.cloud.google.com/s3811346-storage/CueSa0.jpg");
width: 100%;
    background-color: #cccccc;
}
* {box-sizing: border-box;}
label-container
{
    color : white;
    position : fixed;
    right : 100%;
}
#box
{
border: 2px solid white;
padding: 10px;
    border-top-left-radius: 25px;
    border-top-right-radius: 25px;
    border-bottom-left-radius: 25px;
    border-bottom-right-radius: 25px;
width:50%;
}
</style>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<h1 style="color : white">Welcome <?php echo $_SESSION['username']?></h1>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-right">
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" href="#section1">Colombian Beans</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#section2">Indian Beans</a>
</li></li>
<li class="nav-item">
<a class="nav-link" href="#section3">Create Customer Profile</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#section4">Buy Now</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#section5">Inventory In Store</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#section6">Contact Us</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/login.php">Logout</a>
</li>
</ul>
</nav>
<div id="section1"  style="padding-top:70px;padding-bottom:70px; color : white">
<img src='https://storage.cloud.google.com/s3811346-storage/cloudlab3/wildfire-columbia-coffee-logo.jpg' width="193" height="130">
<?php
    $file= fopen('gs://s3811346-storage/ColombianCoffee.txt','r');
    $read=fread($file,filesize('gs://s3811346-storage/ColombianCoffee.txt'));
    echo $read;
    ?>
<div class="container">
<form action="" class="form-container" method="post" style="left : 800 ;top : 10 ; position: relative">
<button name="readreview1" type="submit" class="btn btn-info">Read Reviews</button>
</form>
<form action="" class="form-container" method="post" style="left : 800 ;top : 10 ; position: relative">
<p><input type="text" name="review1" style="color : black"></p>
<button type="submit" class="btn btn-success">Add Review</button>
<?php
    if(isset($_POST['readreview1']))
    {
        $projectId='cloudlab3-249301';
        $datastore = new DatastoreClient(['projectId' => $projectId]);
        $taskKey = $datastore->key('Review1');
        $task = $datastore->entity(
                                   $taskKey,
                                   [
                                   'name' => $_SESSION['username'],
                                   'review' => $review1,
                                   'date' => new DateTime()
                                   ]);
        $query = $datastore->query()->kind('Review1')->order('date', 'DESCENDING')->limit(6);
        $results = $datastore->runQuery($query);
        $visits = [];
        $str=" ";
        foreach ($results as $entity) {
            $str.="<br><label style=\"right : 300px;\">Comment: ".$entity['review']."<br>"."User: ".$entity['name']."</label><br>";
        }
        echo $str;
    }
    if(isset($_POST['review1'])){
        $projectId='cloudlab3-249301';
        $review1=$_POST['review1'];
        $datastore = new DatastoreClient(['projectId' => $projectId]);
        $taskKey = $datastore->key('Review1');
        $task = $datastore->entity(
                                   $taskKey,
                                   [
                                   'name' => $_SESSION['username'],
                                   'review' => $review1,
                                   'date' => new DateTime()
                                   ]);
        $datastore->insert($task);
        $query = $datastore->query()->kind('Review1')->order('date', 'DESCENDING')->limit(1);
        $results = $datastore->runQuery($query);
        $visits = [];
        $str=" ";
        foreach ($results as $entity) {
            $str.="<br><label style=\"right : 300px;\">Comment: ".$entity['review']."<br>"."User: ".$entity['name']."</label><br>";
        }
    
        echo $str;
    }
    ?>
</form>
</div>
</div>
<div id="section2"  style="padding-top:70px;padding-bottom:70px; color : white;">
<img src='https://storage.cloud.google.com/s3811346-storage/cloudlab3/logo.png' width="193" height="130">
<?php
    $file= fopen('gs://s3811346-storage/Indian.txt','r');
    $read=fread($file,filesize('gs://s3811346-storage/Indian.txt'));
    echo $read;
    ?>
<div class="container">
<form action="" class="form-container" method="post" style="left : 800 ;top : 10 ; position: relative">
<p><button name="readreview2" type="submit" class="btn btn-info">Read Reviews</button></p>
</form>
<form action="" class="form-container" method="post" style="left : 800 ;top : 10 ; position: relative">
<p><input type="text" name="review2" style="color : black"></p>
<button type="submit" class="btn btn-success">Add Review</button>
<?php
    if(isset($_POST['readreview2']))
    {
        $projectId='cloudlab3-249301';
        $datastore = new DatastoreClient(['projectId' => $projectId]);
        $taskKey = $datastore->key('Review2');
        $task = $datastore->entity(
                                   $taskKey,
                                   [
                                   'name' => $_SESSION['username'],
                                   'review' => $review2,
                                   'date' => new DateTime()
                                   ]);
        $query = $datastore->query()->kind('Review2')->order('date', 'DESCENDING')->limit(6);
        $results = $datastore->runQuery($query);
        $visits = [];
        $str=" ";
        foreach ($results as $entity) {
            $str.="<br><label style=\"right : 300px;\">User: ".$entity['name']."<br>"."Comment: ".$entity['review']."</label><br>";
        }
    
        echo $str;
        
    }
    if(isset($_POST['review2'])){
        $projectId='cloudlab3-249301';
        $review2=$_POST['review2'];
        $datastore = new DatastoreClient(['projectId' => $projectId]);
        $taskKey = $datastore->key('Review2');
        $task = $datastore->entity(
                                   $taskKey,
                                   [
                                   'name' => $_SESSION['username'],
                                   'review' => $review2,
                                   'date' => new DateTime()
                                   ]);
        $datastore->insert($task);
        $query = $datastore->query()->kind('Review2')->order('date', 'DESCENDING')->limit(1);
        $results = $datastore->runQuery($query);
        $visits = [];
        $str=" ";
        foreach ($results as $entity) {
            $str.="<br><label style=\"right : 300px;\">User: ".$entity['name']."<br>"."Comment: ".$entity['review']."</label><br>";
        }
        echo $str;
    }
    ?>
</form>
</div>
</div>
<div id="section4" style="padding-top:70px;padding-bottom:70px; ">
<div class="container">
<table class="table table-light table-hover" style="width : 50%">
<thead>
<tr><td>Coffee Type</td><td>Quantity</td><td>Price</td></tr></thead>
<tbody>
<form action="" method="post" class="form-group" method="post" style="color: white">
<tr><td><input type="checkbox" name="coffee[]" value="colombian1">Colombian Beans</td> <td> 1 KG </td> <td> $35 </td> </tr>
<tr><td><input type="checkbox" name="coffee[]" value="colombian2">Colombian Beans </td> <td> 2 KG </td> <td> $70 </td> </tr>
<tr><td><input type="checkbox" name="coffee[]" value="colombian3">Colombian Beans </td> <td> 3 KG </td> <td> $105 </td> </tr>
<tr><td><input type="checkbox" name="coffee[]" value="indian1">Indian Beans </td> <td> 1 KG </td> <td> $45 </td> </tr>
<tr><td><input type="checkbox" name="coffee[]" value="indian2">Indian Beans </td> <td> 2 KG </td> <td> $90 </td> </tr>
<tr><td><input type="checkbox" name="coffee[]" value="indian3">Indian Beans </td> <td> 3 KG </td> <td> $135 </td> </tr>
<br>
</tbody></table>
<button type="submit" name="add" class="btn btn-success">Add to Cart</button>
</form><br>
<form action="/cart.php" method="post">
<button type="submit" class="btn btn-outline-success">Go To Cart</button>
</form>
<?php
    if(isset($_POST['add']))
    {
        if(isset($_POST['coffee']))
        {
            $founduser=0;
            $userid=$_SESSION['userid'];
            $projectId='cloudlab3-249301';
            $datasetId='Testing';
            $bigQuery = new BigQueryClient([
                                           'projectId' => $projectId,
                                           ]);
            $dataset = $bigQuery->dataset($datasetId);
            $query="SELECT user_id FROM `Testing.customer_info` where user_id=$userid";
            $queryJobConfig = $bigQuery->query($query);
            $queryResults = $bigQuery->runQuery($queryJobConfig);
            if($queryResults->isComplete())
            {
                foreach ($queryResults as $founduserid)
                {
                    $founduser=$founduserid['user_id'];
                }
            }
            
            if($founduser!=0)
            {
                
                $query="SELECT max(order_id) as order_id FROM `Testing.order_details`";
                $queryJobConfig = $bigQuery->query($query);
                $queryResults = $bigQuery->runQuery($queryJobConfig);
                if($queryResults->isComplete())
                {
                    foreach ($queryResults as $maxorderid)
                    $orderid=$maxorderid['order_id']+1;
                }
                else
                {
                    $orderid=1;
                }
                $query="SELECT max(order_details_id) as order_details_id FROM `Testing.order_details`";
                $queryJobConfig = $bigQuery->query($query);
                $queryResults = $bigQuery->runQuery($queryJobConfig);
                if($queryResults->isComplete())
                {
                    foreach ($queryResults as $maxorderdetailid)
                    $orderdetailid=$maxorderdetailid['order_details_id']+1;
                }
                else
                {
                    $orderdetailid=1;
                }
                
                $coffeetype=$_POST['coffee'];
                for($i=0;$i<count($coffeetype);$i++)
                {
                    $coffee=$coffeetype[$i];
                    if($coffee=="colombian1")
                    {
                        $coffee="colombian";
                        $quantity=1;
                    }
                    else
                        if($coffee=="colombian2")
                        {
                            $coffee="colombian";
                            $quantity=2;
                        }
                        else
                            if($coffee=="colombian3")
                            {
                                $coffee="colombian";
                                $quantity=3;
                            }
                            else if($coffee=="indian1")
                            {
                                $coffee="indian";
                                $quantity=1;
                            }
                            else if($coffee=="indian2")
                            {
                                $coffee="indian";
                                $quantity=2;
                            }
                            else  if($coffee=="indian3")
                            {
                                $coffee="indian";
                                $quantity=3;
                            }
                    
                    
                    $dataset = $bigQuery->dataset($datasetId);
                    $query="SELECT item_id as item_id, item_price as item_price FROM `Testing.item` where item_description='$coffee'";
                    $queryJobConfig = $bigQuery->query($query);
                    $queryResults = $bigQuery->runQuery($queryJobConfig);
                    if($queryResults->isComplete())
                    {
                        
                        foreach($queryResults as $itemdetails)
                        {
                            $item_id=$itemdetails['item_id'];
                            $item_price=$itemdetails['item_price'];
                        }
                    }
                    $item_price=$item_price*$quantity;
                    $sql="INSERT INTO `order_details` (`order_id`,`order_details_id`,`item_id`,`item_price`,`quantity`) VALUES ($orderid,$orderdetailid,$item_id,$item_price,$quantity)";
                    $queryConfig = $bigQuery->query($sql)->defaultDataset($dataset); $response=$bigQuery->runQuery($queryConfig);
                    if($response->isComplete()) {
                        $orderdetailid++;
                    }
                    else
                        echo "BigQuery issue!";
                }
    ?>
<div class="alert alert-success" style="left : 0; position : relative;">
<strong>Items added to cart</strong><br>Go to Cart to complete check-out!
</div>
<?php
    }
    else
    {
        ?>
<div class="alert alert-success" style="left : 0; position : relative;">
<strong>Please Create Customer Profile first!</strong><br>
</div>
<?php
    
    }
    $_SESSION['orderid']=$orderid;
    }
    else
    {
        ?>
<div class="alert alert-danger" style="left : 0; position : relative;">
<strong>Oops! You did not enter a selection, try again!</strong><br>
</div>
<?php
    }
    }
    ?>
</div>
</div>
<div id="section3" style="padding-top:70px;padding-bottom:70px; color : white;">
<div class="container" id="box">
<h3>Enter your details</h3>
<form action="" method="post" class="form-group" method="post" style="left : 800 ;top : 10 ; color: white">
<label>First name   : <input type="text" name="firstname" class="form-control"required> <br>
Last name    : <input type="text" name="lastname" class="form-control"> <br></label>
<label>Phone number : <input type="text" name="phone_no" class="form-control"required> <br>
Email        : <input type="email" name="email" class="form-control" required> <br></label>
<button type="submit" class="btn btn-info">Create</button>
</form>
</div></div>
<?php
    if(isset($_POST['firstname']))
    {
        $userid=$_SESSION['userid'];
        $_SESSION['flag']="false";
        $firstname=($_POST["firstname"]);
        $phone_no=($_POST["phone_no"]);
        $email=($_POST["email"]);
        
        if(!empty($_POST["lastname"]))
            $lastname=($_POST["lastname"]);
        else
            $lastname=" ";
        $projectId='cloudlab3-249301';
        $datasetId='Testing';
        $bigQuery = new BigQueryClient([
                                       'projectId' => $projectId,
                                       ]);
        $dataset = $bigQuery->dataset($datasetId);
        $sql="SELECT user_id FROM `Testing.customer_info` where user_id=$userid";
        
        $queryJobConfig = $bigQuery->query($sql);
        $queryResults = $bigQuery->runQuery($queryJobConfig);
        if($queryResults->isComplete())
        {
            foreach($queryResults as $found)
            {
                if(($found['user_id']))
                {
                    $_SESSION['flag']="true";
                    ?>
<div class="alert alert-warning" style="top : 0; position : relative;">
<strong>We have your details from earlier!</strong>.
</div>
<?php
    }
    }
    }
    if($_SESSION['flag']=="false")
    {
        $sql="INSERT INTO `customer_info` (`user_id`,`first_name`,`last_name`,`phone_no`,`email`) VALUES ($userid,'$firstname','$lastname',$phone_no,'$email')";
        
        $queryConfig = $bigQuery->query($sql)->defaultDataset($dataset);
        $response=$bigQuery->runQuery($queryConfig);
        
        if($response->isComplete())
        {
            ?>
<div class="alert alert-success" style="top : 0; position : relative;">
<strong>Details have been saved!</strong>
</div>
<?php
    }
    }
    }
    ?>

<div id="section5"  style="padding-top:70px;padding-bottom:70px; color : white" >
<div class="container" id="box">
<h2>Your Current In Store Inventory</h2>
<?php
    $item="No Items Found";
    $founduser=0;
    $userid=$_SESSION['userid'];
    $projectId='cloudlab3-249301';
    $datasetId='Testing';
    $bigQuery = new BigQueryClient([
                                   'projectId' => $projectId,
                                   ]);
    $dataset = $bigQuery->dataset($datasetId);
    $query="SELECT user_id,i.available_quantity,it.item_description FROM `Testing.inventory` as i, `Testing.item` as it where i.user_id=$userid and i.item_id=it.item_id";
    $queryJobConfig = $bigQuery->query($query);
    $queryResults = $bigQuery->runQuery($queryJobConfig);
    if($queryResults->isComplete())
    {
        $quantity=0;
        $str="<table  class=\"table table-light table-hover table-striped\"><thead><tr><th>"."<label>Coffee</label></th>"."<th>Quantity</th></tr></thead><tbody>";
        foreach ($queryResults as $found)
        {
            $founduser=$found['user_id'];
            if($founduser!=0)
            {
                $item=$found['item_description'];
                $quantity=$found['available_quantity'];
                $str.="<tr><td>".$item." </td>"."<td>".$quantity."</td></tr>";
                if($quantity<1)
                {
                    
                    ?>
<form action="" method="post">
<button type="submit" name="reminder" class="btn btn-success">Reminder E-mail</button>
</form>
<?php
                }
            }
        }
    if($founduser!=0)
    {
        $str.="</tbody></table>";
        echo $str;
    ?>
<h3 style="color : white;"> Update Inventory </h3>
<br>
<form action="" method="post" style=" color : white; ">
<div class="input-group">
<div class="title">
<label>Coffee: </label>
<select name="coffeebeans">
<option disabled="disabled" selected="selected">Select</option>
<option>Colombian</option>
<option>Indian</option>
</select>
<div class="select-dropdown"></div> <br>
</div>
</div>
<input type="number" name="newquantity" placeholder="New Quantity">
<button type="submit" name="update" class="btn btn-outline-success">Update</button>
</form>
</div>
<?php
    
    }
    else
    {
        ?>
<h2>0</h2>
<?php
    }
    
}
    if(isset($_POST['update']))
    {
        if(isset($_POST['coffeebeans']))
        {
            if($_POST['coffeebeans']=="Colombian")
            {
                $coffee="colombian";
            }
            else
                $coffee="indian";
            
            $newquantity=$_POST['newquantity'];
            $projectId='cloudlab3-249301';
            $datasetId='Testing';
            $bigQuery = new BigQueryClient([
                                           'projectId' => $projectId,
                                           ]);
            $dataset = $bigQuery->dataset($datasetId);
            $query="SELECT item_id as item_id FROM `Testing.item` where item_description='$coffee'";
            $queryJobConfig = $bigQuery->query($query);
            $queryResults = $bigQuery->runQuery($queryJobConfig);
            if($queryResults->isComplete())
            {
                
                foreach($queryResults as $itemdetails)
                {
                    $item_id=$itemdetails['item_id'];
                }
            }
            $updated="failure";
            $sql="UPDATE `Testing.inventory` set available_quantity=$newquantity where user_id=$userid and item_id=$item_id";
            
            $queryJobConfig = $bigQuery->query($sql);
            $queryResults = $bigQuery->runQuery($queryJobConfig);
            if($queryResults->isComplete())
            {
                
                ?>
<div class="alert alert-success" style="top : 0; position : relative;">
<strong>Quantity updated successfully!</strong>
</div>
<?php
    
    }
    }
    else
    {
        ?>
<div class="alert alert-danger" style="top : 0; position : relative;">
<strong>Please Select an Item to update!</strong>
</div>
<?php
    }
    }
    ?>

<?php
    if(isset($_POST['reminder']))
    {
        $query="SELECT email from `Testing.customer_info` where user_id=$userid;";
        $queryJobConfig = $bigQuery->query($query);
        $queryResults = $bigQuery->runQuery($queryJobConfig);
        if($queryResults->isComplete())
        {
            foreach ($queryResults as $email)
            $mail = $email['email'];
        }
        $customersubject='Coffee Shop Reminder';
        $customeremail=$mail;
        $customermessage = new Message();
        $customermessage->setSender("bhavi.smehta@gmail.com");
        $customermessage->addTo($customeremail);
        $customermessage->setSubject($customersubject);
        $customermessage->setTextBody("You're running out of Coffee! This is a reminder to order for more soon");
        $customermessage->setHTMLBody("<h1>This is a test. Do you see the h1 tags? </h1>");
        $customermessage->send();
    }
    ?>
</div>
</div>
</div>
</div>
<div id="section6"  style="padding-top:70px;padding-bottom:70px; color : white;">
<p>Need more help?</p>
<p>Contact us</p>
<p><span class="glyphicon glyphicon-map-marker"></span>Melbourne, Australia</p>
<p><span class="glyphicon glyphicon-phone"></span>Phone: +61 0424 000 000</p>
<p><span class="glyphicon glyphicon-envelope"></span>Email: mail@mail.com</p>
</div>
</body>
</html>
