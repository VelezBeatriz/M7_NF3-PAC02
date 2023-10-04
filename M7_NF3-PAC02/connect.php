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
*/
//select constraint_name, table_name, column_name from information_schema.key_column_usage where constraint_schema = 'moviesite';
//show table status;
//show create table people;
//select m.movie_name, p.people_id from movie m inner join people p on m.movie_leadactor = p.people_id;

//SELECT m.movie_name, d.people_fullname AS director, a.people_fullname AS lead_actor FROM movie m LEFT JOIN people d oN m.movie_director = d.people_id LEFT JOIN people a ON m.movie_leadactor = a.people_id;

?>