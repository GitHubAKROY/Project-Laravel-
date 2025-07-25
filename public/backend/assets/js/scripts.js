(function($) {
    "use strict";

    /*================================
    Preloader
    ==================================*/
    var preloader = $('#preloader');
    $(window).on('load', function() {
        setTimeout(function() {
            preloader.fadeOut('slow');
			$(".staff-menu").fadeIn();
        }, 300)
    });

    /*================================
    Sidebar collapsing
    ==================================*/
    if (window.innerWidth <= 1364) {
        $('.page-container').addClass('sbar_collapsed');
    }
    $('.nav-btn').on('click', function() {
    	$('.page-container').toggleClass('sbar_collapsed');  
    });

	
	/*================================
    Active Sidebar Menu
    ==================================*/
    $("#menu li a").each(function () {
        var path = window.location.href;
        if ($(this).attr("href") == path) {
            $("#menu li").removeClass("active-nav");
            $(this).parent().addClass("active-nav");
            $(this).parent().parent().parent().addClass("active-nav active");
        }
    });

    /*================================
    Init Tooltip 
    ==================================*/

    $('[data-toggle="tooltip"]').tooltip();
	
	/*================================
    Hide Empty Menu 
    ==================================*/
	$("#menu li").each(function(){
		var elem = $(this);
		if($(elem).has("ul").length > 0){
			if($(elem).find("ul").has("li").length === 0){
				$(elem).remove();
			}		
		}
	}); 

    /*================================
    sidebar menu
    ==================================*/
    $("#menu").metisMenu();

    /*================================
    slimscroll activation
    ==================================*/
	if(jQuery().slimscroll) {
		$('.nofity-list').slimScroll({
			height: '435px'
		});
		
		$('.timeline-area').slimScroll({
			height: '500px'
		});
		
		$('.recent-activity').slimScroll({
			height: 'calc(100vh - 114px)'
		});

		$('.settings-list').slimScroll({
			height: 'calc(100vh - 158px)'
		});

		$('.crm-scroll').slimscroll({
			railVisible: true,
			railColor: '#7f8c8d',
			height: '500px',
			alwaysVisible: true,
		});

		$('.card-scroll').slimscroll({
			railColor: '#7f8c8d',
			height: '400px',
		});

		$("#kanban-view .cards").slimscroll({
			railVisible: true,
			railColor: '#7f8c8d',
			height: '500px',
		});
	}

    /*================================
    stickey Header
    ==================================*/
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop(),
            mainHeader = $('#sticky-header'),
            mainHeaderHeight = mainHeader.innerHeight();

        // console.log(mainHeader.innerHeight());
        if (scroll > 1) {
            $("#sticky-header").addClass("sticky-menu");
        } else {
            $("#sticky-header").removeClass("sticky-menu");
        }
    });

    /*================================
    form bootstrap validation
    ==================================*/
    $('[data-toggle="popover"]').popover()

    /*------------- Start form Validation -------------*/
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);


    /*================================
    			login form
    ==================================*/
    $('.form-gp input').on('focus', function() {
        $(this).parent('.form-gp').addClass('focused');
    });
    $('.form-gp input').on('focusout', function() {
        if ($(this).val().length === 0) {
            $(this).parent('.form-gp').removeClass('focused');
        }
    });

    /*================================
      slider-area background setting
    ==================================*/
    $('.settings-btn, .offset-close').on('click', function() {
        $('.offset-area').toggleClass('show_hide');
        $('.settings-btn').toggleClass('active');
    });

    /*================================
    		Fullscreen Page
    ==================================*/
	if ($('#full-view').length) {

		var requestFullscreen = function (ele) {
			if (ele.requestFullscreen) {
				ele.requestFullscreen();
			} else if (ele.webkitRequestFullscreen) {
				ele.webkitRequestFullscreen();
			} else if (ele.mozRequestFullScreen) {
				ele.mozRequestFullScreen();
			} else if (ele.msRequestFullscreen) {
				ele.msRequestFullscreen();
			} else {
				console.log('Fullscreen API is not supported.');
			}
		};

		var exitFullscreen = function () {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			} else {
				console.log('Fullscreen API is not supported.');
			}
		};

		var fsDocButton = document.getElementById('full-view');
		var fsExitDocButton = document.getElementById('full-view-exit');

		fsDocButton.addEventListener('click', function (e) {
			e.preventDefault();
			requestFullscreen(document.documentElement);
			$('body').addClass('expanded');
		});

		fsExitDocButton.addEventListener('click', function (e) {
			e.preventDefault();
			exitFullscreen();
			$('body').removeClass('expanded');
		});
	}

	//App Js	
	$(document).ajaxStart(function () {
		Pace.restart();
	});

	$(document).on('submit', 'form', function() {
	    $(this).find(":submit").prop('disabled', true);
	});

	$(document).on('click', '.btn-remove-2', function () {
		var link = $(this).attr('href');
		var message = $(this).data("message");
		//Sweet Alert for delete action
		Swal.fire({
			title: $lang_alert_title,
			text: message ?? $lang_alert_message,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: $lang_confirm_button_text,
			cancelButtonText: $lang_cancel_button_text
		}).then((result) => {
			if (result.value) {
				window.location.href = link;
			}
		});

		return false;
	});

	$(document).on('click', '.btn-remove', function () {
		var message = $(this).data("message");
		//Sweet Alert for delete action
		Swal.fire({
			title: $lang_alert_title,
			text: message ?? $lang_alert_message,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: $lang_confirm_button_text,
			cancelButtonText: $lang_cancel_button_text
		}).then((result) => {
			if (result.value) {
				$(this).closest('form').submit();
			}
		});

		return false;
	});

	$(document).on('click','.toggle-optional-fields', function(e){
		e.preventDefault();

		$(".optional-field").toggleClass('show');
		var label = $(this).data('toggle-title');
		$(this).data('toggle-title', $(this).html());
		$(this).html(label);
	});

	if ($(".select2").length) {
        $(".select2").each(function (i, obj) {
            $(this).select2({
                placeholder: $(this).data('placeholder') ?? null,
            });
        });
    }


	/** Init Datepicker **/
	init_datepicker();


	$('.dropify').dropify();

	/** Init DateTimepicker **/
	$('.datetimepicker').daterangepicker({
		timePicker: true,
		timePicker24Hour: true,
		singleDatePicker: true,
		showDropdowns: true,
		locale: {
			format: 'YYYY-MM-DD HH:mm'
		}
	});

	/** Init Timepicker **/
	$('.timepicker').daterangepicker({
			timePicker : true,
			singleDatePicker:true,
			timePicker24Hour : true,
			timePickerIncrement : 1,
			timePickerSeconds : false,
			locale : {
				format : 'HH:mm'
			}
		}).on('show.daterangepicker', function(ev, picker) {
			picker.container.find(".calendar-table").hide();
	});


	//Form validation
	if ($('.validate').length) {
		$('.validate').parsley();
	}

	init_editor();

	$(".float-field").on('keypress', function (event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
			(event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

	$(".int-field").on('keypress', function (event) {
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

	$(document).on('click', '#modal-fullscreen', function () {
		$("#main_modal >.modal-dialog").toggleClass("fullscreen-modal");
	});

	$(document).on('click', '#close_alert', function () {
		$("#main_alert").fadeOut();
	});


	//File Upload Field
	$(".file-uploader").after("<input type='text' class='form-control filename' readOnly>"
		+ "<button type='button' class='btn btn-primary file-uploader-btn'>Browse</button>");

	$(".file-uploader").each(function () {
		if ($(this).data("placeholder")) {
			$(this).parent().find(".filename").prop('placeholder', $(this).data("placeholder"));
		}
		if ($(this).data("value")) {
			$(this).parent().find(".filename").val($(this).data("value"));
		}
		if ($(this).attr("required")) {
			$(this).parent().find(".filename").prop("required", true);
		}
	});

	$(document).on("click", ".file-uploader-btn", function () {
		$(this).parent().find("input[type=file]").click();
	});

	$(document).on('change', '.file-uploader', function () {
		readFileURL(this);
	});


	if (
		$("input:required, select:required, textarea:required")
		.closest(".form-group")
		.find(".required").length == 0
	) {
		// INITIALIZATION REQUIRED FIELDS SIGN
		$("input:required, select:required, textarea:required, file:required")
		.closest(".form-group, .row")
		.find("label.form-label, label.col-form-label, label.control-label")
		.append("<span class='required'> *</span>");
	}
	

	//Print Command
	$(document).on('click', '.print', function (event) {
		event.preventDefault();
		$("#preloader").css("display", "block");
		var div = "#" + $(this).data("print");
		$(div).print({
			timeout: 1000,
		});
	});

	//Ajax Select2
	if ($(".select2-ajax").length) {
		$('.select2-ajax').each(function (i, obj) {
			var display2 = "";
			var divider = "";
			var modal = "ajax-modal-2";

			if (typeof $(this).data('display2') !== "undefined") {
				display2 = "&display2=" + $(this).data('display2');
			}

			if (typeof $(this).data('divider') !== "undefined") {
				divider = "&divider=" + $(this).data('divider');
			}

			if(typeof $(this).data('modal') !== "undefined"){
				modal = $(this).data('modal');
			}

			$(this).select2({
				//theme: "classic",
				allowClear: true,
				placeholder: typeof $(this).data('placeholder') !== "undefined" ? $(this).data('placeholder') : $lang_select_one,
				ajax: {
					url: _tenant_url + '/ajax/get_table_data?table=' + $(this).data('table') + '&value=' + $(this).data('value') + '&display=' + $(this).data('display') + display2 + divider + '&where=' + $(this).data('where'),
					processResults: function (data) {
						return {
							results: data
						};
					}
				}
			}).on('select2:open', () => {
				target_select = $(this); // First Level
				if(typeof $(this).data('href') !== "undefined"){
					$(".select2-results:not(:has(a))").append('<p class="border-top m-0 p-2"><a class="'+ modal +'" href="'+ $(this).data('href') +'" data-title="'+ $(this).data('title') +'" data-reload="false"><i class="fas fa-plus-circle mr-1"></i>'+ $lang_add_new +'</a></p>');
				}
			});

		});
	}

	//Ajax Modal Function
	var previous_select;
	var target_select;
	$(document).on("click", ".ajax-modal", function () {
		var link = $(this).data("href");
		if (typeof link == 'undefined') {
			link = $(this).attr("href");
		}

		var title = $(this).data("title");
		var fullscreen = $(this).data("fullscreen");
		var reload = $(this).data("reload");

		$.ajax({
			url: link,
			beforeSend: function () {
				$("#preloader").css("display", "block");
			}, success: function (data) {
				$("#preloader").css("display", "none");
				$('#main_modal .modal-title').html(title);
				$('#main_modal .modal-body').html(data);
				$("#main_modal .alert-primary").addClass('d-none');
				$("#main_modal .alert-danger").addClass('d-none');
				$('#main_modal').modal('show');

				if (fullscreen == true) {
					$("#main_modal >.modal-dialog").addClass("fullscreen-modal");
				} else {
					$("#main_modal >.modal-dialog").removeClass("fullscreen-modal");
				}

				if (reload == false) {
					target_select.select2('close');
					$("#main_modal .ajax-submit, #main_modal .ajax-screen-submit").attr('data-reload', false);
				}

				//init Essention jQuery Library
				if ($('.ajax-submit').length) {
					$('.ajax-submit').parsley();
				}

				if ($('.ajax-screen-submit').length) {
					$('.ajax-screen-submit').parsley();
				}

				init_editor();

				/** Init Datepicker **/
				init_datepicker();

				/** Init Colorpicker **/
				if($('.color-picker').length){
					$('.color-picker').colorpicker();
				}

				/** Init DateTimepicker **/
				$('.datetimepicker').daterangepicker({
					timePicker: true,
					timePicker24Hour: true,
					singleDatePicker: true,
					showDropdowns: true,
					locale: {
						format: 'YYYY-MM-DD HH:mm'
					}
				});

				/** Init Timepicker **/
				$('.timepicker').daterangepicker({
						timePicker : true,
						singleDatePicker:true,
						timePicker24Hour : true,
						timePickerIncrement : 1,
						timePickerSeconds : false,
						locale : {
							format : 'HH:mm'
						}
					}).on('show.daterangepicker', function(ev, picker) {
						picker.container.find(".calendar-table").hide();
				});


				$(".float-field").keypress(function (event) {
					if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
						(event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});

				$(".int-field").keypress(function (event) {
					if ((event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});

				//Select2
				$("#main_modal select.select2").select2({
					//theme: "classic",
					dropdownParent: $("#main_modal .modal-content")
				});

				//Ajax Select2
				if ($("#main_modal .select2-ajax").length) {
					$('#main_modal .select2-ajax').each(function (i, obj) {

						var display2 = "";
						var divider = "";
						if (typeof $(this).data('display2') !== "undefined") {
							display2 = "&display2=" + $(this).data('display2');
						}

						if (typeof $(this).data('divider') !== "undefined") {
							divider = "&divider=" + $(this).data('divider');
						}

						$(this).select2({
							//theme: "classic",
							placeholder: $lang_select_one,
							ajax: {
								url: _tenant_url + '/ajax/get_table_data?table=' + $(this).data('table') + '&value=' + $(this).data('value') + '&display=' + $(this).data('display') + display2 + divider + '&where=' + $(this).data('where'),
								processResults: function (data) {
									return {
										results: data
									};
								}
							},
							dropdownParent: $("#main_modal .modal-content")
						}).on('select2:open', () => {
							if(target_select != null && previous_select == null){
								previous_select = target_select;
							}
							target_select = $(this); // 2nd level		
							
							$(".select2-results:not(:has(a))").append('<p class="border-top m-0 p-2"><a class="ajax-modal-2" href="'+ $(this).data('href') +'" data-title="'+ $(this).data('title') +'" data-reload="false"><i class="fas fa-plus-circle mr-1"></i>'+ $lang_add_new +'</a></p>');
						});;

					});
				}

				//Auto Selected
				if ($(".auto-select").length) {
					$('.auto-select').each(function (i, obj) {	
						$(this).val($(this).data('selected')).trigger('change');		
					})
				}

				$(".dropify").dropify();

				// INITIALIZATION REQUIRED FIELDS SIGN
				$("#main_modal .ajax-submit input:required, #main_modal .ajax-submit select:required, #main_modal .ajax-submit textarea:required")
					.closest(".form-group")
					.find("label.form-label, label.col-form-label, label.control-label")
					.append("<span class='required'> *</span>");
				
				$("#main_modal .ajax-screen-submit input:required, #main_modal .ajax-screen-submit select:required, #main_modal .ajax-screen-submit textarea:required")
					.closest(".form-group")
					.find("label.form-label, label.col-form-label, label.control-label")
					.append("<span class='required'> *</span>");
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});

		return false;
	});

	$("#main_modal").on('show.bs.modal', function () {
		$('#main_modal').css("overflow-y", "hidden");
	});

	$("#main_modal").on('shown.bs.modal', function () {
		$('#main_modal').css("overflow-y", "auto");
	});

	//Ajax Secondary Modal Function
	$(document).on("click", ".ajax-modal-2", function () {
		var link = $(this).attr("href");

		var title = $(this).data("title");
		var fullscreen = $(this).data("fullscreen");
		var reload = $(this).data("reload");

		$.ajax({
			url: link,
			beforeSend: function () {
				$("#preloader").css("display", "block");
			}, success: function (data) {
				$("#preloader").css("display", "none");
				$('#secondary_modal .modal-title').html(title);
				$('#secondary_modal .modal-body').html(data);
				$("#secondary_modal .alert-primary").addClass('d-none');
				$("#secondary_modal .alert-danger").addClass('d-none');
				$('#secondary_modal').modal('show');
				

				if (fullscreen == true) {
					$("#secondary_modal >.modal-dialog").addClass("fullscreen-modal");
				} else {
					$("#secondary_modal >.modal-dialog").removeClass("fullscreen-modal");
				}

				if (reload == false) {
					target_select.select2('close');
					$("#secondary_modal .ajax-submit, #secondary_modal .ajax-screen-submit").attr('data-reload', false);
				}

				//init Essention jQuery Library
				$("#secondary_modal select.select2").select2({
					//theme: "classic",
					dropdownParent: $("#secondary_modal .modal-content")
				});

				//$('.year').mask('0000-0000');
				if ($('.ajax-submit').length) {
					$('.ajax-submit').parsley();
				}

				if ($('.ajax-screen-submit').length) {
					$('.ajax-screen-submit').parsley();
				}

				/** Init Datepicker **/
				init_datepicker();

				/** Init Colorpicker **/
				if($('.color-picker').length){
					$('.color-picker').colorpicker();
				}

				$(".float-field").on('keypress', function (event) {
					if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
						(event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});

				$(".int-field").on('keypress', function (event) {
					if ((event.which < 48 || event.which > 57)) {
						event.preventDefault();
					}
				});

				//Ajax Select2
				if ($("#secondary_modal .select2-ajax").length) {
					$('#secondary_modal .select2-ajax').each(function (i, obj) {

						var display2 = "";
						var divider = "";
						if (typeof $(this).data('display2') !== "undefined") {
							display2 = "&display2=" + $(this).data('display2');
						}

						if (typeof $(this).data('divider') !== "undefined") {
							divider = "&divider=" + $(this).data('divider');
						}


						$(this).select2({
							//theme: "classic",
							placeholder: $lang_select_one,
							ajax: {
								url: _tenant_url + '/ajax/get_table_data?table=' + $(this).data('table') + '&value=' + $(this).data('value') + '&display=' + $(this).data('display') + display2 + divider + '&where=' + $(this).data('where'),
								processResults: function (data) {
									return {
										results: data
									};
								}
							}
						}).on('select2:open', () => {
							target_select = $(this);
							$(".select2-results:not(:has(a))").append('<p class="border-top m-0 p-2"><a class="ajax-modal-2" href="'+ $(this).data('href') +'" data-title="'+ $(this).data('title') +'" data-reload="false"><i class="fas fa-plus-circle mr-1"></i>'+ $lang_add_new +'</a></p>');
						});;

					});
				}

				$(".dropify").dropify();
				
				$("#secondary_modal input:required, #secondary_modal select:required, #secondary_modal textarea:required")
					.closest(".form-group")
					.find("label.form-label, label.col-form-label, label.control-label")
					.append("<span class='required'> *</span>");
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});

		return false;
	});

	$("#secondary_modal").on('show.bs.modal', function () {
		$('#secondary_modal').css("overflow-y", "hidden");
	});

	$("#secondary_modal").on('shown.bs.modal', function () {
		$('#secondary_modal').css("overflow-y", "auto");
	});


	//Ajax Modal Submit
	$(document).on("submit", ".ajax-submit", function () {
		var link = $(this).attr("action");
		var reload = $(this).data('reload');
		var current_modal = $(this).closest('.modal');

		var elem = $(this);
		$(elem).find("button[type=submit]").prop("disabled", true);

		$.ajax({
			method: "POST",
			url: link,
			data: new FormData(this),
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				$("#preloader").css("display", "block");
			}, success: function (data) {
				$(elem).find("button[type=submit]").attr("disabled", false);
				$("#preloader").css("display", "none");
				var json = JSON.parse(data);
				if (json['result'] == "success") {

					if (reload != false) {
						//Main Modal
						if (json['action'] == "store") {
							$('#main_modal .ajax-submit')[0].reset();
						}
						$("#main_modal .alert-primary").html(json['message']);
						$("#main_modal .alert-primary").removeClass('d-none');
						$("#main_modal .alert-danger").addClass('d-none');

						window.setTimeout(function () { window.location.reload() }, 500);
					} else {
						//Secondary Modal
						if (json['action'] == "store") {
							$(current_modal).find('.ajax-submit')[0].reset();
						}

						$(current_modal).find(".alert-primary").html(json['message']);
						$(current_modal).find(".alert-primary").removeClass('d-none');
						$(current_modal).find(".alert-danger").addClass('d-none');

						var select_value = json['data'][target_select.data('value')];
						var select_display = json['data'][target_select.data('display')];

						var newOption = new Option(select_display, select_value, true, true);
						target_select.append(newOption).trigger('change');
						$(current_modal).modal('hide');
					}

				} else {
					if (Array.isArray(json['message'])) {
						if (reload != false) {
							//Main Modal
							$("#main_modal .alert-danger").html("");
							jQuery.each(json['message'], function (i, val) {
								$("#main_modal .alert-danger").append("<span>" + val + "</span>");
							});
							$("#main_modal .alert-primary").addClass('d-none');
							$("#main_modal .alert-danger").removeClass('d-none');
						} else {
							//Secondary Modal
							$(current_modal).find(".alert-danger").html('');
							jQuery.each(json['message'], function (i, val) {
								$(current_modal).find(".alert-danger").append("<span>" + val + "</span>");
							});
							$(current_modal).find(".alert-primary").addClass('d-none');
							$(current_modal).find(".alert-danger").removeClass('d-none');
						}
					} else {
						if (reload != false) {
							$("#main_modal .alert-danger").html("<span>" + json['message'] + "</span>");
							$("#main_modal .alert-primary").addClass('d-none');
							$("#main_modal .alert-danger").removeClass('d-none');
						} else {
							$(current_modal).find(".alert-danger").html("<span>" + json['message'] + "</span>");
							$(current_modal).find(".alert-primary").addClass('d-none');
							$(current_modal).find(".alert-danger").removeClass('d-none');
						}
					}
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});

		return false;
	});

	//Ajax Modal Submit without loading
	$(document).on("submit", ".ajax-screen-submit", function () {
		var link = $(this).attr("action");
		var reload = $(this).data('reload');
		var current_modal = $(this).closest('.modal');

		var elem = $(this);
		$(elem).find("button[type=submit]").prop("disabled", true);

		$.ajax({
			method: "POST",
			url: link,
			data: new FormData(this),
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				$("#preloader").css("display", "block");
			}, success: function (data) {
				$(elem).find("button[type=submit]").attr("disabled", false);
				$("#preloader").css("display", "none");
				var json = JSON.parse(data);
				if (json['result'] == "success") {

					$(document).trigger('ajax-screen-submit');

					$.toast({
						text: json['message'],
						showHideTransition: 'slide',
						icon: 'success',
						position: 'top-right'
					});

					var table = json['table'];

					if (json['action'] == "update") {

						$(table + ' tr[data-id="row_' + json['data']['id'] + '"]').find('td').each(function () {
							if (typeof $(this).attr("class") != "undefined") {
								$(this).html(json['data'][$(this).attr("class").split(' ')[0]]);
							}
						});

					} else if (json['action'] == "store") {
						$(elem)[0].reset();
						var new_row = $(table).find('tbody').find('tr:eq(0)').clone();

						$(new_row).attr("data-id", "row_" + json['data']['id']);


						$(new_row).find('td').each(function () {
							if ($(this).attr("class") == "dataTables_empty") {
								window.location.reload();
							}
							if (typeof $(this).attr("class") != "undefined") {
								$(this).html(json['data'][$(this).attr("class").split(' ')[0]]);
							}
						});


						$(new_row).find('form').attr("action", link + "/" + json['data']['id']);
						$(new_row).find('.dropdown-edit').attr("data-href", link + "/" + json['data']['id'] + "/edit");
						$(new_row).find('.dropdown-view').attr("data-href", link + "/" + json['data']['id']);

						$(table).prepend(new_row);

						if (reload == false) {				
							var select_value = json['data'][target_select.data('value')];
							var select_display = json['data'][target_select.data('display')];

							var newOption = new Option(select_display, select_value, true, true);
							target_select.append(newOption).trigger('change');

							if(previous_select != null){
								var newOption = new Option(select_display, select_value, true, true);
								previous_select.append(newOption).trigger('change');					
							}
							$(current_modal).modal('hide');
						}

					}
					$(current_modal).modal('hide');
					$(current_modal).find(".alert-primary").addClass('d-none');
					$(current_modal).find(".alert-danger").addClass('d-none');

				} else if (json['result'] == "error") {

					$(current_modal).find(".alert-danger").html("");
					if (Array.isArray(json['message'])) {
						jQuery.each(json['message'], function (i, val) {
							$(current_modal).find(".alert-danger").append("<span>" + val + "</span>");
						});
						$(current_modal).find(".alert-primary").addClass('d-none');
						$(current_modal).find(".alert-danger").removeClass('d-none');
					} else {
						$(current_modal).find(".alert-danger").html("<span>" + json['message'] + "</span>");
						$(current_modal).find(".alert-primary").addClass('d-none');
						$(current_modal).find(".alert-danger").removeClass('d-none');
					}
				} else {
					$.toast({
						text: data.replace(/(<([^>]+)>)/ig, ""),
						showHideTransition: 'slide',
						icon: 'error',
						position: 'top-right'
					});
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});

		return false;
	});

	//Ajax Remove without loading
	$(document).on("click", ".ajax-get-remove", function () {
		var current_modal = $(this).closest('.modal');

		Swal.fire({
			title: $lang_alert_title,
			text: $lang_alert_message,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: $lang_confirm_button_text,
			cancelButtonText: $lang_cancel_button_text
		}).then((result) => {
			if (result.value) {
				var link = $(this).attr("href");
				$.ajax({
					method: "GET",
					url: link,
					beforeSend: function () {
						$("#preloader").css("display", "block");
					}, success: function (data) {
						$("#preloader").css("display", "none");

						var json = JSON.parse(JSON.stringify(data));
						console.log(json['result']);
						if (json['result'] == "success") {

							$.toast({
								text: json['message'],
								showHideTransition: 'slide',
								icon: 'success',
								position: 'top-right'
							});

							var table = json['table'];
							//$(table).find('#row_' + json['id']).remove();
							$(table + ' tr[data-id="row_' + json['id'] + '"]').remove();

						} else if (json['result'] == "error") {
							if (Array.isArray(json['message'])) {
								jQuery.each(json['message'], function (i, val) {
									$.toast({
										text: val,
										showHideTransition: 'slide',
										icon: 'error',
										position: 'top-right'
									});
								});

							} else {
								$.toast({
									text: json['message'],
									showHideTransition: 'slide',
									icon: 'error',
									position: 'top-right'
								});
							}
						} else {
							$.toast({
								text: data.replace(/(<([^>]+)>)/ig, ""),
								showHideTransition: 'slide',
								icon: 'error',
								position: 'top-right'
							});
						}
					},
					error: function (request, status, error) {
						console.log(request.responseText);
					}
				});
			}
		});

		return false;

	});


	//Ajax Remove without loading
	$(document).on("submit", ".ajax-remove", function (event) {
		event.preventDefault();

		var current_modal = $(this).closest('.modal');

		Swal.fire({
			title: $lang_alert_title,
			text: $lang_alert_message,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: $lang_confirm_button_text,
			cancelButtonText: $lang_cancel_button_text
		}).then((result) => {
			if (result.value) {
				var link = $(this).attr("action");
				$.ajax({
					method: "POST",
					url: link,
					data: $(this).serialize(),
					beforeSend: function () {
						$("#preloader").css("display", "block");
					}, success: function (data) {
						$("#preloader").css("display", "none");
						var json = JSON.parse(JSON.stringify(data));
						if (json['result'] == "success") {

							$.toast({
								text: json['message'],
								showHideTransition: 'slide',
								icon: 'success',
								position: 'top-right'
							});

							var table = json['table'];
							//$(table).find('#row_' + json['id']).remove();
							$(table + ' tr[data-id="row_' + json['id'] + '"]').remove();

						} else if (json['result'] == "error") {
							if (Array.isArray(json['message'])) {
								jQuery.each(json['message'], function (i, val) {
									$.toast({
										text: val,
										showHideTransition: 'slide',
										icon: 'error',
										position: 'top-right'
									});
								});

							} else {
								$.toast({
									text: json['message'],
									showHideTransition: 'slide',
									icon: 'error',
									position: 'top-right'
								});
							}
						} else {
							$.toast({
								text: data.replace(/(<([^>]+)>)/ig, ""),
								showHideTransition: 'slide',
								icon: 'error',
								position: 'top-right'
							});
						}
					},
					error: function (request, status, error) {
						console.log(request.responseText);
					}
				});
			}
		});

	});


	//Ajax submit without validate
	$(document).on("submit", ".settings-submit", function () {
		var elem = $(this);
		$(elem).find("button[type=submit]").prop("disabled", true);
		var link = $(this).attr("action");
		$.ajax({
			method: "POST",
			url: link,
			data: new FormData(this),
			mimeType: "multipart/form-data",
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				$("#preloader").fadeIn();
			}, success: function (data) {
				$("#preloader").fadeOut();
				$(elem).find("button[type=submit]").attr("disabled", false);
				var json = JSON.parse(data);

				if (json['result'] == "success") {
					$("#main_alert > span.msg").html(json['message']);
					$("#main_alert").addClass("alert-success").removeClass("alert-danger");
					$("#main_alert").css('display', 'block');
				} else {
					if (Array.isArray(json['message'])) {
						$("#main_alert > span.msg").html("");
						$("#main_alert").addClass("alert-danger").removeClass("alert-success");

						jQuery.each(json['message'], function (i, val) {
							$("#main_alert > span.msg").append('<i class="ti-alert"></i> ' + val + '<br>');
						});
						$("#main_alert").css('display', 'block');
					} else {
						$("#main_alert > span.msg").html("");
						$("#main_alert").addClass("alert-danger").removeClass("alert-success");
						$("#main_alert > span.msg").html(json['message']);
						$("#main_alert").css('display', 'block');
					}
				}
			},
			error: function (request, status, error) {
				console.log(request.responseText);
			}
		});

		return false;
	});

	//Auto Selected
	if ($(".auto-select").length) {
		$('.auto-select').each(function (i, obj) {
			$(this).val($(this).data('selected')).trigger('change');
		})
	}

	if ($(".auto-multiple-select").length) {
		$('.auto-multiple-select').each(function (i, obj) {
			var values = $(this).data('selected');
			$(this).val(values).trigger('change');
		})
	}

	$(document).on('change', '.c-select', function(){
		if($(this).data('condition') == $(this).val()){
			$('.' + $(this).data('show')).removeClass('d-none');
		}else{
			$('.' + $(this).data('show')).addClass('d-none');
		}
	});

	if(jQuery().DataTable) {
		if ($(".data-table").length) {
			$('.data-table').each(function (i, obj) {
				var table = $(this).DataTable({
					responsive: true,
					"bAutoWidth": false,
					"ordering": false,
					//"lengthChange": false,
					"dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
					"language": {
						"decimal": "",
						"emptyTable": $lang_no_data_found,
						"info": $lang_showing + " _START_ " + $lang_to + " _END_ " + $lang_of + " _TOTAL_ " + $lang_entries,
						"infoEmpty": $lang_showing_0_to_0_of_0_entries,
						"infoFiltered": "(filtered from _MAX_ total entries)",
						"infoPostFix": "",
						"thousands": ",",
						"lengthMenu": $lang_show + " _MENU_ " + $lang_entries,
						"loadingRecords": $lang_loading,
						"processing": $lang_processing,
						"search": $lang_search,
						"zeroRecords": $lang_no_matching_records_found,
						"paginate": {
							"first": $lang_first,
							"last": $lang_last,
							"previous": "<i class='fas fa-angle-left'></i>",
							"next": "<i class='fas fa-angle-right'></i>"
						},
						"aria": {
							"sortAscending": ": activate to sort column ascending",
							"sortDescending": ": activate to sort column descending"
						},
					},
					drawCallback: function () {
						$(".dataTables_paginate > .pagination").addClass("pagination-bordered");
					}
				});
			});
		}

		if ($(".report-table").length) {
			$(".report-table").each(function (j, obj) {
			  	var headerText = $(obj).prev(".report-header").html();
				var report_table = $(this).DataTable({
					responsive: true,
					"bAutoWidth": false,
					"ordering": false,
					"lengthChange": false,
					dom:
					"<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
					"language": {
						"decimal": "",
						"emptyTable": $lang_no_data_found,
						"info": $lang_showing + " _START_ " + $lang_to + " _END_ " + $lang_of + " _TOTAL_ " + $lang_entries,
						"infoEmpty": $lang_showing_0_to_0_of_0_entries,
						"infoFiltered": "(filtered from _MAX_ total entries)",
						"infoPostFix": "",
						"thousands": ",",
						"lengthMenu": $lang_show + " _MENU_ " + $lang_entries,
						"loadingRecords": $lang_loading,
						"processing": $lang_processing,
						"search": $lang_search,
						"zeroRecords": $lang_no_matching_records_found,
						"paginate": {
							"first": $lang_first,
							"last": $lang_last,
							"previous": "<i class='fas fa-angle-left'></i>",
							"next": 	"<i class='fas fa-angle-right'></i>"
						},
						"aria": {
							"sortAscending": ": activate to sort column ascending",
							"sortDescending": ": activate to sort column descending"
						},
						"buttons": {
							copy: $lang_copy,
							excel: $lang_excel,
							pdf: $lang_pdf,
							print: $lang_print,
						}
					},
					drawCallback: function () {
						$(".dataTables_paginate > .pagination").addClass("pagination-bordered");
					},
					buttons: [
						'copy', 'excel', 'pdf',
						{
							extend: 'print',
							title: '',
							customize: function (win) {
								$(win.document.body)
									.css('font-size', '10pt')
									.prepend(
										'<div class="text-center">' + headerText + '</div>'
									);

								$(win.document.body).find('table')
									.addClass('compact')
									.css('font-size', 'inherit');

							}
						}
					],
				});
			});
		}

	}


	//General Settings Page
	if ($("#mail_type").val() == "mail") {
		$(".smtp").prop("disabled", true);
	}

	$(document).on("change", "#mail_type", function () {
		if ($(this).val() == "mail") {
			$(".smtp").prop("disabled", true);
		} else {
			$(".smtp").prop("disabled", false);
		}
	});

	//Access Control
	$(document).on('change', '#permissions #user_role', function () {
		showRole($(this));
	});

	$("#permissions .custom-control-input").each(function () {
		if ($(this).prop("checked") == true) {
			$(this).closest(".collapse").addClass("show");
		}
	});

	$("#user_type").val() == "user"
			? $("#role_id").prop("disabled", false)
			: $("#role_id").prop("disabled", true);


	$(document).on("change", "#user_type", function () {
		$(this).val() == "user"
			? $("#role_id").prop("disabled", false)
			: $("#role_id").prop("disabled", true);
	});


	$(document).on("click", ".notification_mark_as_read", function (event) {
		event.preventDefault();
		var notification = $(this);
		$.ajax({
		  url: $(notification).attr("href"),
		  beforeSend: function () {
			$("#preloader").css("display", "block");
		  },
		  success: function (data) {
			$(notification).prev().find("p").removeClass("unread-notification");
			$(notification).remove();
			$("#notification-count").html(
			  parseInt($("#notification-count").html()) - 1
			);
			$("#preloader").css("display", "none");
		  },
		});
	});

	$(document).on('click','.copy-link',function(){
		var copyText = $(this).data('copy-text');
		navigator.clipboard.writeText(copyText);
		$.toast({text: $(this).data('message'), icon: 'success'});
	});

	//Multi Select
	if ($(".multi-selector").length) {
		$('.multi-selector').each(function (i, obj) {
			var dropdonwValues = '';
			var selectedText = '';

			$($(this).find('option')).each(function(index, option){
				if($(this).is(':selected')){
					selectedText += ", " + option.text;
					dropdonwValues += `<a class="dropdown-item" href="javascript: void(0);"><label class="d-flex align-items-center"><input type="checkbox" class="mr-2" value="${option.value}" data-text="${option.text}" checked><span>${option.text}</span></label></a>`;
				}else{
					dropdonwValues += `<a class="dropdown-item" href="javascript: void(0);"><label class="d-flex align-items-center"><input type="checkbox" class="mr-2" value="${option.value}" data-text="${option.text}"><span>${option.text}</span></label></a>`;
				}		
			});

			if(selectedText == ""){
				selectedText = $(this).data('placeholder');
			}else{
				selectedText = selectedText.split(' ').slice(1).join(' ');
			}
			
			$(this).after(`<div class="dropdown multi-select-box">
				<button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
					${selectedText}
				</button>
				<div class="dropdown-menu">
				${dropdonwValues}
				</div>
			</div>`);
		})
	}

	$(document).on('change', '.multi-select-box .dropdown-item input', function(){
		var selectedText = '';
		var selectedValues = [];
		$($(this).closest('.dropdown-menu').find('input')).each(function(value, option){
			if($(this).is(':checked')){
				selectedText += ", " + $(this).data('text');
				selectedValues.push( $(this).val());
			}	
		});

		$(this).closest('.multi-select-box').prev().val(selectedValues).trigger('change');

		if(selectedText == ""){
			selectedText = $(this).closest('.multi-select-box').prev().data('placeholder');
		}else{
			selectedText = selectedText.split(' ').slice(1).join(' ');
		}

		$(this).closest('.multi-select-box').find('.dropdown-toggle').html(selectedText);
	});

	$(document).on('click', '.multi-select-box.dropdown', function (e) {
		e.stopPropagation();
	});

})(jQuery);

function readFileURL(input) {
	if(input.files){
		for (let i = 0; i < input.files.length; i++) {
			var reader = new FileReader();
			reader.onload = function (e) { };

			$(input).parent().find(".filename").val(input.files[i].name);
			reader.readAsDataURL(input.files[i]);
		}

		if(input.files.length > 1){
			$(input).parent().find(".filename").val(input.files.length + ' files selected');
		}else{
			$(input).parent().find(".filename").val(input.files[0].name);
		}
	}
}

function init_editor() {
	if ($(".summernote").length > 0) {
		tinymce.remove();
		tinymce.init({
			selector: "textarea.summernote",
			theme: "modern",
			height: 250,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
			style_formats: [
				{ title: 'Bold text', inline: 'b' },
				{ title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
				{ title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
				{ title: 'Example 1', inline: 'span', classes: 'example1' },
				{ title: 'Example 2', inline: 'span', classes: 'example2' },
				{ title: 'Table styles' },
				{ title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
			]
		});
	}

	if ($(".mini-summernote").length > 0) {
		tinymce.remove();
		tinymce.init({
			selector: "textarea.mini-summernote",
			toolbar: "undo redo | bold italic underline | bullist numlist | alignleft aligncenter alignright | link removeformat",
    		plugins: "link lists",
			plugins: "link lists", // Only essential plugins
			branding: false, // Removes "Powered by TinyMCE" branding
			menubar: false,
			height: 200 // Adjusts the editor height
		});
	}
}

function init_datepicker() {
	/** Start Datepicker **/
	var date_format = ["Y-m-d", "d-m-Y", "d/m/Y", "m-d-Y", "m.d.Y", "m/d/Y", "d.m.Y", "d/M/Y", "M/d/Y", "d M, Y"];
	var picker_date_format = ["YYYY-MM-DD", "DD-MM-YYYY", "DD/MM/YYYY", "MM-DD-YYYY", "MM.DD.YYYY", "MM/DD/YYYY", "DD.MM.YYYY", "DD/MMM/YYYY", "MMM/DD/YYYY", "DD MMM, YYYY"];

	var fake_format = picker_date_format[date_format.indexOf(_date_format)];

	//Set Default date
	if ($(".datepicker").length) {
		$('.datepicker').each(function (i, obj) {

			$('.datepicker').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				locale: {
					format: 'YYYY-MM-DD'
				}
			});

			$('.datepicker').css('color', 'transparent');

			if (typeof $(this).next().attr('class') === "undefined") {
				$(this).after('<span class="fake_datepicker"></span>');
				$(this).next('.fake_datepicker').css('margin-top', "-45.2px");
			}
			$(this).next('.fake_datepicker').html(moment($(this).val()).format(fake_format));
		})
	}

	$('.datepicker').on('apply.daterangepicker', function (ev, picker) {
		$(this).next('.fake_datepicker').html(moment($(this).val()).format(fake_format));
	});

	$(document).on('click', '.fake_datepicker', function () {
		$(this).prev().focus();
	});

	/** End Datepicker **/
}

function showRole(elem) {
	if ($(elem).val() == '') {
		return;
	}
	window.location = _user_url + '/roles/' + $(elem).val() + '/access_control';
}

