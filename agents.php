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
access("agents"); //check if user is allowed to access this page
$conn=db_connect(HOST,USER,PASS,DB,PORT);

if (isset($_GET["search"])){
	find($_GET["search"]);
}	

if (isset($_POST['Submit'])){
	$action=$_POST['Submit'];
	switch ($action) {
		case 'Update':
			// instantiate form validator object
			$fv=new formValidator(); //from functions.php
			$fv->validateEmpty('agents_ac_no','Agents A/C No. must be entered');
			$fv->validateEmpty('agentname','Agents name must be entered');
			$fv->validateEmpty('telephone','Agents phone is required');
			$fv->validateEmpty('town','Town is required');
			$fv->validateEmpty('billing_address','Agents billing address is required');
						
			if($fv->checkErrors()){
				// display errors
				echo "<div align=\"center\">";
				echo '<h2>Resubmit the form after correcting the following errors:</h2>';
				echo $fv->displayErrors();
				echo "</div>";
			}else {
				$agentname=$_POST["agentname"];
				$agents_ac_no=$_POST["agents_ac_no"];
				$contact_person=$_POST["contact_person"];
				$telephone=$_POST["telephone"];
				$fax=(!empty($_POST["fax"])) ? $_POST["fax"] : 'NULL';
				$email=(!empty($_POST["email"])) ? $_POST["email"] : 'NULL';
				$billing_address=(!empty($_POST["billing_address"])) ? $_POST["billing_address"] : 'NULL';
				$town=$_POST["town"];
				$postal_code=(!empty($_POST["postal_code"])) ? $_POST["postal_code"] : 'NULL';
				$road_street=(!empty($_POST["road_street"])) ? $_POST["road_street"] : 'NULL';
				$building=(!empty($_POST["building"])) ? $_POST["building"] : 'NULL';
				//SELECT agentid,agentname,agents_ac_no,contact_person, telephone, fax,email,billing_address,town,postal_code,road_street, building,ratesid FROM agents
				$sql="INSERT INTO agents (agentname,agents_ac_no,contact_person,telephone,fax,email,billing_address,town,postal_code,road_street,building)
				 VALUES('$agentname','$agents_ac_no','$contact_person','$telephone',$fax,$email,$billing_address,'$town',$postal_code,$road_street,$building)";
				//echo $sql; 
				$results=mkr_query($sql,$conn);
				if ((int) $results==0){
					//should log mysql errors to a file instead of displaying them to the user
					echo 'Invalid query: ' . mysqli_errno($conn). "<br>" . ": " . mysqli_error($conn). "<br>";
					echo "Agents record NOT UPDATED.";  //return;
				}else{
					echo "Agents record successful updated.";
				}				
			}
			break;
		case 'List':
			//link ("self","agents_list.php");
			break;
		case 'Find':
			//check if user is searching using name, payrollno, national id number or other fields
			find($_POST["search"]);
			break;
	}

}

function find($search){
	global $conn,$agent;
	$search=$search;
	$sql="Select agentname,agents_ac_no,contact_person,telephone,fax,email,billing_address,town,postal_code,road_street,building From agents where agents_ac_no='$search'";
	$results=mkr_query($sql,$conn);
	$agent=fetch_object($results);
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
<form action="agents.php" method="post" enctype="multipart/form-data">
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
      <tr><td> <br>
          </input></td>
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
		<h2>AGENTS</h2>
		</td>
      </tr>
      <tr>
        <td><div id="Requests">
          <table width="59%"  border="0" cellpadding="1">
            <tr>
              <td width="46%">Account No. </td>
              <td width="54%"><input type="text" name="agents_ac_no" value="<?php echo trim($agent->agents_ac_no); ?>"/></td>
            </tr>
            <tr>
              <td>Agents Name</td>
              <td><input type="text" name="agentname" value="<?php echo trim($agent->agentname); ?>" /></td>
            </tr>
            <tr>
              <td>Contact person </td>
              <td><input type="text" name="contact_person" value="<?php echo trim($agent->contact_person); ?>" /></td>
            </tr>
            <tr>
              <td>Telephone</td>
              <td><input type="text" name="telephone" value="<?php echo trim($agent->telephone); ?>" /></td>
            </tr>
            <tr>
              <td>Fax</td>
              <td><input type="text" name="fax" value="<?php echo trim($agent->fax); ?>" /></td>
            </tr>
            <tr>
              <td>E-mail</td>
              <td><input type="text" name="email" value="<?php echo trim($agent->email); ?>" /></td>
            </tr>
            <tr>
              <td>Billing address</td>
              <td><input type="text" name="billing_address" value="<?php echo trim($agent->billing_address); ?>" /></td>
            </tr>
            <tr>
              <td>Town</td>
              <td><input type="text" name="town" value="<?php echo trim($agent->town); ?>" /></td>
            </tr>
            <tr>
              <td>Postal code</td>
              <td><input type="text" name="postal_code" value="<?php echo trim($agent->postal_code); ?>" /></td>
            </tr>
            <tr>
              <td>Building</td>
              <td><input type="text" name="building" value="<?php echo trim($agent->building); ?>" /></td>
            </tr>
            <tr>
              <td>Road/Street</td>
              <td><input type="text" name="road_street" value="<?php echo trim($agent->road_street); ?>" /></td>
            </tr>
          </table>
        </div></td>
		
      </tr>
	  <tr bgcolor="#66CCCC" >
        <td align="left"><div id="RequestDetails"></div>
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
        <td><input type="submit" name="Submit" value="Update" /></td>
      </tr>
      <tr>
        <td><input type="button" name="Submit" value="List" onclick="self.location='agents_list.php'"/></td>
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
        Agent Code </label>
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