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
access("billing"); //check if user is allowed to access this page
$conn=db_connect(HOST,USER,PASS,DB,PORT);

/*if (isset($_GET["search"])){
	$search=$_GET["search"];
	find($search);
}*/

if (isset($_GET['action'])){
	$action=$_GET['action'];
	$search=$_GET['search'];
	switch ($action) {
		case 'remove':
			//before deleting make sure bill has not been printed - todo
			$sql="delete from transactions where transno='$search'";
			$results=mkr_query($sql,$conn);
			$msg[0]="Sorry item not deleted";
			$msg[1]="Item successful deleted";
			AddSuccess($results,$conn,$msg);
			//go to original billno - get value from hidden field
			find($billno);
			$search=$billno;
			break;
		case 'search':
			$search=$_GET["search"];
			find($search);
			break;
}		
}

if (isset($_POST['Submit'])){
	$conn=db_connect(HOST,USER,PASS,DB,PORT);
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Update':
			// instantiate form validator object
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('doc_no','Please enter document number.');			
			$fv->validateEmpty('doc_date','Please enter date');
			$fv->validateEmpty('doc_date','Please enter details');			
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
				//search current record
			}
			else {
				$billno=$_POST["billno"];
				$doc_type=$_POST["doc_type"];
				$doc_no=$_POST["doc_no"];			
				$doc_date= $_POST["doc_date"];
				$details=$_POST["details"];			
				$dr= !empty($_POST["dr"]) ? $_POST["dr"] : 'NULL';				
				$cr= !empty($_POST["cr"]) ? $_POST["cr"] : 'NULL';								
				$sql="INSERT INTO transactions (billno,doc_type,doc_no,doc_date,details,dr,cr)
				 VALUES($billno,'$doc_type',$doc_no,'$doc_date',$details,$dr,$cr)";
				$results=mkr_query($sql,$conn);		
				$msg[0]="Sorry item not posted";
				$msg[1]="Item successful posted";
				AddSuccess($results,$conn,$msg);
				find($billno); //go back to bill after updating it
				$search=$billno;
			}
			break;
		case 'Check Out Guest':
			//Check if bill has been cleared,Change room status to vacant,print bill,mark booking status and update checkout date - to add checkoutby,codatetime in booking
			$roomno=$_POST["roomno"];
			$book_id=$_POST["book_id"];
			$userid=$_SESSION["userid"];

			//change room status to vacant
			$sql="Update rooms set status='V' where roomno=$roomno";
			$results=mkr_query($sql,$conn);		
			$msg[0]="Sorry room not marked as vacant";
			$msg[1]="Room <b>$roomno</b> marked as vacant";
			AddSuccess($results,$conn,$msg);
			
			//Update booking status and update checkout date - to add checkoutby,codatetime in booking
			$sql="Update booking set checkoutby=$userid,codatetime=now() where book_id=$book_id";
			$results=mkr_query($sql,$conn);		
			$msg[0]="Sorry checkout details not updated.";
			$msg[1]="Checkout date and time updated.";
			AddSuccess($results,$conn,$msg);

			//print bill
			
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			find($search);
			break;
	}
}

