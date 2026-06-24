<template>
    <div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v5 kt-login--signin" id="kt_login">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile" :style="`background-image: url(assets/media/bg/bg-3.jpg);height:${windowHeight}px;`">
				<div class="kt-login__left">
					<div class="kt-login__wrapper">
						<div class="kt-login__content">
							<a class="kt-login__logo" href="#">
								<img :src="'assets/logo.png'" style="height: 75px;">
							</a>
							<h3 class="kt-login__title">CAR EX LLC - ADMIN PANEL</h3>
							<span class="kt-login__desc">
								Login to continue your working... 
							</span>
						</div>
					</div>
				</div>

				<div class="kt-login__divider"><div></div></div>

				<div class="kt-login__right">
					<div class="kt-login__wrapper">
						<div class="kt-login__signin">
							<div class="kt-login__head">
								<h3 class="kt-login__title">Login To Your Account</h3>
							</div>
                            <div class="kt-login__form">
								<div class="alert alert-solid-danger alert-bold" role="alert" v-if="data.has_error">
									<div class="alert-text">{{ data.error }}!</div>
									<div class="alert-close">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true"><i class="la la-close"></i></span>
										</button>
									</div>
								</div>
								<form class="kt-form" @submit.prevent="login">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="Email" v-model="data.email" required autofocus autocomplete="off">
										<small style="color:red">{{ errors.email ? errors.email[0] : '' }}</small>
									</div>
									<div class="form-group">
										<input class="form-control form-control-last" type="Password" v-model="data.password" required placeholder="Password">
										<small style="color:red">{{ errors.password ? errors.password[0] : '' }}</small>
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate" :disabled="isSubmit" :class="isSubmit ? 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : ''">Sign In</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</template>

<script>
    export default {
        data() {
            return {
				data:{
					email:'',
					password:'',
					has_error:false,
					error:'',
					success:false,
				},
				isSubmit:false,
				errors:{},
                windowHeight: window.innerHeight
            }
        },
		methods: {
			login(){
				this.errors = {};
				this.data.has_error = false;
				this.data.error = '';
				var app = this;
				app.isSubmit = true;
				let data = {
						email: app.data.email,
						password: app.data.password,
					};
				this.axios.post(`${this.$appUrl}auth/login`, data)
					.then(response => {
						app.isSubmit = false;
						app.data.success = true;
						if(response.data.message == "success"){
							iziToast.success({
								title: 'Congratulations',
								position: 'topRight',
								message: "Logged In Successfully!",
							});
							sessionStorage.setItem('user', JSON.stringify(response.data.user));
							sessionStorage.setItem('token', response.data.token);
							sessionStorage.setItem('settings', JSON.stringify(response.data.settings));
							window.location.href = `${this.$baseUrl}dashboard`;
						}
					})
					.catch(err => {
						app.data.has_error = true;
						app.isSubmit = false;
						app.data.error = err.response.data.message;
						app.errors = err.response.data.errors || {};
					})
					.finally(() => this.loading = false)
			}
		},
    }
</script>
