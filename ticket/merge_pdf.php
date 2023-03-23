<?php
require_once 'vendor/autoload.php';
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;
$fileArray= array("pdf/Violation-11023-2205121066-604.pdf","pdf/Violation-11023-2205121067-459.pdf","pdf/Violation-11023-2205121068-119.pdf");
$merger = new Merger;
$merger->addIterator($fileArray);
$createdPdf = $merger->merge();

$myfile = fopen("pdf_save/newfile.pdf", "w") or die("Unable to open file!");
$txt = $createdPdf;
fwrite($myfile, $txt);

fclose($myfile);