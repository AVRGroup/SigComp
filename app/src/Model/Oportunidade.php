<?php

namespace App\Model;

use App\Library\ToIdArrayInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Oportunidade
 *
 * @ORM\Entity()
 * @ORM\Table(name="oportunidade")
 */
class Oportunidade implements ToIdArrayInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $tipo;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $quantidade_vagas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $professor;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $remuneracao;

    /**
     * @ORM\Column(type="string", length=2000000, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $validade;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $arquivo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $extensao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $arquivo_imagem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $extensao_imagem;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $periodo_minimo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $periodo_maximo;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $criado_em;

    /**
     * @ORM\ManyToMany(targetEntity="Disciplina", inversedBy="oportunidade")
     * @ORM\JoinTable(name="oportunidade_disciplina")
     */
    protected $disciplinas;



    public function __construct()
    {
        $this->disciplinas = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getDisciplinas()
    {
        return $this->disciplinas;
    }

    /**
     * @param Disciplina $disciplina
     */
    public function addDisciplina(Disciplina $disciplina): void
    {
        $disciplina->addOportunidade($this);
        $this->disciplinas[] = $disciplina;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return mixed
     */
    public function getPeriodoMinimo()
    {
        return $this->periodo_minimo;
    }

    public function getPeriodoMinimoParaEscrita()
    {
       if($this->periodo_minimo == -1) {
           return "Sem Limite";
       }

       return $this->periodo_minimo;
    }

    /**
     * @param mixed $periodo_minimo
     */
    public function setPeriodoMinimo($periodo_minimo): void
    {
        $this->periodo_minimo = $periodo_minimo;
    }

    /**
     * @return mixed
     */
    public function getPeriodoMaximo()
    {
        return $this->periodo_maximo;
    }

    public function getPeriodoMaximoParaEscrita()
    {
        if($this->periodo_maximo == 999){
            return "Sem Limite";
        }

        return $this->periodo_maximo;
    }

    /**
     * @param mixed $periodo_maximo
     */
    public function setPeriodoMaximo($periodo_maximo): void
    {
        $this->periodo_maximo = $periodo_maximo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getQuantidadeVagas()
    {
        return $this->quantidade_vagas;
    }

    /**
     * @param mixed $quantidade_vagas
     */
    public function setQuantidadeVagas($quantidade_vagas): void
    {
        $this->quantidade_vagas = $quantidade_vagas;
    }

    /**
     * @return mixed
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * @param mixed $professor
     */
    public function setProfessor($professor): void
    {
        $this->professor = $professor;
    }

    /**
     * @return mixed
     */
    public function getValidade()
    {
        return $this->validade;
    }

    /**
     * @param mixed $validade
     */
    public function setValidade($validade): void
    {
        $this->validade = $validade;
    }


    /**
     * @return mixed
     */
    public function getRemuneracao()
    {
        return $this->remuneracao;
    }

    /**
     * @param mixed $remuneracao
     */
    public function setRemuneracao($remuneracao): void
    {
        $this->remuneracao = $remuneracao;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo): void
    {
        $this->arquivo = $arquivo;
    }

    /**
     * @return mixed
     */
    public function getArquivoImagem()
    {
        return $this->arquivo_imagem;
    }

    /**
     * @param mixed $arquivo_imagem
     */
    public function setArquivoImagem($arquivo_imagem): void
    {
        $this->arquivo_imagem = $arquivo_imagem;
    }

    /**
     * @return mixed
     */
    public function getExtensaoImagem()
    {
        return $this->extensao_imagem;
    }

    /**
     * @param mixed $extensao_imagem
     */
    public function setExtensaoImagem($extensao_imagem): void
    {
        $this->extensao_imagem = $extensao_imagem;
    }


    /**
     * @return mixed
     */
    public function getExtensao()
    {
        return $this->extensao;
    }

    /**
     * @param mixed $extensao
     */
    public function setExtensao($extensao): void
    {
        $this->extensao = $extensao;
    }

    /**
     * @return mixed
     */
    public function getCriadoEm()
    {
        return $this->criado_em;
    }

    /**
     * @param mixed $criado_em
     */
    public function setCriadoEm($criado_em): void
    {
        $this->criado_em = $criado_em;
    }




    public function getNomeTipo()
    {
        switch ($this->tipo) {
            case 0:
                return "Iniciação Científica";
                break;
            case 1:
                return "Treinamento Profissional" ;
                break;
            case 2:
                return "Estágio";
                break;
            case 3:
                return "CLT";
                break;
            case 4:
                return "Outra";
                break;
            default:
                return "Oportunidade";
        }
    }


    public function abreviacao()
    {
        switch ($this->tipo) {
            case 0:
                return "ic";
                break;
            case 1:
                return "tp" ;
                break;
            case 2:
                return "estagio";
                break;
            case 3:
                return "clt";
                break;
            case 4:
                return "outra";
                break;
            default:
                return "outro";
        }
    }

    public function isDisciplinaSelecionada($disciplina)
    {
        $disciplinasSelecionadas = $this->getDisciplinas();

        foreach ($disciplinasSelecionadas as $disciplinasSelecionada) {
            if ($disciplinasSelecionada->getCodigo() == $disciplina->getCodigo()){
                return true;
            }
        }

        return false;
    }

    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }
}

