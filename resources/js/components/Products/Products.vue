<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">All Products</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/products" class="kt-subheader__breadcrumbs-link">All Products</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/products/add-new-product" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Add New Product &nbsp;</router-link>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon">
                            <i class="kt-font-brand la la-list-ul"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            All Products
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <router-link to="/products/add-new-product" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Add New Product
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
                    <div v-show="isRequestCompleted">
                        <table class="table table-striped table-hover table-checkable" id="productsTable" >
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Product Title</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Color</th>
                                    <!-- <th>Model</th>
                                    <th>Year</th>
                                    <th>Drive Type</th> -->
                                    <!-- <th>Steering</th>
                                    <th>Transmission</th>
                                    <th>Fuel Type</th>
                                    <th>Engine Size</th>
                                    <th>Doors</th>
                                    <th>Cylender</th>
                                    <th>Price</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in products" :key="product.id">
                                    <td>{{ product.id }}</td>
                                    <td>
                                        <div v-if="product.image !== null">
                                            <img class="rounded img-fluid" :src=" `${$uploadsUrl}`+product.image" style="width: 200px;">
                                            <br>
                                            <br>
                                        </div>
                                        <b>{{ product.title }}</b>
                                    </td>
                                    <td>{{ product.brand.brandName }}</td>
                                    <td>{{ product.type.vehicleType }}</td>
                                    <td>{{ product.color }}</td>
                                    <!-- <td>{{ product.model }}</td>
                                    <td>{{ product.man_year }}</td>
                                    <td>{{ product.drive_type }}</td> -->
                                    <!-- <td>{{ product.steering }}</td>
                                    <td>{{ product.transmission }}</td>
                                    <td>{{ product.fuel_type }}</td>
                                    <td>{{ product.engine_size }}</td>
                                    <td>{{ product.doors }}</td>
                                    <td>{{ product.cylenders }}</td>
                                    <td>{{ product.price }}</td> -->
                                    <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <router-link :to="{name:'single-product', params: {id: product.id, name:product.title.split(' ').join('_') }}" title="View Product" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></router-link>
                                            <router-link :to="{name:'update-product', params: {id: product.id, name:product.title.split(' ').join('_')}}" title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></router-link>
                                            <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteproduct(product.id)"><i class="la la-trash"></i></a>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>    
                        </table>
                    </div>
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
            products: [],
            isRequestCompleted: false,
            selected: [],
        }
    },
    created(){
        this.getAllResults(true);
    },
    methods:{
        mytable(){
            setTimeout(function() {
                $("#productsTable").DataTable( {
                    dom: 'lBfrtip',
                    pageLength : 25,
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#productsTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteproduct(id){
            let object = this;
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: 'Are you sure to delete this product?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .get(`${object.$appUrl}product/delete/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#productsTable").DataTable().destroy();
                                object.getAllResults(true);
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
            this.products = [];
            this.isRequestCompleted = false;
            $("#productsTable").DataTable().destroy();
            this.getAllResults(true);
        },
            getAllResults(callTable){
                // console.log(axios.default.headers);
                this.axios
                    .get(`${this.$appUrl}products`)
                    .then(response => {
                        this.products = response.data;
                        this.isRequestCompleted = true;
                        if(callTable){ this.mytable(); }
                    });
            },
    },
    computed:{}
}
</script>