<?php

namespace App\Library;

use App\Model\Usuario;
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

    public static function getUsuariosSemAcento($pesquisa, $results)
    {
        $usuariosFiltrados = [];

        $pesquisa = self::removeAcento($pesquisa);

        $pesquisa = strtoupper($pesquisa);

        foreach ($results as $usuario) {
            $nome = self::removeAcento($usuario['nome']);

            if($pesquisa && strpos($nome, $pesquisa) !== false) {
                array_push($usuariosFiltrados, $usuario);
            }
        }

        return $usuariosFiltrados;
    }

    private static function removeAcento($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
    public static function getGruposComPontuacao($container, Usuario $usuario, $isTotal = false)
    {
        $disciplinas = $container->disciplinaDAO->getByGrade($usuario->getGradeId($container));
        $quantidadeDeDisciplinasRealizadasNoCurso = [];

        foreach ($disciplinas as $disciplina) {
            $grupo = $disciplina->getGrupo($container, $usuario->getCurso());
            if(!isset($grupo)) {
                continue;
            }

            $nomeGrupo = $grupo->getNomeInteiro();

            if(!isset($quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo])) {
                $quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo] = 1;
            } else {
                $quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo] ++;
            }
        }

        $gruposComPontuacao = [];
        $quantidadeDeDisciplinasRealizadasNoGrupo = [];

        $grupos = $container->grupoDAO->getAllByCurso($usuario->getCurso());
        foreach ($grupos as $grupo) {
            $nomeGrupo = $grupo->getNomeInteiro();
            $gruposComPontuacao[$nomeGrupo] = 0;
            $quantidadeDeDisciplinasRealizadasNoGrupo[$nomeGrupo] = 0;
        }

        $gruposComPontuacao["3-Multidisciplinaridade"] = 0;
        $quantidadeDeDisciplinasRealizadasNoGrupo["3-Multidisciplinaridade"] = 0;

        $notas = $usuario->getNotas();

        foreach ($notas as $nota) {
            $disciplina = $nota->getDisciplina();
            $estado = $nota->getEstado();

            if($estado == "Matriculado" || $estado == "Trancado" || $estado == "Sem Conceito") {
                continue;
            }

            $grupo = $disciplina->getGrupo($container, $usuario->getCurso());

            if(isset($grupo)) {
                $nomeGrupo = $grupo->getNomeInteiro();
                $gruposComPontuacao[$nomeGrupo] += $nota->getValor();
                $quantidadeDeDisciplinasRealizadasNoGrupo[$nomeGrupo] += 1;

                if($estado == "Rep Nota" || $estado == "Rep Freq" || $estado == "Reprovado") {
                    $quantidadeDeDisciplinasRealizadasNoCurso[$nomeGrupo]++;
                }

            } else {
                $gruposComPontuacao["3-Multidisciplinaridade"] += $nota->getValor();
                $quantidadeDeDisciplinasRealizadasNoGrupo["3-Multidisciplinaridade"] += 1;
            }

        }

        $quantidadeDeDisciplinasRealizadasNoCurso['3-Multidisciplinaridade'] = $quantidadeDeDisciplinasRealizadasNoGrupo['3-Multidisciplinaridade'];

        foreach ($quantidadeDeDisciplinasRealizadasNoGrupo as $nome => $quantidade) {
            if ($quantidadeDeDisciplinasRealizadasNoCurso[$nome] < $quantidade) {
                $quantidadeDeDisciplinasRealizadasNoCurso[$nome] = $quantidade;
            }
        }

        foreach ($gruposComPontuacao as $grupo => $valor) {
            if ($isTotal) {
                if($quantidadeDeDisciplinasRealizadasNoCurso[$grupo] == 0) {
                    $gruposComPontuacao[$grupo] = 0;
                }
                else {
                    $gruposComPontuacao[$grupo] = $valor / $quantidadeDeDisciplinasRealizadasNoCurso[$grupo];
                }

            } else {
                if ($quantidadeDeDisciplinasRealizadasNoGrupo[$grupo] == 0) {
                    $gruposComPontuacao[$grupo] = 0;
                } else {
                    $gruposComPontuacao[$grupo] = $valor / $quantidadeDeDisciplinasRealizadasNoGrupo[$grupo];
                }
            }

        }

        ksort($gruposComPontuacao);
        foreach ($gruposComPontuacao as $nomeGrupo => $valor) {
            $nomeSemHifen = explode("-", $nomeGrupo)[1];

            $gruposComPontuacao[$nomeSemHifen] = $valor;

            unset($gruposComPontuacao[$nomeGrupo]);
        }
        return $gruposComPontuacao;
    }

}