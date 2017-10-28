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
access("rooms"); //check if user is allowed to access this page

if (isset($_POST['Submit'])){
	$conn=db_connect(HOST,USER,PASS,DB,PORT);
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Add Rooms Detail':
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('roomno','Please enter room no.');
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}
			else {
				//gets photo.
				if ((isset($_REQUEST['form_submit'])) && ('form_uploader' == $_REQUEST['form_submit'])){
				{
				if  (is_uploaded_file($_FILES['photo']['tmp_name']))
				{
				$filename = $_FILES['photo']['name'];
				$filetype=$_FILES['photo']['type'];
				$file_temp=$_FILES['photo']['tmp_name'];	
				} 
				$filesize=filesize($file_temp);
				$photo=base64_encode(fread(fopen($file_temp, "rb"),$filesize));
				}}
				
				$roomno=$_POST["roomno"];
				$roomtypeid=$_POST["roomtypeid"];
				$roomname=!empty($_POST["roomname"]) ? "'" . $_POST["roomname"] . "'" : 'NULL';
				$noofrooms=$_POST["noofrooms"];
				$occupancy=$_POST["occupancy"];
				$tv=!empty($_POST["tv"]) ? "'" . $_POST["tv"] . "'" : 'NULL';
				$aircondition=!empty($_POST["aircondition"]) ? "'" . $_POST["aircondition"] . "'" : 'NULL';
				$fun=!empty($_POST["fun"]) ? "'" . $_POST["fun"] . "'" : 'NULL';
				$safe=!empty($_POST["safe"]) ? "'" . $_POST["safe"] . "'" : 'NULL';
				$fridge=!empty($_POST["fridge"]) ? "'" . $_POST["fridge"] . "'" : 'NULL';
				$reserverd=!empty($_POST["status"]) ? "'" . $_POST["status"] . "'" : 'NULL';
				$photo=!empty($_POST["photo"]) ? "'" . $photo . "'" : 'NULL';
				$filetype=!empty($_POST["filetype"]) ? "'" . $filetype . "'" : 'NULL';
				
				$sql="INSERT INTO rooms (roomno,roomtypeid,roomname,noofrooms,occupancy,tv,aircondition,fun,safe,fridge,status,photo,filetype)
				 VALUES($roomno,$roomtypeid,$roomname,$noofrooms,$occupancy,$tv,$aircondition,$fun,$safe,$fridge,$status,$photo,$filetype)";
				$results=mkr_query($sql,$conn);		
				AddSuccess($results,$conn);
			}
			break;
		case 'List':
			
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			$sql="Select rooms.roomid,rooms.roomno,rooms.roomtypeid,roomtype.roomtype,rooms.roomname,
			rooms.noofrooms,rooms.occupancy,rooms.tv,rooms.aircondition,rooms.fun,rooms.safe,rooms.fridge,rooms.status,rooms.photo
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
<form action="rooms.php" method="post" enctype="multipart/form-data">
<table width="102%"  border="0" cellpadding="1" align="center" bgcolor="#66CCCC">
  <tr valign="top">
    <td width="17%" height="332" bgcolor="#FFFFFF">
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
        <td>
		<h2>ROOMS</h2>
		</td>
      </tr>
      <tr>
        <td valign="top"><table width="100%"  border="0" cellpadding="1">
  <tr>
    <td width="26%">Room No. </td>
    <td width="74%"><input type="text" name="roomno" value="<?php echo trim($rooms->roomno); ?>" /></td>
  </tr>
  <tr>
    <td>Room Type </td>
    <td><select name="roomtypeid"><?php populate_select("roomtype","roomtypeid","roomtype",$rooms->roomtypeid);?>
    </select></td>
  </tr>
  <tr>
    <td>Room Name </td>
    <td><input type="text" name="roomname" value="<?php echo trim($rooms->roomname); ?>" /></td>
  </tr>
  <tr>
    <td>No. of rooms </td>
    <td><input type="text" name="noofrooms" value="<?php echo trim($rooms->noofrooms); ?>" /></td>
  </tr>
  <tr>
    <td>Occupancy</td>
    <td><input type="text" name="occupancy" value="<?php echo trim($rooms->occupancy); ?>" /></td>
  </tr>
  <tr>
    <td>TV</td>
    <td><input type="checkbox" name="tv" value="Y" /></td>
  </tr>
  <tr>
    <td>Aircondition</td>
    <td><input type="checkbox" name="aircondition" value="Y" /></td>
  </tr>
  <tr>
    <td>Fun</td>
    <td><input type="checkbox" name="fun" value="Y" /></td>
  </tr>
  <tr>
    <td>Safe</td>
    <td><input type="checkbox" name="safe" value="Y" /></td>
  </tr>
  <tr>
    <td>Fridge</td>
    <td><input type="checkbox" name="fridge" value="Y" /></td>
  </tr>
  <tr>
    <td>Status</td>
    <td><table width="90%" border="0" cellpadding="1">
      <tr>
        <td width="24%" ><label><input type="radio" name="status" value="V" <?php echo ($rooms->status=="V" ? "checked=\"checked\"" : ""); ?> />
      Vacant</label></td>
        <td width="28%"><label><input type="radio" name="status" value="R" <?php echo ($rooms->status=="R" ? "checked=\"checked\"" : ""); ?> />
      Reserved</label></td>
        <td width="25%"><label><input type="radio" name="status" value="B" <?php echo ($rooms->status=="B" ? "checked=\"checked\"" : ""); ?> />
      Booked</label></td>
	  <td width="23%"><label><input type="radio" name="status" value="B" <?php echo ($rooms->status=="L" ? "checked=\"checked\"" : ""); ?> />
      Locked</label></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Attach Photo</td>
    <td><input type="file" name="photo" />
            <input name="form_submit" type="hidden" id="form_submit" value="form_uploader" /></td>
  </tr>
