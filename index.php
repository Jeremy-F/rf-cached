<?php
define("DATA_JSON", "data.json");
define("DIR_ANTENNAS", "data/");
/*
class Run{
    public function start(){
        $data = json_decode(file_get_contents(DATA_JSON));
        foreach($data->antennas AS $antenna){
            $antennaDir = DIR_ANTENNAS.$antenna->dir;

            foreach($antenna->bands AS $band){
                $bandDir = $antennaDir.$band->name;




            }
        }
    }
}*/

(new Run())->start();

/*
$childrens = [];

$bands = [
    ["name" => "nom de la band"],
    ["name" => "Bande Name"],
];

foreach($bands AS $band){
    $pid = pcntl_fork();
    if($pid){
        $childrens[] = $pid;
    }else{
        sleep(5);
        exit(0);
    }
}

foreach($childrens AS $children){
    echo "J'attent le children : ".$children."\n";
    pcntl_waitpid($children, $status);
    //echo " : ".$status."\n";
}*/