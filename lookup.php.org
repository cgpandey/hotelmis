<?php
session_start();
/*****************************************************************************
/*Copyright (C) 2006 Tony Iha Kazungu
/*****************************************************************************
Hotel Management Information System (HotelMIS Version 1.0), is an interactive system that enables small to medium
sized hotels take guests bookings and make hotel reservations.  It could either be uploaded to the internet or used
on the hotel desk computers.  It keep tracks of guest bills and posting of receipts.  Hotel reports can alos be
produce to make work of the accounts department easier.

This program is free software; you can redistribute it and/or modify it under the terms
of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License,
or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program;
if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA or 
check for license.txt at the root folder
/*****************************************************************************
For any details please feel free to contact me at taifa@users.sourceforge.net
Or for snail mail. P. O. Box 938, Kilifi-80108, East Africa-Kenya.
/*****************************************************************************/
error_reporting(E_ALL & ~E_NOTICE);
include_once("login_check.inc.php");
include_once ("queryfunctions.php");
include_once ("functions.php");
access("lookup"); //check if user is allowed to access this page

if (isset($_POST['Submit'])){
	$conn=db_connect(HOST,USER,PASS,DB,PORT);
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Add Transaction Details':
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('item','Please enter item name.');
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}
			else {
				$item=$_POST["item"];
				$description=!empty($_POST["description"]) ? "'" . $_POST["description"] . "'" : 'NULL';
				$sale=!empty($_POST["sale"]) ? $_POST["sale"] : 'NULL';
				$expense=!empty($_POST["expense"]) ? $_POST["expense"] : 'NULL';
				$sql="INSERT INTO details (item,description,sale,expense)
				 VALUES('$item',$description,$sale,$expense)";
				$results=mkr_query($sql,$conn);		
				$msg[0]="Sorry item not added";
				$msg[1]="Item successfull added";
				AddSuccess($results,$conn,$msg);
			}
			break;
		case 'Add Document':
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('doc_code','Please enter document code.');
			$fv->validateEmpty('doc_type','Please enter document type.');			
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}
			else {
				$doc_code=!empty($_POST["doc_code"]) ? "'" . $_POST["doc_code"] . "'" : 'NULL';
				$doc_type=!empty($_POST["doc_type"]) ? "'" . $_POST["doc_type"] . "'" : 'NULL';				
				$remarks=!empty($_POST["remarks"]) ? "'" . $_POST["remarks"] . "'" : 'NULL';				
				$accounts=!empty($_POST["accounts"]) ? $_POST["accounts"] : 'NULL';
				$cooperative=!empty($_POST["cooperative"]) ? $_POST["cooperative"] : 'NULL';
				$payroll=!empty($_POST["payroll"]) ? $_POST["payroll"] : 'NULL';
				
				$sql="INSERT INTO doctypes (doc_code,doc_type,remarks,accounts,cooperative,payroll)
				 VALUES($doc_code,$doc_type,$remarks,$accounts,$cooperative,$payroll)";
				$results=mkr_query($sql,$conn);		
				$msg[0]="Sorry document type not added";
				$msg[1]="Document type successfull added";
				AddSuccess($results,$conn,$msg);
			}
			break;
		case 'Add Transaction Type':
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('trans_code','Please enter transaction code.');
			$fv->validateEmpty('trans_type','Please enter transaction type.');			
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}
			else {
				$trans_code=!empty($_POST["trans_code"]) ? "'" . $_POST["trans_code"] . "'" : 'NULL';
				$trans_type=!empty($_POST["trans_type"]) ? "'" . $_POST["trans_type"] . "'" : 'NULL';				
				$remarks=!empty($_POST["remarks"]) ? "'" . $_POST["remarks"] . "'" : 'NULL';				
				$accounts=!empty($_POST["accounts"]) ? $_POST["accounts"] : 'NULL';
				$cooperative=!empty($_POST["cooperative"]) ? $_POST["cooperative"] : 'NULL';
				$payroll=!empty($_POST["payroll"]) ? $_POST["payroll"] : 'NULL';
				
				$sql="INSERT INTO transtype (trans_code,trans_type,remarks,accounts,cooperative,payroll)
				 VALUES($trans_code,$trans_type,$remarks,$accounts,$cooperative,$payroll)";
				$results=mkr_query($sql,$conn);		
				$msg[0]="Sorry transaction type not added";
				$msg[1]="Transaction type successfull added";
				AddSuccess($results,$conn,$msg);
			}
			break;
		case 'Add Payment Mode':
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('payment_option','Please enter payment option.');
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}
			else {
				$payment_option=!empty($_POST["payment_option"]) ? "'" . $_POST["payment_option"] . "'" : 'NULL';
				$sql="INSERT INTO payment_mode (payment_option) VALUES($payment_option)";
				$results=mkr_query($sql,$conn);		
				$msg[0]="Sorry payment mode not added";
				$msg[1]="Payment mode successfull added";
				AddSuccess($results,$conn,$msg);
			}
			break;							
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			$sql="Select rooms.roomid,rooms.roomno,rooms.roomtypeid,roomtype.roomtype,rooms.roomname,
			rooms.noofrooms,rooms.occupancy,rooms.tv,rooms.aircondition,rooms.fun,rooms.safe,rooms.fridge,rooms.reserverd,rooms.photo
			From rooms Inner Join roomtype ON rooms.roomtypeid = roomtype.roomtypeid where roomno='$search'";
			$results=mkr_query($sql,$conn);
			$rooms=fetch_object($results);
			break;
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/new.css" rel="stylesheet" type="text/css">
<title>Hotel Management Information System</title>

