<?php
namespace Mithra62\BackupManager\Services;

class FilesService
{
    /**
     * @param $val
     * @param $digits
     * @param $mode
     * @param $bB
     * @return string
     */
    public function format($val, $digits = 3, $mode = "SI", $bB = "B"): string
    { //$mode == "SI"|"IEC", $bB == "b"|"B"
        $si = ["", "k", "M", "G", "T", "P", "E", "Z", "Y"];
        $iec = ["", "Ki", "Mi", "Gi", "Ti", "Pi", "Ei", "Zi", "Yi"];
        switch (strtoupper($mode)) {
            case "SI" :
                $factor = 1000;
                $symbols = $si;
                break;
            case "IEC" :
                $factor = 1024;
                $symbols = $iec;
                break;
            default :
                $factor = 1000;
                $symbols = $si;
                break;
        }
        switch ($bB) {
            case "b" :
                $val *= 8;
                break;
            default :
                $bB = "B";
                break;
        }
        for ($i = 0; $i < count($symbols) - 1 && $val >= $factor; $i++) {
            $val /= $factor;
        }
        $p = strpos($val, ".");
        if ($p !== false && $p > $digits) {
            $val = round($val);
        } elseif ($p !== false) {
            $val = round($val, $digits - $p);
        }

        return round($val, $digits) . " " . $symbols[$i] . $bB;
    }
}