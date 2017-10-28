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
function db_connect($HOST,$USER,$PASS,$DB,$PORT)
{
	$conn = ($GLOBALS["___mysqli_ston"] = mysqli_connect($HOST . ":" . $PORT ,  $USER,  $PASS));
	mysqli_select_db($GLOBALS["___mysqli_ston"], $DB);
	return $conn;
}

function db_close($conn)
{
	((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
}

//get data from table
function mkr_query($strsql,$conn)
{
	$rs = mysqli_query($conn, $strsql);
	return $rs;
}

//get number of rows in results sets
function num_rows($rs)
{
	return @mysqli_num_rows($rs); 
}

function fetch_array($rs)
{
	return mysqli_fetch_array($rs);
}

//fetch object
function fetch_object($rs)
{
	return mysqli_fetch_object($rs);
}

function free_result($rs)
{
	@((mysqli_free_result($rs) || (is_object($rs) && (get_class($rs) == "mysqli_result"))) ? true : false);
}

function data_seek($rs,$cnt)
{
	@mysqli_data_seek($rs,  $cnt);
}

function error()
{
	return mysqli_error($GLOBALS["___mysqli_ston"]);
}
?>

<?php
	define("HOST", "localhost");
	define("PORT", 8889);
	define("USER", "root");
	define("PASS", "root");
	define("DB", "hotelmis");
	
	/*define("HOST", "mysql4-h");
	define("PORT", 3306);
	define("USER", "h172638rw");
	define("PASS", "hotelmis321");
	define("DB", "h172638_hotelmis");*/
?>
