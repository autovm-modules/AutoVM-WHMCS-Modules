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
            
            <div class="mt-4 p-2 bg-warning rounded-4 text-dark h6 px-4">
                <div class="accordion-item">
                    <div class="accordion-" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Hard Delete, It will delete everything related to AutoVM <i class="bi bi-arrow-down-circle-fill ms-4"></i>
                    </div>
                    <div id="collapseOne" class="accordion-collapse collapse mt-4" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <button v-if="!HardDeleteVisible" class="col-12 btn btn-danger px-3 mx-2" @click="ChangeShowHardDelete">Hard Delete</button>
                            <button v-if="HardDeleteVisible" class="btn btn-secondary px-5 me-4" @click="ChangeShowHardDelete"><i class="bi bi-arrow-left-circle-fill pe-3"></i> Back</button>
                            <button v-if="HardDeleteVisible" class="btn btn-danger px-5 me-4" @click="ChangeShowHardDelete">I am Sure</button>
                        </div>
                    </div>
                </div>
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