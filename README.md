# Gameficação

## Componentes

* PHP 7 - Versão utilizada para o desenvolvimento
* MySQL - Banco de Dados
* [Composer](https://getcomposer.org) - Gerenciador de dependências 
* [Slim Framework](https://www.slimframework.com/) - Micro-Framework para requisições e rotas
* [Doctrine 2](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/) - Framework ORM para acessar o banco de dados
* [Smarty](https://www.smarty.net/) - Template engine
* [Bootstrap](https://getbootstrap.com/) - Framework utilizado para a view

## Executando o Projeto

1. Clone o código desse repositório para dentro da pasta ``www`` ou ``htdocs`` do seu servidor web com PHP 7 e MySQL
1. Navegue até a pasta do projeto e execute ``composer install`` para instalar as dependências
1. Crie um arquivo ``settings.php`` em ``/app/``, usando como base o ``/app/settings.template.php``
1. Dê permissão de Leitura e Escrita(``chmod -R 777``) para a pasta ``/cache/`` e a pasta de upload (padrão: ``/public/upload``) definida em ``settings.php``
1. Supondo que todas as configurações estão corretas, da raiz da pasta do projeto, execute ``./vendor/bin/doctrine orm:schema-tool:create`` para subir o banco de dados
1. O projeto estará acessivel em ``http://localhost/gameficacao/public/``

## Observações

* Caso atualize o ``Model`` do projeto, deverá executar o comando ``./vendor/bin/doctrine orm:schema-tool:update`` para atualizar o banco de dados
* Caso queira ver o SQL gerado (tanto no ``orm:schema-tool:create`` quanto no ``orm:schema-tool:update``) utilize o argumento ``--dump-sql``. Exemplo: ``./vendor/bin/doctrine orm:schema-tool:create --dump-sql``
