<?php 
    error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    require "loginheader.php"; 
    include "includes/functions.php";
    include "includes/wits.inc.php";

    $allItems = inv_displayItems();

    if(!empty($_GET['item'])) {
        $itemID = $_GET['item'];
    }
    if(!empty($_GET['loc'])) {
        $locID = $_GET['loc'];
    }


    // ----------------------------------------------
    if(isset($_POST["add_to_order"]))  
    {  
         if(isset($_SESSION["order_sess"]))  
         {  
              $item_array_id = array_column($_SESSION["order_sess"], "item_id");  
              if(!in_array($_GET["id"], $item_array_id))  
              {  
                   $count = count($_SESSION["order_sess"]);  
                   $item_array = array(  
                        'item_id'               =>     $_GET["id"],  
                        'item_name'               =>     $_POST["hidden_name"],  
                        'item_price'          =>     $_POST["hidden_price"],  
                        'item_quantity'          =>     $_POST["quantity"],
                        'hidden_location'    =>      $_POST["hidden_location"] 
                   );  
                   $_SESSION["order_sess"][$count] = $item_array;  
              }  
              else  
              {  
                   echo '<script>alert("Item Already Added")</script>';  
                   echo '<script>window.location="inventory.php"</script>';  
              }  
         }  
         else  
         {  
              $item_array = array(  
                   'item_id'               =>     $_GET["id"],  
                   'item_name'               =>     $_POST["hidden_name"],  
                   'item_price'          =>     $_POST["hidden_price"],  
                   'item_quantity'          =>     $_POST["quantity"],
                   'item_location'    =>      $_POST["hidden_location"]
              );  
              $_SESSION["order_sess"][0] = $item_array;  
         }  
    }  
    if(isset($_POST["add_to_po"]))  
    {  
         if(isset($_SESSION["po_sess"]))  
         {  
              $item_array_id = array_column($_SESSION["po_sess"], "item_id");  
              if(!in_array($_GET["id"], $item_array_id))  
              {  
                   $count = count($_SESSION["po_sess"]);  
                   $item_array = array(  
                        'item_id'               =>     $_GET["id"],  
                        'item_name'               =>     $_POST["hidden_name"],  
                        'item_price'          =>     $_POST["hidden_price"],  
                        'item_quantity'          =>     $_POST["quantity"],
                        'item_location'    =>      $_POST["hidden_location"]  
                   );  
                   $_SESSION["po_sess"][$count] = $item_array;  
              }  
              else  
              {  
                   echo '<script>alert("Item Already Added")</script>';  
                   echo '<script>window.location="inventory.php"</script>';  
              }  
         }  
         else  
         {  
              $item_array = array(  
                   'item_id'               =>     $_GET["id"],  
                   'item_name'               =>     $_POST["hidden_name"],  
                   'item_price'          =>     $_POST["hidden_price"],  
                   'item_quantity'          =>     $_POST["quantity"],
                   'item_location'    =>      $_POST["hidden_location"]  
              );  
              $_SESSION["po_sess"][0] = $item_array;  
         }  
    }  


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>WITS - Inventory</title>

</head>