</table>
		</td>
		
      </tr>
	  <tr>
        <td align="left"><div id="RequestDetails"></div>
		</td>
      </tr>
    </table></td>
	<td width="16%" bgcolor="#FFFFFF">
	<table><tr><td bgcolor="#66CCCC">
	<table width="100%"  border="0" cellpadding="1" bgcolor="#FFFFFF">
       <tr>
        <td>Image</td>
      </tr>
	  <tr>
        <td align="center"><input type="submit" name="Submit" value="Add Rooms Detail" /></td>
      </tr>
      <tr>
        <td align="center"><input type="button" name="Submit" value="Rooming List" onclick="self.location='rooms_list.php'"/></td>
      </tr>
      <tr>
        <td align="center"><input type="button" name="Submit" value="Room Details" onclick="loadHTML('ajaxfunctions.php','RequestDetails','RoomDetails')"/></td>
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
	</td></tr></table>
	</td>
  </tr>
  <?php require_once("footer1.php"); ?>
</table>
</form>
</body>
</html>

<!--
//view rooms image
//include "config.php";
include_once ("queryfunctions.php");

$conn=db_connect(HOST,USER,PASS,DB,PORT);
if (!empty($_REQUEST["id"]))	
{	
$imgid=$_REQUEST["id"];
$sqlstr="select * from request where req_id='$imgid'";
}
else
$sqlstr="select * from request limit 1";

$sqlresult=mkr_query($sqlstr,$conn);
$data=fetch_object($sqlresult);

$filetype=$data->filetype;
//$filesize=$data->filesize;
$data=$data->serialnos;
$filetype=ereg_replace(" ", "", $filetype);

Header("Content-type: $filetype");
header("Cache-Control: private");
header("Content-Disposition: attachment; filename=$filetype");
header("Content-Description: PHP Generated Data");
echo base64_decode($data);
								
header("content-type: text/html");
echo "</center>";
print "<br>"; 
free_result(sqlresult);
-->