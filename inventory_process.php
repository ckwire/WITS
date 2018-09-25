<?php
    include "includes/wits.inc.php"; 


$itemID = htmlspecialchars($_POST['txtItemNumber']);
$itemName = htmlspecialchars($_POST['txtItemName']);
$itemDescription = htmlspecialchars($_POST['txtItemDescription']);
$itemCost = htmlspecialchars($_POST['txtCost']);
$itemPrice = htmlspecialchars($_POST['txtPrice']);
$itemUnit = htmlspecialchars($_POST['dropUnit']);
$itemStatus = htmlspecialchars($_POST['dropStatus']);
   

// check for existing itemID

if($_GET['op'] == 'new'){
    inv_newItemEntry($itemID, $itemName, $itemDescription, $itemCost, $itemUnit, $itemPrice, $itemStatus);
    header("Location: inventory.php");
}else{
    inv_editItemEntry($itemID, $itemName, $itemDescription, $itemCost, $itemUnit, $itemPrice, $itemStatus);
    header("Location: inventory.php");
}

?>