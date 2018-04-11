<?php
//define("DATA_JSON", "data.json");
//define("DIR_ANTENNAS", "data/");
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

//(new Run())->start();


$childrens = [];

$jeSuisEnTrain = false;

$bands = [
    ["name" => "nom de la band"],
    ["name" => "Bande Name"],
];

foreach($bands AS $band){
    $pid = pcntl_fork();
    if($pid){
        $childrens[] = $pid;
    }else{
        while ($jeSuisEnTrain){
            echo "Je suis en train...";
            sleep(1);
        }
        sleep(20);
        exit(0);
    }
}

foreach($childrens AS $children){
    pcntl_waitpid($children, $status);
}