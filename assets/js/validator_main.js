$(function () {

  'use strict';

  $.fn.validator.setDefaults({
    trigger: 'input change',
    success: function (e) {
      console.log(e.type, e.value, e.rule);
      $(this).closest('.form-group').removeClass('has-error').find('.help-block').empty();
    },
    error: function (e) {
      console.log(e.type, e.value, e.rule);
      $(this).closest('.form-group').addClass('has-error').find('.help-block').text(e.message);
    }
  });

  var $form = $('.container form');
  var $inputs = $form.find('input');
  var $submit = $form.find(':submit');

  $inputs.validator();

  $submit.click(function (e) {
    var validity = [];

    $inputs.each(function () {
      validity.push($(this).validator('isValid'));
    });

    if ($.inArray(false, validity) !== -1) {
      e.preventDefault();
      return false;
    }
  });
});
