{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Admin Test</h3>
    <h4>Notas dos usuários</h4>
    <ul>
        {foreach $usuariosFull as $usuario}
            <li>{$usuario->getMatricula()} - {$usuario->getNome()}</li>
            <ul>
                {foreach $usuario->getNotas() as $nota}
                    <li>{$nota->getDisciplina()->getCodigo()}({$nota->getEstado()}) -> {$nota->getValor()} </li>
                {/foreach}
            </ul>
        {/foreach}
    </ul>
{/block}