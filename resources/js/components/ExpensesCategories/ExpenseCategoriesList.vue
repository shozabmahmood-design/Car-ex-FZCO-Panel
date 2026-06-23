<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Expense Categories List</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/expenses/categories" class="kt-subheader__breadcrumbs-link">Categories List</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <button data-toggle="modal" data-target="#addExpenseCategory" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Add New Category &nbsp;</button>
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Modal-->
        <div class="modal fade" id="addExpenseCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Expense Category</h5>
                        <button type="button" class="close" @click="category = {}" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" @submit.prevent="addCategory">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input class="form-control" type="text" @blur="validate($event, 'category name', true, null, null, false, 'categoryName')" placeholder="Category Name" v-model="category.categoryName">
                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.categoryName }}</span>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" type="text" placeholder="A few words..." v-model="category.categoryDescription"></textarea>
                            </div>
                            <button type="submit" id="btnSubmit" :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">{{ isSubmit ? 'Loading...' : 'Save Category' }}</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="category = {}" data-dismiss="modal">Cancel</button>
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
                            Expenses Categories List
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <button type="button" @click="deleteMultiple" v-show="selected.length > 0" class="btn btn-danger"><i class="la la-trash"></i> Delete Multiple</button>
                                <button data-toggle="modal" data-target="#addExpenseCategory" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Add New Category
                                </button>
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
                    <table v-show="isRequestCompleted" class="table table-striped table-hover table-checkable" id="categoriesTable" >
                        <thead>
                            <tr>
                                <th>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selectAll"> Record ID
                                        <span></span>
                                    </label>
                                </th>
                                <th>Category Name</th>
                                <th>Description</th>
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
                                <td>{{ category.categoryName }}</td>
                                <td>{{ category.categoryDescription }}</td>
                                <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                    <span style="overflow: visible; position: relative; width: 110px;">
                                        <button title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="editCategory(category)"><i class="la la-edit"></i></button>
                                        <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteCategory(category.id)"><i class="la la-trash"></i></a>
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
            categories: [],
            isRequestCompleted: false,
            category:{
                categoryName:'',
                categoryDescription:'',
            },
            error:{
                categoryName:"",
            },
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
                $("#categoriesTable").DataTable( {
                    dom: 'lBfrtip',
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#categoriesTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteCategory(id){
            let object = this;
            let appUrl = this.$app_url;
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
                            .delete(`${object.$appUrl}expenses_categories/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#categoriesTable").DataTable().destroy();
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
                .get(`${this.$appUrl}expenses_categories/`)
                .then(response => {
                    this.categories = response.data;
                    this.isRequestCompleted = true;
                    if(callTable){ this.mytable(); }
                });
        },
        onChange(e){
            this.file = e.target.files[0];
        },
        addCategory(){
            this.isSubmit = true;
            this.axios
                .post(`${this.$appUrl}expenses_categories`, this.category)
                .then(response => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: response.data.message,
                    });
                    $("#categoriesTable").DataTable().destroy();
                    $("#addExpenseCategory").modal('hide');
                    $(".modal-backdrop").remove();
                    this.getAllResults(true);
                })
                .catch(error => {
                    this.isSubmit = false;
                    iziToast.error({
                        title: 'Oops',
                        position: 'topRight',
                        message: 'Fix the errors to save the contact',
                    });
                    if(error.response.status == 422){
                        for(let key in this.error){
                            this.error[key] = typeof error.response.data.errors[key] === 'undefined' ? '' : error.response.data.errors[key][0];
                        }
                    }
                })
                .finally(() => this.loading = false)
        },
        editCategory(categoryObj){
            this.category = categoryObj;
            $("#addExpenseCategory").modal('show');
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
                            .post(`${object.$appUrl}expenses_categories/delete`, records)
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
        },
        validate(e, fieldName, isRequired, min, max, isEmail, errorField){
            let toCheck = e.target.value;
            let errorsList = [];
            let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(isRequired && toCheck === ""){
                errorsList.push(`${fieldName} is required! `);
            }
            if(min !== null && toCheck.length < min){
                errorsList.push(`${fieldName} must have at least ${min} letters! `);
            }
            if(max !== null && toCheck.length > max){
                errorsList.push(`${fieldName} must have less than ${max} letters! `);
            }
            if(isEmail && !toCheck.match(regexEmail)){
                errorsList.push(`${fieldName} must be a valid email address! `);
            }
            this.error[errorField] = '';
            for(let err in errorsList){
                this.error[errorField] +=  `${errorsList[err]}\n`;
            }
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
        }
    }
}
</script>