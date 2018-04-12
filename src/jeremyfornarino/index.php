<?php
namespace jeremyfornarino;

require_once "../../vendor/autoload.php";
require_once "config.php";

use jeremyfornarino\rfCached\Run;

$run = new Run();
$run->start();