<?php   include_once('autovmupdatefunc.php');    ?>
<?php   include('autovmupdater/header.php');    ?>

<div id="app" class="bg-dark text-light p-5 rounded-5 mt-4">
    <div class="row" v-cloak>
        <div class="col-12 col-md-6">
            <div class="d-felx flex-row justify-content-center align-items-center py-5">
                <span class="h3">
                    AutoVM Module Updater
                </span>
                <span class="btn btn-warning py-0 rounded-5 btn-sm ms-4 px-4 py-1 mb-2">
                    Latest Version:
                    <?php if($RemoteVersion == 0): ?>
                        can't find any
                    <?php else: ?>
                        <?php echo($RemoteVersion); ?>
                    <?php endif ?>
                </span>
            </div>

            <div class="d-felx flex-row justify-content-center align-items-center mt-5 pt-5">
                <p>
                    <?php if($LocalVersion == 0 || $RemoteVersion == 0): ?>
                        <span class="text-warning">
                            Can not find Versions, please install again
                        </span>
                    <?php else: ?>
                        <span>
                            Your Module Version is 
                        </span>
                        <span class="text-warning">
                            <?php echo($LocalVersion); ?>
                        </span>
                        <?php if($LocalVersion == $RemoteVersion): ?>
                            <span class="text-light">
                                and you Module is Update 
                            </span>
                        <?php else: ?>
                            <span class="text-light">
                                and you should update it 
                            </span>
                        <?php endif ?>
                    <?php endif ?>
                </p>
            </div>

            <hr>
            <div class="d-flex flex-row justify-content-start align-items-center">
                <a class="btn btn-primary px-3 mx-2" @click="funcInstall">Install Module</a>
                <a class="btn btn-primary px-3 mx-2" @click="funcUpdate">Update Module</a>
                <a class="btn btn-primary px-3 mx-2" @click="funcFix">Fix Permision</a>
                <a class="btn btn-danger px-3 mx-2" @click="funcDelete">Delete Module</a>
            </div>
        </div>
        <div class="col-12 col-md-6" v-if="ActonResponse">
            <div v-html="ActonResponse" class="bg-body-secondary p-4 rounded-5 border-2 shadow-lg text-secondary small">
            </div>
        </div>
        <div style="height:300px"></div>
            </div>
        </div>
<?php   include('autovmupdater/footer.php');    ?>