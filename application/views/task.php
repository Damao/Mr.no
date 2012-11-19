<div class="page_task_directive">
    <div class="fn_task_directive">
        <div class="directive">
            <?php echo $task_directive ?>
        </div>
        <a href="#" class="qb_btn" id="task_start">开始测试!</a>
    </div>
</div>

<div class="page_task_phone">
    <div class="fn_phone mod_phone qb_fl">
        <div class="phone_border">
            <div class="phone_screen" id="fn_canvas">
                <img src="/uploads/<?php echo $task_id . '.' . $file_type; ?>" alt="">
            </div>
        </div>
    </div>

    <form action="../submit/<?php echo $task_id; ?>" method="post" id="form_task">
        <input id="result_area" type="hidden" value="" name="result_area">
        <input id="result_success" type="hidden" value="" name="result_success">
        <input id="result_stay_time" type="hidden" value="" name="result_stay_time">
    </form>
</div>

<div class="page_task_done">
    <div class="fn_task_done">
        <a href="http://localhost/index.php/result/id/<?php echo $task_id ?>" class="result" title="查看结果"></a>
        <a href="/" class="qb_btn">创建你自己的测试</a>
    </div>
</div>
<div class="page_task_done_mobile">
    测试完毕,转发就送 iPad Mini
</div>

<?php
/*
echo $task_timestamp . "<br>";
echo $file_type . "<br>";
echo $task_area . "<br>";
echo $task_directive . "<br>";
echo $result_device . "<br>";
*/
?>



<script type="text/javascript" src="/f2e/jquery.js"></script>
<script type="text/javascript">
    var is_mobile=<?php if($is_mobile){echo "true";}else{echo "false";}; ?>;
    var create_time = +new Date("<?php echo $task_timestamp ?>");
        current_time = +new Date();
        count_down = parseInt((172800000 - (current_time - create_time))/1000);
        /*48小时倒计时 todo 溢出处理*/
        if(count_down<0){
            window.location="../../result/id/<?php echo $task_id; ?>"
        }else{
            console.log(count_down);
        }


    var task_area = jQuery.parseJSON('<?php echo $task_area ?>');
    var then, now;
    $("#form_task").submit(function(){
        $.ajax({
            type: "POST",
            url: "../submit/<?php echo $task_id; ?>",
            data:$(this).serialize() ,
            success: function(msg){
                $('.page_task_phone').slideUp();
                if(is_mobile){
                    $('.page_task_done_mobile').slideDown();
                }else{
                    $('.page_task_done').slideDown();
                }
            }
        });
        return false;
    });
    $('#task_start').click(function () {
        $(".page_task_directive").slideUp();
        $(".page_task_phone").slideDown();
        then = new Date();
    });
    $('#fn_canvas').click(function (e) {
        var result_area_x = e.clientX - $(this).offset().left;
        var result_area_y = e.clientY - $(this).offset().top;
        if ((result_area_x >= task_area.x && result_area_x <= (task_area.x + task_area.w)) && (result_area_y >= task_area.y && result_area_y <= (task_area.y + task_area.h))) {
            $('#result_success').val("1");
        } else {
            $('#result_success').val("0");
        }
        $('#result_area').val('{"x":' + result_area_x + ',"y":' + result_area_y + '}');
        now = new Date();
        $("#result_stay_time").val(now.getTime() - then.getTime());
        $('#form_task').submit();
    });


</script>
