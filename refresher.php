<?php 

// Der Refresher liefert ein html, dass sich selber refresht
// refresherversion 0.7

$scriptplace = basename($_SERVER["SCRIPT_NAME"]);

$url     = (isset($_GET['url']))?     $_GET['url'] : "www.hansaport.de/webcam.jpg";
$refresh = (isset($_GET['refresh']))? intval($_GET['refresh']) : 60;
$width   = (isset($_GET['width']))?   intval($_GET['width']) : 150;

echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="'.$refresh.'; URL='.$scriptplace .'?refresh='.$refresh.'&width='.$width.'&url='.$url.'">
<style type="text/css"> <!-- html, body { margin:0; padding:0; } --> </style>
</head>
<body><img src="http://'.$url.'" width="'.$width.'" /></body>
</html>');

?>