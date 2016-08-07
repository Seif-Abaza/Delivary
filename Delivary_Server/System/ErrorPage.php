<?php

if (getcwd() == dirname(__FILE__)) {
    die(ShowError());
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function redirect($URL) {
    header("Location: " . $URL);
}

function isBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];

//get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        return true;
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        return true;
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        return true;
    } elseif (preg_match('/Safari/i', $u_agent)) {
        return true;
    } elseif (preg_match('/Opera/i', $u_agent)) {
        return true;
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        return true;
    } else {
        return false;
    }
}

function ShowError() {
    $isBrowser = isBrowser();
    if ($isBrowser == SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
        echo ShowErrorforBrowser();
    } else {
        $Server = array(SERVER_MESSAGE_NOTE => MessagesSystem(SORRY_FOR_UPDATE));
        print json_encode($Server);
    }
    exit(0);
}

function ShowErrorforBrowser() {
    $Message = "<!DOCTYPE HTML>
<html>
<head>
<title>" . MessagesSystem(SERVER_ERROR_TITEL_MESSAGE) . "</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<style type=\"text/css\">
body{
	font-family: 'Capriola', sans-serif;
}
body{
	background:#DAD6CC;
}	
.wrap{
	margin:0 auto;
	width:1000px;
}
.logo h1{
	font-size:200px;
	color:#FF7A00;
	text-align:center;
	margin-bottom:1px;
	text-shadow:4px 4px 1px white;
}	
.logo p{
	color:#B1A18D;;
	font-size:20px;
	margin-top:1px;
	text-align:center;
}	
.logo p span{
	color:lightgreen;
}	
.sub a{
	color:#ff7a00;
	text-decoration:none;
	padding:5px;
	font-size:13px;
	font-family: arial, serif;
	font-weight:bold;
}	
.footer{
	color:white;
	position:absolute;
	right:10px;
	bottom:10px;
}	
.footer a{
	color:#ff7a00;
}	
</style>
</head>


<body>


	<div class=\"wrap\">
		<div class=\"logo\">
			<h1>" . MessagesSystem(SERVER_ERROR_NUMBER) . "</h1>
			<p>" . sprintf(MessagesSystem(SERVER_ERROR_MESSAGE), "No Data") . "</p>
		</div>
	</div>
	
	<div class=\"footer\">
	 SuperWoW
	</div>

</body>";


    echo $Message;
}

function ShowUpdate() {
    $Message = "<!DOCTYPE HTML>
<html>
<head>
<title>" . MessagesSystem(SERVER_REPAIR_TITEL_MESSAGE) . "</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<style type=\"text/css\">
body{
	font-family: 'Capriola', sans-serif;
}
body{
	background:#DAD6CC;
}	
.wrap{
	margin:0 auto;
	width:1000px;
}
.logo h1{
	font-size:100px;
	color:#FF7A00;
	text-align:center;
	margin-bottom:1px;
	text-shadow:4px 4px 1px white;
}	
.logo p{
	color:#B1A18D;;
	font-size:20px;
	margin-top:1px;
	text-align:center;
}	
.logo p span{
	color:lightgreen;
}	
.sub a{
	color:#ff7a00;
	text-decoration:none;
	padding:5px;
	font-size:13px;
	font-family: arial, serif;
	font-weight:bold;
}	
.footer{
	color:white;
	position:absolute;
	right:10px;
	bottom:10px;
}	
.footer a{
	color:#ff7a00;
}	
</style>
</head>


<body>


	<div class=\"wrap\">
		<div class=\"logo\">
			<h1>" . MessagesSystem(SERVER_REPAIR_MESSAGE) . "</h1>
		</div>
	</div>

</body>";

    $isBrowser = isBrowser();
    if ($isBrowser === SystemVariable(FILED_SYSTEM_CAN_GET_DATA_FROM_BROWSER)) {
        echo $Message;
    } else {
        $Server = array(SERVER_MESSAGE_NOTE => MessagesSystem(SORRY_FOR_UPDATE));
        print json_encode($Server);
    }
    exit(0);
}
