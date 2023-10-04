<?php
@require('connect.php');

//Error's quote
$error = 'Error de Connexión número (' . $bbdd->connect_errno . ') ' . $bbdd->connect_error;

function executeQuery($bbdd,$query, $error){

    $data = @$bbdd->query($query) or die ($error);

}

//Query add constraint
$query_constraint = 'ALTER TABLE movie ADD CONSTRAINT FK_movie_leadactor FOREIGN KEY (movie_leadactor) REFERENCES people(people_id)';


//Query add data
$query_add_director = 'INSERT INTO people (people_fullname, people_isactor, people_isdirector) VALUES
("Vincent D\'Onofrio", 0, 1), ("Dan Mazeau", 0, 1), ("Zendaya", 1, 0)';
$query_add_movietype = 'INSERT INTO movietype (movietype_label) VALUES 
("Wester"), ("Fantasy"),("Distopian")';
$query_add_movie = 'INSERT INTO movie (movie_name, movie_type, movie_year, movie_leadactor, movie_director) VALUES
("The Kid", 9, 2019, 1, 7), ("Damsel", 10, 2024, 4, 8), ("Dune", 11, 2021, 9, 6)';

//Query consultas unidas
$query_join = 'SELECT movie.movie_name AS Film, director.people_fullname AS Director, actor.people_fullname AS Actor FROM movie
                LEFT JOIN people director ON movie.movie_director = director.people_id 
                LEFT JOIN people actor ON movie.movie_leadactor = actor.people_id';




//Add constraint
executeQuery($bbdd, $query_constraint, $error);
echo "</br>¡Clave ajena creada con éxito!";

//Add data
executeQuery($bbdd, $query_add_director, $error);
echo "</br>¡Se han añadido 3 nuevos directores y actores!";

executeQuery($bbdd, $query_add_movietype, $error);
echo "</br>¡Se han añadido 3 nuevos tipos de géneros!";

executeQuery($bbdd, $query_add_movie, $error);
echo "</br>¡Se han añadido 3 nuevas peliculas!";


//Extract data
$data = @$bbdd->query($query_join) or die ($error);

// echo '<pre>';
// var_dump($data);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies & More</title>
    <style>
        table,th,td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <?php
        if($data->num_rows == 0):
            ?>
            <h2>¡Esta tabla no tiene contenido...!</h2>
            <?php
            @$bbdd->close;
            exit;
        else:
            ?>
            <h1>Las mejores películas según los expertos</h1>
            <table>
                <thead>
                    <th>Film</th>
                    <th>Director</th>
                    <th>Actor</th>
                </thead>
                <tbody>
            <?php
            $data->data_seek(0);
            while( $row = $data->fetch_assoc()):
                ?>
                <tr>
                <?php
                foreach($row as $index=>$value):
                    ?>
                    <td>
                    <?php
                    echo $value;
                    ?>
                    </td>
                    <?php
                endforeach;
                ?>
                </tr>
                <?php
            endwhile;
            ?>
                </tbody>
            </table>
            <?php
            @$bbdd->close;
            exit;
        endif;    
    ?>
</body>
</html>
