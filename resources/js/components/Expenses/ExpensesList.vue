<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Expense List</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/expenses/all" class="kt-subheader__breadcrumbs-link">Expenses List</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <button data-toggle="modal" data-target="#addExpenseModal" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Create Expense &nbsp;</button>
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Modal-->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Expense</h5>
                        <button type="button" class="close" @click="expense = defaultVals" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" @submit.prevent="addExpense">
                            <div class="form-group">
                                <label>Select Date</label>
                                <input class="form-control" type="date" placeholder="Select Date" v-model="expense.date">
                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.date }}</span>
                            </div>
                            <div class="form-group">
                                <label>Amount ({{ $settings.currency }})</label>
                                <input type="string" class="form-control" placeholder="Expense Amount" v-model="expense.amount">
                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.amount }}</span>
                            </div>
                            <div class="form-group">
                                <label>Select Category</label>
                                <select class="form-control" v-model="expense.category">
                                    <option value="">Choose Category for Expense</option>
                                    <option v-for="category in categories" :key="category.id" v-bind:value="category.id">{{ category.categoryName }}</option>
                                </select>
                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.category }}</span>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="5" type="text" placeholder="A few words..." v-model="expense.description"></textarea>
                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.description }}</span>
                            </div>
                            <button type="submit" id="btnSubmit" :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">{{ isSubmit ? 'Loading...' : 'Save Expense' }}</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="expense = defaultVals" data-dismiss="modal">Cancel</button>
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
                                <button data-toggle="modal" data-target="#addExpenseModal" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Create Expense
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
                    <table v-show="isRequestCompleted" class="table table-striped table-hover table-checkable" id="expensesTable" >
                        <thead>
                            <tr>
                                <th>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selectAll"> Record ID
                                        <span></span>
                                    </label>
                                </th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="expense in expenses" :key="expense.id">
                                <td>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selected" :value="expense.id"> {{ expense.id }}
                                        <span></span>
                                    </label>
                                </td>
                                <td>{{ expense.date }}</td>
                                <td>{{ $settings.currency }}{{ expense.amount }}</td>
                                <td>{{ expense.category.categoryName }}</td>
                                <td>{{ expense.description }}</td>
                                <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                    <span style="overflow: visible; position: relative; width: 110px;">
                                        <button title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="editExpense(expense)"><i class="la la-edit"></i></button>
                                        <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteExpense(expense.id)"><i class="la la-trash"></i></a>
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
export default {
    data(){
        return {
            categories: [],
            expenses:[],
            isRequestCompleted: false,
            expense:{
                date:new Date().toISOString().substring(0, 10),
                description:'',
                amount:'',
                category:'',
            },
            defaultVals:{
                date:new Date().toISOString().substring(0, 10),
                description:'',
                amount:'',
                category:'',
            },
            error:{
                date:'',
                description:'',
                amount:'',
                category:'',
            },
            isSubmit: false,
            selected: [],
        }
    },
    created(){
        this.getAllResults(true);
        this.axios
                .get(`${this.$appUrl}expenses_categories/`)
                .then(response => {
                    this.categories = response.data;
                });
    },
    methods:{
        mytable(){
            setTimeout(function() {
                $("#expensesTable").DataTable( {
                    dom: 'lBfrtip',
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#expensesTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteExpense(id){
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
                message: 'Are you sure to delete this expense?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .delete(`${object.$appUrl}expenses/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#expensesTable").DataTable().destroy();
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
            this.expenses = [];
            this.isRequestCompleted = false;
            $("#expensesTable").DataTable().destroy();
            this.getAllResults(true);
        },
        getAllResults(callTable){
            this.axios
                .get(`${this.$appUrl}expenses/`)
                .then(response => {
                    this.expenses = response.data;
                    this.isRequestCompleted = true;
                    if(callTable){ this.mytable(); }
                });
        },
        onChange(e){
            this.file = e.target.files[0];
        },
        addExpense(){
            this.isSubmit = true;
            this.axios
                .post(`${this.$appUrl}expenses`, this.expense)
                .then(response => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: response.data.message,
                    });
                    $("#expensesTable").DataTable().destroy();
                    $("#addExpenseModal").modal('hide');
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
        editExpense(expenseObj){
            this.expense = expenseObj;
            this.expense['category'] = expenseObj.expenses_categories_id;
            $("#addExpenseModal").modal('show');
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
                return this.expenses ? this.selected.length == this.expenses.length : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.expenses.forEach(function (expense) {
                        selected.push(expense.id);
                    });
                }

                this.selected = selected;
            }
        }
    }
}
</script>