<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Products</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <span class="kt-subheader__desc">Single</span>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <span class="kt-subheader__desc">{{ $route.params.name.split('_').join(' ') }}</span>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/products" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-list-ul"></i> All Products &nbsp;</router-link>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <!-- begin:: Content -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                <div class="kt-portlet kt-sc-2">
                    <div class="kt-portlet__body" v-if="product.image !== null" :style="`background-image: url(${$uploadsUrl}${product.image});height: 385px;background-position: center;background-repeat: no-repeat;background-size: cover;`"></div>
                    <div class="kt-portlet__body" v-if="product.image == null" :style="`background-image: url(https://static.vecteezy.com/system/resources/previews/002/713/608/non_2x/trading-background-with-numbers-and-charts-vector.jpg);filter: blur(5px);height: 385px;background-position: center;background-repeat: no-repeat;background-size: cover;`"></div>
                    <div class="kt-sc__top" style="position: absolute;">
                        <div class="kt-sc__content">
                        </div>
                    </div>
                </div>
                <div class="row" v-if="product.video != null">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <video :src="video" style="width:600px; height:400px;" controls></video>
                    </div>
                    <div class="col-3"></div>
                </div>
                <div style="float:right;">
                    <a type="button" class="btn btn-secondary" v-if="showImages == false" @click="showImages=true" style="text-color:white"><i class="fa fa-eye"></i>Show Images</a>
                    <a type="button" class="btn btn-secondary" v-if="showImages == true" @click="showImages=false"><i class="fa fa-eye"></i>Hide Images</a>
                </div>
                <br><br>
                <div class="row" v-if="showImages == true">
                    <div class="col-sm-6 col-md-4 col-lg-3" v-for="Image in Images" :key="Image.id" style="position:relative;">
                        <img :src="`${$uploadsUrl}${Image.image_name}`" alt="product_image" style="width:200px; height:150px; object-fit:cover; padding-bottom:10px">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body">
                                <div class="kt-infobox">
                                    <div class="kt-infobox__header">
                                        <h2 class="kt-infobox__title">{{ product.title }}</h2>
                                        <div class="kt-infobox__badge btn btn-success " @click="makeFeatured(1)" v-if="product.isfeatured == 0">Make Featured</div>
                                        <div class="kt-infobox__badge btn btn-success " @click="makeFeatured(0)" v-if="product.isfeatured == 1">Remove from Featured</div>
                                        
                                    </div>
                                    <div class="kt-infobox__body">
                                        <div>
                                            <table class="table table-striped table-hover table-checkable" id="productsTable" >
                                                    <tr>
                                                        <th>Featured Product</th>
                                                        <td>{{ product.isfeatured ? 'Yes': 'No' }}</td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <th>Brand</th>
                                                        <td>{{ product.brand.brandName }}</td>

                                                    </tr>
                                                    <tr>
                                                        <th>Type</th>
                                                        <td>{{ product.type.vehicleType }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Color</th>
                                                        <td>{{ product.color }}</td>
                                                    </tr>
                                                    <!-- <tr>
                                                        <th>Price</th>
                                                        <td>{{ product.price }}</td>

                                                    </tr>
                                                    <tr>
                                                        <th>Model</th>
                                                        <td>{{ product.model }}</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>Year</th>
                                                        <td>{{ product.man_year }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Drive Type</th>
                                                        <td>{{ product.drive_type }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Steering</th>
                                                        <td>{{ product.steering }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Transmission</th>
                                                        <td>{{ product.transmission }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Fuel Type</th>
                                                        <td>{{ product.fuel_type }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Engine Size</th>
                                                        <td>{{ product.engine_size }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Doors</th>
                                                        <td>{{ product.doors }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cylender</th>
                                                        <td>{{ product.cylenders }}</td>
                                                    </tr> -->
                                                    
                                            </table>
                                        </div>
                                        <!-- <div class="kt-infobox__section">
                                            <h5>Description</h5>
                                            <div class="kt-infobox__content" v-html="product.description">
                                            </div>
                                        </div> -->
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <router-link to="/products" class="btn btn-success"><i class="la la-caret-left"></i> Back to all Products</router-link>
                                        <button class="btn btn-danger" style="float: right;" @click="deleteproduct(product.id)"><i class="la la-trash"></i> Delete Product</button>
                                        <router-link class="btn btn-success" :to="{name:'update-product', params: {id: product.id, name:product.title.split(' ').join('_')}}" style="float: right;margin:0 10px"><i class="la la-pencil"></i> Update Product</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content -->
    </div>
</template>

<script>
// import { Navigation, Pagination } from 'swiper'
// import { SwiperCore, Swiper, SwiperSlide } from 'swiper-vue2'
// import 'swiper/swiper-bundle.css'

// SwiperCore.use([Navigation, Pagination])
        export default {
        components: {
            // Swiper,
            // SwiperSlide
        },
        data() {
            return {
                product:[
                    // isfeatured = false,
                ],
                Images:[],
                showImages: false,
                video:'',
            }
        },
        created() {
            this.axios.get(`${this.$appUrl}single-product/${this.$route.params.id}`)
                .then(response => {
                    this.product = response.data.product;
                    this.Images  = response.data.product_img;
                    this.video = this.$uploadsUrl + this.product.video;
            })
        },
        methods:{
            makeFeatured(value){
                this.product.isfeatured = value;
                // this.product.isfeatured = !this.product.isfeatured;
                // console.log(this.product.isfeatured)   
                this.axios
                        .get(`${this.$appUrl}change-status/${this.product.id}/${value}`)
                        .then(response =>{  
                            iziToast.success({
                                title: 'Congratulations',
                                position: 'topRight',
                                message: response.data.message,
                            });
                        });
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

                this.$router.push('/products')
            },   
        },
        
    }
</script>

<style lang="css" scoped>
    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        }
</style>