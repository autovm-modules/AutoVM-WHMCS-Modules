<div v-if="machineIsLoaded" class="row mt-4 justify-content-center">
    <div class="col-12 mb-4">
        <div class="row justify-content-start px-2 px-md-4 pt-5 pb-4 border border-2 rounded-4 bg-light" style="--bs-bg-opacity: 0.6;">
            
            <h5 class="mb-2 text-secondary">
                {{ lang('Rotate IPv6') }}
            </h5>

            <p class="text-secondary fw-normal">
                {{ lang('This feature will change your machine’s IPv6 address and configure it on the VM, The process may take a few minutes.') }}
            </p>

            <button data-bs-toggle="modal" data-bs-target="#rotationModal" class="btn btn-primary px-4 py-2" style="width: auto; margin-left: 10px;">
                {{ lang('Rotate IPV6') }}
            </button>
        </div>
    </div>
    <div class="col-12 col-xxl-8 ps-xxl-4">
        <div class="row justify-content-end px-2 px-md-4 pt-5 pb-4 border border-2 rounded-4 bg-light" style="--bs-bg-opacity: 0.6;">
            <table class="table table-borderless" style="max-width: 1200px; --bs-table-bg : #fbfbfc;">
                <thead>
                    <tr class="border-bottom">
                        <th scope="col" class="text-secondary text-center fw-normal pb-3 fs-6 d-flex flex-row">
                            {{ lang('ID') }}
                        </th>
                        <th scope="col" class="text-secondary text-center fw-normal pb-3 fs-6">
                            {{ lang('Status') }}
                        </th>
                        <th scope="col" class="text-secondary text-center fw-normal pb-3 fs-6">
                            {{ lang('Created At') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="pt-3">
                    <tr v-for="rotation in rotations">
                        <td class="text-secondary align-middle fs-6">
                            {{ rotation.id }}
                        </td>
                        <td class="text-secondary align-middle text-center fs-6 d-none d-md-block">
                            <span v-if="rotation.status == 'failed'" class="btn bg-danger btn-sm px-4 mt-2 rounded-4" style="--bs-bg-opacity: .2; width: 100px;">
                                {{ lang('Failed') }}
                            </span>
                            <span v-else-if="rotation.status == 'processing'" class="btn bg-warning btn-sm px-4 mt-2 rounded-4" style="--bs-bg-opacity: .2; width: 100px;">
                                {{ lang('Processing') }}
                            </span>
                            <span v-else-if="rotation.status == 'completed'" class="btn bg-success btn-sm px-4 mt-2 rounded-4" style="--bs-bg-opacity: .2; width: 100px;">
                                {{ lang('Completed') }}
                            </span>
                            <span v-else class="btn bg-secondary btn-sm px-4 mt-2 rounded-4" style="--bs-bg-opacity: .2; width: 100px;">
                                {{ lang('Pending') }}
                            </span>
                        </td>
                        <td class="text-secondary" v-html="formatdate(rotation.createdAt)"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div v-else> <?php include('fetchingdata.php'); ?> </div>

<div class="modal fade modal-lg" id="rotationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rotationModalLabel" aria-hidden="false">
    <div class="modal-dialog ">
        <div class="modal-content border-0">
            <div class="m-0 p-0">
                <div class="modal-header">
                    <h4 class="text-secondary">
                        {{ lang('Rotate IPv6') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row m-0 p-0">
                        <div class="col-12">
                            <label class="text-secondary fw-normal mb-3">
                                {{ lang('Machine Password') }}
                            </label>

                            <input v-model="rotationPassword" type="password" class="form-control py-3 bg-body-secondary fs-6 ps-4 border-0" style="--bs-bg-opacity: 0.5;" placeholder="Enter password here">
                    
                            <p class="text-secondary fw-normal mt-4">
                                {{ lang('Password is required for all windows operating systems') }}
                            </p>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary px-4 mx-2 border-0 mt-5 float-end" @click="rotate" data-bs-dismiss="modal">
                                {{ lang('Rotate IPv6') }}
                            </button>
                            <button type="button" class="btn btn-secondary px-4 mx-2 border-0 mt-5 float-end" data-bs-dismiss="modal">
                                {{ lang('Close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>