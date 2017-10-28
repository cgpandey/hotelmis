<?php
/*Copyright (C) 2006 Tony Iha Kazungu
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

For any details please feel free to contact me at taifa@users.sourceforge.net
Or for snail mail. P. O. Box 938, Kilifi-80108, East Africa-Kenya.
*/
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include_once("login_check.inc.php");
include_once ("queryfunctions.php");
include_once ("functions.php");
access("admin"); //check if user is allowed to access this page
$conn=db_connect(HOST,USER,PASS,DB,PORT);

if (isset($_GET["search"])){
	find($_GET["search"]);
}	

if (isset($_POST['Submit'])){
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Add User': //|| 'Update User'):
			// instantiate form validator object
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('fname','Enter users First name');
			$fv->validateEmpty('sname','Enter users Second name');
			$fv->validateEmpty('loginname','Enter users loginname');
			$fv->validateEmpty('pass','Please enter a password');
						
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}else {
				$fname=$_POST["fname"];
				$sname=$_POST["sname"];
				$loginname=$_POST["loginname"];
				$pass=md5($_POST["pass"]);
				$phone=(!empty($_POST["phone"])) ? $_POST["phone"] : 'NULL';
				$mobile=(!empty($_POST["mobile"])) ? $_POST["mobile"] : 'NULL';
				$fax=(!empty($_POST["fax"])) ? $_POST["fax"] : 'NULL';				
				$email=(!empty($_POST["email"])) ? $_POST["email"] : 'NULL';
				$countrycode=(!empty($_POST["countrycode"])) ? $_POST["countrycode"] : 'NULL';
				$admin=(empty($_POST["admin"])) ? 0 : $_POST["admin"];
				$guest=(empty($_POST["guest"])) ? 0 : $_POST["guest"];
				$reservation=(empty($_POST["reservation"])) ? 0 : $_POST["reservation"];
				$booking=(empty($_POST["booking"])) ? 0 : $_POST["booking"];
				$agents=(empty($_POST["agents"])) ? 0 : $_POST["agents"];
				$rooms=(empty($_POST["rooms"])) ? 0 : $_POST["rooms"];
				$billing=(empty($_POST["billing"])) ? 0 : $_POST["billing"];
				$rates=(empty($_POST["rates"])) ? 0 : $_POST["rates"];
				$lookup=(empty($_POST["lookup"])) ? 0 : $_POST["lookup"];
				$reports=(empty($_POST["reports"])) ? 0 : $_POST["reports"];
				
				//check if it's an update or a new insert
				/*if ($action=='Update User'){
					echo "Put sql statement for updating here";
					//echo different $msg0 & 1
				}else{ //adding*/
					$sql="INSERT INTO users (fname,sname,loginname,pass,phone,mobile,fax,email,dateregistered,admin,guest,reservation,booking,agents,rooms,billing,rates,lookup,reports)
	 					VALUES('$fname','$sname','$loginname','$pass',$phone,$mobile,$fax,$email,now(),$admin,$guest,$reservation,$booking,$agents,$rooms,$billing,$rates,$lookup,$reports)";
				//}
				
				$results=mkr_query($sql,$conn);
				$msg[0]="Sorry user account no created";
				$msg[1]="User account created successful";
				AddSuccess($results,$conn,$msg);	
			}
			break;
		case 'Update User':
			echo "Put sql statement for updating here";		
			break;
		case 'List':
			//link ("self","agents_list.php");
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			$search=$_POST["search"];
			find($search);
			break;
	}

}

