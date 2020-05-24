{extends 'layout.tpl'}
{block name=content}

    <h3 class="text-center">Página do Administrador</h3>
    {if $loggedUser->isAdmin()}
        <br>
        <div class="form-row">
            <select class="form-control col-6" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                <option value="">Selecione o Curso</option>
                <option value="{base_url}/admin/admin-dashboard?curso=35A">Ciência da Computação Noturno</option>
                <option value="{base_url}/admin/admin-dashboard?curso=65C">Ciência da Computação Integral</option>
                <option value="{base_url}/admin/admin-dashboard?curso=76A">Sistemas de Informação</option>
                <option value="{base_url}/admin/admin-dashboard?curso=65B">Engenharia Computacional</option>
            </select>
        </div>
        <hr>
    {/if}
    <input id="countNaoLogaram" type="hidden" value={$countNaoLogaram}>
    <input id="countLogaram" type="hidden" value={$countLogaram}>

    <div align="center"  id="piechart"></div>
    <a href="{path_for name="alunosLogaram"}">Lista de alunos que Acessaram ao menos uma vez</a>
    <br>
    Periodo Atual: {$periodoAtual} | Periodo Passado: {$periodoPassado}

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
                        <td><a href="{path_for name="adminUser" data=["id" => $user->getId()]}">{$user->getNomeAbreviado()}</td>
                        <td>{$user->getIra()|string_format:"%.2f"}</td>
                    </tr>
                {/foreach}
            </table>
        </div>
        <div class="col-6" style="margin-top: 1.8%">
            <div class="row">
                <div class="col-10">
                    <h4 class="text-center">Melhor IRA em {substr_replace($periodoPassado, '.', 4, 0)}</h4>
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
                        <td><a href="{path_for name="adminUser" data=["id" => $user->getId()]}">{$user->getNomeAbreviado()}</a></td>
                        <td>{$user->getIraPeriodoPassado()|string_format:"%.2f"}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>

    <a href="https://analytics.google.com/analytics/web/?authuser=6#/home/a131900774w191543714p187441079/"  class="btn btn-primary analytics">Google Analytics</a>



{/block}