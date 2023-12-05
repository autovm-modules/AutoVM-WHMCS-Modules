<?php  include('routeconfig.php');   ?>
<?php  include_once('./includes/commodules/header.php');   ?>

<body class="container-fluid p-1 p-md-3" style="background-color: #ff000000 !important;" > 
    <div id="createapp" class="row px-1 px-md-4 px-lg-5 py-5 mx-auto" style="max-width: 1350px; padding-bottom: 200px !important;">
        <div class="" v-cloak>
            <?php  include_once('./includes/createparts/modalcreate.php');  ?>
            <?php  include_once('./includes/commodules/backflash.php');     ?>
            <div class="col-12 bg-white rounded-4 border border-2 border-body-secondary m-0 p-0 mt-5">
                <div class="py-5 px-4 px-md-5">
                    <!-- lang BTN     -->
                    <div class="row float-end d-none d-md-block">
                        <div class="col-auto btn bg-primary text-dark m-0 p-0" style="--bs-bg-opacity: 0.2">
                            <?php  include_once('./includes/commodules/langbtn.php'); ?>
                        </div>
                    </div>
                    <?php  include_once('./includes/createparts/hostname.php');     ?>
                    <?php  include_once('./includes/createparts/datacenter.php');   ?>
                    <?php  include_once('./includes/createparts/setos.php');        ?>
                    <?php  include_once('./includes/createparts/sshkey.php');       ?>
                    <?php  include_once('./includes/createparts/totalcost.php');    ?>
                </div>
            </div>
        </div>
    </div>
<?php       include_once('./includes/commodules/footer.php');               ?>