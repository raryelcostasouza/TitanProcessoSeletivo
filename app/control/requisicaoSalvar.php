<?php
//processa requisão do clique no botão Salvar
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") 
{
    App::init($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME);
    
    //se $idprod estiver setado, trata-se de produto já cadastrado
    if ($idprod != "")
    {
        $status = App::atualizaProduto($idprod, $nome, $cor, $preco);
    }
    //caso de produto não cadastrado
    else
    {
        $status = App::salvarProduto($nome, $cor, $preco);
    }

    if ($status)
    {
        echo " Dados cadastrados/salvos com sucesso!";
        $idprod = null;
        $nome = null;
        $cor = null;
        $preco = null;
    }
    else 
    {
        echo " Erro ao cadastrar/atualizar produto!";
    }
}
?>