<template>
	<div
		class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
		id="kt_content"
	>
		<!-- begin:: Content Head -->
		<div class="kt-subheader kt-grid__item" id="kt_subheader">
			<div class="kt-container kt-container--fluid">
				<div class="kt-subheader__main">
					<h3 class="kt-subheader__title">Settings</h3>

					<span
						class="kt-subheader__separator kt-subheader__separator--v"
					></span>

					<span class="kt-subheader__desc">Adjust System Settings</span>
				</div>
				<div class="kt-subheader__toolbar"></div>
			</div>
		</div>
		<!-- end:: Content Head -->
		<!-- begin:: Content -->
		<div
			class="
				kt-container kt-container--fluid
				kt-grid__item kt-grid__item--fluid
			"
		>
			<div class="kt-portlet">
				<div class="kt-portlet__body kt-portlet__body--fit">
					<div
						class="kt-grid kt-wizard-v1 kt-wizard-v1--white"
						id="kt_contacts_add"
						data-ktwizard-state="step-first"
					>
						<div class="kt-grid__item"></div>
						<div
							class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper"
						>
							<!--begin: Form Wizard Form-->
							<form
								class="kt-form"
								enctype="multipart/form-data"
								style="width: 80%; padding: 3rem 0 5rem"
								@submit.prevent="saveSettings"
							>
								<!--begin: Form Wizard Step 1-->
								<div class="kt-wizard-v1__content">
									<div class="kt-section kt-section--first">
										<div class="kt-wizard-v1__form">
											<div class="row">
												<div class="col-xl-12">
													<div class="kt-section__body">
														<div class="kt-heading kt-heading--md">
															Basic Settings
														</div>
														<div class="row">
															<div class="form-group col-lg-4 col-md-4">
																<label>Business Name</label>
																<input
																	class="form-control"
																	type="text"
																	@blur="
																		validate(
																			$event,
																			'business name',
																			true,
																			1,
																			null,
																			false,
																			false,
																			'businessName'
																		)
																	"
																	placeholder="Business Name"
																	v-model="setting.businessName"
																/>
																<span
																	class="form-text text-danger"
																	style="white-space: pre-line"
																	>{{ error.businessName }}</span
																>
															</div>
															<div class="form-group col-lg-4 col-md-4">
																<label>Business Email</label>
																<input
																	class="form-control"
																	type="text"
																	@blur="
																		validate(
																			$event,
																			'business email',
																			true,
																			null,
																			null,
																			true,
																			false,
																			'businessEmail'
																		)
																	"
																	placeholder="Business Email"
																	v-model="setting.businessEmail"
																/>
																<span
																	class="form-text text-danger"
																	style="white-space: pre-line"
																	>{{ error.businessEmail }}</span
																>
															</div>
															<div class="form-group col-lg-4 col-md-4">
																<label>Business Phone</label>
																<input
																	class="form-control"
																	type="text"
																	@blur="
																		validate(
																			$event,
																			'business phone',
																			true,
																			null,
																			null,
																			false,
																			true,
																			'businessPhone'
																		)
																	"
																	placeholder="Business Phone"
																	v-model="setting.businessPhone"
																/>
																<span
																	class="form-text text-danger"
																	style="white-space: pre-line"
																	>{{ error.businessPhone }}</span
																>
															</div>
															<div class="form-group col-lg-4 col-md-4">
																<label>Business Website</label>
																<input
																	class="form-control"
																	type="text"
																	placeholder="Business Website"
																	v-model="setting.businessWebsite"
																/>
																<span
																	class="form-text text-danger"
																	style="white-space: pre-line"
																	>{{ error.businessWebsite }}</span
																>
															</div>
															<div class="form-group col-lg-4 col-md-4">
																<label>Business Address</label>
																<input
																	class="form-control"
																	type="text"
																	@blur="
																		validate(
																			$event,
																			'business address',
																			true,
																			null,
																			null,
																			false,
																			false,
																			'businessAddress'
																		)
																	"
																	placeholder="Business Address"
																	name="businessAddress"
																	v-model="setting.businessAddress"
																/>
																<span
																	class="form-text text-danger"
																	style="white-space: pre-line"
																	>{{ error.businessAddress }}</span
																>
															</div>
														</div>
														<hr />
														<div class="row">
															<div
																class="form-group col-md-3 col-lg-3 text-center"
															>
																<div
																	class="kt-heading kt-heading--md"
																	style="font-size: 1rem"
																>
																	Business Logo
																</div>
																<label
																	for="businessLogo"
																	style="cursor: pointer"
																	title="Click to select image for upload"
																>
																	<img
																		class="rounded img-fluid"
																		:src="businessLogo"
																		style="height: 100px; width: auto"
																	/>
																</label>
																<input
																	type="file"
																	accept=".jpg, .png, .ico, .jpeg, .svg"
																	name="businessLogo"
																	v-bind="setting.businessLogo"
																	@change="businessLogoChange($event)"
																	id="businessLogo"
																	style="display: none"
																/>
															</div>
														</div>
														<hr />
														<div class="row">
															<div class="form-group col-lg-6 col-md-6">
																<label>Footer Text</label>
																<input
																	class="form-control"
																	type="text"
																	placeholder="Footer Text"
																	name="footerText"
																	v-model="setting.footerText"
																/>
															</div>
														</div>
														<hr />
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--end: Form Wizard Step 1-->

								<!--begin: Form Actions -->
								<button
									type="submit"
									id="btnSubmit"
									:disabled="isSubmit"
									class="
										btn btn-success btn-md btn-tall btn-wide
										kt-font-bold kt-font-transform-u
									"
								>
									{{ isSubmit ? "Loading..." : "Save Settings" }}
								</button>
								<router-link
									to="/products/all-products"
									class="
										btn btn-danger btn-md btn-tall btn-wide
										kt-font-bold kt-font-transform-u
									"
									>Cancel</router-link
								>
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
		data() {
			return {
				setting: {
					user_id: this.$authUser.id,
					businessLogo: "",
					showEmail: true,
					showPhone: true,
					showAddress: true,
					adminCut: 0,
				},
				businessLogo: `${this.$assetsUrl}upload.jpg`,
				error: {
					businessName: "",
					businessEmail: "",
					businessPhone: "",
					businessWebsite: "",
				},
				isSubmit: false,
			};
		},
		created() {
			this.getSettings();
		},
		methods: {
			saveSettings() {
				let formData = new FormData();
				for (const key in this.setting) {
					formData.append(key, this.setting[key]);
				}
				const config = {
					header: {
						"content-type": "multipart/form-data",
					},
				};
				this.isSubmit = true;
				this.axios
					.post(`${this.$appUrl}save_settings`, formData, config)
					.then((response) => {
						this.isSubmit = false;
						iziToast.success({
							title: "Congratulations",
							position: "topRight",
							message: response.data.message,
						});
						sessionStorage.setItem(
							"settings",
							JSON.stringify(response.data.settings)
						);
					})
					.catch((error) => {
						this.isSubmit = false;
						if (error.response.status == 422) {
							iziToast.error({
								title: "Oops",
								position: "topRight",
								message: "Fix the errors to save the settings",
							});
							for (let key in this.error) {
								this.error[key] =
									typeof error.response.data.errors[key] === "undefined"
										? ""
										: error.response.data.errors[key][0];
							}
						}
					})
					.finally(() => (this.loading = false));
			},
			getSettings() {
				this.axios
					.get(`${this.$appUrl}settings/${this.$authUser.id}`)
					.then((response) => {
						this.setting = response.data;
						this.businessLogo = this.setting.businessLogo
							? this.$uploadsUrl + this.setting.businessLogo
							: `${this.$assetsUrl}upload.jpg`;
						
					});
			},
			validate(
				e,
				fieldName,
				isRequired,
				min,
				max,
				isEmail,
				isNumeric,
				errorField
			) {
				let toCheck = e.target.value;
				let errorsList = [];
				let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if (isRequired && toCheck === "") {
					errorsList.push(`${fieldName} is required! `);
				}
				if (min !== null && toCheck.length < min) {
					errorsList.push(`${fieldName} must have at least ${min} letters! `);
				}
				if (max !== null && toCheck.length > max) {
					errorsList.push(`${fieldName} must have less than ${max} letters! `);
				}
				if (isEmail && !toCheck.match(regexEmail)) {
					errorsList.push(`${fieldName} must be a valid email address! `);
				}
				if (isNumeric && isNaN(toCheck)) {
					errorsList.push(`${fieldName} must only contain numbers!`);
				}
				this.error[errorField] = "";
				for (let err in errorsList) {
					this.error[errorField] += `${errorsList[err]}\n`;
				}
			},
			businessLogoChange(event) {
				this.setting.businessLogo = event.target.files[0];
				this.businessLogo = URL.createObjectURL(this.setting.businessLogo);
			},
		},
	};
</script>