<?php

require "control/DB.php";

class App
{
    private static $objDB;

    //inicializa conexão com Banco de Dados
    public static function init($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME)
    {
        App::$objDB = new DB($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME);
        App::$objDB->connect();
    }

    public static function salvarProduto($nome, $cor, $preco)
    {
        if (App::validaPreco($preco))
        {
            if (App::insereProduto($nome, $cor))
            {
                $idprod = App::$objDB->lastInsertID();
                $status = App::inserePreco($preco, $idprod, $cor);
            }
            else
            {
                $status = false;
            }
            //fecha conexão com DB
            App::$objDB->close();
            return $status;
        }     
        echo "Preço Inválido";
        return false; 
    }

    private static function validaPreco($preco)
    {
        //verifica se é númerico
        if (!is_numeric($preco))
        {
            return false;
        }
        return true;
    }

    private static function insereProduto($nome, $cor)
    {
        $param = array($nome, $cor);
        $sql = "INSERT INTO Produtos (nome, cor) VALUES (?, ?)";
        $stmt = App::$objDB->query($sql, $param);
        
        if ($stmt)
        {
            return true;
        }
        return false;
    }

    private static function inserePreco($preco, $idprod, $cor)
    {
        $precoFinal = App::verificaDesconto($cor, $preco);

        $param2 = array($precoFinal, $idprod);
        $sql2 = "INSERT INTO Precos (preco, idprod) VALUES (?, ?)";
        $stmt = App::$objDB->query($sql2, $param2);

        if ($stmt)
        {
            return true;
        }
        return false;
    }

    private static function verificaDesconto($cor, $preco)
    {
        //calcula o desconto de acordo com a cor do produto
        switch(strtoupper($cor))
        {
            case "VERMELHO":
                if ($preco > 50)
                {
                    $precoFinal = $preco * 0.95;
                }
                else
                {
                    $precoFinal = $preco * 0.8;
                }
                break;
            case "AZUL":
                $precoFinal = $preco * 0.8;
                break;
            case "AMARELO":
                $precoFinal = $preco * 0.9;
                break;
            default:
                $precoFinal = $preco;
                break;
        }
        return $precoFinal;
    }

    public static function atualizaProduto($idprod, $nome, $cor, $preco)
    {   
        $produto = App::carregaPrecoAnterior($idprod);
        if (App::validaPreco($preco))
        {
            if (App::atualizaTabelaProduto($idprod, $nome))
            {
                //somente atualiza o preco se estiver diferente do anteriormente cadastrado
                if ($produto->preco != $preco)
                {
                    $status = App::atualizaTabelaPreco($idprod, $cor, $preco);
                }                
            }
            else
            {
                $status = false;
            }

            App::$objDB->close();
            return true;
        }
        return false;        
    }

    private static function atualizaTabelaProduto($idprod, $nome)
    {
        $sql = "UPDATE Produtos SET nome = ? WHERE idprod = ?";
        $param = array($nome, $idprod);

        $stmt = App::$objDB->query($sql, $param);
        if ($stmt != null)
        {
            return true;
        }
        return false;
    }

    private static function atualizaTabelaPreco($idprod, $cor, $precoNovo)
    {
        $precoFinal = App::verificaDesconto($cor, $precoNovo);
        
        $sql = "UPDATE Precos SET preco = ? WHERE idprod = ?";
        $param = array($precoFinal, $idprod);
        $stmt = App::$objDB->query($sql, $param);
        
        if ($stmt != null)
        {
            return true;
        }
        return false;
    }

    public static function deletaProduto($idprod)
    {
        $sql1 = "DELETE FROM Precos WHERE idprod = ?";
        $sql2 = "DELETE FROM Produtos WHERE idprod = ?";
        $param = array($idprod);

        $stmt1 = App::$objDB->query($sql1, $param);
        $stmt2 = App::$objDB->query($sql2, $param);

        App::$objDB->close();
        //se ambas as deleções foram ok
        if ($stmt1 && $stmt2)
        {
            return true;
        }
        return false;
    }
    
    public static function carregarProdutos()
    {
        $sql = "SELECT * FROM Produtos 
                            JOIN Precos ON Produtos.idprod = Precos.idprod";
        $stmt = App::$objDB->query($sql, null);
        $arrayProdutos = $stmt->fetchAll(PDO::FETCH_OBJ);

        App::$objDB->close();        
        return $arrayProdutos;
    }

    //carrega um produto específico pelo id
    public static function carregaProduto($id)
    {
        $sql = "SELECT * FROM Produtos 
                            JOIN Precos on Produtos.idprod = Precos.idprod
                            where Produtos.idprod = ?";
        $params = array($id);
        $stmt = App::$objDB->query($sql, $params);
        $produto = $stmt->fetch(PDO::FETCH_OBJ);

        App::$objDB->close();        
        return $produto;
    }

    //carrega o preço anterior de um produto específico
    public static function carregaPrecoAnterior($id)
    {
        $sql = "SELECT preco FROM Produtos 
                            JOIN Precos on Produtos.idprod = Precos.idprod
                            where Produtos.idprod = ?";
        $params = array($id);
        $stmt = App::$objDB->query($sql, $params);
        return  $stmt->fetch(PDO::FETCH_OBJ);
    }
}

?>