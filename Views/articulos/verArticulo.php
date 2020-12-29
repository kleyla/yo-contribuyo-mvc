<?php headerPublic($data); ?>

<div class="container-md my-2 py-4">
    <div class="row">
        <h2 class="text-center "><?= $data['articulo']['titulo'] ?></h2>
    </div>
    <div class="row mt-4">
        <div class=" col-lg-2 col-md-3 col-sm-4 ">
            <div class="card shadow">
                <div class="card-body my-2 d-flex flex-column justify-content-center align-items-center">
                    <img src="<?= media(); ?>images/uploads/usuario.svg" class="rounded-circle avatar-big" alt="...">
                    <p class="text-muted mt-2"><?= $data['articulo']['nick'] ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <p>
                <?= $data['articulo']['contenido'] ?>
            </p>
        </div>
    </div>
    <div class="row mt-5">
        <h4>Comentarios:</h4>
    </div>
    <div class="row">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-1 d-flex flex-column justify-content-center align-items-center">
                        <img src="<?= media(); ?>images/uploads/usuario.svg" class="rounded-circle avatar" alt="...">
                    </div>
                    <div class="col">
                        <p class="text-muted my-0"><?= $data['articulo']['nick'] ?></p>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta iusto, veniam dolor veritatis cumque perspiciatis distinctio! Asperiores natus vero dolorem facere perferendis tenetur quaerat quae error necessitatibus, laborum, ipsam voluptates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="py-4">
        <p class="text-center">&copy; Karen Rodriguez</p>
    </div>
</footer>
<?php footerPublic($data); ?>