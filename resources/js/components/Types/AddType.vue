<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Types</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <span class="kt-subheader__desc">Add New Type</span>
                    <div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
                        <input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
                        <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span><i class="flaticon2-search-1"></i></span>
                        </span>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/products-types-list" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-list-ul"></i> Types List &nbsp;</router-link>
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
                            <form class="kt-form" @submit.prevent="addType">
                                <!--begin: Form Wizard Step 1-->
                                <div class="kt-wizard-v1__content">
                                    <div class="kt-heading kt-heading--md">New Type Details:</div>
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-wizard-v1__form">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6 text-center">
                                                                <label for="image" style="cursor:pointer" title="Click to select image for upload"> 
                                                                    <img class="rounded img-fluid" :src="image" style="height:200px;width:auto">
                                                                </label>
                                                                <input type="file" name="image" @change="typeImage" id="image" style="display:none">
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="kt-section__body">
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Type Name</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <input class="form-control" type="text" 
                                                                @blur="validate($event, 'vehicle type', true, null, null, false, 'vehicleType')" 
                                                                placeholder="Vehicle Type" name="vehicleType" v-model="type.vehicleType">
                                                                <span class="form-text text-danger" style="white-space: pre-line">{{ error.vehicleType }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-xl-3 col-lg-3 col-form-label">Note</label>
                                                            <div class="col-lg-9 col-xl-9">
                                                                <textarea name="note" class="form-control" rows="5" placeholder="A few words" v-model="type.note"></textarea>
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
                                <button type="submit" id="btnSubmit" :disabled="isSubmit" class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">{{ isSubmit ? 'Loading...' : 'Save Type' }}</button>
                                <router-link to="/products-types-list" class="btn btn-danger btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u">Cancel</router-link>
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
export default {
    data(){
        return {
            type: {
                image: null,
            },
            error:{
                vehicleType:''
            },
            isSubmit: false,
            image: `${this.$assetsUrl}upload.jpg`,
        }
    },
    methods: {
        addType(){
            this.isSubmit = true;
            let formData = new FormData();
            for (const key in this.type) {
                formData.append(key, this.type[key]);
            }
            const config = {
                header: {
                    'content-type' : 'multipart/form-data',
                }
            }
            this.axios
                .post(`${this.$appUrl}types`, formData, config)
                .then(response => {
                    this.isSubmit = false;
                    iziToast.success({
                        title: 'Congratulations',
                        position: 'topRight',
                        message: response.data.message,
                    });
                    this.$router.push({ name: 'products-types-list' })
                })
                .catch(error => {
                    this.isSubmit = false;
                    iziToast.error({
                        title: 'Oops',
                        position: 'topRight',
                        message: 'Fix the errors to save the Type',
                    });
                    if(error.response.status == 422){
                        for(let key in this.error){
                            this.error[key] = typeof error.response.data.errors[key] === 'undefined' ? '' : error.response.data.errors[key][0];
                        }
                    }
                })
                .finally(() => this.loading = false)
        },

        typeImage(event){
            this.type.image = event.target.files[0];
            console.log(this.type.image);
            this.image = URL.createObjectURL(this.type.image);
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
    }
}
</script>