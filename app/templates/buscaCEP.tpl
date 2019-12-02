{extends 'layout.tpl'}
{block name=content}
    <hr>
    <div align="center" class="col-6 mx-auto" style="margin-top: 5%">

    <form  method="POST" action="{base_url}/pageBuscaCEP">
      <div class="form-group">
        <label for="idCEP">Digite o CEP</label>
        <input type="text" class="form-control" name="nameCEP" id="idCEP" placeholder="CEP">
      </div>
     
      <button type="submit" class="btn btn-outline-primary">Confirmar</button>
    
    </form>
  </div>

{/block}