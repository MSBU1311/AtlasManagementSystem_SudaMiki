$(function () {

  $('.delete-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var delete_date = $(this).attr('delete_date');
    var reservePart = $(this).attr('reservePart');
    $('#modal-date').text(delete_date);
    $('#modal-delete-part').text(reservePart);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});
