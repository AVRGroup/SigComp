<?php

namespace App\Controller;

use App\Model\Categoria;
use App\Model\Resposta;
use App\Model\Topico;
use Slim\Http\Request;
use Slim\Http\Response;

class ForumController{

    private $container;

    public function __construct(\Container $container)
    {
        $this->container = $container;
    }

    public function showForumAction(Request $request, Response $response, $args){
        $allCategories = $this->container->categoriaDAO->getAll();
        $this->container->view['categoriesFull'] = $allCategories;

        return $this->container->view->render($response, 'forumMain.tpl');
    }

    public function listCategoriesAction(Request $request, Response $response, $args){
        $allCategories = $this->container->categoriaDAO->getAll();

        $this->container->view['categoriesFull'] = $allCategories;

        return $this->container->view->render($response, 'listCategories.tpl');
    }

    public function novaCategoriaAction(Request $request, Response $response, $args){

        $categoria = new Categoria();

        try {
            if ($request->isPost()) {
                $nome = $request->getParsedBodyParam('nomeCategoria');
                $descricao = $request->getParsedBodyParam('descricaoCategoria');

                $categoria->setNome($nome);
                $categoria->setDescricao($descricao);

                $this->container->categoriaDAO->persist($categoria);
                $this->container->categoriaDAO->flush(); //Commit the transaction
                $this->container->view['success'] = "Categoria criada com sucesso!";
            }
        }
        catch (\Exception $e){
            $this->container->view['error'] = $e->getMessage();
        }

        return $this->container->view->render($response, 'novaCategoria.tpl');
    }

    public function novoTopicoAction(Request $request, Response $response, $args){
        $topico = new Topico();
        $resposta = new Resposta();

        $allCategories = $this->container->categoriaDAO->getAll();

        try{
            if($request->isPost()){
                $assunto = $request->getParsedBodyParam('topic_subject');
                $data = date('Y-m-d H:i:s');
                $categoria = $request->getParsedBodyParam('topic_cat');
                $autor = $_SESSION['id'];
                $conteudo = $request->getParsedBodyParam('post_content');

                $topico->setAssunto($assunto);
                $topico->setData($data);
                $topico->setCategoria($this->container->categoriaDAO->getById($categoria));
                $topico->setUsuario($this->container->usuarioDAO->getById($autor));

                $this->container->topicoDAO->persist($topico);
                $this->container->topicoDAO->flush();

                $resposta->setAutor($this->container->usuarioDAO->getById($autor));
                $resposta->setConteudo($conteudo);
                $resposta->setData($data);
                $resposta->setTopico($topico);
                $this->container->respostaDAO->persist($topico);
                $this->container->respostaDAO->flush();
                $this->container->view['success'] = true;
            }
        }catch (\Exception $e){
            $this->container->view['error'] = $e->getMessage();
        }

        if(!isset($allCategories))
            $this->container->view['error'] = 'Você não tem categorias cadastradas!';

        $this->container->view['categoriesFull'] = $allCategories;
        return $this->container->view->render($response, 'novoForum.tpl');
    }

}