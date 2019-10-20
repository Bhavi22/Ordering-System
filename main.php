<?php
    session_start();
    require 'php/vendor/autoload.php';
    use Google\Cloud\Datastore\DatastoreClient;
    use Google\Cloud\BigQuery\BigQueryClient;
    ?>
<?php
    $userid=$_SESSION['userid'];
    $projectId='cloudlab3-249301';
    $datasetId='Testing';
    $bigQuery = new BigQueryClient([
                                   'projectId' => $projectId,
                                   ]);
    if(isset($_POST['update']))
    {
        if(isset($_POST['order']))
        {
            $order=$_POST['order'];
            for($i=0;$i<count($order);$i++)
            {
                $orderid=$order[$i];
                echo $orderid;
                
                $sql="UPDATE `Testing.orders` set status='Completed' where order_id=$orderid";
                
                $queryJobConfig = $bigQuery->query($sql);
                $queryResults = $bigQuery->runQuery($queryJobConfig);
                if($queryResults->isComplete())
                {
                    
                    ?>
<div class="alert alert-success" style="top : 0; position : relative;">
<strong>Order has been Shipped!</strong>
</div>
<?php
    
    }
    }
    }
    else
    {
        ?>
<div class="alert alert-danger" style="left : 0; position : relative;">
<strong>Please select order to be updated</strong>
</div>
<?php
    }
    }
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
</style>
<body data-spy="scroll" data-target=".navbar" data-offset="50">
<h1 style="color : white">Welcome <?php echo $_SESSION['username']?></h1>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-right">
<ul class="navbar-nav">
<li class="nav-item">
<a class="nav-link" href="#section1">Order History</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#section2">Open Orders</a>
</li>
<li class="nav-item">
<a class="nav-link" href="/login.php">Logout</a>
</li>
</ul>
</nav>
<div id="section1"  style="padding-top:70px;padding-bottom:70px;">
<div class="container">
<h2 style="color : white"> Order History </h2>
<table  class="table table-dark table-hover table-striped" style="width: 75%">
<thead><tr><th>OrderId</th><th>Customer Name</th><th>Created Date</th><th>Status</th><th>Total Cost</th></tr></thead><tbody>

<?php
    $query="select o.order_id, first_name,last_name, FORMAT_DATETIME(\"%c\", created_date) as date,status, total_price from `Testing.orders` as o, `Testing.customer_info` as cus where cus.user_id=o.user_id Order by created_date ASC";
    
    $queryJobConfig = $bigQuery->query($query);
    $queryResults = $bigQuery->runQuery($queryJobConfig);
    if($queryResults->isComplete())
    {
        foreach ($queryResults as $orders)
        {
            echo "<tr><td>".$orders['order_id']."</td><td>".$orders['first_name']." ".$orders['last_name']."</td><td>".$orders['date']."</td><td>".$orders['status']."</td><td>".$orders['total_price']."</td></tr>";
        }
    }
?>
</tbody></table>
</div>

    
<div id="section2"  style="padding-top:70px;padding-bottom:70px;">
<div class="container">
<h2 style="color : white"> Pending Orders </h2>
<table  class="table table-light table-hover table-striped" style="width: 75%">
<thead><tr><th>OrderId</th><th>Customer Name</th><th>Created Date</th><th>Status</th><th>Total Cost</th></tr></thead><tbody>
<form action="" method="post">
<?php
    
    $query="select o.order_id, first_name,last_name, FORMAT_DATETIME(\"%c\", created_date) as date,status, total_price from `Testing.orders` as o, `Testing.customer_info` as cus where cus.user_id=o.user_id and status='Open' Order by created_date ASC";
    
    $queryJobConfig = $bigQuery->query($query);
    $queryResults = $bigQuery->runQuery($queryJobConfig);
    if($queryResults->isComplete())
    {
        foreach ($queryResults as $orders)
        {
            ?>
<tr><td><input type="checkbox" name="order[]" value=<?php echo $orders['order_id']; ?> >
<?php
    echo $orders['order_id']."</td><td>".$orders['first_name']." ".$orders['last_name']."</td><td>".$orders['date']."</td><td>".$orders['status']."</td><td>".$orders['total_price']."</td></tr>";
    }
    }
    ?>
</tbody></table>
<button type="submit" name="update" class="btn btn-outline-success">Ship Order</button>
</form>
</div>
</div>
</body>
</html>

