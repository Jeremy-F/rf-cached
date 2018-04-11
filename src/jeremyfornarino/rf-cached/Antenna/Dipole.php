<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeremyfornarino
 * Date: 11/04/2018
 * Time: 04:02
 */

namespace jeremyfornarino\rfCached\Antenna;


class Dipole extends Antenna {
    static function gain(int $frequency, int $absolutePower){
        return 0;
    }
}