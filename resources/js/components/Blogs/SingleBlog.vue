<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Blogs</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <span class="kt-subheader__desc">Single</span>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <span class="kt-subheader__desc">{{ $route.params.name.split('_').join(' ') }}</span>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/blogs" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-list-ul"></i> All Blogs &nbsp;</router-link>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <!-- begin:: Content -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                <div class="kt-portlet kt-sc-2">
                    <div class="kt-portlet__body" v-if="blog.image !== null" :style="`background-image: url(${$uploadsUrl}${blog.image});filter: blur(3px);height: 385px;background-position: center;background-repeat: no-repeat;background-size: cover;`"></div>
                    <div class="kt-portlet__body" v-if="blog.image == null" :style="`background-image: url(https://static.vecteezy.com/system/resources/previews/002/713/608/non_2x/trading-background-with-numbers-and-charts-vector.jpg);filter: blur(5px);height: 385px;background-position: center;background-repeat: no-repeat;background-size: cover;`"></div>
                    <div class="kt-sc__top" style="position: absolute;">
                        <div class="kt-sc__content">
                            <h2 class="kt-sc__title" style="color: white;">
                                {{ blog.title }}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body">
                                <div class="kt-infobox">
                                    <div class="kt-infobox__header">
                                        <h2 class="kt-infobox__title">{{ blog.title }}</h2>
                                        <div class="kt-infobox__badge">{{ blog.blog_category.title }}</div>
                                    </div>
                                    <div>Posted on: {{ blog.created_at | moment("dddd, MMMM Do YYYY") }} <br><br></div>
                                    <div class="kt-infobox__body">
                                        <div class="kt-infobox__section">
                                            <div class="kt-infobox__content" v-html="blog.description">
                                            </div>
                                            <br/>
                                            <br/>
                                            <a href="#" class="kt-link">{{ blog.tags }}</a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <router-link to="/blogs" class="btn btn-success"><i class="la la-caret-left"></i> Back to all Blogs</router-link>
                                        <button class="btn btn-danger" style="float: right;" @click="deleteblog(blog.id)"><i class="la la-trash"></i> Delete Blog</button>
                                        <router-link class="btn btn-success" :to="{name:'update-blog', params: {id: blog.id, name:blog.title.split(' ').join('_')}}" style="float: right;margin:0 10px"><i class="la la-pencil"></i> Update Blog</router-link>
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
    export default {
        data() {
            return {
                blog:[],
            }
        },
        created() {
            this.axios.get(`${this.$appUrl}single-blog/${this.$route.params.id}`)
                .then(response => {
                    this.blog = response.data;
            })
        },

        methods:{
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

                this.$router.push('/blogs')
            },
        }
    }
</script>