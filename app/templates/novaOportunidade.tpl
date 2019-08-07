{extends 'layout.tpl'}
{block name=content}
    <div class="nova-oportunidade">
        <h4 align="center">Cadastrar Oportunidade</h4>

        {if isset($error)}
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {$error}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}
        {if isset($success)}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Oportunidade cadastrada com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        {/if}

        <form method="POST" action="{base_url}/admin/criar-oportunidade">
            <div class="form-row">
                <div class="col-6">
                    <label for="tipo_oportunidade">Escolha o tipo:</label>
                    <select class="form-control" name="tipo_oportunidade">
                        <option value="0">Iniciacao Cientifica</option>
                        <option value="1">Treinamento Profissional</option>
                        <option value="2">Estágio</option>
                    </select>
                </div>

                <div style="margin-left: 10%;" class="col-3">
                    <label for="numero_vagas">Quantidade de vagas:</label>
                    <input type="number" class="form-control" name="numero_vagas">
                </div>
            </div>

            <div class="form-row">
                <label for="nome_professor">Nome do Professor que está oferecendo:</label>
                <input class="form-control" type="text" name="nome_professor">
            </div>

            <label style="margin-top: 5%" for="remuneracao">Remuneração:</label for="remuneracao">
            <div class="form-row" style="margin-top: 0">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="tem_remuneracao" value="voluntario" type="radio">
                    <label for="tem_remuneracao" class="form-check-label">Voluntário</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" name="tem_remuneracao" value="remunerado" type="radio">
                    <label for="tem_remuneracao" class="form-check-label">Escolher Valor:</label>
                </div>
                <input type="number" class="form-control col-4" name="valor_remuneracao">
            </div>


            <label style="margin-top: 5%" for="requisitos">Pré-Requisitos:</label>
            <br>
            <a class="btn btn-success add-requisito" style="color: white;">Adicionar</a>

            <div class="novos-requisitos"></div>

            <div class="form-row">
                <label for="descricao">Descrição da Oportunidade</label>
                <textarea class="form-control" name="descricao"  cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 5%;">Cadastrar Oportunidade</button>
        </form>
    </div>

{/block}

{block name="javascript"}
    <script>
        console.log("TESTE");
    </script>

{/block}