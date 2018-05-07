{extends 'layout.tpl'}
{block name=content}
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="text-center">
                    <img src="{base_url}/img/silhueta.jpg" class="img-thumbnail" alt="{$loggedUser->getNome()}" width="190" height="190">
                    {$loggedUser->getNome()}
                </div>
            </div>
            <div class="col-9">
                <h4 class="text-center">Estatíticas</h4>
                <p class="mb-0 mt-3"><b>Experiência:</b> {$usuario->getExperiencia()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getExperiencia())/($usuario->getExperiencia() +500 ) }%;">{((100 * $usuario->getExperiencia())/($usuario->getExperiencia() +500 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Inteligência:</b> {$usuario->getInteligencia()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getInteligencia())/($usuario->getInteligencia() +200 ) }%;">{((100 * $usuario->getInteligencia())/($usuario->getInteligencia() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Sabedoria:</b> {$usuario->getSabedoria()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getSabedoria())/($usuario->getSabedoria() +200 ) }%;">{((100 * $usuario->getSabedoria())/($usuario->getSabedoria() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Destreza:</b> {$usuario->getDestreza()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getDestreza())/($usuario->getDestreza() +200 ) }%;">{((100 * $usuario->getDestreza())/($usuario->getDestreza() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Força:</b> {$usuario->getForca()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getForca())/($usuario->getForca() +200 ) }%;">{((100 * $usuario->getForca())/($usuario->getForca() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Carisma:</b> {$usuario->getCarisma()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getCarisma())/($usuario->getCarisma() +200 ) }%;">{((100 * $usuario->getCarisma())/($usuario->getCarisma() +200 ))|string_format:"%.2f"}%</div>
                </div>
                <p class="mb-0 mt-3"><b>Cultura:</b> {$usuario->getCultura()}</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar" role="progressbar" style="width: {(100 * $usuario->getCultura())/($usuario->getCultura() +50 ) }%;">{((100 * $usuario->getCultura())/($usuario->getCultura() + 50 ))|string_format:"%.2f"}%</div>
                </div>

                <h4 class="text-center mt-3">Notas dos usuários</h4>
                <ul>
                    {foreach $usuario->getNotas() as $nota}
                        <li>{$nota->getDisciplina()->getCodigo()}({$nota->getEstado()}) -> {$nota->getValor()} </li>
                    {/foreach}
                </ul>
            </div>

        </div>
    </div>
{/block}