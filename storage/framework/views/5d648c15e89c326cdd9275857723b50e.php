<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<?php if(app()->bound('tenant')): ?>
        <title><?php echo e(!isset($page_title) ? get_tenant_option('business_name', get_option('site_title', config('app.name'))) : $page_title); ?></title>
		<?php else: ?>
        <title><?php echo e(!isset($page_title) ? get_option('site_title', config('app.name')) : $page_title); ?></title>
		<?php endif; ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

		<!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(get_favicon()); ?>">
		<link href="<?php echo e(asset('public/backend/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet">
		<link href="<?php echo e(asset('public/backend/plugins/sweet-alert2/css/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo e(asset('public/backend/plugins/animate/animate.css')); ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo e(asset('public/backend/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
	    <link href="<?php echo e(asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.css')); ?>" rel="stylesheet" />
		<link href="<?php echo e(asset('public/backend/plugins/daterangepicker/daterangepicker.css')); ?>" rel="stylesheet" />

		<!-- App Css -->
        <link rel="stylesheet" href="<?php echo e(asset('public/backend/plugins/bootstrap/css/bootstrap.min.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/fontawesome.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/themify-icons.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/plugins/metisMenu/metisMenu.css')); ?>">

		<?php if(isset(request()->tenant->id)): ?>
			<?php if(get_tenant_option('backend_direction') == "rtl"): ?>
			<link rel="stylesheet" href="<?php echo e(asset('public/backend/plugins/bootstrap/css/bootstrap-rtl.min.css')); ?>">
			<?php endif; ?>
		<?php else: ?>
			<?php if(get_option('backend_direction') == "rtl"): ?>
			<link rel="stylesheet" href="<?php echo e(asset('public/backend/plugins/bootstrap/css/bootstrap-rtl.min.css')); ?>">
			<?php endif; ?>
		<?php endif; ?>

		<!-- Conditionals CSS -->
		<?php echo $__env->make('layouts.others.import-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<!-- Others css -->
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/typography.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/default-css.css')); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/styles.css') . '?v=' . filemtime(public_path('backend/assets/css/styles.css'))); ?>">
		<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/responsive.css?v=1.0')); ?>">

		<!-- Modernizr -->
		<script src="<?php echo e(asset('public/backend/assets/js/vendor/modernizr-3.6.0.min.js')); ?>"></script>

		<?php if(isset(request()->tenant->id)): ?>
			<?php if(get_tenant_option('backend_direction') == "rtl"): ?>
			<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/rtl/style.css?v=1.0')); ?>">
			<?php endif; ?>
		<?php else: ?>
			<?php if(get_option('backend_direction') == "rtl"): ?>
			<link rel="stylesheet" href="<?php echo e(asset('public/backend/assets/css/rtl/style.css?v=1.0')); ?>">
			<?php endif; ?>
		<?php endif; ?>

		<?php echo $__env->make('layouts.others.languages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </head>

    <body>
		<!-- Main Modal -->
		<div id="main_modal" class="modal" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
				    <div class="modal-header">
						<h5 class="modal-title ml-2"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true"><i class="ti-close text-danger"></i></span>
						</button>
				    </div>

				    <div class="alert alert-danger d-none mx-4 mt-3 mb-0"></div>
				    <div class="alert alert-primary d-none mx-4 mt-3 mb-0"></div>
				    <div class="modal-body overflow-hidden"></div>

				</div>
		    </div>
		</div>

		<!-- Secondary Modal -->
		<div id="secondary_modal" class="modal" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				    <div class="modal-header">
						<h5 class="modal-title ml-2"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true"><i class="ti-close text-danger"></i></span>
						</button>
				    </div>

				    <div class="alert alert-danger d-none mx-4 mt-3 mb-0"></div>
				    <div class="alert alert-primary d-none mx-4 mt-3 mb-0"></div>
				    <div class="modal-body overflow-hidden"></div>
				</div>
		    </div>
		</div>

		<!-- Preloader area start -->
		<div id="preloader">
			<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
		</div>
		<!-- Preloader area end -->

		<?php $user_type = auth()->user()->user_type; ?>

		<div class="page-container">
		    <!-- sidebar menu area start -->
			<div class="sidebar-menu">
				<div class="extra-details">
					<a href="<?php echo e($user_type == 'superadmin' ? route('admin.dashboard.index') : route('dashboard.index')); ?>">
						<img class="sidebar-logo" src="<?php echo e(get_logo()); ?>" alt="logo">
					</a>
				</div>

				<div class="main-menu">
					<div class="menu-inner">
						<nav>
							<ul class="metismenu <?php echo e($user_type == 'user' ? 'staff-menu' : ''); ?>" id="menu">
							<?php echo $__env->make('layouts.menus.'.Auth::user()->user_type, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
			<!-- sidebar menu area end -->

			<!-- main content area start -->
			<div class="main-content">
				<!-- header area start -->
				<div class="header-area">
					<div class="row align-items-center">
						<!-- nav and search button -->
						<div class="col-lg-6 col-4 clearfix rtl-2">
							<div class="nav-btn float-left">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>

						<!-- profile info & task notification -->
						<div class="col-lg-6 col-8 clearfix rtl-1">
							<ul class="notification-area float-right d-flex align-items-center">
	                            <li class="dropdown d-none d-sm-inline-block">
									<div class="dropdown">
									  <a class="dropdown-toggle d-flex align-items-center" type="button" id="selectLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<img class="avatar avatar-xss avatar-circle mr-1" src="<?php echo e(get_language() == 'language' ? asset('public/backend/plugins/flag-icon-css/flags/1x1/us.svg') : asset('public/backend/plugins/flag-icon-css/flags/1x1/'.explode('---', get_language())[1].'.svg')); ?>">
										<span class="d-none d-md-inline-block"><?php echo e(explode('---', get_language())[0]); ?></span>
										<i class="fa fa-angle-down ml-1"></i>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="selectLanguage">
										<?php $__currentLoopData = get_language_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<a class="dropdown-item" href="<?php echo e(route('switch_language')); ?>?language=<?php echo e($language); ?>"><img class="avatar avatar-xss avatar-circle mr-1" src="<?php echo e(asset('public/backend/plugins/flag-icon-css/flags/1x1/'.explode('---', $language)[1].'.svg')); ?>"> <?php echo e(explode('---', $language)[0]); ?></a>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									  </div>
									</div>
								</li>

								<?php if(auth()->user()->user_type == 'customer'): ?>
									<?php $notifications = Auth::user()->member->notifications->take(15); ?>
									<?php $unreadNotification = Auth::user()->member->unreadNotifications(); ?>
								<?php else: ?>
									<?php $notifications = Auth::user()->notifications->take(15); ?>
									<?php $unreadNotification = Auth::user()->unreadNotifications(); ?>
								<?php endif; ?>

								<li class="dropdown d-none d-sm-inline-block">
									<i class="ti-bell dropdown-toggle" data-toggle="dropdown">
										<span><?php echo e($unreadNotification->count()); ?></span>
									</i>
									<div class="dropdown-menu bell-notify-box notify-box">
										<span class="notify-title text-center">
											<?php if($unreadNotification->count() > 0): ?>
											<?php echo e(_lang('You have').' '.$unreadNotification->count().' '._lang('new notifications')); ?>

											<?php else: ?>
											<?php echo e(_lang("You don't have any new notification")); ?>

											<?php endif; ?>
										</span>
										<div class="nofity-list">
											<?php if($notifications->count() == 0): ?>
												<small class="text-center d-block py-2"><?php echo e(_lang('No Notification found')); ?> !</small>
											<?php endif; ?>

											<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<a href="<?php echo e(route('profile.show_notification', $notification->id)); ?>" class="d-flex ajax-modal notify-item" data-title="<?php echo e($notification->data['subject']); ?>">
												<div class="notify-thumb <?php echo e($notification->read_at == null ? 'unread-thumb' : ''); ?>"></div>
												<div class="notify-text <?php echo e($notification->read_at == null ? 'font-weight-bold' : ''); ?>">
													<p><i class="far fa-bell"></i> <?php echo e($notification->data['subject']); ?></p>
													<p><span><?php echo e($notification->created_at->diffForHumans()); ?></span></p>
												</div>
											</a>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</div>
									</div>
								</li>

								<li>
									<div class="user-profile">
										<h4 class="user-name dropdown-toggle" data-toggle="dropdown">
											<img class="avatar user-thumb" id="my-profile-img" src="<?php echo e(profile_picture()); ?>" alt="avatar"> <?php echo e(Auth::user()->name); ?> <i class="fa fa-angle-down"></i>
										</h4>
										<div class="dropdown-menu">
											<?php if(auth()->user()->user_type == 'customer'): ?>
											<a class="dropdown-item" href="<?php echo e(route('profile.membership_details')); ?>"><i class="ti-user text-muted mr-2"></i><?php echo e(_lang('Membership Details')); ?></a>
											<?php endif; ?>

											<?php $isAadminRoute = auth()->user()->user_type == 'superadmin' ? 'admin.' : ''; ?>
											<a class="dropdown-item" href="<?php echo e(route($isAadminRoute.'profile.edit')); ?>"><i class="ti-pencil text-muted mr-2"></i><?php echo e(_lang('Profile Settings')); ?></a>
											<a class="dropdown-item" href="<?php echo e(route($isAadminRoute.'profile.change_password')); ?>"><i class="ti-exchange-vertical text-muted mr-2"></i></i><?php echo e(_lang('Change Password')); ?></a>
											
											<?php if(auth()->user()->user_type == 'admin'): ?>
											<a class="dropdown-item" href="<?php echo e(route('settings.index')); ?>"><i class="ti-settings text-muted mr-2"></i><?php echo e(_lang('System Settings')); ?></a>
											<?php endif; ?>

											<?php if(auth()->user()->user_type == 'admin' && auth()->user()->tenant_owner == 1): ?>
											<a class="dropdown-item" href="<?php echo e(route('membership.index')); ?>"><i class="ti-crown text-muted mr-2"></i><?php echo e(_lang('My Subscription')); ?></a>
											<?php endif; ?>

											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><i class="ti-power-off text-muted mr-2"></i><?php echo e(_lang('Logout')); ?></a>
										</div>
									</div>
	                            </li>

	                        </ul>

						</div>
					</div>
				</div><!-- header area end -->

				<!-- Page title area start -->
				<?php if(Request::is('dashboard') || Request::is('*/dashboard')): ?>
				<div class="page-title-area">
					<div class="row align-items-center py-3">
						<div class="col-sm-12">
							<div class="d-flex align-items-center justify-content-between">
								<h6><?php echo e(_lang('Dashboard')); ?></h6>

								<!--Branch Switcher-->
								<?php if(auth()->user()->user_type == 'admin' || auth()->user()->all_branch_access == 1): ?>
								<div class="dropdown">
									<a class="dropdown-toggle btn btn-dark btn-xs" type="button" id="selectLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php echo e(session('branch') =='' ? _lang('All Branch') : session('branch')); ?>

									</a>
									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="selectLanguage">
										<a class="dropdown-item" href="<?php echo e(route('switch_branch')); ?>"><?php echo e(_lang('All Branch')); ?></a>
										<a class="dropdown-item" href="<?php echo e(route('switch_branch')); ?>?branch_id=default&branch=<?php echo e(get_option('default_branch_name', 'Main Branch')); ?>"><?php echo e(get_option('default_branch_name', 'Main Branch')); ?></a>
										<?php $__currentLoopData = \App\Models\Branch::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<a class="dropdown-item" href="<?php echo e(route('switch_branch')); ?>?branch_id=<?php echo e($branch->id); ?>&branch=<?php echo e($branch->name); ?>"><?php echo e($branch->name); ?></a>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div><!-- page title area end -->
				<?php endif; ?>

				<div class="main-content-inner mt-4">
					<div class="row">
						<div class="<?php echo e(isset($alert_col) ? $alert_col : 'col-lg-12'); ?>">

							<?php if(auth()->user()->user_type == 'admin' && auth()->user()->tenant_owner == 1 && request()->tenant->membership_type == 'trial'): ?>
							<div class="alert alert-warning alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true"><i class="far fa-times-circle"></i></span>
								</button>
								<span><i class="fas fa-info-circle mr-2"></i><?php echo e(_lang('Your trial period will end on').' '.request()->tenant->valid_to); ?></span>
							</div>
							<?php endif; ?>

							<div class="alert alert-success alert-dismissible" id="main_alert" role="alert">
								<button type="button" id="close_alert" class="close">
									<span aria-hidden="true"><i class="far fa-times-circle"></i></span>
								</button>
								<span class="msg"></span>
							</div>
						</div>
					</div>

					<?php echo $__env->yieldContent('content'); ?>
				</div><!--End main content Inner-->

			</div><!--End main content-->

		</div><!--End Page Container-->

        <!-- jQuery  -->
		<script src="<?php echo e(asset('public/backend/assets/js/vendor/jquery-3.7.1.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/assets/js/popper.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/metisMenu/metisMenu.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/assets/js/print.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/pace/pace.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/backend/plugins/moment/moment.js')); ?>"></script>

		<!-- Conditional JS -->
        <?php echo $__env->make('layouts.others.import-js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<script src="<?php echo e(asset('public/backend/plugins/dropify/js/dropify.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/sweet-alert2/js/sweetalert2.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/select2/js/select2.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/parsleyjs/parsley.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
		<script src="<?php echo e(asset('public/backend/plugins/slimscroll/jquery.slimscroll.min.js')); ?>"></script>

        <!-- App js -->
        <script src="<?php echo e(asset('public/backend/assets/js/scripts.js'). '?v=' . filemtime(public_path('backend/assets/js/scripts.js'))); ?>"></script>

		<?php echo $__env->make('layouts.others.alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<!-- Custom JS -->
		<?php echo $__env->yieldContent('js-script'); ?>
    </body>
</html>
<?php /**PATH D:\My Projects\laravel\updated\resources\views/layouts/app.blade.php ENDPATH**/ ?>