<!-- Finance and Network -->
<div class="row d-flex flex-row align-items-stretch text-start m-0 p-0">

    

    <!-- Network -->
    <div class="col-12 col-md-8 col-lg-6 col-xl-4 m-0 p-0 flex-grow-1 p-0 m-0 mb-3 order-2 order-md-2 order-lg-2 order-xl-2">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 ms-md-1 mx-xl-1 pb-5 h-100">
            <!-- top slice -->
            <div class="m-0 p-0">
                <!-- title -->
                <div class="m-0 p-0 mb-5 d-flex flex-row justify-content-between">
                    <span class="text-dark fw-medium m-0 p-0 fs-5 my-auto">
                        {{ lang('networkinformation') }}
                    </span>
                    <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/servers/product/views/view/assets/img/internet.svg" alt="internet">
                </div>



                <!-- ip -->
                <div v-if="Ipv4Address == null" class="mt-4 fs-4 d-flex flex-row justify-content-between m-0 p-0">
                    <div class="text-start m-0 p-0">
                        <span class="text-secondary fs-6 align-middle m-0 p-0">
                            {{ lang('ipaddress') }}
                        </span>

                        <span v-if="!machineIsLoaded || !address"
                            class="text-primary fw-medium m-0 p-0 ps-4 fs-2 align-middle">
                            ---
                        </span>
                        <span v-if="machineIsLoaded && address && !alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-2 align-middle">
                            {{ address }}
                        </span>
                        <span v-if="machineIsLoaded && alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-3 align-middle">
                            {{ alias }}
                        </span>
                    </div>
                    <div v-show="!AddressCopied"class="m-0 p-0" >
                        <img @click="CopyAddress"
                            src="<?php echo($PersonalRootDirectoryURL); ?>/modules/servers/product/views/view/assets/img/ip.svg" alt="ipaddress">
                    </div>
                    <div v-show="AddressCopied" class="m-0 p-0">
                        <i class="bi bi-check-all text-primary"></i>
                    </div>
                </div>
            </div><!-- end top -->

            <div v-if="Ipv4Address == null" class="py-4">
                <hr class="text-secondary border-2 border-secondary m-0 p-0">
            </div>

            <!-- bottom slice -->
            <div>
                <div class="m-0 p-0 fs-4">
                    <div class="d-flex flex-row align-items-center justify-content-between m-0 p-0">
                        <div class="d-flex flex-row align-items-center justify-content-between m-0 p-0">
                            <?php if($templatelang =='Farsi'): ?>
                                <div style="width:80px">
                            <?php else: ?>
                                <div style="width:40px">
                            <?php endif ?>
                                <span class="text-secondary fs-6 m-0 p-0">
                                    {{ lang('IPV4') }}
                                </span>
                            </div>
                            <div style="width:200px">
                                <span v-if="Ipv4Address != null" class="text-primary fs-6 m-0 p-0 border-0 mx-3" :class="ipv4color">    
                                    {{ Ipv4Address }}
                                </span>
                                <span v-else class="text-primary fs-6  m-0 p-0 mx-1">
                                    ---
                                </span>
                            </div>
                        </div>
                        <div class="m-0 p-0">
                            <a @click="CopyIPV4" class="btn btn-sm btn-outline p-0 m-0 ms-1 p-1" style="font-size: 70%;">
                                <span v-if="!IPV4AddressCopied" class="small">
                                    <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/addons/cloudsnp/views/autovm/includes/assets/img/ip.svg" alt="copy" style="width: 23px;">
                                </span>    
                                <span v-if="IPV4AddressCopied" class="d-flex flex-row justify-content-center align-items-end text-primary">
                                    <i class="bi bi-check-all"></i>
                                    <span class="small">Copied</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end bottom -->
            <!-- bottom slice -->
            <div>
                <div class="m-0 p-0 fs-4">
                    <div class="d-flex flex-row align-items-center justify-content-between m-0 p-0 mb-4">
                        <div class="d-flex flex-row align-items-center justify-content-between m-0 p-0">
                            <?php if($templatelang =='Farsi'): ?>
                                <div style="width:80px">
                            <?php else: ?>
                                <div style="width:40px">
                            <?php endif ?>
                                <span class="text-secondary fs-6 m-0 p-0">
                                    {{ lang('IPV6') }}
                                </span>
                            </div>
                            <div style="width:200px">
                                <span v-if="Ipv6Address != null" class="text-primary fs-6 m-0 p-0 border-0 mx-3" :class="ipv6color">    
                                    {{ Ipv6Address }}
                                </span>
                                <span v-else class="text-primary fs-6  m-0 p-0 mx-1">
                                    ---
                                </span>
                            </div>
                        </div>
                        <div class="m-0 p-0">
                            <a @click="CopyIPV6" class="btn btn-sm btn-outline p-0 m-0 ms-1 p-1" style="font-size: 70%;">
                                <span v-if="!IPV6AddressCopied" class="small">
                                    <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/addons/cloudsnp/views/autovm/includes/assets/img/ip.svg" alt="copy" style="width: 23px;">
                                </span>    
                                <span v-if="IPV6AddressCopied" class="d-flex flex-row justify-content-center align-items-end text-primary">
                                    <i class="bi bi-check-all"></i>
                                    <span class="small">Copied</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end bottom -->
        </div>
    </div><!-- end Network -->

    <!-- Login -->
    <div class="col-12 col-md-4 col-lg-4 col-xl-4 p-0 m-0 mb-3 order-3 order-md-1 order-lg-1 order-xl-3">
        <div class="border border-2 rounded-4 bg-white m-0 p-0 py-4 px-4 mx-0 me-md-1 ms-xl-1 me-xl-0 pb-5 h-100">
            <div class="m-0 p-0 mb-5">
                <span class="text-dark fw-medium m-0 p-0 fs-5 my-auto">
                    {{ lang('login') }}
                </span>
            </div>

            <div class="m-0 p-0 mb-2 mt-4">
                <span class="text-secondary m-0 p-0 fs-6">
                    {{ lang('username') }}
                </span>
            </div>

            <div class="row m-0 p-0">
                <div class="input-group d-flex flex-row justify-content-between align-items-center m-0 p-0">
                    <div v-if="machineIsLoaded" class="input-group-text col-10 rounded m-0 p-0 ps-3" style="height: 45px;">
                        <span v-if="machineUserName" class="text-dark m-0 p-0 fs-6">
                            {{ machineUserName }}
                        </span>
                    </div>

                    <div v-if="!machineIsLoaded" class="input-group-text col-10 rounded m-0 p-0 ps-3" style="height: 45px;">
                        <span class="m-0 p-0">
                            ---
                        </span>
                    </div>
                    <div class="col-auto m-0 p-0">
                        <i class="bi bi-person-check-fill fs-4 col-auto m-0 p-0"></i>
                    </div>
                </div>
            </div>


            <div class="row m-0 p-0">
                <div class="m-0 p-0 mb-2 mt-4">
                    <span class="m-0 p-0 text-secondary fs-6">
                        {{ lang('password') }}
                    </span>
                </div>
            </div>



            <div class="row m-0 p-0">
                <div class="input-group d-flex flex-row justify-content-between align-items-center m-0 p-0">
                    <div v-if="machineIsLoaded && machineUserPass" class="input-group-text col-10 rounded m-0 p-0 ps-3" style="height: 45px;">
                        <span v-if="showpassword" class="text-dark m-0 p-0 fs-6">
                            <?php for ($i = 0; $i <= 10; $i++) : ?>
                                <i class="bi bi-asterisk text-secondary" style="font-size: 10px !important;"></i>
                            <?php endfor ?>
                        </span>
                        <span v-if="!showpassword" class="text-dark m-0 p-0 fs-6">{{ machineUserPass }}</span>
                    </div>

                    <div v-else class="input-group-text col-10 rounded m-0 p-0 ps-3" style="height: 45px;">
                        <span class=""> --- </span>
                    </div>

                    <!-- Icon btn visibilty -->
                    <div class="col-auto m-0 p-0">
                        <i v-if="showpassword"
                            class="col-auto m-0 p-0 bi bi-eye-slash-fill fs-4 fw-bold text-secondary btn"
                            @click="changeVisibility()"></i>
                        <i v-if="!showpassword"
                            class="col-auto m-0 p-0 bi bi-eye-fill fs-4 fw-bold text-primary btn"
                            @click="changeVisibility()"></i>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end Login -->


</div>
<!-- End Finance and Network -->
