<div v-if="machineIsLoaded" class="row justify-content-center px-0 px-md-2 px-xl-4">    
    
    <!-- Network -->
    <div class="col-lg-5 col-xl-4 flex-grow-1 p-0 m-0 d-none d-lg-block pe-lg-2">
        <div class="border border-2 rounded-4 bg-light py-4 px-4 mx-0 me-xxl-2 pb-5 h-100" style="--bs-bg-opacity: 0.6;">
            <!-- top slice -->
            <div>
                <!-- title -->
                <div class="mb-5 d-flex flex-row justify-content-between">
                    <span class="text-dark fw-medium fs-5 my-auto">
                        {{ lang('networkinformation') }}    
                    </span>
                    <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/addons/cloud/views/autovm/includes/assets/img/internet.svg" alt="internet">
                </div>

                <!-- ip -->
                <div class="mt-4 fs-4 d-flex flex-row justify-content-between m-0 p-0">
                    <div class="text-start m-0 p-0">
                        <span class="text-secondary fs-6 align-middle m-0 p-0">
                            {{ lang('ipaddress') }}
                        </span>
                        <span v-if="machineIsLoaded" class="m-0 p-0">
                            <span v-if="ipaddress && !alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-2 align-middle">
                                {{ ipaddress }}
                            </span>
                            <span v-if="alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-2 align-middle">
                                {{ alias }}
                            </span>
                            <span v-if="!ipaddress" class="text-primary fw-medium m-0 p-0 ps-4 fs-2 align-middle">
                                ---
                            </span>
                        </span>
                        <span v-if="!machineIsLoaded" class="m-0 p-0">
                            <span class="text-primary fw-medium m-0 p-0 ps-4 fs-2 align-middle">
                                ---
                            </span>
                        </span>
                    </div>
                    <div class="m-0 p-0">
                        <a @click="CopyAddress" class="btn btn-sm btn-outline p-0 m-0 ms-1 p-1" style="font-size: 70%;">
                            <span v-if="!AddressCopied" class="small">
                                <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/addons/cloud/views/autovm/includes/assets/img/ip.svg" alt="copy" style="width: 23px;">
                            </span>    
                            <span v-if="AddressCopied" class="d-flex flex-row justify-content-center align-items-end text-primary">
                                <i class="bi bi-check-all"></i>
                                <span class="small">Copied</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div><!-- end top -->

            <div>
                <hr class="text-secondary border-2 border-secondary">
            </div>

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
                </div><!-- end bottom -->
            </div>
        </div>
    </div><!-- end Network -->

    <!-- Table -->
    <div class="col-12 col-lg-7 col-xl-8 ps-xl-2">
        <div class="row justify-content-end px-2 px-md-4 pt-5 pb-4 border border-2 rounded-4 bg-light h-100" style="--bs-bg-opacity: 0.6;">
            <table class="table table-borderless" style="max-width: 1200px; --bs-table-bg : #fbfbfc;     max-height: 90px;">
                <thead>
                <tr class="border-bottom">
                    <th scope="col" class="text-secondary fw-normal pb-3 px-0" style=" max-width: 150px;">{{ lang('status') }}</th>
                    <th scope="col" class="text-secondary fw-normal pb-3 d-flex flex-row px-0">{{ lang('iplists') }}</th>
                    <th scope="col" class="text-secondary fw-normal pb-3 px-0">{{ lang('gateway') }}</th>
                    <th scope="col" class="text-secondary fw-normal pb-3 px-0">{{ lang('netmask') }}</th>
                </tr>
                </thead>
                
                <tbody class="pt-3 border-bottom">
                <tr v-for="item in machine.reserves">
                    
                    <td class="text-secondary align-middle px-0 ps-3 ps-md-0">
                            
                            <!-- status (Passive | Active) -->
                            <span v-if="item.status === 'active'" class="btn bg-success btn-sm px-2 mx-2 rounded-4 d-none d-md-block" style="--bs-bg-opacity: .2; width: 70px;">
                            <i class="bi bi-circle-fill text-success small me-1"></i> 
                            <span class="m-0 p-0">{{ lang('active') }}</span>
                            </span>

                            <span v-else-if="item.status === 'passive'"  class="btn bg-danger btn-sm px-2 mx-2 rounded-4 d-none d-md-block" style="--bs-bg-opacity: .2; width: 80px;">
                            <i class="bi bi-circle-fill text-danger small me-1"></i> 
                            {{ lang('passive') }}
                            </span>                                
                            <span v-else class="btn bg-success px-4 mx-2 d-none d-md-block" style="--bs-bg-opacity: .2; width: 50px;">
                                ---
                            </span>

                            <!-- Connected -->
                            <span v-if="item.status === 'active'" class="spinner-grow text-success d-block d-md-none" style="--bs-spinner-width: 12px;--bs-spinner-height: 12px; --bs-spinner-animation-speed: 1.1s;"></span>
                            
                            <!-- Disconnected -->
                            <span v-if="item.status === 'passive'" class="spinner-grow text-danger d-block d-md-none" style="--bs-spinner-width: 12px;--bs-spinner-height: 12px; --bs-spinner-animation-speed: 1.1s;"></span>

                        </td>  

                        <td v-if="item.address.address" scope="row" class="py-3 text-secondary d-flex flex-row px-0">
                            <span>{{ item.address.address }}</span>                    
                            <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/addons/cloud/views/autovm/includes/assets/img/ip.svg" class="ms-3 d-none d-md-block" alt="ipicon" style="height: 20px;">
                        </td>

                        <td v-if="item.address.gateway" class="text-secondary align-middle px-0">{{ item.address.gateway }}</td>
                        <td v-if="item.address.netmask" class="text-secondary align-middle px-0">{{ item.address.netmask }}</td>            
                            
                </tr>
                </tbody>
            </table>
        </div>
    </div>
  
</div>

<div v-if="!machineIsLoaded" class="p-0 m-0 px-2 px-md-0">
<?php  include('./includes/commodules/fetchingdata.php');     ?>
</div>