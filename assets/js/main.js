jQuery(document).ready(function($) {
    
    const swiper = new Swiper('.banner__slider', {
        loop: true,
        autoplay: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // product slider
    const product = new Swiper('.product__list', {
        loop: true,
        slidesPerView: 1.8,
        spaceBetween: 22,
        autoplay: true,
        breakpoints: {
            640: {
                slidesPerView: 3,
            },
			1440: {
				slidesPerView: 4.8,
			}
        },
    });

    const imageSlider = new Swiper('.image-slider', {
        loop: true,
        slidesPerView: 2,
        autoplay: true,
        spaceBetween: 9,
        breakpoints: {
            640: {
                slidesPerView: 4,
                spaceBetween:34,
            },
			1440: {
				slidesPerView: 6,
				spaceBetween: 34,
			}
        },
    });

	const shopProductSlider = new Swiper('.shop__product-slider', {
		loop: true,
		slidesPerView: 3.3,
		centeredSlides: true,
		autoplay: false,
		spaceBetween: 11,
		breakpoints: {
			768: {
				slidesPerView: 4,
				spaceBetween: 22,
			},
			1024: {
				slidesPerView: 7,
				spaceBetween: 22,
	
			},
		},
	});

    $('#login-form').submit(function(e) {
		e.preventDefault();
		var username = $('#bte_username').val();
		var password = $('#bte_password').val();
		$.ajax({
			url: ajax_params.ajaxurl,
			type: 'POST',
			data: {
				'action': 'bte_ajax_login',
				username: username,
				password: password,
			},
			success: function(response) {
				if (response.success) {
                    $('#login-message').html('<p class="success-message-popup">Login successful. Redirecting...</p>');
                    window.location.href = '/shop';
				} else {
					$('#login-message').html('<p class="error-message-popup">Login Unsuccessful.</p>');
				}
			}
		});
	});

    $('#forgot-password-form').on('submit', function(e) {
		e.preventDefault();

		var user_login = $('#bte_username_email').val();

		$.ajax({
			type: 'POST',
			url: ajax_params.ajaxurl,
			data: {
				action: 'bte_handle_forgot_password',
				nonce: ajax_params.nonce,
				user_login: user_login
			},
			success: function(response) {
				$('#forgot-password-message').html('<p>' + response.data + '</p>');
				if (response.success) {
					$('#forgot-password-form')[0].reset();
				}
				setTimeout(function() {
					$('.thank-you').show();
					$('.signup').hide();
				}, 2000);
			},
			error: function(response) {
				$('#forgot-password-message').html('<p>An error occurred. Please try again.</p>');
			}
		});
	});

	jQuery(document).ready(function($) {
		$('#signup-form,#signup-mobile-form').on('submit', function(e) {
			e.preventDefault(); // Prevent default form submission
	
			const formData = {
				action: 'bte_register_user',
				username: $('#username').val(),
				password: $('#password').val(),
				confirm_password: $('#confirm_password').val(),
				email: $('#email').val(),
				first_name: $('#first_name').val(),
				last_name: $('#last_name').val(),
				birthday: $('#birthday').val(),
				bussiness_name: $('#bussiness_name').val(),
				bussiness_email: $('#bussiness_email').val(),
				bussiness_type: $('#bussiness_type').val(),
				wholesale_account: $('#wholesale').is(':checked') ? 1 : 0,
				register_nonce: ajax_params.nonce, // Dynamically inject nonce
			};
	
			$.ajax({
				url: ajax_params.ajaxurl, // AJAX handler URL
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.success) {
						$('#signup-message').text(response.data.message).css('color', 'green');
						setTimeout(function() {
							$('.thank-you').show();
							$('.signup').hide();
						}, 2000);
						
					} else {
						$('#signup-message').text(response.data.message).css('color', 'red');
					}
				},
				error: function() {
					$('#signup-message').text('An error occurred. Please try again.').css('color', 'red');
				},
			});
		});
	});

	jQuery(document).ready(function ($) {
		let currentStep = 0;
		const steps = $(".form__step");
	
		function showStep(step) {
			steps.removeClass("active");
			$(steps[step]).addClass("active");
		}
	
		$(".next-btn").on("click", function () {
			if (currentStep < steps.length - 1) {
				currentStep++;
				showStep(currentStep);
			}
		});
	
		$(".prev-btn").on("click", function () {
			if (currentStep > 0) {
				currentStep--;
				showStep(currentStep);
			}
		});
	
		// Show the first step initially
		showStep(currentStep);
	});
	
	//sticky menu
    let lastScrollPosition = 0;
	const header = document.getElementById('site-header');

	// Add a scroll event listener to the window
	window.addEventListener('scroll', () => {
		const currentScrollPosition = window.scrollY;

		header.classList.add('sticky');

		if( currentScrollPosition == 0 ) {
			header.classList.remove('sticky');
		}

		// Update last scroll position
		lastScrollPosition = currentScrollPosition;
	});

	jQuery(document).ready(function ($) {
		const passwordField = $('#password_1');
		const confirmPasswordField = $('#password_2');
		const submitButton = $('.woocommerce-Button'); // Update selector for your save button
		const errorContainer = $('<div class="password-errors"></div>');
	
		errorContainer.css({
			color: 'red',
			marginTop: '10px',
		});
	
		passwordField.after(errorContainer);
	
		const validatePassword = () => {
			const password = passwordField.val();
			const confirmPassword = confirmPasswordField.val();
			const errors = [];
	
			if (password.length < 12) errors.push('Password must be at least 12 characters.');
			if (!/[A-Z]/.test(password)) errors.push('Password must contain at least one uppercase letter.');
			if (!/[a-z]/.test(password)) errors.push('Password must contain at least one lowercase letter.');
			if (!/\d/.test(password)) errors.push('Password must contain at least one number.');
			if (!/[\W_]/.test(password)) errors.push('Password must contain at least one special character.');
			if (password !== confirmPassword) errors.push('Passwords do not match.');
	
			errorContainer.html(errors.join('<br>'));
	
			submitButton.prop('disabled', errors.length > 0);
		};
	
		passwordField.on('input', validatePassword);
		confirmPasswordField.on('input', validatePassword);
	});

	var WindowWidth = $(window).width();
	$(window).resize(function () {
		WindowWidth = $(window).width();
	}).resize();

	$('#search-products').keyup(function (e) {
		e.preventDefault();
		if (WindowWidth <= 740) {
			var number = 4;
		} else {
			var number = 5;
		}
		let self = $(this);
		var parent = self.parents('form');
		parent = $('.search-drop');
		let data = $(this).val();
		if (data.length >= 2) {
			parent.find('.search-product-wrapper').find('.product-row').html('');
			parent.find('.search-product-wrapper').removeClass('visually-hidden');
			$('.noresult_info').addClass('visually-hidden');
			$('.search-drop').addClass('search_drop_active');
			$('.search-product-wrapper .btn-wrapper').addClass('visually-hidden');

			if (data == self.val()) {
				$.ajax({
					type: "POST",
					async: true,
					url: ajax_params.ajaxurl,
					data: {
						'action': 'bte_autocomplete_search',
						'data': data,
						'number': number
					},
					success: function (response) {
						var obj = jQuery.parseJSON(response);
						if (obj.total > 0) {
							$('.noresult_info').addClass('visually-hidden');
							parent.find('.product-row').text('').append(obj.result);
							parent.find('.btn-results').attr('href', obj.url);
							parent.find('.btn-results').closest('.btn-wrapper').removeClass('visually-hidden');
						} else {
							$('.search-product-wrapper').removeClass('visually-hidden');
							$('.search-product-wrapper').find('.noresult_info').removeClass('visually-hidden');
							parent.find('.btn-results').attr('href', obj.url);
							parent.find('.btn-results').closest('.btn-wrapper').addClass('visually-hidden');
						}

					}
				});
			}

		} else {
			parent.find('.search-product-wrapper').addClass('visually-hidden');
			parent.find('.search-product-wrapper').removeClass('no_result');
			//  parent.find('.search-product-wrapper').removeClass('ajax_loading');
		}
	});

	// Close dropdown on outside click
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.search-drop').length) {
            $('.search-product-wrapper').addClass('visually-hidden');
        }
    });
	
		
});

document.addEventListener("DOMContentLoaded", function () {
	flatpickr("#birthday", {
		dateFormat: "m/d/Y", // Adjust the format as needed
	});
});

document.addEventListener('DOMContentLoaded', function () {
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const mobileNav = document.querySelector('.mobile__nav');

    if (hamburgerMenu && mobileNav) {
        hamburgerMenu.addEventListener('click', function () {
            this.classList.toggle('active');
            mobileNav.classList.toggle('active');
        });

		// Hide mobile menu on scroll
		let lastScrollY = window.scrollY;
		window.addEventListener('scroll', function () {
		if (window.scrollY > lastScrollY) {
			// Hide menu on scroll down
			mobileNav.classList.remove('active');
			hamburgerMenu.classList.remove('active');
		}
		lastScrollY = window.scrollY;
		});
	}
});
  