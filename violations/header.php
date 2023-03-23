<?php
ob_start();
global $servername;
global $username;
global $password;
global $database;

//$servername = 'localhost';
//$username = 'videoenf_videoenforcement';
//$password = 'Classified123#@!';
//$database = 'videoenf_videoenforcement';

 $servername = 'localhost';
 $username = 'root';
 $password = '';
 $database = 'videoenf_videoenforcement';

include_once('includes/database.php');