<script type="text/javascript">
<!--
var request;
var dest;

function loadHTML(URL, destination, button){
    dest = destination;
	var str = '?submit=' + button;
	URL=URL + str
	if (window.XMLHttpRequest){
        request = new XMLHttpRequest();
        request.onreadystatechange = processStateChange;
        request.open("GET", URL, true);
        request.send(null);
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.XMLHTTP");
        if (request) {
            request.onreadystatechange = processStateChange;
            request.open("GET", URL, true);
            request.send();
        }
    }
}

function processStateChange(){
    if (request.readyState == 4){
        contentDiv = document.getElementById(dest);
        if (request.status == 200){
            response = request.responseText;
            contentDiv.innerHTML = response;
        } else {
            contentDiv.innerHTML = "Error: Status "+request.status;
        }
    }
}

function loadHTMLPost(URL, destination, button){
    dest = destination;
	var str = 'button=' + button;
	if (window.XMLHttpRequest){
        request = new XMLHttpRequest();
        request.onreadystatechange = processStateChange;
        request.open("POST", URL, true);
        request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
		request.send(str);
    } else if (window.ActiveXObject) {
        request = new ActiveXObject("Microsoft.XMLHTTP");
        if (request) {
            request.onreadystatechange = processStateChange;
            request.open("POST", URL, true);
            request.send();
        }
    }
}
//-->	 
</script>
<script language="JavaScript" src="js/highlight.js" type="text/javascript"></script>
</head>

<body>
<form action="lookup.php" method="post" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="1" align="center" bgcolor="#66CCCC">
  <tr valign="top">
    <td width="17%" bgcolor="#FFFFFF">
	<table width="100%"  border="0" cellpadding="1">	  
	  <tr>
    <td width="15%" bgcolor="#66CCCC">
		<table cellspacing=0 cellpadding=0 width="100%" align="left" bgcolor="#FFFFFF">
      <tr><td width="110" align="center"><a href="index.php"><img src="images/titanic1.gif" width="70" height="74" border="0"/><br>
          Home</a></td>
      </tr>
      <tr><td>&nbsp; </td>
      </tr>
      <tr>
        <td align="center">
		<?php signon(); ?>		
		</td></tr>
	  </table></td></tr>
	<?php require_once("menu_header.php"); ?>				
    </table>
	</td>
    
    <td width="67%" bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="1">
      <tr>
        <td align="center" onclick="loadHTMLPost('lookupfunctions.php','maincontent','details')" style="cursor:pointer">Details</td>
		<td align="center" onclick="loadHTMLPost('lookupfunctions.php','maincontent','documents')" style="cursor:pointer">Document Types</td>
		<td align="center" onclick="loadHTMLPost('lookupfunctions.php','maincontent','transactions')" style="cursor:pointer">Transaction Types</td>
		<td align="center" onclick="loadHTMLPost('lookupfunctions.php','maincontent','paymode')" style="cursor:pointer">Payment Modes</td>
		<td align="center" onclick="loadHTMLPost('lookupfunctions.php','maincontent','roomtype')" style="cursor:pointer">Room Types</td>
      </tr>
      <tr>
        <td valign="top" colspan="5"><div id="maincontent"></div></td>
      </tr>
    </table></td>
  </tr>
   <?php require_once("footer1.php"); ?>
</table>
</form>
</body>
</html>