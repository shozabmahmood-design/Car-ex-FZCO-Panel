<template>
    <div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v5 kt-login--signin" id="kt_login">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile" :style="`background-image: url(assets/media/bg/bg-3.jpg);height:${windowHeight}px;`">
				<div class="kt-login__left">
					<div class="kt-login__wrapper">
						<div class="kt-login__content">
							<a class="kt-login__logo" href="#">
								<img :src="'assets/media/logos/logo-5.png'">
							</a>

							<h3 class="kt-login__title">JOIN OUR GREAT COMMUNITY</h3>

							<span class="kt-login__desc">
								The ultimate Bootstrap & Angular 6 admin theme framework for next generation web apps.
							</span>

							<div class="kt-login__actions">
								<router-link type="button" :to="`/`" id="kt_login_signup" class="btn btn-outline-brand btn-pill">Login</router-link>
							</div>
						</div>
					</div>
				</div>

				<div class="kt-login__divider"><div></div></div>

				<div class="kt-login__right">
					<div class="kt-login__wrapper">
						<div class="kt-login__signin">
							<div class="kt-login__head">
								<h3 class="kt-login__title">Create Your Account</h3>
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
								<form class="kt-form" @submit.prevent="register">
									<div class="form-group">
										<input class="form-control" type="text" v-model="data.name" placeholder="Name" required autofocus autocomplete="off">
										<small style="color:red">{{ errors.name ? errors.name[0] : '' }}</small>
									</div>
                                    <div class="form-group">
										<input class="form-control" type="text" placeholder="Email" v-model="data.email" required autocomplete="off">
										<small style="color:red">{{ errors.email ? errors.email[0] : '' }}</small>
									</div>
									<div class="form-group">
										<input class="form-control" type="password" required v-model="data.password" autocomplete="current-password" placeholder="Password">
										<small style="color:red">{{ errors.password ? errors.password[0] : '' }}</small>
									</div>
                                    <div class="form-group">
										<input class="form-control" type="password" required v-model="data.password_confirmation" placeholder="Confirm Password">
										<small style="color:red">{{ errors.password_confirmation ? errors.password_confirmation[0] : '' }}</small>
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate" :disabled="isSubmit" :class="isSubmit ? 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : ''">Create Account</button>
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
					name:'',
					email:'',
					password:'',
					password_confirmation:'',
					has_error:false,
					error:'',
					success:false,
				},
				isSubmit:false,
				errors:{},
                windowHeight: window.innerHeight
            }
        },
		methods:{
			register(){
				this.errors = {};
				this.data.has_error = false;
				this.data.error = '';
				var app = this;
				app.isSubmit = true;
				let data = {
						name: app.data.name,
						email: app.data.email,
						password: app.data.password,
						password_confirmation: app.data.password_confirmation,
					};
				this.axios.post(`${this.$appUrl}auth/register`, data)
					.then(response => {
						app.isSubmit = false;
						app.data.success = true;
						if(response.data.message == "success"){
							iziToast.success({
								title: 'Congratulations',
								position: 'topRight',
								message: "Account created successfully! Login to your account...",
							});
							this.$router.push({ name: 'login' });
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
		}
    }
</script>
