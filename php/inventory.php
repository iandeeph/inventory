<?php
$menu = isset($_GET['menu'])?$_GET['menu']:'';
$cat = isset($_GET['cat'])?$_GET['cat']:'';
$detail = isset($_GET['detail'])?$_GET['detail']:'';
$user = isset($_SESSION['name'])?$_SESSION['name']:'';
$postMessages = isset($postMessages)?$postMessages:'';
$colorMessages = isset($colorMessages)?$colorMessages:'';
$now = date("Y-m-d H:i:s");

if ($detail == "A") {
    $itemCategory = "Laptop";
    $idCat = 1;
}elseif ($detail == "B") {
    $idCat = 2;
    $itemCategory = "Keyboard";
}elseif ($detail == "C") {
    $idCat = 3;
    $itemCategory = "Mouse";
}elseif ($detail == "D") {
    $idCat = 4;
    $itemCategory = "Monitor";
}elseif ($detail == "E") {
    $idCat = 5;
    $itemCategory = "Adaptor Laptop";
}elseif ($detail == "F") {
    $idCat = 8;
    $itemCategory = "Headphone";
}elseif ($detail == "H") {
    $idCat = 9;
    $itemCategory = "Handphone";
}elseif ($detail == "K") {
    $idCat = 7;
    $itemCategory = "Kunci Kantor";
}else{
    $idCat = "";
    $itemCategory = "Item tidak ada";
}

