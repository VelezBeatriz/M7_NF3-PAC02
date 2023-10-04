<?php
//Definir constantes de utilidad
define( 'ADMIN_USER', 'root');
define( 'ADMIN_PASSWORD', 'root');
define( 'SITE_DDBB', 'localhost');
define( 'DATABASE_NAME', 'moviesite');


//Conexión
$bbdd = @new mysqli(SITE_DDBB, ADMIN_USER, ADMIN_PASSWORD, DATABASE_NAME);

    if($bbdd->connect_errno){
        die('Error de Connexión número ' . $bbdd->connect_errno . ', ' . $bbdd->connect_error);
    } else {
       echo 'Connexión establecida...';
    }


/*
Comandos chulis que he utilizado: 
 - show table status;
 - show create table people;
 - select constraint_name, table_name, column_name from information_schema.key_column_usage where constraint_schema = 'database_name';
*/
?>
