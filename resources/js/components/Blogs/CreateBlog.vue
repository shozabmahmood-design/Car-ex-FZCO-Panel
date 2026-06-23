<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Blogs</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <span class="kt-subheader__desc">{{ $route.params.id ? 'Update - ' + $route.params.name.split('_').join(' ') : 'Create New Blog' }}</span>
                    <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                        <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span><i class="flaticon2-search-1"></i></span>
                        </span>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/blogs" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-list-ul"></i> Categories List &nbsp;</router-link>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-grid  kt-wizard-v1 kt-wizard-v1--white" id="kt_contacts_add" data-ktwizard-state="step-first">
                        <div class="kt-grid__item">
                            
                        </div>
                        <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                            <!--begin: Form Wizard Form-->
                            <form class="kt-form" enctype="multipart/form-data" @submit.prevent="addBlog">
                                <!--begin: Form Wizard Step 1-->
                                <div class="kt-wizard-v1__content">
                                    <div class="kt-heading kt-heading--md">{{ $route.params.id ? 'Update - ' + $route.params.name.split('_').join(' ') : 'New Blog Details' }}</div>
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-wizard-v1__form">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="kt-section__body">
                                                        <div class="row">
                                                            <div class="col-md-3 col-lg-3"></div>    
                                                            <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="image" style="cursor:pointer" title="Click to select image for upload"> 
                                                                    <img class="rounded img-fluid" :src="image" style="height:200px;width:auto">
                                                                </label>
                                                                <input type="file" name="image" @change="blogImage" id="image" style="display:none">
                                                            </div>    
                                                            <div class="col-md-3 col-lg-3"></div>    
                                                        </div> 
                                                        <hr>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Blog Title</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input class="form-control" type="text" placeholder="Blog Title" name="title" v-model="blog.title">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.title ? errors.title[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Blog Category</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <select class="form-control" v-model="blog.blog_category">
                                                                    <option selected disabled value="">Select Blog Category</option>
                                                                    <option v-for="category in categories" :key="category.id" v-bind:value="category.id">{{ category.title }}</option>
                                                                </select>
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.blog_category ? errors.blog_category[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Blog Description</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <vue-editor v-model="blog.description"></vue-editor>
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.description ? errors.description[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Blog Tags</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="Separate tags by comma(,)" v-model="blog.tags">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.tags ? errors.tags[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 1-->
                                <!--begin: Form Actions -->
                                <button type="submit" id="btnSubmit" :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">{{ isSubmit ? 'Loading...' : 'Save Blog' }}</button>
                                <router-link to="/blogs" class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">Cancel</router-link>
                                <!--end: Form Actions -->
                            </form>
                            <!--end: Form Wizard Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content -->
    </div>
    
</template>

<script>
import {VueEditor}  from "vue2-editor";
export default {
    components:{
        VueEditor,
    },
    data(){
        return {
            blog: {
                image: null,
                blog_category:'',
            },
            categories:[],
            errors:{},
            isSubmit: false,
            image: `${this.$assetsUrl}upload.jpg`,
        }
    },
    methods: {
        addBlog(){
            this.isSubmit = true;
            let formData = new FormData();
            for (const key in this.blog) {
                formData.append(key, this.blog[key]);
            }
            const config = {
                header: {
                    'content-type' : 'multipart/form-data',
                }
            }
            this.axios
                .post(`${this.$appUrl}add-blog`, formData, config)
                .then(response => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: response.data.message,
                    });
                    this.$router.push({ name: 'blogs' })
                })
                .catch(error => {
                    this.isSubmit = false;
                    iziToast.error({
                        title: 'Oops',
                        position: 'topRight',
                        message: error.response.data.message,
                    });
                    this.errors = error.response.data.errors || {};
                })
                .finally(() => this.loading = false)
        },
        blogImage(event){
            this.blog.image = event.target.files[0];
            console.log(this.blog.image);
            this.image = URL.createObjectURL(this.blog.image);
        },
    },
    created() {
        this.axios.get(`${this.$appUrl}blog-categories`).then(response => {
            this.categories = response.data;
        });
        if(this.$route.params.id){
            this.axios.get(`${this.$appUrl}single-blog/${this.$route.params.id}`).then(response => {
                this.blog = response.data;
                this.blog.blog_category = this.blog.blog_category_id;
                this.image = this.$uploadsUrl + this.blog.image
                this.blog.image = null;
                // console.log(this.blog);
            });
        }
    },
}
</script>