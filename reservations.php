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

access("reservation"); //check if user is allowed to access this page
$conn=db_connect(HOST,USER,PASS,DB,PORT);

if (isset($_GET["search"]) && !empty($_GET["search"])){
	find($_GET["search"]);
}

if (isset($_POST['Navigate'])){
	//echo $_SESSION["strOffSet"];
	$nRecords=num_rows(mkr_query("select * from guests",$conn),$conn);
	paginate($nRecords);
	free_result($results);
	find($_SESSION["strOffSet"]);
}

$guestid=$_POST['guestid'];

if (isset($_POST['Submit'])){
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Guest Reservation':
			//if guest has not been selected exit
			// instantiate form validator object
			$fv=new formValidator(); //from functions.php
			if (empty($_POST["guestid"])){ //if no guest has been selected no point in displaying other errors
				$fv->validateEmpty('guestid','No guest has been selected for reservation.');
			}else{
				$fv->validateEmpty('reservation_type','Please indicate if it\'s a Direct booking or Agent booking.');
				$fv->validateEmpty('meal_plan','Please select Meal Plan');
				$fv->validateEmpty('reserve_checkindate','Please enter checkin date for reservation');
				$fv->validateEmpty('roomid','Please indicate room being booked');				
			}
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}
			else {
				$reserved_through=!empty($_POST["reservation_type"]) ? "'" . $_POST["reservation_type"] . "'" : 'NULL';
				$guestid=$_POST["guestid"];
				$reservation_by=!empty($_POST["reservation_by"]) ? "'" . $_POST["reservation_by"] . "'" : 'NULL';
				$reservation_by_phone=!empty($_POST["reservation_by_phone"]) ? "'" . $_POST["reservation_by_phone"] . "'" : 'NULL';
				$reserve_checkindate=!empty($_POST["reserve_checkindate"]) ? "'" . $_POST["reserve_checkindate"] . "'" : 'NULL';
				$reserve_checkoutdate=!empty($_POST["reserve_checkoutdate"]) ? "'" . $_POST["reserve_checkoutdate"] . "'" : 'NULL';
				$no_adults=!empty($_POST["no_adults"]) ? $_POST["no_adults"] : 'NULL';
				$no_child0_5=!empty($_POST["no_child0_5"]) ? $_POST["no_child0_5"] : 'NULL';
				$no_child6_12=!empty($_POST["no_child6_12"]) ? $_POST["no_child6_12"] : 'NULL';
				$no_babies=!empty($_POST["no_babies"]) ? $_POST["no_babies"] : 'NULL';
				$meal_plan=$_POST["meal_plan"];
				$billing_instructions=!empty($_POST["billing_instructions"]) ? "'" . $_POST["billing_instructions"] . "'" : 'NULL';
				$deposit=!empty($_POST["deposit"]) ? $_POST["deposit"] : 'NULL';
				$agents_ac_no=!empty($_POST["agents_ac_no"]) ? "'" . $_POST["agents_ac_no"] . "'" : 'NULL';
				$voucher_no=!empty($_POST["voucher_no"]) ? "'" . $_POST["voucher_no"] . "'" : 'NULL';
				$reserved_by=$_SESSION["userid"]; //a need to check if the session value exists
				$date_reserved=!empty($_POST["date_reserved"]) ? "'" . $_POST["date_reserved"] . "'" : 'NULL';
				$confirmed_by=!empty($_POST["confirmed_by"]) ? "'" . $_POST["confirmed_by"] . "'" : 'NULL';
				$confirmed_date=!empty($_POST["confirmed_date"]) ? "'" . $_POST["confirmed_date"] . "'" : 'NULL';
				$roomid=!empty($_POST["roomid"]) ? $_POST["roomid"] : 'NULL';
				
				$sql="INSERT INTO reservation (reserved_through,guestid,reservation_by,reservation_by_phone,datereserved,
						reserve_checkindate,reserve_checkoutdate,no_adults,no_child0_5,no_child6_12,no_babies,meal_plan,
						billing_instructions,deposit,agents_ac_no,voucher_no,reserved_by,date_reserved,confirmed_by,confirmed_date,roomid,billed)
					 VALUES($reserved_through,$guestid,$reservation_by,$reservation_by_phone,now(),
						$reserve_checkindate,$reserve_checkoutdate,$no_adults,$no_child0_5,$no_child6_12,$no_babies,'$meal_plan',
						$billing_instructions,$deposit,$agents_ac_no,$voucher_no,$reserved_by,$date_reserved,$confirmed_by,$confirmed_date,$roomid,0)";
				$results=mkr_query($sql,$conn);
				if ((int) $results==0){
					//should log mysql errors to a file instead of displaying them to the user
					echo 'Invalid query: ' . mysqli_errno($conn). "<br>" . ": " . mysqli_error($conn). "<br>";
					echo "Reservation NOT MADE.";  //return;
				}else{
					echo "<div align=\"center\"><h1>Reservation successfull.</h1></div>";
					
					//only create bill when deposit has been payed.(Give a setup option to the user for this) - todo
					if (!empty($_POST["deposit"])){
						//create bill - let user creat bill/create bill automatically
						$sql="INSERT INTO bills (book_id,billno,date_billed) select reservation.reservation_id,reservation.reservation_id,reservation.datereserved from reservation where reservation.billed=0";
						$results=mkr_query($sql,$conn);
						$msg[0]="Sorry no bill created";
						$msg[1]="Bill successfull created";
						AddSuccess($results,$conn,$msg);
						
						//if bill succesful created update billed to 1 in bookings- todo
						$sql="Update reservation set billed=1 where billed=0"; //get the actual updated reservation_id, currently this simply updates all reservations that have not been billed
						$results=mkr_query($sql,$conn);
						$msg[0]="Sorry Reservation not updated";
						$msg[1]="Reservations successful updated";			
						AddSuccess($results,$conn,$msg);
					}else{
						echo "<div align=\"center\"><h1>Bill/Reservation will be created on deposit</h1></div>";
					}
		
					//mark room as booked
					$sql="Update rooms set status='R' where roomid=$roomid"; //get the actual updated book_id, currently this simply updates all bookings 
					$results=mkr_query($sql,$conn);
					$msg[0]="Sorry room reservation not marked";
					$msg[1]="Room marked as reserved";			
					AddSuccess($results,$conn,$msg);					
				}				
			}			
			find($guestid);
			$results=mkr_query($sql,$conn);		
			break;
		case 'List':
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			find($search);
			$sql="Select guests.guestid,guests.lastname,guests.firstname,guests.middlename,guests.pp_no,
			guests.idno,guests.countrycode,guests.pobox,guests.town,guests.postal_code,guests.phone,
			guests.email,guests.mobilephone,countries.country
			From guests
			Inner Join countries ON guests.countrycode = countries.countrycode where pp_no='$search'";
			$results=mkr_query($sql,$conn);
			$reservation=fetch_object($results);
			break;
	}
}

