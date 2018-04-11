<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeremyfornarino
 * Date: 11/04/2018
 * Time: 04:08
 */

namespace jeremyfornarino\rfCached\extract;


abstract class Extract{
    abstract static function run($filesPath, $antenna);
}