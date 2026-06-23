<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Categories List</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/blog-categories" class="kt-subheader__breadcrumbs-link">Categories List</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/blog-categories/create" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Add New Category &nbsp;</router-link>
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
                            Categories List
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <button type="button" @click="deleteMultiple" v-show="selected.length > 0" class="btn btn-danger"><i class="la la-trash"></i> Delete Multiple</button>
                                <router-link to="/blog-categories/create" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Add New Category
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
                        <table class="table table-striped table-hover table-checkable" id="categoriesTable" >
                            <thead>
                                <tr>
                                    <th>
                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                            <input type="checkbox" v-model="selectAll"> Record ID
                                            <span></span>
                                        </label>
                                    </th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="category in categories" :key="category.id">
                                    <td>
                                        <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                            <input type="checkbox" v-model="selected" :value="category.id"> {{ category.id }}
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        <b>{{ category.title }}</b>
                                    </td>
                                    <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <router-link :to="{name:'categories-edit', params: {id: category.id}}" title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></router-link>
                                            <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteCategory(category.id)"><i class="la la-trash"></i></a>
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
            categories: [],
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
                $("#categoriesTable").DataTable( {
                    dom: 'lBfrtip',
                    pageLength : 25,
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#categoriesTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteCategory(id){
            let object = this;
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: 'Are you sure to delete this category?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .get(`${object.$appUrl}blog-category/delete/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#categoriesTable").DataTable().destroy();
                                $("#subCategoriesTable").DataTable().destroy();
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
            this.categories = [];
            this.isRequestCompleted = false;
            $("#categoriesTable").DataTable().destroy();
            this.getAllResults(true);
        },
        getAllResults(callTable){
            this.axios
                .get(`${this.$appUrl}blog-categories/`)
                .then(response => {
                    this.categories = response.data;
                    this.isRequestCompleted = true;
                    if(callTable){ this.mytable(); }
                });
        },
        deleteMultiple(){
            let object = this;
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
                            .post(`${object.$appUrl}blog-categories/delete`, records)
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
                return this.categories ? this.selected.length == this.categories.length : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.categories.forEach(function (category) {
                        selected.push(category.id);
                    });
                }

                this.selected = selected;
            }
        },
    }
}
</script>