
			$(function() {
				function maskPhone() {
					var country = $('#country option:selected').val();
						switch (country) {
							case "+380":
								$("#phone").mask("+38(999) 999-99-99");
								break;
							case "+7":
								$("#phone").mask("+7(999) 999-99-99");
								break;
							case "+1":
								$("#phone").mask("+1(999) 999-99-99");
								break;
							case "+375":
								$("#phone").mask("+375(999) 999-99-99");
								break;
							case "+44":
								$("#phone").mask("+44(999) 999-99-99");
								break;
							case "+90":
								$("#phone").mask("+90(999) 999-99-99");
								break;
							case "+34":
								$("#phone").mask("+34(999) 999-99-99");
								break;
						}
					}
					maskPhone();
					$('#country').change(function() {
					maskPhone();
				});
			});