<?php 

    require "loginheader.php"; 
    include "includes/functions.php";
    include "includes/wits.inc.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>WITS - Dashboard</title>

    

</head>

<body>

    <!--Main Navigation-->



    <?php
            //includes default header navigation
            include_once('includes/header.inc.php');
        ?>


        <!--Main Navigation-->

        <!--Main Layout-->
        <main>
            <div class="container-fluid" style="margin-top:20px;">

                <div class="card">
                    <div class="card-header">
                        Location Status:
                    </div>
                    <div class="card-body">
                        <?php
                            $locations = dash_displayLocations();

                            foreach($locations as $location){
                                if($location['locationStatus'] == 1)
                                {
                                    echo '<a href="location.php?id=' . $location['locationID'] .'" class="btn btn-success">' . $location['locationName'] .'</a>&nbsp';
                                }
                                elseif($location['locationStatus'] == 2)
                                {
                                    echo '<a href="location.php?id=' . $location['locationID'] .'" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Inactive">' . $location['locationName'] .'</a>&nbsp';
                                }
                                elseif($location['locationStatus'] == 3)
                                {
                                    echo '<a href="location.php?id=' . $location['locationID'] .'" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Pending">' . $location['locationName'] .'</a>&nbsp';
                                }
                                else
                                {
                                    echo "Error!";
                                }
                            }
                            next($locations);
                        ?>
                    </div>


                </div>

                </br>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <a href="inventory.php" class="btn btn-light">Inventory</a>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">New Items</h4>
                                
                                <?php 
                                    $topItems = dash_displayTop3Items();

                                    foreach($topItems as $item){
                                        echo '<hr>';
                                        echo '<p class="card-text"><a href="inventory.php?item=' . $item['inventoryID'] .'">'.$item['inventoryID'].'</a>'. "&emsp;-&emsp;" . $item['inventoryName'] .'</p>';
                                    }
                                    next($locations);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" >
                            <div class="card-header">
                                <a href="orders.php" class="btn btn-light">Orders</a>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">New Orders</h4>
                                
                                <?php 
                                    $topItems = dash_displayTop3Orders();

                                    foreach($topItems as $item){
                                        echo '<hr>';
                                        echo '<p class="card-text"><a href="orders.php?id='.$item['orderID'].'">'.$item['orderID'].'</a>'. "&emsp;-&emsp;" . $item['orderDate'].'</a>'. "&emsp;-&emsp;$" . $item['orderTotal'] .'</p>';
                                    }
                                    next($locations);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                </br>





            </div>
            <!-- main container -->



        </main>
        <!--Main Layout-->

</body>

</html>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>