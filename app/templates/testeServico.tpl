{extends 'layout.tpl'}
{block name=content}
    <h2 class="text-center"> Teste Serviço </h2>

    <p align="center"> Aperte confirmar pra testar o serviço  </p>

    <form method="POST" action="{base_url}/admin/store-teste-servico">  
        <nav aria-label="navigation" class="pagination justify-content-center">
            <button style="margin-top: 2%; width: 300px; height: 45px" class="btn btn-outline-dark" type="submit">Confirmar</button>  
        </nav>
    </form>

{/block}