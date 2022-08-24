<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Estoque - Titan</title>
    </head>
    <body>
        <form action="?act=save" method="POST" name="form1" >
          <h1>Estoque Titan</h1>
          <hr>
          <input type="hidden" name="idprod" <?php
            // Preenche o id no campo id com um valor "value"
            if (isset($idprod) && $idprod != null || $idprod != "") {
                echo "value=\"{$idprod}\"";
            }
            ?> />
          Nome:
          <input type="text" name="nome" <?php
            // Preenche o nome no campo nome com um valor "value"
            if (isset($nome) && $nome != null || $nome != ""){
                echo "value=\"{$nome}\"";
            }
            ?> />
          Cor:
          <input type="text" name="cor" <?php
            // Preenche o nome no campo nome com um valor "value"
            if (isset($cor) && $cor != null || $cor != ""){
                echo "value=\"{$cor}\"". "readonly=\"readonly\"";
            }
            ?> />
          Preço:
         <input type="text" name="preco" <?php
            // Preenche o nome no campo nome com um valor "value"
            if (isset($preco) && $preco != null || $preco != ""){
                echo "value=\"{$preco}\"";
            }
            ?> />
         <input type="submit" value="salvar" />
         <input type="reset" value="Novo" />
         <hr>
       </form>
       <table border="1" width="100%">
        <tr>
            <th>Nome</th>
            <th>Cor</th>
            <th>Preço</th>
            <th>Ações</th>

        </tr>


<?php
include "app/view/viewConteudoTabelaProdutos.php";
?>