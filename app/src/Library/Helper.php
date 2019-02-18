<?php

namespace App\Library;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Helper
{
    /**
     * @param $objList
     * @return array
     */
    public static function convertToIdArray($objList)
    {
        $array = array();
        if (is_array($objList)) {
            foreach ($objList as $obj) {
                if ($obj instanceof ToIdArrayInterface) {
                    $array[$obj->getIdentifier()] = $obj;
                }
            }
        }

        return $array;
    }

    public static function processCSV($filePath)
    {
        $fileExcel = IOFactory::load($filePath);
        $fileExcel->setActiveSheetIndex(0);
        $fileSheet = $fileExcel->getActiveSheet();

        $data = ['usuarios' => [], 'disciplinas' => []];

        for ($row = 2; $row <= $fileSheet->getHighestRow(); $row++) {

            $index = $fileSheet->getCell('B' . $row)->getValue();
            if (!isset($data['usuarios'][$index])) {
                $data['usuarios'][$index]['curso'] = $fileSheet->getCell('A' . $row)->getValue();
                $data['usuarios'][$index]['matricula'] = $fileSheet->getCell('B' . $row)->getValue();
                $data['usuarios'][$index]['nome'] = $fileSheet->getCell('C' . $row)->getValue();
                $data['usuarios'][$index]['grade'] = $fileSheet->getCell('D' . $row)->getValue();
            }

            if (!isset($data['usuarios'][$index]['disciplinas'])) {
                $data['usuarios'][$index]['disciplinas'] = [];
            }

            $disciplina = [
                'codigo' => $fileSheet->getCell('F' . $row)->getValue(),
                'periodo' => $fileSheet->getCell('E' . $row)->getValue(),
                'status' => $fileSheet->getCell('H' . $row)->getValue(),
                'nota' => intval($fileSheet->getCell('G' . $row)->getValue()),
                'carga' => $fileSheet->getCell('I' . $row)->getValue()
            ];

            $data['usuarios'][$index]['disciplinas'][] = $disciplina;

            if (!isset($data['disciplinas'][$disciplina['codigo']])) {
                $data['disciplinas'][$disciplina['codigo']] = $disciplina;
            }

        }

        return $data;
    }

    public static function processGradeCSV($filePath)
    {
        $fileExcel = IOFactory::load($filePath);
        $fileExcel->setActiveSheetIndex(0);
        $fileSheet = $fileExcel->getActiveSheet();

        $data = ['disciplinas' => []];

        for ($row = 1; $row <= $fileSheet->getHighestRow(); $row++) {

            $disciplina = [
                'codigo' => $fileSheet->getCell('A' . $row)->getValue(),
                'periodo' => $fileSheet->getCell('C' . $row)->getValue(),
                'nome' => $fileSheet->getCell('B' . $row)->getValue(),
                'carga' => $fileSheet->getCell('D' . $row)->getValue()
            ];

            $data['disciplinas'][$row] = $disciplina;

            /*if (!isset($data['disciplinas'][$disciplina['codigo']])) {
                $data['disciplinas'][$disciplina['codigo']] = $disciplina;
            }*/
        }

        return $data;
    }
}