<?php

//processa requisição do clique no botão Excluir
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $idprod != "") 
{
    App::init($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME);
    $status = App::deletaProduto($idprod);
    if ($status)
    {
        echo "Registro foi excluído com êxito";
        $idprod = null;
    }
    else
    {
        echo "Erro ao deletar produto.";
    }
}

?>