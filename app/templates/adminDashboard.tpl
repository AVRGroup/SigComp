{extends 'layout.tpl'}
{block name=content}

    <h3 class="text-center">Página do Administrador</h3>
    <hr>

    <input id="countNaoLogaram" type="hidden" value={$countNaoLogaram}>
    <input id="countLogaram" type="hidden" value={$countLogaram}>

    <div align="center"  id="piechart"></div>
    <hr>

    <div class="row">
        <div class="col-6" style="margin-top: 1.8%">
            <div class="row">
                <h4 class="text-center col-10">Melhor IRA Geral</h4>
            </div>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">IRA</th>
                </tr>
                </thead>
                <tbody>
                {$i = 1}
                {foreach $top10Ira as $user}
                    <tr>
                        <th scope="row">{$i++}</th>
                        <td>{$user->getNomeAbreviado()}</td>
                        <td>{$user->getIra()|string_format:"%.2f"}</td>
                    </tr>
                {/foreach}
            </table>
        </div>
        <div class="col-6" style="margin-top: 1.8%">
            <div class="row">
                <div class="col-10">
                    <h4 class="text-center">Melhor IRA No Período</h4>
                </div>
            </div>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">IRA</th>
                </tr>
                </thead>
                <tbody>
                {$i = 1}
                {foreach $top10IraPeriodoPassado as $user}
                    <tr>
                        <th scope="row">{$i++}</th>
                        <td>{$user->getNomeAbreviado()}</td>
                        <td>{$user->getIraPeriodoPassado()|string_format:"%.2f"}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <a href="https://analytics.google.com/analytics/web/?authuser=6#/home/a131900774w191543714p187441079/"  class="btn btn-primary analytics">Google Analytics</a>

{/block}