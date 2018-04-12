<?php
/**
 * Created by IntelliJ IDEA.
 * User: jeremyfornarino
 * Date: 11/04/2018
 * Time: 04:08
 */

namespace jeremyfornarino\rfCached\extract;


class Avg extends Extract{
    static function run($filesPath, $antenna){
        $results = [];
        foreach($filesPath AS $filePath){
            $fileContent = file_get_contents($filePath);
            $lines = explode("\n", $fileContent);
            $countLines = count($lines);
            //$timestamp = explode(",", $lines[1])[2];
            for($nbrLine = 1; $nbrLine < $countLines; $nbrLine++){
                $line = $lines[$nbrLine];
                if(strlen(trim($line)) > 3) {
                    list($frequency, $absolutepower) = explode(",", $line);
                    $frequency = intval($frequency);
                    $absolutepower = intval($absolutepower - $antenna->gain(intval($frequency), intval($absolutepower)));

                    if (!isset($results[$frequency])) $results[$frequency] = ["total" => $absolutepower, "n" => 1];
                    else {
                        $results[$frequency]["total"] += $absolutepower;
                        $results[$frequency]["n"]++;
                    }
                }
            }
        }
        ksort($results);
        $realResults = ["data" => [], "xkey" => "frequency", "ykey" => ['absolutePower']];
        foreach($results AS $frequency => $data){
            $realResults["data"][] = [
                "frequency" => $frequency,
                "absolutePower" => round($data["total"] / $data["n"], 0),
                "total" => $data["total"],
                "n" => $data["n"]
            ];
        }
        /*
        $realResults = ["x" => [], "y" => []];
        foreach($results AS $frequency => $data){
            $realResults["x"][] = $frequency;
            $realResults["y"][] = round($data["total"] / $data["n"], 0);
        }*/
        return $realResults;
    }
}