{extends 'layout.tpl'}
{block name=content}
    <h3 class="text-center">Grades</h3>
    <h4>Grades {print_r($usuariosFull, true)}</h4>
    <ul>
        {foreach $gradesFull as $grade}
            <li>{$grade->getCodigo()}</li>
            <ul>
                {foreach $grade->getDisciplinas_grade() as $discpl}
                    <li>{$discpl->getDisciplina()->getCodigo()} - Período: {$discpl->getPeriodo()}</li>
                {/foreach}
            </ul>
        {/foreach}
    </ul>
{/block}