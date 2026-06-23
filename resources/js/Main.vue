<template>
	<div v-if="$authUser">
		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed">
			<div class="kt-header-mobile__logo">
				<router-link to="/dashboard"> Car EX LLC</router-link>
			</div>
			<div class="kt-header-mobile__toolbar">
				<button
					class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
					id="kt_aside_mobile_toggler"
				>
					<span></span>
				</button>

				<button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler">
					<span></span>
				</button>

				<button
					class="kt-header-mobile__topbar-toggler"
					id="kt_header_mobile_topbar_toggler"
				>
					<i class="flaticon-more"></i>
				</button>
			</div>
		</div>
		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div
				class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page"
			>
				<!-- begin:: Aside -->
				<div
					class="
						kt-aside kt-aside--fixed
						kt-grid__item
						kt-grid kt-grid--desktop kt-grid--hor-desktop
					"
					id="kt_aside"
				>
					<!-- begin:: Aside -->
					<div class="kt-aside__brand kt-grid__item" id="kt_aside_brand">
						<div class="kt-aside__brand-logo">
							<router-link to="/dashboard">
								<img
									:src="`${$uploadsUrl}${$settings.businessLogo}`"
									style="height: 60px; margin-left: 40px"
								/>
							</router-link>
						</div>

						<div class="kt-aside__brand-tools">
							<button
								class="kt-aside__brand-aside-toggler"
								id="kt_aside_toggler"
							></button>
						</div>
					</div>
					<!-- end:: Aside -->
					<!-- begin:: Aside Menu -->
					<div
						class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid"
						id="kt_aside_menu_wrapper"
					>
						<div
							id="kt_aside_menu"
							class="kt-aside-menu"
							data-ktmenu-vertical="1"
							data-ktmenu-scroll="1"
							data-ktmenu-dropdown-timeout="500"
						>
							<ul class="kt-menu__nav">
								<li class="kt-menu__item" aria-haspopup="true">
									<router-link to="/dashboard" class="kt-menu__link"
										><span class="kt-menu__link-icon"
											><span class="material-icons md-18">home</span></span
										><span class="kt-menu__link-text"
											>Dashboard</span
										></router-link
									>
								</li>
									<li
										class="kt-menu__item kt-menu__item--submenu"
										aria-haspopup="true"
										data-ktmenu-submenu-toggle="hover"
									>
										<router-link
											class="kt-menu__link kt-menu__toggle"
											to="/messages"
										>
											<span class="kt-menu__link-icon"
												><span class="material-icons md-18">message</span></span
											><span class="kt-menu__link-text">Contact Messages</span>
										</router-link>
									</li>

									<li
										class="kt-menu__item kt-menu__item--submenu"
										aria-haspopup="true"
										data-ktmenu-submenu-toggle="hover"
									>
										<router-link
											class="kt-menu__link kt-menu__toggle"
											to="/whatsapp/messages"
										>
											<span class="kt-menu__link-icon"
												><span class="material-icons md-18">messenger</span></span
											><span class="kt-menu__link-text"> Product Messages</span>
										</router-link>
									</li>

									<li
										class="kt-menu__item kt-menu__item--submenu"
										aria-haspopup="true"
										data-ktmenu-submenu-toggle="hover"
									>
										<router-link
											class="kt-menu__link kt-menu__toggle"
											to="/whatsapp-messages"
										>
											<span class="kt-menu__link-icon"
												><span class="material-icons md-18">chat_bubble_outline</span></span
											><span class="kt-menu__link-text"> Whatsapp Messages</span>
										</router-link>
									</li>
								<li
									class="kt-menu__item kt-menu__item--submenu"
									aria-haspopup="true"
									data-ktmenu-submenu-toggle="hover"
								>
									<router-link
										class="kt-menu__link kt-menu__toggle"
										to="/notes"
									>
										<span class="kt-menu__link-icon"
											><span class="material-icons md-18">edit_note</span></span
										><span class="kt-menu__link-text">Notes</span>
									</router-link>
								</li>
								<li
									class="kt-menu__item kt-menu__item--submenu"
									aria-haspopup="true"
									data-ktmenu-submenu-toggle="hover"
								>
									<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
										<span class="kt-menu__link-icon"
											><span class="material-icons md-18"
												>assignment</span
											></span
										><span class="kt-menu__link-text">Expenses</span
										><i class="kt-menu__ver-arrow la la-angle-right"></i>
									</a>
									<div class="kt-menu__submenu">
										<span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
											<li
												class="kt-menu__item kt-menu__item--parent"
												aria-haspopup="true"
											>
												<span class="kt-menu__link"
													><span class="kt-menu__link-text"
														>Expenses</span
													></span
												>
											</li>
											<li
												class="kt-menu__item kt-menu__item--submenu"
												aria-haspopup="true"
												data-ktmenu-submenu-toggle="hover"
											>
												<router-link
													to="/expenses/all"
													class="kt-menu__link kt-menu__toggle"
													><i
														class="
															kt-menu__link-bullet kt-menu__link-bullet--line
														"
														><span></span></i
													><span class="kt-menu__link-text"
														>Expenses</span
													></router-link
												>
											</li>
											<li
												class="kt-menu__item kt-menu__item--submenu"
												aria-haspopup="true"
												data-ktmenu-submenu-toggle="hover"
											>
												<router-link
													to="/expenses/categories"
													class="kt-menu__link kt-menu__toggle"
													><i
														class="
															kt-menu__link-bullet kt-menu__link-bullet--line
														"
														><span></span></i
													><span class="kt-menu__link-text"
														>Expense Categories</span
													></router-link
												>
											</li>
										</ul>
									</div>
								</li>
								<li
									class="kt-menu__item kt-menu__item--submenu"
									aria-haspopup="true"
									data-ktmenu-submenu-toggle="hover"
								>
									<router-link
										class="kt-menu__link kt-menu__toggle"
										to="/settings"
									>
										<span class="kt-menu__link-icon"
											><span class="material-icons md-18">settings</span></span
										><span class="kt-menu__link-text">Settings</span>
									</router-link>
								</li>
								<li class="kt-menu__item" aria-haspopup="true">
									<router-link to="/products-brands-list" class="kt-menu__link">
										<span class="kt-menu__link-icon">
											<span class="material-icons md-18">flag</span>
										</span>
										<span class="kt-menu__link-text">Vehicle Brands</span>
									</router-link>
								</li>
								<li class="kt-menu__item" aria-haspopup="true">
									<router-link to="/products-types-list" class="kt-menu__link">
										<span class="kt-menu__link-icon">
											<span class="material-icons md-18">list</span>
										</span>
										<span class="kt-menu__link-text">Vehicle Type</span>
									</router-link>
								</li>
								<li class="kt-menu__item" aria-haspopup="true">
									<router-link to="/products" class="kt-menu__link">
										<span class="kt-menu__link-icon">
											<span class="material-icons md-18">	directions_car</span>
										</span>
										<span class="kt-menu__link-text">Vehicles</span>
									</router-link>
								</li>
								<li class="kt-menu__item" aria-haspopup="true">
									<router-link to="/blogs" class="kt-menu__link">
										<span class="kt-menu__link-icon">
											<span class="material-icons md-18">book</span>
										</span>
										<span class="kt-menu__link-text">Blogs</span>
									</router-link>
								</li>
								<li class="kt-menu__item" aria-haspopup="true">
									<router-link to='/blog-categories' class="kt-menu__link">
										<span class="kt-menu__link-icon">
											<span class="material-icons md-18">category</span>
										</span>
										<span class="kt-menu__link-text">Blog Category</span>
									</router-link>
								</li>
								<li
									class="kt-menu__item kt-menu__item--submenu"
									aria-haspopup="true"
									data-ktmenu-submenu-toggle="hover"
								>
									<a
										href="javascript:;"
										class="kt-menu__link kt-menu__toggle"
										@click="logout"
									>
										<span class="kt-menu__link-icon"
											><span class="material-icons md-18">logout</span></span
										><span class="kt-menu__link-text">Logout</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<!-- end:: Aside Menu -->
				</div>
				<!-- end:: Aside -->

				<div
					class="
						kt-grid__item kt-grid__item--fluid
						kt-grid kt-grid--hor
						kt-wrapper
					"
					id="kt_wrapper"
				>
					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid__item kt-header--fixed">
						<!-- begin:: Header Menu -->
						<div
							class="kt-header-menu-wrapper"
							id="kt_header_menu_wrapper"
						></div>
						<!-- end:: Header Menu -->
						<!-- begin:: Header Topbar -->
						<div class="kt-header__topbar">
							<!--begin: User Bar -->
							<div class="kt-header__topbar-item kt-header__topbar-item--user">
								<div
									class="kt-header__topbar-wrapper"
									data-toggle="dropdown"
									data-offset="0px,0px"
								>
									<div class="kt-header__topbar-user">
										<span class="kt-header__topbar-welcome kt-hidden-mobile"
											>Hi,</span
										>
										<span class="kt-header__topbar-username kt-hidden-mobile">{{
											$authUser.name
										}}</span>
										<!-- <img class="kt-hidden" alt="Pic" src="../../themes/metronic/theme/default/demo1/dist/assets/media/users/300_25.jpg" /> -->
										<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
										<span
											class="
												kt-badge
												kt-badge--username
												kt-badge--unified-success
												kt-badge--lg
												kt-badge--rounded
												kt-badge--bold
											"
											>{{ $authUser.name.charAt(0) }}</span
										>
									</div>
								</div>

								<div
									class="
										dropdown-menu
										dropdown-menu-fit
										dropdown-menu-right
										dropdown-menu-anim
										dropdown-menu-top-unround
										dropdown-menu-xl
									"
								>
									<!--begin: Head -->
									<div
										class="
											kt-user-card kt-user-card--skin-dark
											kt-notification-item-padding-x
										"
										style="background-image: url()"
									>
										<div class="kt-user-card__avatar">
											<!-- <img class="kt-hidden" alt="Pic" src="../../themes/metronic/theme/default/demo1/dist/assets/media/users/300_25.jpg" /> -->
											<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
											<span
												class="
													kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold
													kt-font-success
												"
												style="margin-left: 20px"
												>{{ $authUser.name }}</span
											>
										</div>
									</div>
									<!--end: Head -->

									<!--begin: Navigation -->
									<div class="kt-notification">
										<div class="kt-notification__custom kt-space-between">
											<a
												href="javascript:;"
												@click="logout"
												class="btn btn-label btn-label-brand btn-sm btn-bold"
												>Sign Out</a
											>
										</div>
									</div>
									<!--end: Navigation -->
								</div>
							</div>
							<!--end: User Bar -->
						</div>
						<!-- end:: Header Topbar -->
					</div>
					<!-- end:: Header -->
					<router-view> </router-view>
					<!-- begin:: Footer -->
					<div
						class="
							kt-footer
							kt-grid__item
							kt-grid kt-grid--desktop kt-grid--ver-desktop
						"
						id="kt_footer"
					>
						<div class="kt-container kt-container--fluid">
							<div class="kt-footer__copyright">
								{{ new Date().getFullYear() }}&nbsp;&copy;&nbsp;{{
									$settings.footerText
								}}
								<!-- . Developed By&nbsp;<a
									href="https://cyberifydesigns.co.uk"
									target="_blank"
									class="kt-link"
									>Cyberify Designs</a
								> -->
							</div>
						</div>
					</div>
					<!-- end:: Footer -->
				</div>
			</div>
		</div>
	</div>
	<div v-else>
		<router-view> </router-view>
	</div>
</template>
 
<script>
	export default {
		methods: {
			logout() {
				this.axios
					.post(`${this.$appUrl}logout`)
					.then((response) => {
						if (response.data.message == "success") {
							iziToast.success({
								title: "Congratulations",
								position: "topRight",
								message: "Logged Out Successfully!",
							});
							sessionStorage.removeItem("user");
							window.location.href = `${this.$baseUrl}`;
						}
					})
					.catch((err) => {
						iziToast.success({
							title: "Congratulations",
							position: "topRight",
							message: err.response.data,
						});
					})
					.finally(() => (this.loading = false));
			},
		},
	};
</script>