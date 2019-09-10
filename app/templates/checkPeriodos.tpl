{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Grades</h3>
    <ul>
        {foreach $usuariosFull as $usuario}
            <li>{$usuario->getMatricula()} - {$usuario->getNome()}</li>
            <ul>
                {foreach $usuario->getNotas() as $nota}
                    <li>{$nota->getDisciplina()->getCodigo()}({$nota->getEstado()} - {$nota->getPeriodo()}) -> {$nota->getValor()} </li>
                {/foreach}
            </ul>
        {/foreach}
        {foreach $disciplinas as $disciplina}
            <li>{$disciplina->getCodigo()}</li>
        {/foreach}
    </ul>
{/block}