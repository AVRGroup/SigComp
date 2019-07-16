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
        $user = $request->getAttribute('user');
        $this->container->view['user'] = $user;

        $this->container->view['notificacoes'] =  $this->container->usuarioDAO->getConvitesPendentes($user->getId());
        $this->container->view['categoriesFull'] = $this->container->categoriaDAO->getAll();
        $this->container->view['topicosPorCategoria'] = $this->getTopicosPorCategoria();

        return $this->container->view->render($response, 'forumMain.tpl');
    }

    public function getTopicosPorCategoria()
    {
        $databaseResponse = $this->container->categoriaDAO->getQuantidadeTopicos();
        $topicosPorCategoria = [];

        foreach ($databaseResponse as $topicoPorCategoria) {
            $topicosPorCategoria[$topicoPorCategoria['id']] = $topicoPorCategoria['quantidade'];
        }

        return $topicosPorCategoria;
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

    public function showCategoryAction(Request $request, Response $response, $args)
    {
        $categoria = $this->container->categoriaDAO->getById(intval($args['id']));

        if(!$categoria) {
            return $response->withRedirect($this->container->router->pathFor('listCategories'));
        }

        $topicos = $this->container->topicoDAO->getAllByCategory(intval($args['id']));

        $this->container->view['categoria'] = $categoria;
        $this->container->view['topicsFull'] = $topicos;

        return $this->container->view->render($response, 'categoria.tpl');
    }

    public function novoTopicoAction(Request $request, Response $response, $args){
        $topico = new Topico();
        $categoria = $this->container->categoriaDAO->getById($args['id']);

        $allCategories = $this->container->categoriaDAO->getAll();

        try{
            if($request->isPost()){
                $autor = $_SESSION['id'];
                $topico->setUsuario($this->container->usuarioDAO->getById($autor));

                $assunto = $request->getParsedBodyParam('topic_subject');
                $data = date('Y-m-d H:i:s');
                $conteudo = $request->getParsedBodyParam('post_content');

                $topico->setAssunto($assunto);
                $topico->setConteudo($conteudo);
                $topico->setData($data);
                $topico->setCategoria($categoria);

                $this->container->topicoDAO->persist($topico);
                $this->container->topicoDAO->flush();

                $this->container->view['success'] = true;
            }
        }catch (\Exception $e){
            $this->container->view['error'] = $e->getMessage();
        }

        if(!isset($allCategories))
            $this->container->view['error'] = 'Você não tem categorias cadastradas!';

        $this->container->view['categoriesFull'] = $allCategories;
        return $this->container->view->render($response, 'novoTopico.tpl');
    }

    public function showTopicoAction(Request $request, Response $response, $args)
    {
        $topico = $this->container->topicoDAO->getById($args['id']);

        $this->container->view['topico'] = $topico;

        return $this->container->view->render($response, 'topic.tpl');
    }

    public function responderAction(Request $request, Response $response, $args)
    {
        $conteudo = $request->getParsedBodyParam('resposta');
        $idTopico = $request->getParsedBodyParam('id_topico');
        $idUsuario = $request->getParsedBodyParam('id_usuario');

        $usuario = $this->container->usuarioDAO->getById($idUsuario);
        $topico = $this->container->topicoDAO->getById($idTopico);

        $data = date('d-m-Y');

        $resposta = new Resposta();

        $resposta->setConteudo($conteudo);
        $resposta->setAutor($usuario);
        $resposta->setTopico($topico);
        $resposta->setData($data);

        try {
            $this->container->respostaDAO->save($resposta);
        } catch (\Exception $e) {
            die(var_dump($e->getMessage()));
            return $this->container->view->render($response, '404.tpl');
        }

        return $response->withRedirect($idTopico);
    }

}