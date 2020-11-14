
@extends('user.layouts.full-width')
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".table-gray").tablesorter();
        });
        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });
    </script>
@stop
@section('css')
    <style>
        
    </style>
@stop
@section('content')
  <p class="alert text-center">ยังไม่มีข้อความแจ้งเตือน</p>
@stop