<?php
$files = array("pdf/Violation-11023-2205121035-148.pdf","pdf/Violation-11023-2205121041-558.pdf","pdf/Violation-11023-2206261100-349.pdf");
$zipname = 'zip/file.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);