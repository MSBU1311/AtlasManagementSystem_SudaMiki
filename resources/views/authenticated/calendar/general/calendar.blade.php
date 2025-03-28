<x-sidebar>
<div class="pt-5 pb-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto" style="padding-top: 10px;">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <!-- ルートはこちら -->
    <form action="{{ route('deleteParts') }}" method="post">
      <div class="w-100">
        <div class="modal-inner w-50 m-auto">
          <div class="modal-inner-date">
            <p class="">予約日：<span id="modal-delete-date"></span></p>
          </div>
          <div class="modal-inner-part">
            <p class="">時間：<span id="modal-reserve-part"></span></p>
          </div>
          <p class="">上記の予約をキャンセルしてもよろしいですか？</p>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-primary d-block" href="">閉じる</a>
          <input type="hidden" name="reserve_id" id="delete-form-reserve-id">
          <input  type="submit" class="btn btn-danger d-inline-block" value="キャンセル">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
</x-sidebar>
