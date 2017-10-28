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
function populate_select($table,$fields_id,$fields_value,$selected){
	$conn=db_connect(HOST,USER,PASS,DB,PORT);
	$sql="Select $fields_id,$fields_value From $table Order By $fields_value";
	$results=mkr_query($sql,$conn);
	while ($row = fetch_object($results)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_value . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	free_result($results);
}

function signon(){
	echo "<input name=\"login\" type=\"submit\" value=\"";
	echo !isset($_COOKIE['data_login']) ? "Login" : "Logout";
	echo "\"/></input><br>";
	//echo "<font color=\"#339999\">Signed in as: " . $_COOKIE['data_login'] . "</font>";
	echo "<font color=\"#339999\">Signed in as: " . "<br/>" .$_SESSION["employee"] . "</font>";
}

function delete_copy() {
	/* makes connection */
	$conn=db_connect(HOST,USER,PASS,DB,PORT);
	/* Creates SQL statement to retrieve the copies using the releaseID */
	$sql = "DELETE FROM $file WHERE $recordid =" . $_POST['ID'];
	$results=mkr_query($sql,$conn);
	$msg[0]="Sorry ERROR in deletion";
	$msg[1]="Record successful DELETED";			
	AddSuccess($results,$conn,$msg);
	/* Closes connection */
	((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
	/* calls get_data */
	//get_data();
} 
		
class formValidator{
    private $errors=array();
    public function __construct(){}

    // validate empty field
    public function validateEmpty($field,$errorMessage,$min=1	,$max=32){
		if(!isset($_POST[$field])||trim($_POST[$field])==''||strlen($_POST[$field])<$min||strlen($_POST[$field])>$max){
            $this->errors[]=$errorMessage;
        }
    }

    // validate integer field
    public function validateInt($field,$errorMessage){
        if(!isset($_POST[$field])||!is_numeric($_POST[$field])||intval($_POST[$field])!=$_POST[$field]){
            $this->errors[]=$errorMessage;
        }
    }

    // validate numeric field
    public function validateNumber($field,$errorMessage){
        if(!isset($_POST[$field])||!is_numeric($_POST[$field])){
            $this->errors[]=$errorMessage;
        }
    }

    // validate if field is within a range
    public function validateRange($field,$errorMessage,$min=1,$max=99){
        if(!isset($_POST[$field])||$_POST[$field]<$min||$_POST[$field]>$max){
            $this->errors[]=$errorMessage;
        }
    }

    // validate alphabetic field
    public function validateAlphabetic($field,$errorMessage){
        if(!isset($_POST[$field])||!preg_match("/^[a-zA-Z]+$/",$_POST[$field])){
            $this->errors[]=$errorMessage;
        }
    }

    // validate alphanumeric field
    public function validateAlphanum($field,$errorMessage){
        if(!isset($_POST[$field])||!preg_match("/^[a-zA-Z0-9]+$/",$_POST[$field])){
            $this->errors[]=$errorMessage;
        }
    }

    // validate email - does not work on windows machine
    public function validateEmail($field,$errorMessage){
        if(!isset($_POST[$field])||!preg_match("/.+@.+\..+./",$_POST[$field])||!checkdnsrr(array_pop(explode("@",$_POST[$field])),"MX")){
            $this->errors[]=$errorMessage;
        }
    }

    // check for errors
    public function checkErrors(){
        if(count($this->errors)>0){
            return true;
        }
        return false;
    }
	
    // return errors
    public function displayErrors(){
        $errorOutput='<ul>';
        foreach($this->errors as $err){
            $errorOutput.='<li>'.$err.'</li>';
        }
        $errorOutput.='</ul>';
        return $errorOutput;
    }
}

//todo - customize
function findguest($search){
	global $conn,$guests;
	$search=$search;
	//check on wether search is being done on idno/ppno/guestid/guestname
	$sql="Select guests.guestid,guests.lastname,guests.firstname,guests.middlename,guests.pp_no,
		guests.idno,guests.countrycode,guests.pobox,guests.town,guests.postal_code,guests.phone,
		guests.email,guests.mobilephone,countries.country
		From guests
		Inner Join countries ON guests.countrycode = countries.countrycode where guests.guestid='$search'";
	$results=mkr_query($sql,$conn);
	$guests=fetch_object($results);
}

function AddSuccess($results,&$conn,$msg){
	if ((int) $results==0){
		//should log mysql errors to a file instead of displaying them to the user
		echo 'Invalid query: ' . mysqli_errno($conn). "<br>" . ": " . mysqli_error($conn). "<br>";
		echo "<div align=\"center\"><h1>$msg[0]</h1></div>";		
	}else{
		echo "<div align=\"center\"><h1>$msg[1]</h1></div>";
		//return(AddSuccess);
	}
}

function paginate($nRecords){
	 $strOffSet=$_SESSION["strOffSet"];
	 switch ($_POST["Navigate"]){
		case "<<":
			$strOffSet=0;
			break;
		case "<":
			if ($strOffSet>$nRecords){
				$strOffSet=$strOffSet-1;
			}else{
				$strOffSet=0;
			}
			//$strPage = $strPage==0 ? 1 : $strPage; //checks to see that page numbers don't go to neg
			break;
		case ">":
			if ($strOffSet<$nRecords){
				$strOffSet=$strOffSet+1;
			}else{
				$strOffSet=$nRecords-1;
			}	
			break;
		case ">>":
			$strOffSet=$nRecords;
			break;
		default:
			$strOffSet = $strOffSet==0 ? 0 : $strOffSet;
	}	
	$_SESSION["strOffSet"]=$strOffSet; //counts offset values
}
?>