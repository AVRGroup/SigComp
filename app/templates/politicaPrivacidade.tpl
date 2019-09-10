{extends 'layout.tpl'}
{block name=content}
    <h3 align="center">Política de Privacidade</h3>
    <hr>
    <p>
        Bem vindo ao Sistema de Gamificação do curso de Ciência da Computação Noturno. Por favor,
        leia com atenção nossa política de privacidade. Caso não esteja de acordo, pedimos que não utilize o sistema.
    </p>

    <p>Nosso sistema tem as informações de todas suas notas, <b>mas ninguém além do administrador do sistema</b> terá acesso à elas.</p>

    <p>
        O sistema exibe os <b>10 melhores IRAs</b> do curso (geral e do período anterior). Usuários que nunca acessaram o sistema <b>tem seus nomes
        ocultos </b> por padrão. Ao acessar o sistema pela primeira vez o nome do usuário poderá ser exibido se o mesmo estiver entre
        os 10 primeiros em uma das duas listagens. Caso o usuário queira manter seu nome oculto, basta acessar o menu
        "Informações Pessoais" e marcar a opção <b>“Quero que meu nome não seja exibido”</b>. Essa opção pode ser alterada a qualquer momento.
    </p>

    <p><b>Por padrão o IRA será exibido caso esteja entre os 10 melhores</b></p>

    <p>
        O sistema <b>não reivindica o direito</b> das informações pessoais que você disponibiliza para sua conta, como os links
        para suas redes sociais, o campo sobre mim e sua foto caso queira colocá-los.
    </p>

    <p>O sistema não <b>coleta nenhum tipo de informação sobre você</b>, além é claro das que você explicitamente conceder.</p>

    <p>
        As pontuações de inteligência, sabedoria, destreza, força e cultura são arbitrárias, baseadas nas notas
        de certas disciplinas. Elas não refletem de forma alguma a realidade.
    </p>

    <p>Podemos pedir para concordar com termos adicionais futuros relativos a possíveis novos serviços.</p>

    <p>Em caso de dúvidas, mande um e-mail para gamificacaoufjf@gmail.com</p>

    <hr>

    <p>Esse texto pode ser acessado a qualquer momento pelo menu de navegação</p>

    <p>Caso esteja de acordo, clique em "Aceitar" e você será redirecionado para a página de cadastro.</p>

    <a href="{path_for name="informacoesPessoais"}" class="btn btn-success">Aceitar</a>
{/block}