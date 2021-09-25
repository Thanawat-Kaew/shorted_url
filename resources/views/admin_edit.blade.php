@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Short URL') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <input type="hidden" id="id_url" name="id_url" value="{{$url->id}}">
                    <input type="hidden" id="ogn_url" name="ogn_url" value="{{$url->short_url}}">
                    <div style="display: flex; justify-content: center;">
                        <input type="text" name="short_url" class="short_url" style="width:500px;" value="http://salty-cliffs-10650.herokuapp.com/url/{{ $url->short_url}}">
                    </div>
                    <br>
                    <div style="display: flex; justify-content: center;">
                        <button id="submit">บันทึก</button>&nbsp;&nbsp;
                        <button id="cancle">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="ajax-center-url" data-url="<?php echo route('home.ajax_center.post')?>"></div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $("#submit").click(function(){
            let short_url   = $(".short_url").val();
            let id_url      = $("#id_url").val();
            let ogn_url     = $("#ogn_url").val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
                type: 'POST',
                url: $('#ajax-center-url').data('url'),
                data: {
                    method : 'updateUrl',
                    current_id : id_url,
                    ogn_url : ogn_url,
                    short_url : short_url
                },
                success: function (result) {
                    if(result.status == "success"){
                        alert("success");
                        window.location = '{{ url("/admin") }}';
                    }else if(result.status == "error1"){
                        alert("ไม่สามารถแก้ไข domain ได้");
                    }else if(result.status == "error2"){
                        alert("กรุณาใส่ short url");
                    }else if(result.status == "error3"){
                        alert("short url นี้มีการใช้งานแล้ว");
                    }
                },
                error : function(errors)
                {
                    console.log(errors);
                }
            })
        });

        $("#cancle").click(function(){
            let ogn_url = $("#ogn_url").val();
            console.log(ogn_url);
            $(".short_url").val("http://salty-cliffs-10650.herokuapp.com/url/"+ogn_url+"");
        });
    });
</script>
@endsection
