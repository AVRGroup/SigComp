  
{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Questões </h2>
    <hr>
    <form method="POST" action="{base_url}/storeQuestao">    <!-- Formulario para adicionar questao -->
        <div align="center">
            <p>Inserir nova questão</p>
            <div>
                <input type="text" name="novaQuestao" id="novaQuestao" placeholder="digite a questão" />
            </div>
            <div>
                <input type="number" name="numeroQuestao" id="numeroQuestao" min="0" placeholder="digite o número"  />
            </div>
            <div class="button">
                <button type="submit">Enviar</button>
            </div>
        </div>
    </form>

    <div>
        {foreach $questoes as $questao}
            <p style=" font-size: 20px"> {$questao->getNumero()}- {$questao->getEnunciado()}</p>
        {/foreach}
    </div>

{/block}