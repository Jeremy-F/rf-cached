<?php
namespace jeremyfornarino;

require_once "../../vendor/autoload.php";
require_once "config.php";

use jeremyfornarino\rfCached\Run;


$run = new Run();
foreach (glob(DIR_RESULTS."saved/*.json") AS $filePath){
    $content = json_decode(file_get_contents($filePath));
    $run->realySave($content->antenna,$content->band, $content->fileName, $content->type);
    //unlink($filePath);
}