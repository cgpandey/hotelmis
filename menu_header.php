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
include_once ("queryfunctions.php");
include_once ("functions.php");

$loginname=$_SESSION["loginname"];
$sql = "select userid,admin,guest,reservation,booking,agents,rooms,billing,rates,lookup,reports from users where loginname='$loginname'";
$conn=db_connect(HOST,USER,PASS,DB,PORT);
$results=mkr_query($sql,$conn);
$msg[0]="";
$msg[1]="";
AddSuccess($results,$conn,$msg);
$access = fetch_object($results);

//will be used to set access on pages
/*if !isset($_SESSION["access"]){
	$_SESSION["access"]
}*/

if($access->admin==1) echo "<tr><td><a href=\"admin.php\">Admin</a></td></tr>";
if($access->guest==1) echo "<tr><td><a href=\"guests.php\">Guests</a></td></tr>";
if($access->reservation==1) echo "<tr><td><a href=\"reservations.php\">Reservations</a></td></tr>";
if($access->booking==1) echo "<tr><td><a href=\"bookings.php\">Bookings</a></td></tr>";
if($access->agents==1) echo "<tr><td><a href=\"agents.php\">Agents</a></td></tr>";
if($access->rooms==1) echo "<tr><td><a href=\"rooms.php\">Rooms</a></td></tr>";
if($access->billing==1) echo "<tr><td><a href=\"billings.php\">Guest Bill</a></td></tr>";
if($access->rates==1) echo "<tr><td><a href=\"rates.php\">Rates</a></td></tr>";
if($access->lookup==1) echo "<tr><td><a href=\"lookup.php\">Lookups</a></td></tr>";
if($access->reports==1) echo "<tr><td><a href=\"reports.php\">Reports</a></td></tr>";
free_result($access);
?>