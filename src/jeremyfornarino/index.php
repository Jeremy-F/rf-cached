<?php
namespace jeremyfornarino;

require_once "../../vendor/autoload.php";

use jeremyfornarino\rfCached\Run;

define("DATA_JSON", "/home/rf/rf-vue/api/data.json");
define("DIR_ANTENNAS",  "/home/rf/data/");
define("DIR_RESULTS",  "/home/rf/rf-vue/api/results/");

$run = new Run();
$run->start();