<body>

    <!--Main Navigation-->
    <?php
        //includes default header navigation
        include_once('includes/header.inc.php');
    ?>


        <!--Main Layout-->
        <main>
            <div class="container-fluid" style="margin-top:15px;">

                <div class="card">
                    <div class="card-body">
                        <a href="inventory.php" class="btn btn-secondary" role="button" aria-pressed="true">Item Dashboard</a>
                        <a href="inventory.php?op=new" class="btn btn-secondary" role="button" aria-pressed="true">New Items</a>
                        <?php
                            $locations = dash_displayLocations();
                            
                                foreach($locations as $location){
                                    if($location['locationStatus'] == 1)
                                    {
                                        echo '<a href="inventory.php?op=order&loc=' . $location['locationID'] .'" class="btn btn-success">' . $location['locationName'] .'</a>&nbsp';
                                    }
                                    elseif($location['locationStatus'] == 2)
                                    {
                                        //echo '<a href="location.php?id=' . $location['locationID'] .'" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Inactive">' . $location['locationName'] .'</a>&nbsp';
                                    }
                                    elseif($location['locationStatus'] == 3)
                                    {
                                        //echo '<a href="location.php?id=' . $location['locationID'] .'" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Pending">' . $location['locationName'] .'</a>&nbsp';
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

                <?php 
            
            if($_GET['op'] == 'new'){
                // NEW ITEM PAGE

                newItem();
            }
            elseif($_GET['op'] == 'show' && !empty($itemID)){
                showItemWithInv($itemID);
            }
            elseif(!empty($itemID)){
                editItem($itemID);
            } 
            elseif($_GET['op'] == 'order' && !empty($locID)){
                orderItems($locID);
            }
            else {
                // DEFAULT INVENTORY PAGE
                echo "</br><table class=\"table table-sm table-striped table-hover\">";
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>Item #</th>";
                        echo "<th>Item Name</th>";
                        echo "<th>Item Unit</th>";
                        echo "<th>Item Status</th>";
                        echo "<th>Item QTY Totals</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";


                foreach($allItems as $item){    
                    $id = $item['inventoryID'];
                        $qty = inv_itemQuanity($item['inventoryID']);
                        echo "<tr>";
                            echo '<th scope="row"><a href="inventory.php?item=' . $item['inventoryID'] .'">'.$item['inventoryID'].'</a></th>';
                            echo '<td>'.$item['inventoryName'].'</td>';
                            echo '<td>'.$item['unitDescription'].'</td>';
                            echo '<td>'.$item['statusDescription'].'</td>';

                            $var = $qty;
                            if($qty == 0){
                                echo '<td><a style="color:red;" href="inventory.php?op=show&item=' . $item['inventoryID'] .'">'. $qty .'</a></td>';
                            } else {
                                echo '<td><a href="inventory.php?op=show&item=' . $item['inventoryID'] .'">'. $qty .'</a></td>';
                            }
                                                            
                        echo "</tr>";
                }
                next($allItems);

                echo "</tbody>";
                echo "</table>";
                echo '<hr class="my-5">';
            }
            
            
            ?>



            </div>

        </main>

</body>

</html>

<?php
    // function:    newItem
    // description: shows blank form for new item
    function newItem(){
        $nextItem = inv_nextItemNumber();
        $nextItem = $nextItem['inventoryID']+1;
        
        echo '<div class="col-md-10 offset-md-1">';
        echo '<span class="anchor" id="formComplex"></span>';
        echo '<hr class="my-5">';
        echo '<h3>New Item Entry:</h3>';

            echo '<form method="post" action="inventory_process.php?op=new">';

                echo '<div class="row mt-4">';

                    // NUMBER
                    echo '<div class="col-sm-4 pb-3">';
                        echo '<label for="txtItemNumber">Item Number</label>';
                        echo '<input type="text" class="form-control" readonly="readonly" name="txtItemNumber" value=' . $nextItem .'>';
                    echo '</div>';

                    // NAME
                    echo '<div class="col-sm-8 pb-3">';
                        echo '<label for="txtItemName">Item Name #</label>';
                        echo '<input type="text" class="form-control" name="txtItemName" placeholder="Item Name">';
                    echo '</div>';

                    // DESCRIPTION
                    echo '<div class="col-sm-12 pb-3">';
                        echo '<label for="txtItemDescrition">Item Description</label>';
                        echo '<input type="text" class="form-control" name="txtItemDescription" placeholder="Item Description">';
                    echo '</div>';

                    //COST AMOUNT
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="txtCost">Item Cost</label>';
                        echo '<div class="input-group">';
                            echo '<div class="input-group-addon">$</div>';
                            echo '<input type="text" class="form-control" name="txtCost" placeholder="Item Cost">';
                        echo '</div>';
                    echo '</div>';

                    //PRICE AMOUNT
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="txtPrice">Item Price</label>';
                        echo '<div class="input-group">';
                            echo '<div class="input-group-addon">$</div>';
                            echo '<input type="text" class="form-control" name="txtPrice" placeholder="Item Price">';
                        echo '</div>';
                    echo '</div>';

                    // UNIT DROP DOWN
                    $units = inv_unitDropDown();

                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="dropUnit">Item Units</label>';
                        echo '<select class="form-control" name="dropUnit">';
                            echo '<option selected="selected" value=0 >Choose one</option>';
                        
                            foreach($units as $unit){
                                $localID = $unit['unitID'];
                                $localDescription = $unit['unitDescription'];

                                echo "<option value=" . $localID . ">". $localDescription ."</option>";
                            }
                            next($units); 

                        echo '</select>';
                    echo '</div>';

                    // UNIT DROP DOWN
                    $statuses = inv_statusDropDown();
                    
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="dropStatus">Item Status</label>';
                        echo '<select class="form-control" name="dropStatus">';
                            echo '<option selected="selected" value=0 >Choose one</option>';
                        
                            foreach($statuses as $status){
                                $statID = $status['statusID'];
                                $statDescription = $status['statusDescription'];

                                echo "<option value=" . $statID . ">". $statDescription ."</option>";
                            }
                            next($units); 

                        echo '</select>';
                    echo '</div>';
                echo '</div>';
         
                echo '<button type="submit" class="btn btn-primary">Submit</button>';
                
            echo '</form>';
        echo '<hr class="my-5">';
        echo '</div>';
    };

    // function: editItem
    // description: shows form along with values of the item number passed to it
    function editItem($itemID){
        
        $itemData = inv_populateForm($itemID);
                
        echo '<div class="col-md-10 offset-md-1">';
        echo '<span class="anchor" id="formComplex"></span>';
        echo '<hr class="my-5">';
        echo '<h3>Edit Item:</h3>';

            echo '<form action="inventory_process.php?op=edit" method="post">';

                echo '<div class="row mt-4">';

                    // NUMBER
                    echo '<div class="col-sm-4 pb-3">';
                        echo '<label for="txtItemNumber">Item Number</label>';
                        echo '<input type="text" class="form-control" readonly="readonly" name="txtItemNumber" value="'.$itemData[0][inventoryID].'">';
                    echo '</div>';

                    // NAME
                    echo '<div class="col-sm-8 pb-3">';
                        echo '<label for="txtItemName">Item Name #</label>';
                        echo '<input type="text" class="form-control" name="txtItemName" value="'.$itemData[0][inventoryName].'">';
                    echo '</div>';

                    // DESCRIPTION
                    echo '<div class="col-sm-12 pb-3">';
                        echo '<label for="txtItemDescrition">Item Description</label>';
                        echo '<input type="text" class="form-control" name="txtItemDescription" value="'.$itemData[0][inventoryDescription].'">';
                    echo '</div>';

                    //COST AMOUNT
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="txtCost">Item Cost</label>';
                        echo '<div class="input-group">';
                            echo '<div class="input-group-addon">$</div>';
                            echo '<input type="text" class="form-control" name="txtCost" value="'.$itemData[0][inventoryCost].'">';
                        echo '</div>';
                    echo '</div>';

                    //PRICE AMOUNT
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="txtPrice">Item Price</label>';
                        echo '<div class="input-group">';
                            echo '<div class="input-group-addon">$</div>';
                            echo '<input type="text" class="form-control" name="txtPrice" value="'.$itemData[0][inventoryPrice].'">';
                        echo '</div>';
                    echo '</div>';

                    // UNIT DROP DOWN
                    $units = inv_unitDropDown();

                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="dropUnit">Item Units</label>';
                        echo '<select class="form-control" name="dropUnit">';
                            $inv_unit = $itemData[0][inventoryUnit];
                        
                            foreach($units as $unit){
                                $localID = $unit['unitID'];
                                $localDescription = $unit['unitDescription'];

                                if($localID == $inv_unit){
                                    echo '<option selected="selected" value="' . $localID . '">'. $localDescription .'</option>';
                                }else
                                echo "<option value=" . $localID . ">". $localDescription ."</option>";
                            }
                            next($units); 

                        echo '</select>';
                    echo '</div>';

                    // UNIT DROP DOWN
                    $statuses = inv_statusDropDown();
                    
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="dropStatus">Item Status</label>';
                        echo '<select class="form-control" name="dropStatus">';
                            $inv_status = $itemData[0][inventoryStatus];

                            foreach($statuses as $status){
                                $statID = $status['statusID'];
                                $statDescription = $status['statusDescription'];
                                if($statID == $inv_status){
                                    echo '<option selected="selected" value="' . $statID . '">'. $statDescription .'</option>';
                                }else
                                    echo "<option value=" . $statID . ">". $statDescription ."</option>";
                            }
                            next($units); 

                        echo '</select>';
                    echo '</div>';
                echo '</div>';

                echo '<input type="submit" class="btn btn-primary"></input>';
                
            echo '</form>';
        echo '<hr class="my-5">';
        echo '</div>';
    };

    function showItemWithInv($itemID){
        
        // used to populate form fields / that will be disabled
        $itemData = inv_populateForm($itemID);
                       
        echo '<div class="col-md-10 offset-md-1">';
        echo '<span class="anchor" id="formComplex"></span>';
        echo '<hr class="my-5">';
        echo '<h3>Item Quantity by Location:</h3>';

            echo '<form action="inventory_process.php?op=edit" method="post">';

                echo '<div class="row mt-4">';

                    // NUMBER
                    echo '<div class="col-sm-4 pb-3">';
                        echo '<label for="txtItemNumber">Item Number</label>';
                        echo '<input type="text" class="form-control" readonly="readonly" name="txtItemNumber" value="'.$itemData[0][inventoryID].'">';
                    echo '</div>';

                    // NAME
                    echo '<div class="col-sm-8 pb-3">';
                        echo '<label for="txtItemName">Item Name #</label>';
                        echo '<input type="text" class="form-control" readonly="readonly" name="txtItemName" value="'.$itemData[0][inventoryName].'">';
                    echo '</div>';

                    // DESCRIPTION
                    echo '<div class="col-sm-12 pb-3">';
                        echo '<label for="txtItemDescrition">Item Description</label>';
                        echo '<input type="text" class="form-control" readonly="readonly" name="txtItemDescription" value="'.$itemData[0][inventoryDescription].'">';
                    echo '</div>';

                    //COST AMOUNT
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="txtCost">Item Cost</label>';
                        echo '<div class="input-group">';
                            echo '<div class="input-group-addon">$</div>';
                            echo '<input type="text" class="form-control" readonly="readonly" name="txtCost" value="'.$itemData[0][inventoryCost].'">';
                        echo '</div>';
                    echo '</div>';

                    //PRICE AMOUNT
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="txtPrice">Item Price</label>';
                        echo '<div class="input-group">';
                            echo '<div class="input-group-addon">$</div>';
                            echo '<input type="text" class="form-control" readonly="readonly" name="txtPrice" value="'.$itemData[0][inventoryPrice].'">';
                        echo '</div>';
                    echo '</div>';

                    // UNIT DROP DOWN
                    $units = inv_unitDropDown();

                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="dropUnit">Item Units</label>';
                        echo '<select class="form-control" readonly="readonly" name="dropUnit">';
                            $inv_unit = $itemData[0][inventoryUnit];
                        
                            foreach($units as $unit){
                                $localID = $unit['unitID'];
                                $localDescription = $unit['unitDescription'];

                                if($localID == $inv_unit){
                                    echo '<option selected="selected" value="' . $localID . '">'. $localDescription .'</option>';
                                }else
                                echo "<option value=" . $localID . ">". $localDescription ."</option>";
                            }
                            next($units); 

                        echo '</select>';
                    echo '</div>';

                    // UNIT DROP DOWN
                    $statuses = inv_statusDropDown();
                    
                    echo '<div class="col-sm-3 pb-3">';
                        echo '<label for="dropStatus">Item Status</label>';
                        echo '<select class="form-control" readonly="readonly" name="dropStatus">';
                            $inv_status = $itemData[0][inventoryStatus];

                            foreach($statuses as $status){
                                $statID = $status['statusID'];
                                $statDescription = $status['statusDescription'];
                                if($statID == $inv_status){
                                    echo '<option selected="selected" value="' . $statID . '">'. $statDescription .'</option>';
                                }else
                                    echo "<option value=" . $statID . ">". $statDescription ."</option>";
                            }
                            next($units); 

                        echo '</select>';
                    echo '</div>';
                echo '</div>';
                
            echo '</form>';
        echo '<hr class="my-5">';

        $locData = inv_showItemWithInv($itemID);
        echo '</div>';

        
    };

    function orderItems($locID){

        $allItems = inv_displayItems();
        // DEFAULT INVENTORY PAGE
        echo "</br><table class=\"table table-sm table-striped table-hover\">";
        echo "<thead>";
            echo "<tr>";
                echo "<th>Item #</th>";
                echo "<th>Item Name</th>";
                echo "<th>Item Unit</th>";
                echo "<th>Item Status</th>";
                echo "<th>Item QTY Totals</th>";
                echo "<th>Quantity --></th>";
                echo "<th>to Order</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";


        foreach($allItems as $item){    
            
            $id = $item['inventoryID'];
                
                $qty = ord_itemQuantityByLocation($id, $locID);
                echo "<tr>";
                    echo '<th scope="row"><a href="inventory.php?item=' . $item['inventoryID'] .'">'.$item['inventoryID'].'</a></th>';
                    echo '<td>'.$item['inventoryName'].'</td>';
                    echo '<td>'.$item['unitDescription'].'</td>';
                    echo '<td>'.$item['statusDescription'].'</td>';

                    if($qty[0]['recordQTY'] == 0){
                        echo '<td>0</a></td>';
                    } else {
                        echo '<td>'. $qty[0]['recordQTY'] .'</a></td>';
                    }

    
                    echo '<form name="orderForm" method="post" action="inventory.php?op=order&loc='. $locID .'&id='. $id .'">';
                        echo '<input type="hidden" name="hidden_item" value="' .$item['inventoryID']. '" />';
                        if($qty[0]['recordQTY'] == 0){
                            echo '<td><input type="text" name="quantity" disabled/></td>';
                        } else {
                            echo '<td><input type="text" name="quantity"/></td>';
                        }
                        echo '<input type="hidden" name="hidden_location" value="' .$locID. '" />';
                        echo '<input type="hidden" name="hidden_name" value="' .$item['inventoryName']. '" />';
                        echo '<input type="hidden" name="hidden_price" value="' .$item['inventoryPrice']. '" />';
                        
                        echo '<td><input type="submit" name="add_to_order" style="margin-top:5px;" class="btn btn-primary btn-sm" value="Order" /></td>';
                    echo '</form>';
                                                    
                echo "</tr>";
        }
        next($allItems);

        echo "</tbody>";
        echo "</table>";
        echo '<hr class="my-5">';
    }
?>

