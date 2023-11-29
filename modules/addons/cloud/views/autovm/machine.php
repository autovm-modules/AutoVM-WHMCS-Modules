<?php  include_once('./includes/commodules/header.php');   ?>

<body>
<!-- main container -->
<div class="machineapp container-fluid p-4 my-5" style="max-width: 1350px; padding-bottom: 200px !important;" v-cloak>
    <?php  include_once('./includes/commodules/backflash.php');     ?>
    <div class="row bg-white border border-1 border-secondar rounded-4 py-5 my-5 px-2 px-md-4 px-lg-5">
        <?php  include_once('./includes/machineparts/modalaction.php');      ?>
        <?php  include_once('./includes/machineparts/modalconsole.php');     ?>
        <?php  include_once('./includes/machineparts/modalprocessing.php');  ?>
        <?php  include_once('./includes/machineparts/modalsetup.php');       ?>
        <?php  include_once('./includes/machineparts/modaldestroy.php');     ?>
        <?php  include_once('./includes/machineparts/hoststatus.php');       ?>
        <?php  include_once('./includes/machineparts/machinedetails.php');   ?>
        <?php  include_once('./includes/machineparts/login.php');            ?>
        <?php  include_once('./includes/machineparts/circlures.php');        ?>
        <?php  include_once('./includes/machineparts/access.php');           ?>
    </div>
</div>
<?php  include_once('./includes/commodules/footer.php');           ?>