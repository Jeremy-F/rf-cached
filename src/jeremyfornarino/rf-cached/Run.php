<?php
namespace jeremyfornarino\rfCached;

use jeremyfornarino\rfCached\Antenna\Dipole;
use jeremyfornarino\rfCached\Antenna\Discon;
use jeremyfornarino\rfCached\extract\Max;
use jeremyfornarino\rfCached\extract\Min;
use jeremyfornarino\rfCached\extract\Avg;

class Run{
    private $data = null;
    public function start(){
        $time_start = microtime(true);
        $this->loadData();
        foreach($this->data->antennas AS $antenna){
            $antennaDir = DIR_ANTENNAS.$antenna->dir;

            $antennaObj = null;
            if($antenna->type == "dipole"){
                $antennaObj = new Dipole();
            }else if($antenna->type == "discon"){
                $antennaObj = new Discon();
            }else{
                echo "Attention l'antenne n'a pas de type !";
                //exit();
            }
            if($antennaObj != null) {
                $childrens = [];
                foreach ($antenna->bands AS $band) {
                    $pid = pcntl_fork();
                    if($pid){
                        $childrens[] = $pid;
                    }else{
                        $bandDir = $antennaDir . $band->name . "/";
                        $filesPath = glob($bandDir . "*.csv*");

                        $antennaName = $antenna->name;
                        $bandName = $band->name;

                        $max = Max::run($filesPath, $antennaObj);
                        $this->saveResults($antennaName, $bandName, "max", $max);

                        $min = Min::run($filesPath, $antennaObj);
                        $this->saveResults($antennaName, $bandName, "min", $min);

                        $avg = Avg::run($filesPath, $antennaObj);
                        $this->saveResults($antennaName, $bandName, "avg", $avg);

                        exit(0);
                    }
                }
                foreach($childrens AS $children){
                    echo "Waiting children : ".$children."\n";
                    pcntl_waitpid($children, $status);
                }
            }

        }
        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "Execution :  $time secondes\n";
    }
    public function saveResults($antennaName, $bandName, $chartType, $result){

        $filePath = $this->pathNameGenerator();
        file_put_contents($filePath, json_encode($result));

        $data = [];
        foreach($this->data->antennas AS $antenna){
            if($antenna->name == $antennaName){
                foreach($antenna->bands AS $bandKey => $band){
                    if($band->name == $bandName){
                        $data = [
                            "band" => $bandName,
                            "antenna" => $antennaName,
                            "fileName" => basename($filePath),
                            "type" => $chartType
                        ];
                    }
                }
            }
        }
        $savedFilePath = $this->pathNameGenerator("saved/");
        file_put_contents($savedFilePath, json_encode($data));
    }
    public function pathNameGenerator(string $middleFix = ""){
        return DIR_RESULTS.$middleFix.md5(uniqid().rand(0,1000).rand(0,1000).uniqid()).".json";
    }
    public function loadData(){
        $jsonDataContent = file_get_contents(DATA_JSON);
        $this->data = json_decode($jsonDataContent);
    }
    public function saveData(){
        file_put_contents(DATA_JSON, json_encode($this->data));
    }

    public function realySave($antennaName, $bandName, $fileName, $type){
        $this->loadData();
        foreach($this->data->antennas AS $antennaKey => $antenna) {
            if ($antenna->name == $antennaName) {
                foreach ($antenna->bands AS $bandKey => $band) {
                    if ($band->name == $bandName) {
                        if(!isset($band->charts)){$band->charts = [];}
                        $band->charts[] = ["fileName" => $fileName,"type" => $type];
                        $antenna->bands[$bandKey] = $band;
                        $this->data->antennas[$antennaKey] = $antenna;
                        break;
                    }
                }
                break;
            }
        }
        $this->saveData();
    }
}