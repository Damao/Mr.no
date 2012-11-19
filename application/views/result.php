<div class="page_result qb_clearfix">
    <div class="fn_phone mod_phone qb_fl">
        <div class="phone_border">
            <div class="phone_screen" id="fn_canvas">
                <img src="/uploads/<?php echo $task_id . '.' . $file_type; ?>" alt="">

                <div id="do_task_area">
                    <div id="do_resize"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="fn_summary mod_box qb_fl">
        <div id="countdown"></div>
        <ul class="data qb_clearfix">
            <li>
                <div id="success"><?php echo $avg_success * 100 ?>%</div>
                成功率
            </li>
            <li>
                <div class="no"><?php echo $response ?></div>
                人数
            </li>
            <li>
                <div class="no"><?php echo $avg_stay_time ?>s</div>
                耗时
            </li>
        </ul>
    </div>
    <div class="fn_directive mod_box qb_fl">
        <h2 class="title">测试说明</h2>

        <div class="directive"><?php echo $task_directive; ?></div>
        <div class="task qb_tar">
            <a href="http://localhost/index.php/task/id/<?php echo $task_id ?>" class="qb_btn">预览测试</a></div>
    </div>
</div><!-- .page_config -->

<?php /*
echo $task_timestamp . "task_timestamp<br>";
echo $file_type . "file_type<br>";
echo $task_area . "task_area<br>";
echo $task_directive . "task_directive<br>";
echo $result_device . "result_device<br>";
echo $response . "response<br>";
echo $avg_stay_time . "avg_stay_time<br>";
echo $avg_success . "avg_success<br><pre>";
var_dump($result_all_area) . "<br>";
var_dump($result_all_device) . "<br></pre>";
*/
?>
<script type="text/javascript">
    var create_time = +new Date("<?php echo $task_timestamp ?>");
    function secondToDate(second) {
        if (!second) {
            return 0;
        }
        var time = '';
        if (second >= 24 * 3600) {
            time += parseInt(second / (24 * 3600)) + '天';
            second %= 24 * 3600;
        }
        if (second >= 3600) {
            time += parseInt(second / 3600) + '小时';
            second %= 3600;
        }
        if (second >= 60) {
            time += parseInt(second / 60) + '分钟';
            second %= 60;
        }
        if (second > 0) {
            time += second + '秒';
        }
        return time;
    }
    function countdown() {
        current_time = +new Date();
        count_down = parseInt((172800000 - (current_time - create_time))/1000);
        console.log(count_down);
        /*48小时倒计时 todo 溢出处理*/
        $("#countdown").text(secondToDate(count_down));
    }
    setInterval(countdown, 1000);
    var task_area =<?php echo $task_area ?>;
    $('#do_task_area').css({
        width:task_area.w,
        height:task_area.h,
        top:task_area.y,
        left:task_area.x
    });
    var result_all_area =<?php echo $result_all_area ?>;
    var result_all_device =<?php echo $result_all_device ?>;
    var result_response =<?php echo $response ?>;

    for (var i = 0; i < result_response; i++) {
        var _tmp = $.parseJSON(result_all_area[i]);
        $('<div class="unit"></div>').css({
            top:_tmp.y,
            left:_tmp.x
        }).appendTo("#fn_canvas");
    }

</script>