
<?php include("template/header.php"); ?>

<?php 
    include("admin/config/db.php"); 
    $sentenciaSQL = $conection->prepare("SELECT * FROM libros");
    $sentenciaSQL->execute();
    $listLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<?php foreach($listLibros as $book){ ?>
<div class="col-md-3">
    <div class="card">
        <img class="card-img-top h-25" src="./assets/<?php echo $book["image"]; ?>" alt="">
        <div class="card-body">
            <h4 class="card-title"> <?php echo $book["name"]; ?></h4>
            <a name="" id="" class="btn btn-primary" href="#" role="button">Ver mas</a>
        </div>
    </div>
</div>
<?php } ?>

<?php include("template/footer.php"); ?>