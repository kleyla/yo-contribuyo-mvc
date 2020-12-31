<script>
    const base_url = "<?= base_url(); ?>";
</script>
<!-- Essential javascripts for application to work-->
<script src="<?= media(); ?>js/jquery-3.3.1.min.js"></script>
<script src="<?= media(); ?>js/popper.min.js"></script>
<script src="<?= media(); ?>js/bootstrap.min.js"></script>
<script src="<?= media(); ?>js/main.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="<?= media(); ?>js/plugins/pace.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>js/plugins/sweetalert.min.js"></script>

<!-- Data table plugin-->
<script type="text/javascript" src="<?= media(); ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>js/plugins/dataTables.bootstrap.min.js"></script>
<?php if ($data['script']) { ?>
    <script src="<?= media(); ?><?= $data['script']; ?> "></script>
<?php } ?>

</body>

</html>