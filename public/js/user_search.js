$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
    $(this).find('.arrow').toggleClass('up');
  });

  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(this).find('.arrow_subject').toggleClass('up');
  });

  $('[class^="subject_inner"]').hide();
});
