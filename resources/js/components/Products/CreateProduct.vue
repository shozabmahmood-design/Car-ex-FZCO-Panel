<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Products</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <span class="kt-subheader__desc">{{ $route.params.id ? 'Update - ' + $route.params.name.split('_').join(' ') : 'Create New Product' }}</span>
                    <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                        <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span><i class="flaticon2-search-1"></i></span>
                        </span>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/products" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-list-ul"></i> Products List &nbsp;</router-link>
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
                            <form class="kt-form" enctype="multipart/form-data" @submit.prevent="addProduct">
                                <!--begin: Form Wizard Step 1-->
                                <div class="kt-wizard-v1__content">
                                    <div class="kt-heading kt-heading--md">{{ $route.params.id ? 'Update - ' + $route.params.name.split('_').join(' ') : 'New Product Details' }}</div>
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-wizard-v1__form">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="kt-section__body">
                                                        <div class="row">   
                                                            <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="image" style="cursor:pointer; object-fit:contain;" title="Click to select image for upload"> 
                                                                    <img class="rounded img-fluid" :src="image" style="height:200px;width:auto">
                                                                </label>
                                                                <input type="file" name="image" @change="productImage" id="image" style="display:none">
                                                            </div> 
                                                            <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="image2" style="cursor:pointer; object-fit:contain;" title="Click to select image for upload"> 
                                                                    <img class="rounded img-fluid" :src="image2" style="height:200px;width:auto">
                                                                </label>
                                                                <input type="file" name="image2" @change="productImage2" id="image2" style="display:none">
                                                            </div> 
                                                            <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="image3" style="cursor:pointer; object-fit:contain;" title="Click to select image for upload"> 
                                                                    <img class="rounded img-fluid" :src="image3" style="height:200px;width:auto">
                                                                </label>
                                                                <input type="file" name="image3" @change="productImage3" id="image3" style="display:none">
                                                            </div> 
                                                            <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="image4" style="cursor:pointer; object-fit:contain;" title="Click to select image for upload"> 
                                                                    <img class="rounded img-fluid" :src="image4" style="height:200px;width:auto">
                                                                </label>
                                                                <input type="file" name="image4" @change="productImage4" id="image4" style="display:none">
                                                            </div>    
                                                        </div> 
                                                        <!-- <hr>
                                                        <div class="row">
                                                            <div class="col-md-3 col-lg-3"></div>
                                                            <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="video" style="cursor:pointer; object-fit:contain;" title="Click to select Video for upload"> 
                                                                    <img class="rounded img-fluid" :src="video" style="height:200px;width:auto" v-if="product.video == null">
                                                                    <video :src="video" v-if="product.video != null" style="height:200px;width:auto" autoplay></video>
                                                                </label>
                                                                <input type="file" name="video" @change="productVideo" id="video" style="display:none" accept="video/*">
                                                            </div>
                                                            <div class="col-md-3 col-lg-3"></div>
                                                        </div> -->
                                                        <hr>

                                                        <div class="row" v-if="Images.length>0">
                                                            <div class="col-sm-6 col-md-4 col-lg-4" v-for="Image in Images" :key="Image.id" style="position:relative;">
                                                                <img :src="`${$uploadsUrl}${Image.image_name}`" alt="product_image" style="width:200px; height:150px; object-fit:cover; padding-bottom:10px">
                                                                <a type="button" aria-label="Close" style="position:absolute; top:10%; left:90%" @click="deleteImage(Image.id)"><span class="flaticon-delete-1" style="color:white;"></span></a>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="">
                                                                <div class="wt-labelgroup">
                                                                    <label>
                                                                        <span class="wt-btn">Select Files</span>
                                                                        <input type="file" multiple @change="getAllFiles" name="file" id="file">
                                                                    </label>
                                                                    <span>Select files here to upload</span>
                                                                    <em class="wt-fileuploading">Uploading<i class="fa fa-spinner fa-spin"></i></em>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <ul class="wt-attachfile">
                                                                    <li v-for="(file, index) in attachments" :key="index">
                                                                        <span class="uploadprogressbar"></span>
                                                                        <span>{{ file.name }}</span>
                                                                        <em>File size: {{ (file.size / 1024).toFixed(2) }} kb <a href="javascript:void(0);" @click="removeFile(index)" class="material-icons md-18">close</a></em>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Product Title</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input class="form-control" type="text" placeholder="Product Title" name="title" v-model="product.title">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.title ? errors.title[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Vehicle Brand</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <select class="form-control" v-model="product.brand">
                                                                    <option selected disabled value="">Select Vehicle Brand</option>
                                                                    <option v-for="brand in brands" :key="brand.id" v-bind:value="brand.id">{{ brand.brandName }}</option>
                                                                </select>
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.brand ? errors.brand[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Vehicle Type</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <select class="form-control" v-model="product.type">
                                                                    <option selected disabled value="">Select Vehicle Type</option>
                                                                    <option v-for="type in types" :key="type.id" v-bind:value="type.id">{{ type.vehicleType }}</option>
                                                                </select>
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.type ? errors.type[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Vehicle Model</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="Model no" v-model="product.model">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.model ? errors.model[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Vehicle Manufecture Year</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="Year" v-model="product.man_year">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.man_year ? errors.man_year[0] : '' }}</span>
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Color</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="white" v-model="product.color">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.color ? errors.color[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Drive Type</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="4 x 4" v-model="product.drive_type">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.drive_type ? errors.drive_type[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Steering</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="Left or Right" v-model="product.steering">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.steering ? errors.steering[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Transmission</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="automatic" v-model="product.transmission">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.transmission ? errors.transmission[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Fuel Type</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="Diesel" v-model="product.fuel_type">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.fuel_type ? errors.fuel_type[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Engine Size</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="5L" v-model="product.engine_size">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.engine_size ? errors.engine_size[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Doors</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="4" v-model="product.doors">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.doors ? errors.doors[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Cylenders</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="10" v-model="product.cylenders">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.cylenders ? errors.cylenders[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Price</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="text" class="form-control" placeholder="$1000" v-model="product.price">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.price ? errors.price[0] : '' }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">product Description</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <vue-editor v-model="product.description"></vue-editor>
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ errors.description ? errors.description[0] : '' }}</span>
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Product PDF File</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input type="file" name="pdf_file" accept=".pdf, .doc, .docx" @change="productFile" >
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
                                <button type="submit" id="btnSubmit" :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">{{ isSubmit ? 'Loading...' : 'Save Product' }}</button>
                                <router-link to="/products" class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">Cancel</router-link>
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
            product: {
                image: null,
                image2: null,
                image3: null,
                image4: null,
                pdf_file:null,
                video:null,
                brand:'',
                type:'',
            },
            brands:[],
            types:[],
            errors:{},
            attachments:[],
            Images:[],
            isSubmit: false,
            image: `${this.$assetsUrl}upload.jpg`,
            image2: `${this.$assetsUrl}upload.jpg`,
            image3: `${this.$assetsUrl}upload.jpg`,
            image4: `${this.$assetsUrl}upload.jpg`,
            video: `${this.$assetsUrl}uploadVideo.png`,
        }
    },
    methods: {
        addProduct(){
            this.isSubmit = true;
            let formData = new FormData();
            for (const key in this.product) {
                formData.append(key, this.product[key]);
            }
            for(var i=0;i<this.attachments.length;i++){
                formData.append("attachments[]",this.attachments[i]);
            }
            const config = {
                header: {
                    'content-type' : 'multipart/form-data',
                }
            }

            console.log(this.attachments)
            this.axios
                .post(`${this.$appUrl}add-product`, formData, config)
                .then(response => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: response.data.message,
                    });
                    this.$router.push({ name: 'products' })
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
        productImage(event){
            this.product.image = event.target.files[0];
            this.image = URL.createObjectURL(this.product.image);
        },
        productImage2(event){
            this.product.image2 = event.target.files[0];
            console.log(this.product.image2);
            this.image2 = URL.createObjectURL(this.product.image2);
        },
        productImage3(event){
            this.product.image3 = event.target.files[0];
            this.image3 = URL.createObjectURL(this.product.image3);
        },
        productImage4(event){
            this.product.image4 = event.target.files[0];
            console.log(this.product.image4)
            this.image4 = URL.createObjectURL(this.product.image4);
        },

        productVideo(event){
            if(event.target.files[0].size>20971520){
                iziToast.error({
                        title: 'sorry',
                        position: 'topRight',
                        message: 'Max video size is 20mb',
                    });
            }
            else{
                this.product.video = event.target.files[0];
                this.video = URL.createObjectURL(this.product.video);
            }
            
        },

        getAllFiles(e){
            let total = e.target.files;
            console.log(total);
            for(let i = 0; i < total.length; i++){
                this.attachments.push(total[i]);
            }
        },
        removeFile(index){
            this.attachments.splice(index, 1);
        },
        productFile(event){
            this.product.pdf_file = event.target.files[0];
            this.pdf_file = URL.createObjectURL(this.product.pdf_file);
        },

        deleteImage(id){
            this.axios.get(`${this.$appUrl}remove-Image/${id}`).then((response=>{
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: 'Image deleted Succeddfully',
                    });
            }))

            this.$router.go()

        }
    },
    created() {
        this.axios.get(`${this.$appUrl}brands`).then(response => {
            this.brands = response.data;
        });
        this.axios.get(`${this.$appUrl}types`).then(response => {
            this.types = response.data;
        });
        if(this.$route.params.id){
            this.axios.get(`${this.$appUrl}single-product/${this.$route.params.id}`).then(response => {
                // console.log(response.data);
                this.product = response.data.product;
                this.Images = response.data.product_img;
                console.log(this.Images)
                this.product.brand = this.product.brand_id;
                this.product.type = this.product.type_id;
                this.image = this.$uploadsUrl + this.product.image;
                this.image2 = this.$uploadsUrl + this.product.image2;
                this.image3 = this.$uploadsUrl + this.product.image3;
                this.image4 = this.$uploadsUrl + this.product.image4;
                this.video = this.$uploadsUrl + this.product.video;
                this.pdf_file = this.product.pdf_file;
            }); 
        }
    },
}
</script>