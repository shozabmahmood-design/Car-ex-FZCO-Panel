<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">All Messages</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/messages" class="kt-subheader__breadcrumbs-link">All Messages</router-link>
                    </div>
                </div>>
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
                            All Messages
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
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
                        <table class="table table-striped table-hover table-checkable" id="messagesTable" >
                            <thead>
                                <tr>
                                    <th>Sender Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date </th>
                                    <th>Product Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="message in messages" :key="message.id">
                                    <td>{{ message.firstName }}</td>
                                    <td>{{ message.email }}</td>
                                    <td>{{ message.phone }}</td>
                                    <td>{{ message.created_at | moment("dddd, MMMM Do YYYY") }}</td>
                                    <td>
                                        <router-link :to="{name:'single-product', params:{id: message.product_id, name: message.firstName.split(' ').join('_')}}">
                                            {{ message.product ? message.product.title : '' }}
                                        </router-link>
                                    </td>
                                    <!-- <td>{{message.products.title}}</td> -->
                                    <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <router-link :to="{name:'single-product-message', params: {id: message.id, name:message.firstName.split(' ').join('_') }}" title="View message" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></router-link>
                                            <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deletemessage(message.id)"><i class="la la-trash"></i></a>
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
            messages: [],
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
                $("#messagesTable").DataTable( {
                    dom: 'lBfrtip',
                    pageLength : 25,
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#messagesTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deletemessage(id){
            let object = this;
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: 'Are you sure to delete this message?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .get(`${object.$appUrl}message/delete/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#messagesTable").DataTable().destroy();
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
            this.messages = [];
            this.isRequestCompleted = false;
            $("#messagesTable").DataTable().destroy();
            this.getAllResults(true);
        },
            getAllResults(callTable){
                // console.log(axios.default.headers);
                this.axios
                    .get(`${this.$appUrl}product/messages`)
                    .then(response => {
                        this.messages = response.data;
                        console.log(response.data);
                        this.isRequestCompleted = true;
                        if(callTable){ this.mytable(); }
                    });
            },
    },
    computed:{}
}
</script>