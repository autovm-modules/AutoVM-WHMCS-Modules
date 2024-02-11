<div v-if="machineIsLoaded" class="row mt-4 justify-content-center">
    
    <!-- Network -->
  <div class="col-4 flex-grow-1 p-0 m-0 d-none d-xxl-block pe-xxl-4">
    <div class="border border-2 rounded-4 bg-light py-4 px-4 mx-0 me-xxl-2  pb-5 h-100" style="--bs-bg-opacity: 0.6;">
        <!-- top slice -->
        <div>
            <!-- title -->
            <div class="mb-5 d-flex flex-row justify-content-between">
                <span class="text-dark fw-medium fs-5 my-auto">
                    {{ lang('networkinformation') }}    
                </span>
                <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/servers/product/views/view/assets/img/internet.svg" alt="internet">
            </div>



            <!-- ip -->
            <div class="mt-4 fs-4 d-flex flex-row justify-content-between">
                <div class="text-start">
                    <span class="text-secondary fs-6 align-middle">
                        {{ lang('ipaddress') }}    
                    </span>
                    <span v-if="!machineIsLoaded" class="text-primary fw-medium ps-4 fs-4  align-middle">
                        ---
                    </span>
                    <span v-if="machineIsLoaded && address && !alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-4 align-middle">
                        {{ address }}
                    </span>
                    <span v-if="machineIsLoaded && alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-4 align-middle">
                        {{ alias }}
                    </span>                    
                    <span v-if="machineIsLoaded && !address && !alias" class="text-primary fw-medium m-0 p-0 ps-4 fs-4 align-middle">
                        ---
                    </span>                    
                </div>
                <div v-show="!AddressCopied">
                    <img @click="CopyAddress" src="<?php echo($PersonalRootDirectoryURL); ?>/modules/servers/product/views/view/assets/img/ip.svg" alt="ipaddress">
                </div>
                <div v-show="AddressCopied">
                    <i class="bi bi-check-all text-primary"></i>
                </div>
            </div>
        </div><!-- end top -->

        <div>
            <hr class="text-secondary border-2 border-secondary">
        </div>

        <!-- bottom slice -->
        <div>
            <div class="m-0 p-0 mt-0 fs-4">
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
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- end bottom -->
    </div>
  </div><!-- end Network -->

  <!-- Table -->
  <div class="col-12 col-xxl-8 ps-xxl-4">
      <div class="row justify-content-end px-2 px-md-4 pt-5 pb-4 border border-2 rounded-4 bg-light" style="--bs-bg-opacity: 0.6;">
        <table v-if="machine.reserves" class="table table-borderless" style="max-width: 1200px; --bs-table-bg : #fbfbfc;">
            <thead>
              <tr class="border-bottom">
                <th scope="col" class="text-secondary fw-normal pb-3 fs-6 d-flex flex-row">{{ lang('iplists') }}</th>
                <th scope="col" class="text-secondary fw-normal pb-3 fs-6">{{ lang('gateway') }}</th>
                <th scope="col" class="text-secondary fw-normal pb-3 fs-6">{{ lang('netmask') }}</th>
                <th scope="col" class="text-secondary fw-normal pb-3 fs-6 d-none d-md-block ps-3">{{ lang('status') }}</th>
              </tr>
            </thead>
            <tbody class="pt-3">
              <tr v-for="item in machine.reserves">
                
                <td scope="row" class="py-3 text-secondary d-flex flex-row fs-6">
                    <img src="<?php echo($PersonalRootDirectoryURL); ?>/modules/servers/product/views/view/assets/img/ip.svg" class="me-4 d-none d-md-block" alt="ipicon">
                    <span>{{ item.address.address }}</span>
                </td>

                <td v-if="item.address.gateway" class="text-secondary align-middle fs-6">{{ item.address.gateway }}</td>
                <td v-if="item.address.netmask" class="text-secondary align-middle fs-6">{{ item.address.netmask }}</td>            
                <td class="text-secondary align-middle fs-6 d-none d-md-block">
                
                  <!-- status (Passive | Active) -->
                  <div class="d-none d-md-block">
                    <span v-if="item.status == 'active'" class="btn bg-success btn-sm px-2 mx-2 rounded-4" style="--bs-bg-opacity: .2; width: 100px;">
                      <i class="bi bi-circle-fill text-success small me-1"></i> 
                      {{ lang('active') }}
                    </span>

                    <span v-else-if="item.status == 'passive'"  class="btn bg-danger btn-sm px-2 mx-2 rounded-4" style="--bs-bg-opacity: .2; width: 100px;">
                      <i class="bi bi-circle-fill text-danger small me-1"></i> 
                      {{ lang('passive') }}
                    </span>                                
                    <span v-else class="btn bg-success px-4 mx-2" style="--bs-bg-opacity: .2; width: 100px;">
                        ...
                    </span>
                  </div>
                </td>            
              </tr>
            </tbody>
          </table>
      </div>
  </div>
  
</div>

<div v-else><?php include('fetchingdata.php'); ?></div>