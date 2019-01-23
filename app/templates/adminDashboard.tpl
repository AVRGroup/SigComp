{extends 'layout.tpl'}
{block name=content}

    <h3 class="text-center">Página do Administrador</h3>
    <hr>

    <input id="countNaoLogaram" type="hidden" value={$countNaoLogaram}>
    <input id="countLogaram" type="hidden" value={$countLogaram}>

    <div align="center"  id="piechart"></div>
    <hr>

    <a href="https://analytics.google.com/analytics/web/?authuser=6#/home/a131900774w191543714p187441079/"  class="btn btn-primary analytics">Google Analytics</a>

{/block}