function find($search){
	global $conn,$bill;
	$search=$search;
	//search on booking
	//check on wether search is being done on idno/ppno/guestid/guestname
	$sql="Select bills.bill_id,bills.book_id,bills.date_billed,bills.billno,bills.`status`,bills.date_checked,
		concat_ws(' ',guests.firstname,guests.middlename,guests.lastname) as guest,guests.pobox,guests.town,guests.postal_code,
		booking.checkin_date,booking.checkout_date,booking.roomid,rooms.roomno
		From bills
		Inner Join booking ON bills.book_id = booking.book_id
		Inner Join guests ON booking.guestid = guests.guestid
		Inner Join rooms ON booking.roomid = rooms.roomid where bills.bill_id='$search'";
		
		//need a search on reservation - todo not (tested)
		/*$sql="Select bills.bill_id,bills.book_id,bills.date_billed,bills.billno,bills.`status`,bills.date_checked,
		concat_ws(' ',guests.firstname,guests.middlename,guests.lastname) as guest,guests.pobox,guests.town,guests.postal_code,
		reservation.reserve_checkindate,reservation.reserve_checkoutdate,reservation.roomid,rooms.roomno
		From bills
		Inner Join reservation ON bills.book_id = reservation.reservation_id
		Inner Join guests ON reservation.guestid = guests.guestid
		Inner Join rooms ON reservation.roomid = rooms.roomid where bills.bill_id='$search'";*/
	$results=mkr_query($sql,$conn);
	$bill=fetch_object($results);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <link href="css/new.css" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" type="text/css" href="css/print.css" media="print" /> -->
<title>Hotel Management Information System</title>

<script type="text/javascript">
<!--
var request;
var dest;

function loadHTML(URL, destination){
	dest = destination;
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
<script language="javascript" src="js/cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" src="js/cal_conf2.js"></script>
<script language="JavaScript" src="js/highlight.js" type="text/javascript"></script>
</head>

<body>
<form action="billings.php" method="post" enctype="multipart/form-data" id="billing" name="billing">
<table width="100%"  border="0" cellpadding="1" align="center" bgcolor="#66CCCC">
  <tr valign="top">
    <td width="17%" bgcolor="#FFFFFF"><div id="navigation">
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
	</div></td>
    
    <td width="67%" bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="1">
      <tr>
        <td align="center"></td>
      </tr>
      <tr>
        <td>
		<h2>GUEST BILLS</h2>
		</td>
      </tr>
      <tr >
        <td align="center"><div id="RequestDetails"></div>
		</td>
      </tr>
	  <tr>
        <td>
          <table width="100%"  border="0" cellpadding="1">
            <tr >
              <td width="23%">&nbsp;</td>
              <td width="26%">&nbsp;</td>
              <td width="21%">Bill No. </td>
              <td width="30%"><input type="text" name="billno" size="10" value="<?php echo $bill->billno; ?>"/></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="hidden" name="book_id" value="<?php echo $bill->book_id; ?>"/></td>
              <td>Room No. </td>
              <td><input type="text" name="roomno" size="10" readonly="" value="<?php echo $bill->roomno; ?>"/></td>
            </tr>
            <tr>
              <td>Arrival Date </td>
              <td><input type="text" name="checkin_date" readonly="" value="<?php echo $bill->checkin_date; ?>" size="20"/></td>
              <td>Depature Date </td>
              <td><input type="text" name="checkout_date" readonly="" value="<?php echo $bill->checkout_date; ?>" size="20"/></td>
            </tr>
            <tr>
              <td>Name</td>
              <td colspan="2" bgcolor=""><?php echo $bill->guest; ?></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Address</td>
              <td><?php
			   echo "P. O. Box " . trim($bill->pobox) ."<br>";
			   echo trim($bill->town) . "-" . trim($bill->postal_code);
			   ?>
	   		</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Payment options </td>
              <td colspan="2"><label>
                <input type="radio" name="doc_type" value="Reciept" onclick="loadHTMLPost('ajaxfunctions.php','transoption','Cash')"/>
      Cash Sales </label>
                  <label>
                  <input type="radio" name="doc_type" value="Chit" onclick="loadHTMLPost('ajaxfunctions.php','transoption','Debit')"/>
      Debit Sales </label>
              </td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr><td colspan="4"><div id="transoption"></div></td></tr>
            <tr>
              <td colspan="4"><div id="showbill">
			  <?php
				$billno=!empty($_POST['search']) ? $_POST['search'] : 0;
				//$billno=!empty($_POST['billid']) ? $_POST['billid'] : 1;
				$sql="Select transactions.transno,transactions.doc_date,details.item,transactions.dr,transactions.cr,transactions.doc_no,transactions.doc_type,details.itemid,transactions.billno
					From transactions
					Inner Join details ON transactions.details = details.itemid
					Where transactions.billno = '$search'";
				$results=mkr_query($sql,$conn);
			
			  	echo "<table width=\"100%\"  border=\"0\" cellpadding=\"1\">
                  <tr bgcolor=\"#FF9900\">
                    <th></th>
					<th>Date</th>
                    <th>Details</th>
                    <th>DR</th>
                    <th>CR</th>
                    <th>Balance</th>
                    <th>Doc. No. </th>
                    <th>Doc. Type</th>					
                  </tr>";
				//get data from selected table on the selected fields
				while ($trans = fetch_object($results)) {
					$balance=$balance-$trans->cr+$trans->dr;
					//alternate row colour
					$j++;
					if($j%2==1){
						echo "<tr id=\"row$j\" onmouseover=\"javascript:setColor('$j')\" onmouseout=\"javascript:origColor('$j')\" bgcolor=\"#CCCCCC\">";
						}else{
						echo "<tr id=\"row$j\" onmouseover=\"javascript:setColor('$j')\" onmouseout=\"javascript:origColor('$j')\" bgcolor=\"#EEEEF8\">";
					}
						echo "<td><a href=\"billings.php?search=$trans->transno&action=remove&billno=$trans->billno\"><img src=\"images/button_remove.png\" width=\"16\" height=\"16\" border=\"0\" title=\"bill guest\"/></a></td>";
						echo "<td>" . $trans->doc_date . "</td>";
						echo "<td>" . $trans->item . "</td>";
						echo "<td>" . $trans->dr . "</td>";
						echo "<td>" . $trans->cr . "</td>";
						echo "<td>" . $balance . "</td>"; //when negative don't show
						echo "<td>" . $trans->doc_no . "</td>";
						echo "<td>" . $trans->doc_type . "</td>"; //calucate running balance		
					echo "</tr>"; //end of - data rows
				} //end of while row
				echo "<tr><td colspan=\"3\" align=\"center\"><b>TOTAL</b></td><td><b>DR Total</b></td><td><b>CR Total</b></td><td><b>Total Bal.</b></td><tr>";
				  echo "</table>"; ?>
				 </div> 
			  </td>
            </tr>
          </table></td>
      </tr>
	  <!--<tr >
        <td align="center"><div id="RequestDetails"></div>
		</td>
      </tr>-->
    </table></td>
	<td width="16%" bgcolor="#FFFFFF">
	<table width="100%"  border="0" cellpadding="1">	  
	  <tr>
    <td width="15%" bgcolor="#66CCCC">
	<table width="100%"  border="0" cellpadding="1" bgcolor="#FFFFFF">
       <tr>
        <td>Image</td>
      </tr>
	  <tr>
        <td align="center"><input type="button" name="Submit" value="View Bills" onclick="loadHTML('ajaxfunctions.php?submit=Bills','RequestDetails')"/></td>
	  </tr>
      <tr>
        <td align="center"><input type="submit" name="Submit" value="Check Out Guest"/></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td>
            <label> Search By:<br />
            <input type="radio" name="optFind" value="Name" />
        Room No. </label>
            <br />
            <label>
            <input type="radio" name="optFind" value="Payrollno" />
        Bill No. </label>
            <br>
        <input type="text" name="search" width="100" /><br>
        <input type="submit" name="Submit" value="Find"/>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</td></tr></table>
	</td>
  </tr>
   <?php require_once("footer1.php"); ?>
</table>
</form>
</body>
</html>