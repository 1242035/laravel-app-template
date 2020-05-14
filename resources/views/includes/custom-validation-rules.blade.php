<script>
  let phone_number_regex = /^(?:\d{10}|\d{11}|\d{12})$/;
  let valid_email_regex = /^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/;
  // Added custom validate email method
  jQuery.validator.addMethod("validateEmail", function (value, element, param) {
    return value.trim().match(valid_email_regex);
  }, '{{ __('validation.admin.general.email_error') }}');
  // Added custom validate email method
  jQuery.validator.addMethod("checkPhoneNumber", function (value, element, param) {
    return value.trim().match(phone_number_regex);
  }, '{{ __('validation.admin.general.invalid_phone_number') }}');
</script>