function find($search){
	global $conn,$guests;
	$search=$search;
	$strOffSet=!empty($_POST["strOffSet"]) ? $_POST["strOffSet"] : 0; //offset value peacked on all pages with pagination - logical error
	
	//check on wether search is being done on idno/ppno/guestid/guestname
	$sql="Select guests.guestid,concat_ws(' ',guests.firstname,guests.middlename,guests.lastname) as guest,guests.pp_no,
		guests.idno,guests.countrycode,guests.pobox,guests.town,guests.postal_code,guests.phone,
		guests.email,guests.mobilephone,countries.country
		From guests
		Inner Join countries ON guests.countrycode = countries.countrycode where guests.guestid='$search'
		LIMIT $strOffSet,1";
	$results=mkr_query($sql,$conn);
	$guests=fetch_object($results);
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
	//if (document.getElementById('roomid')==""){
		room = document.getElementById('roomid').value;
		str ='roomid='+ room;
		//get occupancy (no of adults/children) - should not be empty
		str =str + '&no_adults=' + (document.getElementById('no_adults').value);
		//get meal plan - should not be empty
		for (i=0;i<document.reservation.meal_plan.length;i++){
		if (document.reservation.meal_plan[i].checked==true)
			//alert(document.bookings.meal_plan[i].value);
			str =str + '&meal_plan=' + document.reservation.meal_plan[i].value;
		}

		//get direct/agent booking - should not be empty
		for (i=0;i<document.reservation.booking_type.length;i++){
		if (document.reservation.booking_type[i].checked==true)
			//alert(document.bookings.booking_type[i].value);
			str =str + '&booking_type=' + document.reservation.booking_type[i].value;
		}
		//alert(document.getElementById['agent']);	
		/*if (document.getElementById('agent')!==null){
			s=document.getElementById['agent'].value;
		}*/
	//}
	var str = str + '&button=' + button;
	
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

function nights(){
date2=(document.getElementById('checkoutdate').value);
date1=(document.getElementById('checkindate').value);
document.getElementById('no_nights').value=date2-date1;
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
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>

<body>
<form action="reservations.php" method="post" name="reservation" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="1" bgcolor="#66CCCC" align="center">
  <tr valign="top">
    <td width="19%" bgcolor="#FFFFFF">
	<table width="100%"  border="0" cellpadding="1">
	  
	  <tr>
    <td width="15%" bgcolor="#66CCCC">
		<table cellspacing=0 cellpadding=0 width="100%" align="left" bgcolor="#FFFFFF">
      <tr>
        <td width="110" align="center"><a href="index.php"><img src="images/titanic1.gif" width="70" height="74" border="0"/><br>
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
    
    <td width="81%" bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="1">
      <tr>
        <td align="center"></td>
      </tr>
      <tr>
        <td>
		<H2>ROOM RESERVATIONS</H2>
		</td>
      </tr>
      <tr>
        <td><table width="86%"  border="0" cellpadding="1" align="left">
    <tr>
      <td colspan="3">
	<table border="1" cellpadding="0">
          <tr>
            <td width="78">
			<input type="submit" name="Navigate" id="First" style="cursor:pointer" title="first page" value="<<"/>
            <input type="submit" name="Navigate" id="Previous" style="cursor:pointer" title="previous page" value="<"/>
            </td>
            <td width="241" align="center" bgcolor="#FFFFFF"><h3><?php echo trim($guests->guest); ?></h3></td>
            <td width="79">
			<input type="submit" name="Navigate" id="Next" style="cursor:pointer" title="next page" value=">"/>
            <input type="submit" name="Navigate" id="Last" style="cursor:pointer" title="last page" value=">>"/>
            </td>
          </tr>
        </table>
	</td>
	<td width="32%"><input type="button" name="Submit" value="Reservations List" onclick="self.location='reservation_list.php'"/>
	  <input name="guestid" type="hidden" value="<?php echo trim($guests->guestid); ?>" /></td>
    </tr>
    <tr>
      <td width="18%">Reservation By: </td>
      <td colspan="3"><p>
          <label>
<input type="radio" name="reservation_type" value="T" />        
Telephone</label>
          <label>
          <input type="radio" name="reservation_type" value="A" />
        At Desk</label>
          <label>
          <input type="radio" name="reservation_type" value="L" />
        Letter</label>
          <label>
          <input type="radio" name="reservation_type" value="O" />
        Online</label>
      </p></td>
    </tr>
    <tr>
      <td>Guest Name: </td>
      <td width="35%"><input type="text" name="name" /></td>
      <td width="15%">Telephone</td>
      <td><input type="text" name="phone" value="<?php echo trim($guests->phone); ?>" /></td>
    </tr>
    <tr>
      <td>Made By: </td>
      <td><input type="text" name="reservation_by" /></td>
      <td>Telephone</td>
      <td><input type="text" name="reservation_by_phone" /></td>
    </tr>
    <tr>
      <td>Date of arrival </td>
      <td><input type="text" name="reserve_checkindate" id="checkindate" readonly=""/>
          <a href="javascript:showCal('Calendar1')"> <img src="images/ew_calendar.gif" width="16" height="15" border="0"/></a></td>
      <td>Departure Date</td>
      <td><input type="text" name="reserve_checkoutdate" id="checkoutdate" onblur="nights()" readonly=""/>
          <small><a href="javascript:showCal('Calendar2')"> <img src="images/ew_calendar.gif" width="16" height="15" border="0"/></a></small></td>
    </tr>
    <tr>
      <td>No. of nights</td>
      <td><input type="text" name="no_nights" id="no_nights" size="10" readonly=""/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>No. of Guests </td>
      <td colspan="4"><table width="74%"  border="0" cellpadding="1">
          <tr>
            <td width="18%">Adults <br />
                <input type="text" name="no_adults" id="no_adults" size="10"/></td>
            <td width="22%">Child 0 - 5 <br />
                <input type="text" name="no_child0_5" size="10"/></td>
            <td width="22%">Child 6 - 12 <br />
                <input type="text" name="no_child6_12" size="10"/></td>
            <td width="38%">Babies <br />
                <input type="text" name="no_babies" size="10"/></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td>Meal Plan </td>
      <td><table width="108%"  border="0" cellpadding="1">
        <tr>
          <td width="28%"><input type="radio" name="meal_plan" id="mealplan" value="BO" <?php echo ($guests->meal_plan=="BO" ? "checked=\"checked\"" : ""); ?> />
            BO</td>
          <td width="25%"><input type="radio" name="meal_plan" id="mealplan" value="BB" <?php echo ($guests->meal_plan=="BB" ? "checked=\"checked\"" : ""); ?> />
            BB</td>
          <td width="24%"><input type="radio" name="meal_plan" id="mealplan" value="HB" <?php echo ($guests->meal_plan=="HB" ? "checked=\"checked\"" : ""); ?> />
            HB</td>
          <td width="23%"><input type="radio" name="meal_plan" id="mealplan" value="FB" <?php echo ($guests->meal_plan=="FB" ? "checked=\"checked\"" : ""); ?> />
            FB</td>
        </tr>
      </table></td>
      <td>Billing Instructions</td>
      <td colspan="2"><textarea name="billing_instructions"></textarea></td>
    </tr>
<tr>
      <td>Booking Type</td>
      <td colspan="3">
        <label>
<input type="radio" name="booking_type" id="booking_type" value="D" onclick="loadHTMLPost('ajaxfunctions.php','agentoption','Direct')"/>
Direct booking </label>
        <label>
        <input type="radio" name="booking_type" id="booking_type" value="A" onclick="loadHTMLPost('ajaxfunctions.php','agentoption','Agent')"/>
  Agent booking</label>
      </td>
    </tr>    
	<tr>
      <td colspan="2" width="100%"><div id="agentoption"></div></td>
      <td>Voucher No. </td>
      <td><input type="text" name="voucher_no" /></td>
    </tr>
    <tr>
      <td>Address</td>
      <td bgcolor="#66CCCC"><?php
	   echo "P. O. Box " . trim($guests->pobox) ."<br>";
	   echo trim($guests->town) . "-" . trim($guests->postal_code);
	   ?></td>
      <td>Room No. </td>
      <td><div id="showrates"></div>
	  <select name="roomid" id="roomid" onchange="loadHTMLPost('ajaxfunctions.php','showrates','GetRates')">
        <option value="" >Select Room</option>
        <?php populate_select("rooms","roomid","roomno",$bookings->roomid);?>
      </select></td>
    </tr>
<tr>
      <td>Daily Rates</td>
      <td><input type="text" name="textfield" /></td>
      <td>Deposit</td>
      <td><input type="text" name="deposit" /></td>
    </tr>	
    <tr>
      <td colspan="2"><h2>Booking Taken By</h2></td>
      <td colspan="2"><h2>Booking Confirmed By:</h2></td>
    </tr>
    <tr>
      <td>Name</td>
      <td><input type="text" name="reserved_by" value="<?php echo $_SESSION["employee"]; ?>"/></td>
      <td>Name</td>
      <td><input type="text" name="confirmed_by" /></td>
    </tr>
    <tr>
      <td>Date</td>
      <td><input type="text" name="date_reserved" /></td>
      <td>Date</td>
      <td><input type="text" name="confirmed_date" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="Guest Reservation"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
		</td>
		
      </tr>
	  <tr bgcolor="#66CCCC" >
        <td align="left">
		<div id="RequestDetails"></div>
		</td>
      </tr>
    </table></td>
  </tr>
   <?php require_once("footer1.php"); ?>
</table>
</form>
</body>
</html>

<!--"Select reservation_id,reserved_through,guestid,reservation_by,reservation_by_phone,datereserved,
reserve_checkindate,reserve_checkoutdate,no_adults,no_child0_5,no_child6_12,no_babies,meal_plan,
billing_instructions,deposit,agents_ac_no,voucher_no,reserved_by,date_reserved,confirmed_by,
confirmed_date,roomid
From reservation";-->