<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Notes</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/notes" class="kt-subheader__breadcrumbs-link">All Notes</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <button data-toggle="modal" data-target="#addNoteModal" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Create Note &nbsp;</button>
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Modal-->
        <div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Note</h5>
                        <button type="button" class="close" id="closeModal1" @click="createDefault" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" @submit.prevent="addNote">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" type="text" placeholder="Note Title" v-model="note.title">
                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.title }}</span>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="5" type="text" placeholder="A few words..." v-model="note.description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Label <small>(Any)</small></label>
                                <input class="form-control" type="text" placeholder="Label" v-model="note.label">
                            </div>
                            <button type="submit" id="btnSubmit" :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">{{ isSubmit ? 'Loading...' : 'Save Note' }}</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="closeModal2" @click="createDefault" aria-label="Close" data-dismiss="modal">Cancel</button>
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
                            All Notes
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <button type="button" @click="deleteMultiple" v-show="selected.length > 0" class="btn btn-danger"><i class="la la-trash"></i> Delete Multiple</button>
                                <button data-toggle="modal" data-target="#addNoteModal" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Create Note
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
                    <table v-show="isRequestCompleted" class="table table-striped table-hover table-checkable" id="notesTable" >
                        <thead>
                            <tr>
                                <th>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selectAll"> Record ID
                                        <span></span>
                                    </label>
                                </th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="note in notes" :key="note.id">
                                <td>
                                    <label class="kt-checkbox kt-checkbox--tick kt-checkbox--danger">
                                        <input type="checkbox" v-model="selected" :value="note.id"> {{ note.id }}
                                        <span></span>
                                    </label>
                                </td>
                                <td>{{ note.created_at | moment("ddd, MM Do YYYY, h:mm A") }}</td>
                                <td>{{ note.title }}</td>
                                <td>{{ note.description }}</td>
                                <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                    <span style="overflow: visible; position: relative; width: 110px;">
                                        <button title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="editNote(note)"><i class="la la-edit"></i></button>
                                        <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteNote(note.id)"><i class="la la-trash"></i></a>
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
            notes:[],
            isRequestCompleted: false,
            note:{
                title:'',
                description:'',
                label:'',
            },
            error:{
                title:'',
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
                $("#notesTable").DataTable( {
                    dom: 'lBfrtip',
                    order: [[ 0, "desc" ]],
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#notesTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteNote(id){
            let object = this;
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: 'Are you sure to delete this note?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        object.axios
                            .get(`${object.$appUrl}notes/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#notesTable").DataTable().destroy();
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
            this.notes = [];
            this.isRequestCompleted = false;
            $("#notesTable").DataTable().destroy();
            this.getAllResults(true);
        },
        getAllResults(callTable){
            this.axios
                .get(`${this.$appUrl}notes/`)
                .then(response => {
                    this.notes = response.data;
                    this.isRequestCompleted = true;
                    if(callTable){ this.mytable(); }
                });
        },
        addNote(){
            this.isSubmit = true;
            this.axios
                .post(`${this.$appUrl}notes/save`, this.note)
                .then(response => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: response.data.message,
                    });
                    $("#notesTable").DataTable().destroy();
                    this.getAllResults(true);
                    window.location.reload();
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
        editNote(noteObj){
            this.note = noteObj;
            $("#addNoteModal").modal('show');
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
                message: `Are you sure to delete ${this.selected.length} notes?`,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .post(`${object.$appUrl}notes/delete`, records)
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
        closeModal() {
            this.createDefault();
            document.getElementById('closeModal1').click();
            document.getElementById('closeModal2').click();
        },
        createDefault(){
            this.note = {
                title:'',
                description:'',
                label:'',
            };
        },
    },
    computed:{
        selectAll: {
            get: function () {
                return this.notes ? this.selected.length == this.notes.length : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.notes.forEach(function (note) {
                        selected.push(note.id);
                    });
                }

                this.selected = selected;
            }
        }
    }
}
</script>