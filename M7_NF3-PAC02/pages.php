<?php
@require('connect.php');

//Error's quote
$error = 'Error de Connexión número (' . $bbdd->connect_errno . ') ' . $bbdd->connect_error;

//Declarar variables
$registros = 0;
$pagina = 0;

function numberpages($bbdd, $pagina, $buskr, $registro, $error){

    $query = "SELECT count(*) FROM movie WHERE movie_name LIKE '%$buskr%'";
    $result = @$bbdd->query($query) or die ($error);

    while( $row = $result->fetch_assoc()):
       $totalRegistros = $row["count(*)"]; 
    endwhile;

    $paginas = $totalRegistros/$registro;

    echo $paginas;
    ?>
    <tr>
    <td colspan="2" align="center">
		 <strong>Total registros:</strong>
         <?php echo $totalRegistros;?>
    </td>
    <td colspan="2" align="center">
        <strong>Página actual:</strong>
        <?php echo $pagina;?>
    </tr>
    <tr bgcolor="f3f4f1">
        <td colspan="4" align="right">
            <strong>Páginas:</strong>
            <?php
            for($i=1; $i<$paginas+1; $i++) {
                //Imprimo las paginas
                if($i == $pagina)
                    echo "<font color=red>$i </font>";
                //A la pagina actual no le pongo link
                else
                    echo "<a href=\"?pagina=".$i.
                "&searchs=".$buskr."\" style=color:#000;> ".$i."</a>";
            }
            ?>
        </td>
    </tr>
    <?php
}

function pages($bbdd, $pagina, $buskr, $registro, $error){
    $query = "SELECT * FROM movie WHERE movie_name LIKE '%$buskr%' LIMIT ".($pagina-1)*$registro.",$registro";
    //echo $query;

    $result = @$bbdd->query($query) or die ($error);

    // echo '<pre>';
    // var_dump($result);
    // echo '</pre>';

    if($result->num_rows == 0):
        ?>
        <h2>¡Esta tabla no tiene contenido...!</h2>
        <?php
        @$bbdd->close;
        exit;
    else:
        ?>
        <h2>Estás en la página <?php echo $pagina ?></h2>
         <table>
             <thead>
                 <th>Photo</th>
                 <th>Name</th>
                 <th>Year</th>
             </thead>
             <tbody>
         <?php
         while( $row = $result->fetch_assoc()):

            // echo '<pre>';
            // var_dump($row);
            // echo '</pre>';

            ?>
            <tr>
                <td><img title='<?php echo $row["movie_name"]?>' alt='<?php echo $row["movie_name"]?>' src='fotos/<?php echo $row["movie_id"]?>' width=70 height=70></td>
                <td><?php echo $row["movie_name"]?></td>
                <td><?php echo $row["movie_year"]?></td>
            </tr>
            <?php
         endwhile;
         ?>
             </tbody>
         </table>
         <?php
         numberpages($bbdd, $pagina, $buskr, $registro, $error);
         @$bbdd->close;
         exit;
    endif;

}

function searchs(){

    if(isset($_GET['searchs'])):
        $buskr=$_GET['searchs'];
    else:
        $buskr=' ';
    endif;

    return $buskr;
}

if(isset($_GET['pagina'])):
$registro= 2;
$pagina = $_GET['pagina'];
  $buskr = searchs();

    pages($bbdd, $pagina, $buskr, $registro, $error);

else:
$registro= 4;
$pagina = 1;
  $buskr = searchs();
  //var_dump($buskr);

  pages($bbdd, $pagina, $buskr, $registro, $error);

endif;

?>


