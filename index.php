<?php

require "app/config.php";
require "app/app.php";


// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //inicializa as variáveis de produto com os parametros do POST
    $idprod = (isset($_POST["idprod"]) && $_POST["idprod"] != null) ? $_POST["idprod"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $cor = (isset($_POST["cor"]) && $_POST["cor"] != null) ? $_POST["cor"] : "";
    $preco = (isset($_POST["preco"]) && $_POST["preco"] != null) ? $_POST["preco"] : NULL;
} else if (!isset($idprod)) 
{
    //inicializa como Null as variáveis de produto
    $idprod = (isset($_GET["idprod"]) && $_GET["idprod"] != null) ? $_GET["idprod"] : "";
    $nome = NULL;
    $cor = NULL;
    $preco = NULL;
}

include "app/control/requisicaoRemover.php";
include "app/control/requisicaoSalvar.php";
include "app/control/requisicaoAlterar.php";

include "app/view/view.php";
?>