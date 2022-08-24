# Instruções

1) Editar o arquivo app/config.php com as configurações do DB
2) Logar no MySQL
    $ mysql -u root -p
3) CREATE DATABASE raryel_titan;
4) Importar o arquivo db.sql
$ mysql -u root -p raryel_titan < db.sql

5) Verificar se a extensão php-intl está ativada (necessário para a função de formatar a moeda em formato nacional)
    * Abrir o /etc/php.ini 
    * Procurar por ";extension=intl"
    * Remover o ";" deixando "extension=intl"
    * Instalar o pacote apt-install php-intl
5) Inicializar o servidor PHP na pasta do projeto
    $ php -S localhost:8000 -t ./

6) Abrir o navegador em localhost:8000
