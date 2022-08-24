
<?php
//processa requisão do clique no botão Alterar
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $idprod != "") 
{
    App::init($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME);
    $produto = App::carregaProduto($idprod);
    
    if ($produto)
    {
        $idprod = $produto->idprod;
        $nome = $produto->nome;
        $cor = $produto->cor;
        $preco = $produto->preco;
    }
    else 
    {
        echo "Erro ao carregar dados de produto";
    }
}
?>