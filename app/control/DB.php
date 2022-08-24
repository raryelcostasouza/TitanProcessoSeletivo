<?php

class DB
{
    private $DB_HOST;
    private $DB_USER;
    private $DB_PWD;
    private $DB_NAME;
    private $PDO;

    public function __construct($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME)
    {
        $this->DB_HOST = $DB_HOST;
        $this->DB_USER = $DB_USER;
        $this->DB_PWD = $DB_PWD;
        $this->DB_NAME = $DB_NAME;
    }

    public function connect()
    {
        try
        {
            $this->PDO = new PDO("mysql:host=".$this->DB_HOST.";dbname=".$this->DB_NAME, $this->DB_USER, $this->DB_PWD);
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex)
        {
            die("Não consegue conectar ao MySQL: " . $ex->getMessage());
        }      
        
    }

    //fecha a conexão com o DB
    public function close()
    {
        try 
        {
            if (isset($this->PDO))
            {
                $this->PDO = null;
            }
        } 
        catch (PDOException $ex)
        {
            die("Erro MySQL: " . $ex->getMessage());
        }             
    }

    //executa as querys com os parâmetros passados
    public function query($sql, $arrayParameters)
    {
        try 
        {
            $stmt = $this->PDO->prepare($sql);
            
            //adiciona os parametros na query
            if ($arrayParameters != null)
            {
                $i = 1;
                //necessário passar parâmetro por referência no loop (&) para funcionar
                foreach ($arrayParameters as &$parameter)
                {
                    $stmt->bindParam($i, $parameter);
                    $i++;
                }
            }           
            
            if ($stmt->execute()) 
            {
                return $stmt;
            } 
            else 
            {
                throw new PDOException("Erro: Não foi possível executar a query SQL! ");
            }
        } 
        catch (PDOException $erro) 
        {
            echo "Erro: " . $erro->getMessage();
            return null;
        } 
    }
    
    //ultimo ID inserido no BD
    public function lastInsertID()
    {
        try
        {
            return $this->PDO->lastInsertID();
        }
        catch(PDOException $ex)
        {
            echo "Erro: " . $ex->getMessage();
            return null;
        }   
    }
}

?>