function find($search){
	global $conn,$users;
	$search=$search;
	$sql="select userid,fname,sname,loginname,pass,phone,mobile,fax,email,countrycode,admin,
		guest,reservation,booking,agents,rooms,billing,rates,lookup,reports
		From users where userid='$search'";
	$results=mkr_query($sql,$conn);
	$users=fetch_object($results);
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
		request.send("str");
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
<form action="admin.php" method="post" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="1" bgcolor="#66CCCC" align="center">
  <tr valign="top">
    <td width="18%" valign="top" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellpadding="1" cellspacing="5">
	  <tr>
    <td bgcolor="#66CCCC" valign="top">
		<table cellspacing=0 cellpadding=0 width="100%" align="left" bgcolor="#FFFFFF">
      <tr><td align="center"><a href="index.php"><img src="images/titanic1.gif" width="70" height="74" border="0"/><br>Home</a></td></tr>
	  <tr><td width="110"> Username:<br><input name="username" type="text" width="10"></input> </td></tr>
      <tr><td> Password: <br><input name="password" type="password" width="10"></input></td></tr>
      <tr>
        <td align="center">
		<?php signon(); ?>		
		</td></tr>
	  </table></td></tr>
		<?php require_once("menu_header.php"); ?>
    </table>
	</td>
    
    <td width="100%" bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="1">
      <tr>
        <td align="center"></td>
      </tr>
      <tr>
        <td>
		<H4>HOTEL MANAGEMENT INFORMATION SYSTEMS</H4> </td>
      </tr>
      <tr>
        <td><h2>Administrator</h2></td>
      </tr>
	<tr>
        <td><div id="Requests">
<table width="82%"  border="0" cellpadding="1">
  <tr>
    <td width="19%" height="33">User ID </td>
    <td width="28%"><input type="text" name="userid" readonly="" value="<?php echo trim($users->userid); ?>"/></td>
    <td width="21%">Date Registered </td>
    <td width="32%"><input type="text" name="dateregistered" readonly="" value="<?php echo trim($users->dateregistered); ?>" /></td>
  </tr>
  <tr>
    <td>Login Name</td>
    <td><input type="text" name="loginname" value="<?php echo trim($users->loginname); ?>"/></td>
    <td>Password</td>
    <td><input type="password" name="pass" /></td>
  </tr>
  <tr>
    <td>First Name </td>
    <td><input type="text" name="fname" value="<?php echo trim($users->fname); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Second Name </td>
    <td><input type="text" name="sname" value="<?php echo trim($users->sname); ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Phone</td>
    <td><input type="text" name="phone" value="<?php echo trim($users->phone); ?>"/></td>
    <td>Mobile</td>
    <td><input type="text" name="mobile" value="<?php echo trim($users->mobile); ?>"/></td>
  </tr>
  <tr>
    <td>Fax</td>
    <td><input type="text" name="fax" value="<?php echo trim($users->fax); ?>"/></td>
    <td>Email</td>
    <td><input type="text" name="email" value="<?php echo trim($users->email); ?>"/></td>
  </tr>
  <tr>
    <td><h3>Access Rights</h3> </td>
    <td>Administrator
      <input type="checkbox" name="admin" value="1" <?php if($users->admin==1) echo "checked";?>/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" cellpadding="1">
      <tr>
        <td width="13%">guest</td>
        <td width="87%"><input type="checkbox" name="guest" value="1" <?php if($users->guest==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>reservation</td>
        <td><input type="checkbox" name="reservation" value="1" <?php if($users->reservation==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>booking</td>
        <td><input type="checkbox" name="booking" value="1" <?php if($users->booking==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>agents</td>
        <td><input type="checkbox" name="agents" value="1" <?php if($users->agents==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>rooms</td>
        <td><input type="checkbox" name="rooms" value="1" <?php if($users->rooms==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>billing</td>
        <td><input type="checkbox" name="billing" value="1" <?php if($users->billing==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>rates</td>
        <td><input type="checkbox" name="rates" value="1" <?php if($users->rates==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>lookup</td>
        <td><input type="checkbox" name="lookup" value="1" <?php if($users->lookup==1) echo "checked";?>/></td>
      </tr>
      <tr>
        <td>reports</td>
        <td><input type="checkbox" name="reports" value="1" <?php if($users->reports==1) echo "checked";?>/></td>
      </tr>
    </table></td>
  </tr>
</table>
		</div></td>
			
      </tr>
	  <tr bgcolor="#66CCCC" >
        <td align="left" colspan="2">
		<div id="RequestDetails"></div>
		</td>
      </tr>
    </table></td>
	<td width="18%" valign="top" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellpadding="1" cellspacing="5">
	  <tr>
    <td bgcolor="#66CCCC">	
	<table width="100%"  border="0" cellpadding="1" bgcolor="#FFFFFF">
       <tr>
        <td>Image</td>
      </tr>
	  <tr>
        <td><input type="submit" name="Submit" value="<?php echo isset($_GET["search"]) ? "Update User" : "Add User" ?>"/></td>
      </tr>
      <tr>
        <td><input type="button" name="Submit" value="Users List" onclick="self.location='users_list.php'"/></td>
      </tr>
      <tr>
        <td>
            <label> Search By:<br />
            <input type="radio" name="optFind" value="Name" />
        User Name</label>
            <br />
            <label>
            <input type="radio" name="optFind" value="Payrollno" />
        User Id </label>
            <br>
        <input type="text" name="search" width="100" /><br>
        <input type="submit" name="Submit" value="Find"/>
        </td>
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