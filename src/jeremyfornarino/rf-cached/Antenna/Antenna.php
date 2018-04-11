<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeremyfornarino
 * Date: 11/04/2018
 * Time: 03:58
 */

namespace jeremyfornarino\rfCached\Antenna;


abstract class Antenna{
    abstract static function gain(int $frequency, int $absolutePower);
}