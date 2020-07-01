{extends 'layout.tpl'}
{block name=content}   
    <p align="center" style="font-weight: 500; font-size: 30px">Parabéns! Você concluiu todas as avaliações.</p>
    <p align="center" class="font-italic" style="font-weight: 400; font-size: 20px">Continue assim para conquistar novas medalhas!</p>
    <div align="center">
        <div style="max-width: 120px; margin-top: 4%">
            <img src="{base_url}/img/b_avaliacao_{$numImgMedalha}.png" class="img-thumbnail" alt="not found" width="120" height="120">       
            <div class="caption">
                <p style="font-size: 15px; font-weight: 500; margin-top: 3%" class="text-center">{$nomeMedalha}</p>
            </div>
        </div>
    </div>
    <form method="POST" action="{path_for name="home"}">  
        <nav aria-label="navigation" class="pagination justify-content-center">
            <button style="margin-top: 2%; width: 300px; height: 45px" class="btn btn-primary" type="submit">Confirmar</button>  
        </nav>
    </form>
{/block}