<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">All Blogs</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link"></a>
                        <router-link to="/blogs" class="kt-subheader__breadcrumbs-link">All Blogs</router-link>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/blogs/add-new-blog" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-plus"></i> Add New Blog &nbsp;</router-link>
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
                            All Blogs
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <router-link to="/blogs/add-new-blog" class="btn btn-brand btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    Add New Blog
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
                        <table class="table table-striped table-hover table-checkable" id="blogsTable" >
                            <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Blog Title</th>
                                    <th>Category</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="blog in blogs" :key="blog.id">
                                    <td>{{ blog.id }}</td>
                                    <td>
                                        <div v-if="blog.image !== null">
                                            <img class="rounded img-fluid" :src=" `${$uploadsUrl}`+blog.image" style="width: 200px;">
                                            <br>
                                            <br>
                                        </div>
                                        <b>{{ blog.title }}</b>
                                    </td>
                                    <td>{{ blog.blog_category.title }}</td>
                                    <td>{{ blog.created_at | moment("dddd, MMMM Do YYYY") }}</td>
                                    <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                                        <span style="overflow: visible; position: relative; width: 110px;">
                                            <router-link :to="{name:'single-blog', params: {id: blog.id, name:blog.title.split(' ').join('_') }}" title="View Blog" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-eye"></i></router-link>
                                            <router-link :to="{name:'update-blog', params: {id: blog.id, name:blog.title.split(' ').join('_')}}" title="Edit details" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></router-link>
                                            <a title="Delete" class="btn btn-sm btn-clean btn-icon btn-icon-md" @click="deleteblog(blog.id)"><i class="la la-trash"></i></a>
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
            blogs: [],
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
                $("#blogsTable").DataTable( {
                    dom: 'lBfrtip',
                    pageLength : 25,
                    buttons: [
                        'print','copy', 'excel', 'csv','pdf'
                    ]
                });
                $("#blogsTable_filter label").css({'float':'right', 'margin-top': '-50px'});
            }, 500);
        },
        deleteblog(id){
            let object = this;
            iziToast.question({
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Warning',
                message: 'Are you sure to delete this blog?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
        
                        object.axios
                            .get(`${object.$appUrl}blog/delete/${id}`)
                            .then(response => {
                                iziToast.success({
                                    title: 'Congratulations',
                                    position: 'topRight',
                                    message: response.data.message,
                                });
                                $("#blogsTable").DataTable().destroy();
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
            this.blogs = [];
            this.isRequestCompleted = false;
            $("#blogsTable").DataTable().destroy();
            this.getAllResults(true);
        },
            getAllResults(callTable){
                // console.log(axios.default.headers);
                this.axios
                    .get(`${this.$appUrl}blogs`)
                    .then(response => {
                        this.blogs = response.data;
                        this.isRequestCompleted = true;
                        if(callTable){ this.mytable(); }
                    });
            },
    },
    computed:{}
}
</script>