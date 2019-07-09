<?php

namespace App\Library;

use App\Model\Certificado;
use App\Model\Nota;
use App\Model\Usuario;

class CalculateAttributes
{
    public static function calculateUsuarioStatistics(Usuario $usuario, $container)
    {
        $usuario->setNivel(0)
            ->setExperiencia(0)
            ->setCarisma(0)
            ->setInteligencia(0)
            ->setSabedoria(0)
            ->setDestreza(0)
            ->setForca(0);

        // Calculo das Notas
        foreach ($usuario->getNotas() as $nota) {
            /** @var Nota $nota */
            if ($nota->getEstado() !== 'Aprovado') {
                continue;
            }

            $disciplina = $nota->getDisciplina();

            $usuario->setCarisma($usuario->getCarisma() + ($nota->getValor() * ($disciplina->getFatorCarisma() / 10)))
                ->setInteligencia($usuario->getInteligencia() + ($nota->getValor() * ($disciplina->getFatorInteligencia() / 10)))
                ->setSabedoria($usuario->getSabedoria() + ($nota->getValor() * ($disciplina->getFatorSabedoria() / 10)))
                ->setDestreza($usuario->getDestreza() + ($nota->getValor() * ($disciplina->getFatorDestreza() / 10)))
                ->setForca($usuario->getForca() + ($nota->getValor() * ($disciplina->getFatorForca() / 10)));
        }

        $usuario->setExperiencia(self::calculaExpereiencia($usuario, $container));

        CalculateAttributes::updateUsuarioCultura($usuario);
    }

    public static function updateUsuarioCultura(Usuario $usuario)
    {
        $usuario->setCultura(0);

        // Calculo das Notas
        foreach ($usuario->getCertificados() as $certificado) {
            /** @var Certificado $certificado */
            if (!$certificado->getValido()) {
                continue;
            }

            $usuario->setCultura($usuario->getCultura() + 10);
        }
    }

    /**
     * @param $usuario
     * @param $container
     * @return float|int
     */
    public static function calculaExpereiencia(Usuario $usuario, $container)
    {
        $notas_usuario = $usuario->getNotas();
        $aprovacoes = 0;
        for ($periodo = 1; $periodo <= 9; $periodo++) {
            $disciplinas = $container->usuarioDAO->getDisciplinasByGradePeriodo($usuario->getGrade(), $periodo);

            foreach ($disciplinas as $disciplina){
                foreach ($notas_usuario as $nota){
                    if ($disciplina->getCodigo() == $nota->getDisciplina()->getCodigo()&& $nota->getEstado() == 'Aprovado' )
                        $aprovacoes++;
                    else if ($nota->getDisciplina()->getCodigo() == $disciplina->getCodigo()."E" && $nota->getEstado() == 'Aprovado')
                        $aprovacoes++;
                }
            }
        }

        return $aprovacoes * 100;
    }


}