{extends 'layout.tpl'}
{block name=content}

    <h3 class="text-center">Página do Administrador</h3>
    <hr>

    <input id="countNaoLogaram" type="hidden" value={$countNaoLogaram}>
    <input id="countLogaram" type="hidden" value={$countLogaram}>

    <div align="center"  id="piechart"></div>
    <hr>
    <div align="center"  id="piechart-3d"></div>

{/block}