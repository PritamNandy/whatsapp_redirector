"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizardObj;
	var _validations = [];

	// Private functions
	var _initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'Name is required'
							}
						}
					},
					email: {
						validators: {
							notEmpty: {
								message: 'Email is required'
							},
                            emailAddress: {
                                message: 'Enter a valid email address'
                            }
						}
					},
					phone: {
						validators: {
							notEmpty: {
								message: 'Phone Number is required'
							},
                            integer: {
                                message: 'The value is not a valid integer number',
                            }
						}
					},
                    address: {
					    validators: {
                            integer: {
                                message: 'The value is not a valid integer number',
                            },
                            stringLength: {
                                min: 4,
                                max: 4,
                                message: 'Postcode length should be 4'
                            }
                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap({
						//eleInvalidClass: '',
						eleValidClass: '',
					})
				}
			}
		));
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    description: {
                        validators: {
                            notEmpty: {
                                message: 'Description is required'
                            }
                        }
                    },
                    age: {
                        validators: {
                            notEmpty: {
                                message: 'Recipient Age is required'
                            }
                        }
                    },
                    date: {
                        validators: {
                            notEmpty: {
                                message: 'Preferred Booking date is required'
                            }
                        }
                    },
                    size: {
                        validators: {
                            notEmpty: {
                                message: 'Estimated Size is required'
                            }
                        }
                    },
                    location: {
                        validators: {
                            notEmpty: {
                                message: 'Location on the body is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));
        _validations.push(FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    ca_email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'Enter a valid email address'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            },
                            stringLength: {
                                message: 'Password length should be greater than 7',
                                min: 7
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: '',
                    })
                }
            }
        ));
	}

	var _initWizard = function () {
		// Initialize form wizard
		_wizardObj = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false  // allow step clicking
		});

		// Validation before going to next page
		_wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}

			// Validate form before change wizard step
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
				    let is_registered = $('#is_registered').val();
				    if(is_registered == undefined) {
				        is_registered = false;
                    } else {
				        is_registered = true;
                    }

				    if(is_registered == true) {
                        wizard.goTo(wizard.getNewStep());
                        KTUtil.scrollTop();
                    } else if (status == 'Valid' && $('#valid_email').val() == 1 && $('#valid_phone').val() == 1) {
						wizard.goTo(wizard.getNewStep());
						KTUtil.scrollTop();
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: {
								confirmButton: "btn font-weight-bold btn-light"
							}
						}).then(function () {
							KTUtil.scrollTop();
						});
					}
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Change event
		_wizardObj.on('changed', function (wizard) {
			KTUtil.scrollTop();
		});

		// Submit event
		_wizardObj.on('submit', function (wizard) {

            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {
                    let is_registered = $('#is_registered').val();
                    if(is_registered == undefined) {
                        is_registered = false;
                    } else {
                        is_registered = true;
                    }

                    if(is_registered == true && status == 'Valid') {
                        _formEl.submit();
                    } else if (status == 'Valid' && $('#valid_email').val() == 1 && $('#valid_phone').val() == 1) {
                        _formEl.submit();
                    } else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        }).then(function () {
                            KTUtil.scrollTop();
                        });
                    }
                });
            }

			// Swal.fire({
			// 	text: "All is good! Please confirm the form submission.",
			// 	icon: "success",
			// 	showCancelButton: true,
			// 	buttonsStyling: false,
			// 	confirmButtonText: "Yes, submit!",
			// 	cancelButtonText: "No, cancel",
			// 	customClass: {
			// 		confirmButton: "btn font-weight-bold btn-primary",
			// 		cancelButton: "btn font-weight-bold btn-default"
			// 	}
			// }).then(function (result) {
			// 	if (result.value) {
			// 		_formEl.submit(); // Submit form
			// 	} else if (result.dismiss === 'cancel') {
			// 		Swal.fire({
			// 			text: "Your form has not been submitted!.",
			// 			icon: "error",
			// 			buttonsStyling: false,
			// 			confirmButtonText: "Ok, got it!",
			// 			customClass: {
			// 				confirmButton: "btn font-weight-bold btn-primary",
			// 			}
			// 		});
			// 	}
			// });
		});
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');

			_initValidation();
			_initWizard();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard1.init();
});
