<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">

                    <h3 class="kt-subheader__title">Messages</h3>

                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>

                    <span class="kt-subheader__desc">Single</span>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                    <span class="kt-subheader__desc">{{ $route.params.name.split('_').join(' ') }}</span>
                </div>
                <div class="kt-subheader__toolbar">
                    <div class="kt-subheader__wrapper">
                        <router-link to="/messages" class="btn btn-brand btn-elevate btn-icon-sm"><i class="la la-list-ul"></i> All Messages &nbsp;</router-link>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->
        <!-- begin:: Content -->
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="kt-portlet">
                            <div class="kt-portlet__body">
                                <div class="kt-infobox">
                                    <div class="kt-infobox__header">
                                        <h4>Sent By: {{message.firstName}} {{message.lastName}}</h4>
                                        <div class="kt-infobox__badge">{{ message.created_at | moment("dddd, MMMM Do YYYY, HH:MM") }} </div>
                                    </div>
                                    <div class="kt-infobox__body">
                                        <div class="kt-infobox__section">
                                            <h5><small>Email:</small>   {{message.email}}</h5>
                                            <h5><small>Phone no:</small>   {{message.phone}}</h5>
                                        </div>
                                        <div class="kt-infobox__section">
                                            <div class="kt-infobox__content">
                                                <h5>Message Body</h5>
                                               <h6>{{message.msg}}</h6>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <router-link to="/messages" class="btn btn-success"><i class="la la-caret-left"></i> Back to all Messages</router-link>
                                        <button class="btn btn-danger" style="float: right;" @click="deletemessage(message.id)"><i class="la la-trash"></i> Delete Message</button>
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
                message:[],
            }
        },
        created() {
            this.axios.get(`${this.$appUrl}single-message/${this.$route.params.id}`)
                .then(response => {
                    this.message = response.data;
            })
        },
        methods:{
            deletemessage(id){
                let object = this;
                iziToast.question({
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Warning',
                    message: 'Are you sure to delete this message?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
            
                            object.axios
                                .get(`${object.$appUrl}message/delete/${id}`)
                                .then(response => {
                                    iziToast.success({
                                        title: 'Congratulations',
                                        position: 'topRight',
                                        message: response.data.message,
                                    });
                                    $("#messagesTable").DataTable().destroy();
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

                this.$router.push('/messages')
            }
        }
    }
</script>