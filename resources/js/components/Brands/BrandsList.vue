<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Brands List</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/products-brands-list" class="kt-subheader__breadcrumbs-link">Brands List</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/products-brands-list/create" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Add New Brand &nbsp;</router-link>
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Modal-->
        <div class="modal fade" id="importBrands" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Brands</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" @submit="uploadFileForm">
                            <div class="form-group">
                                <input type="file" class="form-control" name="uploadedFile" @change="onChange" id="uploadedFile" accept=".csv">
                                <span class="form-text text-danger" style="white-space: pre-line">{{ fileError }}</span>
                            </div>
                            <div class="form-group">
                                <button :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit">{{ isSubmit ? 'Uploading...' : 'Upload Brands' }}</button>
                                <a class="btn btn-primary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" href="/imports/import_brands.csv">Download Example</a>
                            </div>
                        </form>
                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <td>Brand Name</td>
                                <td><small class="form-text text-danger">Required Field</small></td>
                            </tr>
                            <tr>
                                <td>Note</td>
                                <td><small class="form-text text-success">Not a required field</small></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Modal-->
        <!-- end:: Content Head -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand la la-list-ul"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Products Brands List
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <button type="button" @click="deleteMultiple" v-show="selected.length > 0" class="btn btn-danger"><i class="la la-trash"></i> Delete Multiple</button>
                                <button type="button" class="btn btn-outline-brand" data-toggle="modal" data-target="#importBrands">
                                    <i class="la la-cloud-download"></i> Import Brands
                                </button>
                                <router-link to="/products-brands-list/create" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Add New Brand
                                </router-link>
                                <button type="button" class="btn btn-outline-brand" @click="refreshTable">
                                    <i class="la la-refresh"></i> Refresh
                                </button>
                            </div>	
                        </div>		
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <div v-show="!isRequestCompleted" class="text-center">
                        <img :src="'/assets/media/loading.gif'" style="height:300px;width:auto" />
                    </div>
                    <table v-show="isRequestCompleted" class="table table-striped table-hover table-checkable" id="brandsTable" >
                        <thead>
                            <tr>
                                <th>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selectAll"> Record ID
                                        <span></span>
                                    </label>
                                </th>
                                <th>Brand Name</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="brand in brands" :key="brand.id">
                                <td>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selected" :value="brand.id"> {{ brand.id }}
                                        <span></span>
                                    </label>
                                </td>
                                <td>{{ brand.brandName }}</td>
                                <td>{{ brand.note }}</td>
                                <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                    <span style="overflow: visible; position: relative; width: 110px;">
                                        <router-link :to="{name:'products-brands-edit', params: {id: brand.id}}" title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></router-link>
                                        <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteBrand(brand.id)"><i class="la la-trash"></i></a>
                                    </span>
                                </td>
                            </tr>
                        </tbody>    
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
let table = null;
export default {
    data(){
        return {
            brands: [],
            isRequestCompleted: false,
            fileError: 'File must be in csv format',
            file: '',
            isSubmit: false,
            selected: [],
        }
    },
    created(){
        this.getAllResults(true);
    },
    methods:{
        mytable(){
            setTimeout(function() {
                $("#brandsTable").DataTable( {
                    dom: 'lBfrtip',
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#brandsTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteBrand(id){
            let object = this;
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: 'Are you sure to delete this brand?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .delete(`${object.$appUrl}brands/${id}`)
                            .then(response => {
                                console.log(response.data)
                                if(response.data.status){
                                    iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#brandsTable").DataTable().destroy();
                                object.getAllResults(true);
                                }
                                else{
                                    iziToast.error({
                                        title: 'Sorry',
                                        position: 'topRight',
                                        message: response.data.message,
                                    });
                                }
                                
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            });
        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
        
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        },
        refreshTable(){
            this.brands = [];
            this.isRequestCompleted = false;
            $("#brandsTable").DataTable().destroy();
            this.getAllResults(true);
        },
        getAllResults(callTable){
            this.axios
                .get(`${this.$appUrl}brands/`)
                .then(response => {
                    this.brands = response.data;
                    this.isRequestCompleted = true;
                    if(callTable){ this.mytable(); }
                });
        },
        onChange(e){
            this.file = e.target.files[0];
        },
        uploadFileForm(e){
            e.preventDefault();
            this.isSubmit = true;
            let object = this;
            const config = {
                header: {
                    'content-type' : 'multipart/form-data',
                }
            }
            let data = new FormData();
            data.append('file', this.file);
            this.axios
            .post(`${this.$appUrl}brands/upload/`, data, config)
            .then(response => {
                this.isSubmit = false;
                iziToast.success({
                    title: 'Congratulations',
                    position: 'topRight',
                    message: response.data.message,
                });
                $("#importBrands").modal('hide');
                $(".modal-backdrop").remove();
                object.refreshTable();
            })
            .catch(error => {
                this.isSubmit = false;
                if(error.response.status == 422){
                    iziToast.error({
                        title: 'Oops',
                        position: 'topRight',
                        message: 'Fix the errors to uplaod',
                    });
                    this.fileError = typeof error.response.data.errors.file === 'undefined' ? '' : error.response.data.errors.file[0];
                }
            });
        },
        deleteMultiple(){
            let object = this;
            let appUrl = this.$app_url;
            const records = Object.assign({}, this.selected)
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: `Are you sure to delete ${this.selected.length} categories?`,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .post(`${object.$appUrl}brands/delete`, records)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                object.refreshTable();
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            });
        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
        
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                    }],
                ],
                onClosing: function(instance, toast, closedBy){
                    console.info('Closing | closedBy: ' + closedBy);
                },
                onClosed: function(instance, toast, closedBy){
                    console.info('Closed | closedBy: ' + closedBy);
                }
            });
        }
    },
    computed:{
        selectAll: {
            get: function () {
                return this.brands ? this.selected.length == this.brands.length : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.brands.forEach(function (brand) {
                        selected.push(brand.id);
                    });
                }

                this.selected = selected;
            }
        }
    }
}
</script>