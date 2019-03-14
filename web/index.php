<?php

$fileName = 'data.csv';
$program = new Main($fileName);

class Main{

    private $html;

    public function __construct($fileName){

        $records = File::getRecords($fileName);
        $table = Site::table($records);
        System::printPage($table);

    }
}

class File{

    public static function getRecords(String $filename){

        $records = Array();
        $count = 0;
        $fieldNames = '';

        if (($handle = fopen($filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

                if($count == 0) {
                    $fieldNames = $row;
                } else {
                    $records[] = (object) array_combine($fieldNames, $row);
                }
                $count++;
            }
            fclose($handle);
        }

        return $records;

    }

}

class Site{

    public static function tableRow($row){
        $html = "<tr> $row </tr>";
        return $html;
    }

    public static function table($records){

        $html = '<table>';

        $html .= '<tr>';

        $headings = array_shift($records);

        foreach ($headings as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
        $html .= '</tr>';

        foreach ($records as $key=>$value){
            $html .= '<tr>';
            foreach ($value as $key2=>$value2){
                $html .= '</td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';
        return $html;
    }
}

class System
{
    public static function printPage($page)
    {

        echo $page;

    }
}