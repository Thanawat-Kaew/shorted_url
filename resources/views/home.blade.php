@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="display: flex; justify-content: center;">
                        <input type="text" id="full_url" name="full_url" placeholder="Enter or paste a long url" required style="width:500px">
                        <button id="btn_short">Shorten</button>
                    </div>
                    <br>
                    <div style="display: flex; justify-content: center;" class="show_short_url">
                    </div>
                    <br>
                    <div style="display: flex; justify-content: center;" class="btn_submit_cancle">
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
        $("#btn_short").click(function(){
            let full_url = $('#full_url').val();
            if(full_url.length > 0){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
                    type: 'POST',
                    url: $('#ajax-center-url').data('url'),
                    data: {
                        method : 'generateShortUrl',
                        full_url : full_url
                    },
                    success: function (result) {
                        console.log(result.status)
                        if(result.status == "success"){
                            $(".show_short_url").empty();
                            let show_short_url_html = '<input type="text" name="short_url" class="short_url" style="width:500px; background-color:#ccc;" value="http://salty-cliffs-10650.herokuapp.com/url/'+result.ran_url+'" readonly><button id="btn_edit_short">Edit</button>';
                            $(".show_short_url").append(show_short_url_html);

                            $("#btn_edit_short").click(function(){
                                $('.btn_submit_cancle').empty();
                                let btn = '<div><button id="submit">บันทึก</button><button id="cancle">ยกเลิก</button></div>';
                                $('.btn_submit_cancle').append(btn);
                                $(".short_url").attr("readonly", false); 
                                $(".short_url").css("background-color", "");

                                $("#submit").click(function(){
                                    let short_url = $(".short_url").val();
                                    $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('input[name=_token]').attr('value')},
                                        type: 'POST',
                                        url: $('#ajax-center-url').data('url'),
                                        data: {
                                            method : 'updateUrl',
                                            current_id : result.id,
                                            ogn_url : result.ran_url,
                                            short_url : short_url
                                        },
                                        success: function (result) {
                                            if(result.status == "success"){
                                                alert("success");
                                                $(".short_url").attr("readonly", false); 
                                                $(".short_url").css("background-color", "#ccc");
                                                $('.btn_submit_cancle').empty();
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
                                    $(".short_url").attr("readonly", false); 
                                    $(".short_url").css("background-color", "#ccc");
                                    $(".short_url").val("http://salty-cliffs-10650.herokuapp.com/url/"+result.ran_url+"");
                                    $('.btn_submit_cancle').empty();
                                });

                            });

                        }else if(result.status == "error"){
                            alert("url ไม่ถูกต้อง");
                        }
                    },
                    error : function(errors)
                    {
                        console.log(errors);
                    }
                })
            }else{
                alert("กรุณาใส่ url");
            }
        });
    });
</script>
@endsection