function alertBox($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

function logging($date, $user, $action, $value, $iditem){
	require "sql/connect.php";
	$insertLogQry = "";
	$insertLogQry = "INSERT INTO log (date, user, action, value, iditem) VALUES ('".$date."', '".$user."', '".$action."', '".$value."', '".$iditem."')";
	if(!mysql_query($insertLogQry)){
    	alertBox("ERROR: Could not able to execute " . mysql_error($conn));
    }else{
    	alertBox("loging success..!!");
    }
}

// ==============================================================================================================================
// -------------------------------------------------- LOGIN ----------------------------------------------
// ==============================================================================================================================

if(isset($_POST['btnLogin'])){
    $postUsername = $_POST['loginUsername'];
    $postPassword = $_POST['loginPassword'];

    $loginQry = "SELECT * FROM admin WHERE username = '".$postUsername."' AND password = '".$postPassword."' LIMIT 1";
    if($resultLogin = mysql_query($loginQry)){
        if (mysql_num_rows($resultLogin) != 0) {
            $rowLogin = mysql_fetch_array($resultLogin);
            $_SESSION['login']      = 'logged';
            $_SESSION['name']       = $rowLogin['name'];
            $_SESSION['privilege']  = $rowLogin['privilege'];
            $_SESSION['idadmin']    = $rowLogin['idadmin'];
            $_SESSION['username']   = $rowLogin['username'];

            $logingContentText = "Username : ".$rowLogin['username']."<br>Name : ".$rowLogin['name'];
            logging($now, $postUsername, "User Login Success", $logingContentText, $rowLogin['idadmin']);
            header('Location: ./');
        }else{
            $_SESSION['login']  = 'notlogged';
            alertBox('Username atau Password Salah..');
        }
    }
}

// ==============================================================================================================================
// -------------------------------------------------- ITEM ----------------------------------------------
// ==============================================================================================================================

// ============================================= ADD NEW ITEM
if(isset($_POST['addItemButton'])){
	$postIdInventory 	= $_POST['addIdInventory'];
	$postItemsCategory 	= $_POST['addItemsCategory'];
	$postItemName 		= $_POST['addItemName'];
	$postItemSN 		= $_POST['addItemSN'];
    $postItemUser       = $_POST['addItemsUser'];

    $catQry = "";
    $catQry = "SELECT name FROM category WHERE idcategory = '".$postItemsCategory."'";
    if($resultCatr = mysql_query($catQry)){
        if (mysql_num_rows($resultCatr) > 0) {
            $rowCat = mysql_fetch_array($resultCatr);
            $category = $rowCat['name'];
        }else{
            $category = "Not Found";
        }
    }

	$idInventoryQry = "";
    $idInventoryQry = "SELECT count(idinventory) as countId FROM item WHERE idinventory = '".$postIdInventory."'";
    if($resultIdInventory = mysql_query($idInventoryQry)){
        if (mysql_num_rows($resultIdInventory) > 0) {
            $rowIdInventory = mysql_fetch_array($resultIdInventory);
            if ($rowIdInventory['countId'] == 0) {
                if ($postItemUser == "") {
    				$addNewItemQry = "INSERT INTO item (idinventory, dateIn, name, idcategory, serialNumber, status, notes) 
    								VALUES ('".$postIdInventory."', NOW(), '".$postItemName."', '".$postItemsCategory."', '".$postItemSN."', 'Stock', 'Baru')";

                    $loggingText = "ID Inventory : ".$postIdInventory."
                                    Item Name : ".$postItemName."
                                    Category : ".$category."
                                    S/N : ".$postItemSN."";
                }else{
                    $addNewItemQry = "INSERT INTO item (idinventory, dateIn, dateOut, name, iduser, idcategory, serialNumber, status) 
                                    VALUES ('".$postIdInventory."', NOW(), NOW(), '".$postItemName."', '".$postItemUser."', '".$postItemsCategory."', '".$postItemSN."', 'Used Up')";

                    $logUserQry = "";
                    $logUserQry = "SELECT user.name as name, division.name as division FROM user,division WHERE user.iduser = '".$selectedIdUser."' AND user.iddivision = division.iddivision LIMIT 1";
                    if($resultLogUser = mysql_query($logUserQry)){
                        if (mysql_num_rows($resultLogUser) > 0) {
                            $rowLogUser = mysql_fetch_array($resultLogUser);
                            $name           = $rowLogUser['name'];
                            $division     = $rowLogUser['division'];

                        }
                    }
                }
                $loggingText = "ID Inventory : ".$postIdInventory."
                                Item Name : ".$postItemName."
                                Category : ".$category."
                                S/N : ".$postItemSN."
                                To User : ".$name." - ".$division."";

				if(mysql_query($addNewItemQry)){
					$LastId = mysql_insert_id($conn);
					logging($now, $user, "Add New Item", $loggingText, $LastId);
			        header('Location: ./index.php?menu=item&detail='.$detail);
			    }else{
			    	echo "ERROR: Could not able to execute ".$addNewItemQry.". " . mysql_error($conn);
			    }
            }else{
            	alertBox("ID Inventory sudah ada..!!!");
            }
        }
    }

}

// ============================== BUTTON DELETE CLICK ==========================================================
if(isset($_POST['btnDeleteItem'])){
	foreach ($_POST['checkboxItem'] as $selectedIdItem) {
		$delItemQry = "DELETE FROM item WHERE iditem = '".$selectedIdItem."'";

		// =============================================== LOGING
		$delLogItemQry = "";
        $delLogItemQry = "SELECT * FROM item WHERE iditem = '".$selectedIdItem."'";
        if($resultDelLogItem = mysql_query($delLogItemQry)){
            if (mysql_num_rows($resultDelLogItem) > 0) {
                while($rowDelLogItem = mysql_fetch_array($resultDelLogItem)){
                    $idinventory 	= $rowDelLogItem['idinventory'];
                    $name 			= $rowDelLogItem['name'];
                    $category 		= $rowDelLogItem['idcategory'];
                    $serialNumber 	= $rowDelLogItem['serialNumber'];
                    $status 		= $rowDelLogItem['status'];
                    $iduser 		= $rowDelLogItem['iduser'];


                    $loggingText = "ID Inventory : ".$idinventory."
                    				Item Name : ".$name."
                    				Category : ".$category."
                    				S/N : ".$serialNumber."
                    				Status : ".$status."
                    				iduser : ".$iduser."";

					logging($now, $user, "Deleting item(s)", $loggingText, $selectedIdItem);
                }
            }
        }
		// =============================================== LOGING
		if (mysql_query($delItemQry)) {
		    alertBox("Record deleted successfully");
		} else {
		    alertBox("Error deleting record: " . mysqli_error($conn));
		}
	}
}

// ============================== BUTTON DELETE CATEGORY ==========================================================
if(isset($_POST['btnDelCat'])){
    $postIdCat = $_POST['catDelId'];
    $delCatQry = "DELETE FROM category WHERE idcategory = '".$postIdCat."'";

    // =============================================== LOGING
    $delLogCatQry = "";
    $delLogCatQry = "SELECT * FROM category WHERE idcategory = '".$postIdCat."'";
    if($resultDelLogCat = mysql_query($delLogCatQry)){
        if (mysql_num_rows($resultDelLogCat) > 0) {
            while($rowDelLogCat = mysql_fetch_array($resultDelLogCat)){
                $idcategory    = $rowDelLogCat['idcategory'];
                $nameCat       = $rowDelLogCat['name'];

                $loggingText = "ID Category : ".$idcategory."
                                Category Name : ".$nameCat."";

                logging($now, $user, "Deleting item(s)", $loggingText, $postIdCat);
            }
        }
    }
    // =============================================== LOGING
    if (mysql_query($delCatQry)) {
        alertBox("Jenis item berhasil dihapus");
    } else {
        alertBox("Error deleting record: " . mysqli_error($conn));
    }
}


// ============================================= ADD NEW CATEGORY
if(isset($_POST['addCategoryButton'])){
    $postaddName    = $_POST['addCatName'];
    if(!empty($postaddName)){
        $idCategoryQry = "";
        $idCategoryQry = "SELECT count(idcategory) as countId FROM category WHERE name = '".$postaddName."'";
        if($resultIdCategory = mysql_query($idCategoryQry)){
            if (mysql_num_rows($resultIdCategory) > 0) {
                $rowIdCategory = mysql_fetch_array($resultIdCategory);
                if ($rowIdCategory['countId'] == 0) {
                    $addNewCategoryQry = "";
                    $addNewCategoryQry = "INSERT INTO category (name) VALUES ('".$postaddName."')";

                    $loggingText = "Category Name : ".$postaddName."";

                    if(mysql_query($addNewCategoryQry)){
                        $LastId = mysql_insert_id($conn);
                        logging($now, $user, "Add New Category", $loggingText, $LastId);
                        header('Location: ./index.php?menu=item&detail='.$detail);
                    }else{
                        alertBox("ERROR: Could not able to execute " . mysql_error($conn));
                    }
                }else{
                    alertBox("Category sudah ada..!!!");
                }
            }
        }
    }else{
        alertBox("Data tidak boleh kosong..!!!");
    }
}

// ==============================================================================================================================
// -------------------------------------------------- USER ----------------------------------------------
// ==============================================================================================================================

// ============================================= ADD NEW USER
if(isset($_POST['addUserButton'])){
    $postName       = $_POST['addName'];
    $postDivision   = $_POST['addUserDivision'];

    $addNewUserQry = "INSERT INTO user (name, iddivision) 
                    VALUES ('".$postName."', '".$postDivision."')";

    $loggingText = "Name : ".$postName."
                    Division : ".$postDivision."";

    if(mysql_query($addNewUserQry)){
        $LastId = mysql_insert_id($conn);
        logging($now, $user, "Add New Item", $loggingText, $LastId);
        header('Location: ./index.php?menu=user');
    }else{
        alertBox("ERROR: Could not able to execute ". mysql_error($conn));
    }

}

// ============================== BUTTON DELETE CLICK ==========================================================
if(isset($_POST['btnDeleteUser'])){
    foreach ($_POST['checkboxUser'] as $selectedIdUser) {
        $delUserQry = "DELETE FROM user WHERE iduser = '".$selectedIdUser."'";

        // =============================================== LOGING
        $delLogUserQry = "";
        $delLogUserQry = "SELECT * FROM user WHERE iduser = '".$selectedIdUser."'";
        if($resultDelLogUser = mysql_query($delLogUserQry)){
            if (mysql_num_rows($resultDelLogUser) > 0) {
                while($rowDelLogUser = mysql_fetch_array($resultDelLogUser)){
                    $name           = $rowDelLogUser['name'];
                    $iddivision       = $rowDelLogUser['iddivision'];

                    $loggingText = "Name : ".$name."
                                    Division : ".$iddivision."";

                    logging($now, $user, "Deleting User(s)", $loggingText, $selectedIdUser);
                }
            }
        }
        // =============================================== LOGING
        if (mysql_query($delUserQry)) {
            alertBox("Record deleted successfully");
        } else {
            alertBox("Error deleting record: " . mysqli_error($conn));
        }
    }
}
// ==============================================================================================================================
// -------------------------------------------------- ADMIN ----------------------------------------------
// =========================================================================================================================
// ============================================= ADD NEW ADMIN
if(isset($_POST['addAdminButton'])){
    $postUsername   = $_POST['addUserUsername'];
    $postPassword   = $_POST['addUserPassword'];
    $postName       = $_POST['addUserName'];
    $postPrivilege  = $_POST['addUserPermission'];

    $addNewUserQry = "INSERT INTO admin (username, password, name, privilege) 
                    VALUES ('".$postUsername."', '".$postPassword."', '".$postName."', '".$postPrivilege."')";
    $permission = ($postPrivilege == '1')?"Administrator":"User";

    if(mysql_query($addNewUserQry)){
        $LastIdUser = mysqli_insert_id($conn);
        $loggingText = "Username    : ".$postUsername."
                        Name        : ".$postName."
                        Permision   : ".$permission."
                        Password    : ".$postPassword."";
        logging($now, $user, "Add New User", $loggingText, $LastIdUser);
        header('Location: ./index.php?menu=admin');
    }else{
        alertBox("ERROR: Could not able to execute " . mysql_error($conn));
    }
}
// ============================== BUTTON DELETE CLICK ==========================================================
if(isset($_POST['btnDeleteAdmin'])){
    foreach ($_POST['checkboxUser'] as $selectedIdUser) {
        $delUserQry = "DELETE FROM admin WHERE idadmin = '".$selectedIdUser."'";

        // =============================================== LOGING
        $nameDelUserQry = "";
        $nameDelUserQry = "SELECT idadmin, username, name, privilege FROM admin WHERE idadmin = '".$selectedIdUser."'";
        if($resultDelUserQry = mysql_query($nameDelUserQry)){
            if (mysql_num_rows($resultDelUserQry) > 0) {
                while($rowDelUsers = mysql_fetch_array($resultDelUserQry)){
                    $idDelUsers         = $rowDelUsers['idadmin'];
                    $usernameDelUsers   = $rowDelUsers['username'];
                    $nameDelUsers       = $rowDelUsers['name'];
                    $privilegeDelUsers  = $rowDelUsers['privilege'];

                    $permission = ($privilegeDelUsers == '1')?"Administrator":"Operator";

                    $loggingText = "Username    : ".$usernameDelUsers."
                                    Name        : ".$nameDelUsers."
                                    Permision   : ".$permission."";
                }
            }
        }
        // =============================================== LOGING
        if (mysql_query($delUserQry)) {
            logging($now, $user, "Delete User", $loggingText, $idDelUsers);
            alertBox("Record deleted successfully");
        } else {
            alertBox("Error deleting record: " . mysqli_error($conn));
        }
    }
}
// ==============================================================================================================================
// -------------------------------------------------- DIVISION ----------------------------------------------
// ==============================================================================================================================

// ============================================= ADD NEW DIVISION
if(isset($_POST['addDivisionButton'])){
    $postaddName    = $_POST['addName'];

    $idDivisionQry = "";
    $idDivisionQry = "SELECT count(iddivision) as countId FROM division WHERE name = '".$postaddName."'";
    if($resultIdDivision = mysql_query($idDivisionQry)){
        if (mysql_num_rows($resultIdDivision) > 0) {
            $rowIdDivision = mysql_fetch_array($resultIdDivision);
            if ($rowIdDivision['countId'] == 0) {
                $addNewDivisionQry = "";
                $addNewDivisionQry = "INSERT INTO division (name) VALUES ('".$postaddName."')";

                $loggingText = "Division Name : ".$postaddName."";

                if(mysql_query($addNewDivisionQry)){
                    $LastId = mysql_insert_id($conn);
                    logging($now, $user, "Add New Division", $loggingText, $LastId);
                    header('Location: ./index.php?menu=user');
                }else{
                    echo "ERROR: Could not able to execute ".$addNewItemQry.". " . mysql_error($conn);
                }
            }else{
                alertBox("Divisi sudah ada..!!!");
            }
        }
    }
}
// ==============================================================================================================================
// -------------------------------------------------- TRANSACTION ----------------------------------------------
// ==============================================================================================================================

// ============================================= OUTGOING TRANSACTION
if(isset($_POST['trxOutSubmit'])){
    $postIdInventory    = $_POST['trxOutIdInventory'];
    $postUser           = $_POST['trxOutUser'];
    if(!empty($postIdInventory) && !empty($postUser)){
        $updateItemOutQry = "";
        $updateItemOutQry = "UPDATE item SET
                                dateOut = NOW(),
                                status = 'Used Up',
                                iduser = '".$postUser."',
                                notes = ''
                            WHERE idinventory = '".$postIdInventory."'";

        $loggingText = "Date Out : '".date("Y-m-d")."'
                        ID Inventory : ".$postIdInventory."
                        User : ".$postUser."
                        ";

        if(mysql_query($updateItemOutQry)){
            logging($now, $user, "Outgoing Item Transaction", $loggingText, $postIdInventory);
            header('Location: ./index.php?menu=item&detail='.$detail);
        }else{
            alertBox("ERROR: Could not able to execute " . mysql_error($conn));
        }
    }else{
        alertBox("Data tidak boleh kosong..!!");
    }
}

// ============================================= INGOING TRANSACTION
if(isset($_POST['trxInSubmit'])){
    $postIdInventory    = $_POST['trxInIdInventory'];
    $postNotes          = $_POST['updateStatus'];
    if(!empty($postIdInventory) && !empty($postNotes)){
        $lastQry = "";
        $lastQry = "SELECT user.name as name, item.iduser as iduser FROM item, user WHERE item.iduser = user.iduser AND item.idinventory = '".$postIdInventory."' LIMIT 1";
        if($resultLast = mysql_query($lastQry)){
            if (mysql_num_rows($resultLast) > 0) {
                $rowLast = mysql_fetch_array($resultLast);
                $postLastUser   = $rowLast['name'];
                $postLastIdUser = $rowLast['iduser'];
            }else{
                $postLastUser = 0;
            }
        }

        $updateItemOutQry = "";
        $updateItemOutQry = "UPDATE item SET
                                dateIn = NOW(),
                                status = 'Stock',
                                iduser = '0',
                                lastIdUser = '".$postLastIdUser."',
                                notes = '".$postNotes."'
                            WHERE idinventory = '".$postIdInventory."'";

        $loggingText = "Date In : ".date("Y-m-d")."
                        ID Inventory : ".$postIdInventory."
                        Last User : ".$postLastUser."
                        Notes : ".$postNotes."
                        ";

        if(mysql_query($updateItemOutQry)){
            logging($now, $user, "Ingoing Item Transaction", $loggingText, $postIdInventory);
            header('Location: ./index.php?menu=item&detail='.$detail);
        }else{
            alertBox("ERROR: Could not able to execute " . mysql_error($conn));
        }
    }else{
        alertBox("Data tidak boleh kosong..!!");
    }
}
?>