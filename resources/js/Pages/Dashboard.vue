<template>
    <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-container kt-container--fluid">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Dashboard</h3>
                </div>
                
            </div>
        </div>
        <!-- end:: Content Head -->
        <!-- begin:: Content -->
        <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
            <!--Begin::Dashboard 1-->
            <!--Begin::Row-->
            <div class="row">
                <div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
                    <!--begin:: Widgets/Activity-->
                    <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
                        <!-- <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Sales Chart - Last 30 Days
                                </h3>
                            </div>
                        </div> -->
                        <div class="kt-portlet__body kt-portlet__body--fit">
                            <div class="kt-widget17" style="margin-top:95px">
                                <!-- <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #598ad6;">
                                    <div class="kt-widget17__chart" style="height: 320px;">
                                        <canvas ref="salesChartRef"></canvas>
                                    </div>
                                </div> -->
                                <div class="kt-widget17__stats" style="margin: 0rem auto 0 auto;">
                                    <div class="kt-widget17__items">
                                            <div class="kt-widget17__item">
									            <router-link to="/messages" class="kt-menu__link">

                                                    <span class="kt-widget17__icon">
                                                        <i class="flaticon-chat-2" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                                    </span>
                                                    <span class="kt-widget17__subtitle">
                                                        Contact Messages
                                                    </span>
                                                    <span class="kt-widget17__desc">
                                                        Total: {{stats.messages}}
                                                    </span>
                                                </router-link>
                                            </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/product/messages" class="kt-menu__link">

                                            <span class="kt-widget17__icon">
                                                <i class="flaticon-chat-1" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Products Messages 
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.product_msg}}
                                            </span>
                                         </router-link>
                                        </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/products-brands-list" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon-price-tag" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Cars Brand
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.brands}}
                                            </span>
                                         </router-link>
                                        </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/products-types-list" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon-arrows" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Car Types
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.types}}
                                            </span>
                                         </router-link>
                                        </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/products" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon2-start-up" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Products
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.products}}
                                            </span>
                                         </router-link>
                                        </div>
                                    </div>
                                    <div class="kt-widget17__items">
                                        <div class="kt-widget17__item">
									     <router-link to="/blog-categories" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon-layers" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Blog Categories
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.blog_cats}}
                                            </span>
                                         </router-link>
                                        </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/blogs" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon2-document" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Blogs
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.blogs}}
                                            </span>
                                         </router-link>
                                        </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/notes" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon-clipboard" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Notes
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.notes}}
                                            </span>
                                         </router-link>
                                        </div>
                                        <div class="kt-widget17__item">
									     <router-link to="/expenses/all" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon2-heart-rate-monitor" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Expenses
                                            </span>
                                            <span class="kt-widget17__desc">
                                                Total: {{stats.expenses}}
                                            </span>
                                         </router-link>
                                        </div>

                                        <div class="kt-widget17__item">
									     <router-link to="/settings" class="kt-menu__link">
                                            <span class="kt-widget17__icon">
                                                <i class="flaticon2-settings" :style="`color: #${Math.floor(Math.random()*16777215).toString(16)};font-size: 40px;font-weight: bold;`"></i>
                                            </span>
                                            <span class="kt-widget17__subtitle">
                                                Settings
                                            </span>
                                            <span class="kt-widget17__desc">
                                            </span>
                                         </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Activity-->
                </div>
            </div>
            <!--End::Row-->
        </div>
        <!-- end:: Content -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stats:{},
            }
        },
        created(){
            this.isLoggedIn();
            this.getStats();
		},
        methods: {
            getStats(){
                this.axios
                .get(`${this.$appUrl}get-stats/`)
                .then(response => {
                    this.stats = response.data;
                    console.log(this.stats);
                });
            }
        },
    }
</script>
