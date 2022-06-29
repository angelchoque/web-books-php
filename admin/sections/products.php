<!-- crear un crud para administrar libros, crear, eliminar, etc -->
<?php include("../template/header.php");?>
<?php 
    // print_r($_POST);
    // print_r($_FILES);
    // isset ve si hay algo o no
    $txtID=(isset($_POST["txt-id"]))?$_POST["txt-id"]:"";
    $txtName=(isset($_POST["txt-name"]))?$_POST["txt-name"]:"";

    $txtImage=(isset($_FILES["file-form"]["name"]))?$_FILES["file-form"]["name"]:"";
    $action=(isset($_POST["action"]))?$_POST["action"]:"";

    include("../config/db.php");
  
    switch($action){
        case "Add":
            // echo "boton agregar";
            // INSERT INTO `libros` (`id`, `name`, `image`) VALUES (NULL, 'Libro de PHP', 'imagen.jpg');
            // id null para poner autoincremental
            $sentenciaSQL = $conection->prepare("INSERT INTO `libros` (name, image) VALUES (:name, :image);");
            $sentenciaSQL->bindParam(":name", $txtName);

            $fecha = new DateTime();
            $nameFile = ($txtImage != "") ? $fecha->getTimesTamp()."_".$_FILES["file-form"]["name"] : "undefined.jpg";

            $tmpImage = $_FILES["file-form"]["tmp_name"];
            if($tmpImage != ""){
                move_uploaded_file($tmpImage, "../../assets/".$nameFile);
            }

            $sentenciaSQL->bindParam(":image", $nameFile);
            $sentenciaSQL->execute();

            header("Location:products.php");
            break;
        case "Change":
            // echo "boton Change";
            $sentenciaSQL = $conection->prepare("UPDATE libros SET name=:name WHERE id=:id");
            $sentenciaSQL->bindParam(":name", $txtName);

            $sentenciaSQL->bindParam(":id", $txtID);
            $sentenciaSQL->execute();
            
            if($txtImage != ""){

                $fecha = new DateTime();
                $nameFile = ($txtImage != "") ? $fecha->getTimesTamp()."_".$_FILES["file-form"]["name"] : "undefined.jpg";
    
                $tmpImage = $_FILES["file-form"]["tmp_name"];

                move_uploaded_file($tmpImage, "../../assets/".$nameFile);

                // Buscamos la imagen encontrada para borrar la antigua
                $sentenciaSQL = $conection->prepare("SELECT image FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(":id", $txtID);
                $sentenciaSQL->execute();
                $Libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
                if (isset($Libro["image"]) && ($Libro["image"] != "undefined.jpg")){
                    if (file_exists("../../assets/".$Libro["image"])){
                        unlink("../../assets/".$Libro["image"]);
                    }
                }

                // una vez hayamnos subido y borrado, actualizamos con la imagen nueva
                $sentenciaSQL = $conection->prepare("UPDATE libros SET image=:image WHERE id=:id");
                // $sentenciaSQL->bindParam(":image", $txtImage);
                $sentenciaSQL->bindParam(":image", $nameFile);
                $sentenciaSQL->bindParam(":id", $txtID);
                $sentenciaSQL->execute();
            }

            header("Location:products.php");
            break;
        case "Cancel":
            // echo "boton Cancel";
            header("Location:products.php");
            break;
        case "select":
            // 2:15:56
            // echo "select";
            $sentenciaSQL = $conection->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(":id", $txtID);
            $sentenciaSQL->execute();
            $Libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);
            
            $txtName = $Libro['name'];
            $txtImage = $Libro['image'];
            break;
        case "delete":
            // echo "eliminar";
            $sentenciaSQL = $conection->prepare("SELECT image FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(":id", $txtID);
            $sentenciaSQL->execute();
            $Libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($Libro["image"]) && ($Libro["image"] != "undefined.jpg")){
                if (file_exists("../../assets/".$Libro["image"])){
                    unlink("../../assets/".$Libro["image"]);
                }
            }

            $sentenciaSQL = $conection->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(":id", $txtID);
            $sentenciaSQL->execute();
            header("Location:products.php");
            break;
    }

    // ejecutando una instruccion de sql de seleccion
    $sentenciaSQL = $conection->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Books Data
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class = "form-group">
                        <label for="txt-id">ID:</label>
                        <input type="text" Required readonly class="form-control disabled" value="<?php echo $txtID; ?>" name="txt-id" id="txt-id" aria-describedby="txt-id" placeholder="Enter ID">
                        <small id="id-help" class="form-text text-muted">Input ID.</small>
                    </div>
                    <div class = "form-group">
                        <label for="txt-name">Name:</label>
                        <input type="text" class="form-control" value="<?php echo $txtName; ?>" name="txt-name" id="txt-name" aria-describedby="txt-name" placeholder="Enter Name" Required>
                    </div>
                    <div class = "form-group">
                        <label for="file-form">Image:</label>
                        <br>
                        <!-- <?php echo $txtImage; ?> -->

                        <?php 
                            if($txtImage != "") {
                        ?>
                            <img class="img-thumbnail rounded" src="../../assets/<?php echo $txtImage;?>" width="120" alt="" />
                        <?php } ?>
                        <input type="file" class="form-control" name="file-form" id="file-form" aria-describedby="file-form" placeholder="Enter ID">
                    </div>
                    <div class="btn-group" role="group" aria-label="">
                        <button type="submit" name="action" <?php echo ($action=="select")? "disabled" : "" ?> value="Add" class="btn btn-success">Add</button>
                        <button type="submit" name="action" <?php echo ($action!="select")? "disabled" : "" ?> value="Change" class="btn btn-warning">Change</button>
                        <button type="submit" name="action" <?php echo ($action!="select")? "disabled" : "" ?> value="Cancel" class="btn btn-info">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- template -->
                <?php foreach($listLibros as $libro) { ?>
                <tr>
                    <td> <?php echo $libro['id']; ?> </td>
                    <td> <?php echo $libro['name']; ?> </td>
                    <td> 
                        <img src="../../assets/<?php echo $libro['image']; ?>" width="50" alt="" />
                        <!-- <?php echo $libro['image']; ?> -->
                    </td>

                    <td>
                        <form method="post">
                            <input type="hidden" name="txt-id" id="txtId" value="<?php echo $libro['id']; ?>" />
                            <input type="submit" name="action" value="select" class="btn btn-primary">
                            <input type="submit" name="action" value="delete" class="btn btn-danger" />
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include("../template/footer.php");?>