$(function () {

  $('.delete-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    // ClarendaeViewから取得する
    var deleteDate = $(this).data('date');
    var reservePart = $(this).data('part');
    var reserveId = $(this).data('reserve-id');
    // 受け取った値をcalendar.bladeの対象のクラスに設定する
    $('#modal-delete-date').text(deleteDate);
    $('#modal-reserve-part').text(reservePart);
    $('#delete-form-reserve-id').val(reserveId);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});
