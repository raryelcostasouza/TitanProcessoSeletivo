<?php

App::init($DB_HOST, $DB_USER, $DB_PWD, $DB_NAME);

//obtem todos os produtos cadastrados do banco
$arrayProdutos = App::carregarProdutos();

//formata o valor monetário no padrão brasileiro
$fmt =  new NumberFormatter('pt_BR', NumberFormatter::CURRENCY );
foreach($arrayProdutos as $produto)
{
    echo "<tr>";
    echo "<td>".$produto->nome."</td><td>".$produto->cor."</td><td>". $fmt->formatCurrency($produto->preco, "BRL")
                ."</td><td><center><a href=\"?act=upd&idprod=" . $produto->idprod . "\">[Alterar]</a>"
                ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                ."<a href=\"?act=del&idprod=" . $produto->idprod . "\">[Excluir]</a></center></td>";
    echo "</tr>";
}

?>

        </table>
    </body>
</html>