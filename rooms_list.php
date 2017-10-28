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

if (isset($_POST['Submit'])){
	$conn=db_connect(HOST,USER,PASS,DB,PORT);
	$action=$_POST['Submit'];
	switch ($action) {
		case 'List':
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			$sql="Select agentname,agents_ac_no,contact_person,telephone,fax,email,billing_address,town,postal_code,road_street,building From agents where agentcode='$search'";
			$results=mkr_query($sql,$conn);
			$agent=fetch_object($results);
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

function loadHTMLPost(URL, destination){
    dest = destination;
	if (window.XMLHttpRequest){
        request = new XMLHttpRequest();
        request.onreadystatechange = processStateChange;
        request.open("POST", URL, true);
        request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
      	request.setRequestHeader("Content-length", parameters.length);
      	request.setRequestHeader("Connection", "close");
		request.send("good");
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
</head>

<body>
<form action="rooms.php" method="post" enctype="multipart/form-data">
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
        <td align="center"></td>
      </tr>
      <tr>
        <td colspan="2">
		<h2>Rooms List </h2>
		</td>
      </tr>
      <tr bgcolor="#FF9900"><td><h1>View Rooms </h1></td> 
	  <td>
          <label>
          <input type="radio" name="roomstatus" value="A" />
  All</label>
          <label>
          <input type="radio" name="roomstatus" value="V" />
  Vacant</label>
          <label>
          <input type="radio" name="roomstatus" value="R" />
  Reserved</label>
          <label>
          <input type="radio" name="roomstatus" value="B" />
  Booked</label>
          <label>
          <input type="radio" name="roomstatus" value="L" />
  Locked</label>
	</td></tr>
	  <tr>
        <td colspan="2"><div id="Requests">
		<?php
			$conn=db_connect(HOST,USER,PASS,DB,PORT);
			/*$sql="Select rooms.roomno,concat_ws(' ',guests.firstname,guests.middlename,guests.lastname) as guest,
				booking.checkin_date,booking.checkout_date,DATEDIFF(booking.checkout_date,booking.checkin_date) as nights,
				booking.meal_plan,booking.no_adults,booking.no_child
				From rooms
				left Join booking ON rooms.roomid = booking.roomid
				left Join guests ON booking.guestid = guests.guestid
				Where year(booking.checkin_date ) = '2006' AND month(booking.checkin_date ) = '7'
				Order By booking.checkin_date Asc";*/
			$sql="Select rooms.roomno,guests.guestid,concat_ws(' ',guests.firstname,guests.middlename,guests.lastname) AS guest,
				booking.checkin_date,booking.checkout_date,DATEDIFF(booking.checkout_date,booking.checkin_date) AS nights,
				booking.meal_plan,booking.no_adults,booking.no_child,rooms.`status`
				From rooms
				left Join booking ON rooms.roomid = booking.roomid
				left Join guests ON booking.guestid = guests.guestid
				Order By rooms.roomno Asc";	
			$results=mkr_query($sql,$conn);
			echo "<table align=\"center\">";
			//get field names to create the column header
			echo "<tr bgcolor=\"#009999\">
				<th></th>
				<th>Room No.</th>
				<th>Guest Name</th>
				<th>In</th>
				<th>Out</th>
				<th>Nts</th>
				<th>Plan</th>
				<th>Adults</th>
				<th>Children</th>
				<th>Room Status</th>
				</tr>";
			//end of field header
			//get data from selected table on the selected fields
			while ($booked = fetch_object($results)) {
				//alternate row colour
				$j++;
				if($j%2==1){
					echo "<tr bgcolor=\"#CCCCCC\">";
					}else{
					echo "<tr bgcolor=\"#EEEEF8\">";
				}
					echo "<td><a href=\"bookings.php?search=$booked->guestid\"><img src=\"images/button_view.png\" width=\"16\" height=\"16\" border=\"0\" title=\"view booking details\"/></a></td>";
					echo "<td>" . $booked->roomno . "</td>";
					echo "<td>" . $booked->guest . "</td>";
					echo "<td>" . $booked->checkin_date . "</td>";
					echo "<td>" . $booked->checkout_date . "</td>";
					echo "<td>" . $booked->nights . "</td>";
					echo "<td>" . $booked->meal_plan . "</td>";
					echo "<td>" . $booked->no_adults . "</td>";					
					echo "<td>" . $booked->no_child . "</td>";
					echo "<td>" . $booked->status . "</td>";
					
				echo "</tr>"; //end of - data rows
			} //end of while row
			echo "</table>";
		?>
		</div></td>		
      </tr>
	  <tr bgcolor="#66CCCC" >
        <td align="left" colspan="2"><div id="RequestDetails"></div>
		</td>
      </tr>
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
        <td><input type="button" name="Submit" value="List" onclick="self.location='rooms_list.php'"/></td>
	  </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
            <label> Search By:<br />
            <input type="radio" name="optFind" value="Name" />
        Agent Name</label>
            <br />
            <label>
            <input type="radio" name="optFind" value="Payrollno" />
        Room No. </label>
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
	</td><tr></table>
	</td>
  </tr>
  <?php require_once("footer1.php"); ?>
</table>
</form>
</body>
</html>