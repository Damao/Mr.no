<div class="page_home">
    <div class="fn_uploader">
        <div id="file-uploader">
            <noscript>
                <p>Please enable JavaScript to use file uploader.</p>
                <!-- or put a simple form for upload here -->
            </noscript>
        </div>
    </div>
</div><!-- .page_home -->
<div class="page_config qb_clearfix">
    <div class="fn_phone mod_phone qb_fl">
        <div class="phone_border">
            <div class="phone_screen" id="fn_canvas">
                <div id="do_task_area">
                    <div id="do_move"></div>
                    <div id="do_resize"></div>
                </div>
            </div>
        </div>
    </div>
    <form action="index.php/form/update" method="post" id="form_config">
        <div class="fn_directive mod_box qb_fl">
            <h2 class="title">1.给你的被测试者一个指令吧</h2>
            <input type="hidden" id="task_area" name="task_area" value="{w:1,h:1,x:1,y:1}">
            <textarea type="text" id="task_directive" name="task_directive" class="qb_textarea" placeholder="任务描述"></textarea>
            <input type="hidden" value="" id="task_id" name="task_id">
        </div>
        <div class="fn_directive mod_box qb_fl">
            <h2 class="title">2.在左侧拖拽出你希望用户点击的区域</h2>

            <div class="demo qb_fl">
                <div class="d1">
                    <div class="d2">
                    </div>
                </div>
            </div>
            <div class="marks">&lt; 测试者将看不到红色方框!</div>
        </div>
        <div class="fn_submit"><input type="submit" class="qb_btn"></div>
    </form>

</div><!-- .page_config -->

<div class="page_task_summary">
    <div class="fn_task_summary mod_box">
        <h2>你已经可以开始测试了!</h2>

        <h3>你有48小时来测试你的方案</h3>

        <div class="link" id="link">
            复制一下链接，分享他人测试
            <input type="text" id="test_link_input" value="" class="qb_input"/>
        </div>
        <div class="next">
            <a href="#" class="qb_btn qb_mr10" id="result_link">查看结果</a>
            <a href="http://mrno.ooxx.me/task/id/" id="test_link_a">预览我的测试</a>
        </div>
    </div>
</div>
<script>
function createUploader() {
    var uploader = new qq.FileUploader({
        element:document.getElementById('file-uploader'),
        action:'/index.php/form/ajaxupload',
        debug:true,
        inputName:"qqfile",
        autoUpload:true,
        allowedExtensions:['jpg', 'png'],
        forceMultipart:false,
        failedUploadTextDisplay:{
            mode:'custom',
            maxChars:40,
            responseProperty:'error',
            enableTooltip:true
        },
        uploadButtonText:"来一发",
        onSubmit: function(id, fileName){
            $(".page_home").slideUp();
            $(".page_config").slideDown();
        },
        onComplete:function (id, fileName, responseJSON) {
            if (responseJSON.success) {
                var responseIMG = new Image();
                responseIMG.src = "uploads/" + responseJSON.task_id + responseJSON.file_type;
                responseIMG.id = "uploaded";
                responseIMG.onload = function () {
                    $('#fn_canvas').prepend(responseIMG);
                    if ($("#uploaded").height() > 480) {
                        $('#fn_canvas').addClass("scrollbar");
                    }
                    $('#do_task_area').fadeIn();
                };
                $("#task_id").val(responseJSON.task_id);
                $("#link").append('<img class="qr" src="http://chart.apis.google.com/chart?cht=qr&chld=|0&choe=UTF-8&chs=128x128&chl=http%3A%2F%2Fmrno.ooxx.me%2Ftask%2Fid%2F'+ responseJSON.task_id+'">');
                $("#test_link_input").val('http://mrno.ooxx.me/task/id/' + responseJSON.task_id);
                $("#test_link_a").attr('href', 'http://mrno.ooxx.me/task/id/' + responseJSON.task_id);
                $("#result_link").attr('href', 'http://mrno.ooxx.me/result/id/' + responseJSON.task_id);
            }
        }
    });
}


// in your app create uploader as soon as the DOM is ready
// don't wait for the window to load
window.onload = createUploader;

/*坑爹的拖拽*/
function cpDrag(ele, rangeWidth) {
    var oDiv = $(ele);
    var startX = 0;
    /* 鼠标起始位置 */
    var startY = 0;
    var startLeft = 0;
    /*oDiv起始位置*/
    var startTop = 0;
    oDiv.on("mousedown", startDrag);
    function startDrag(e) /*鼠标点击事件 */ {
        e.preventDefault();
        var e = e || window.event;
        startX = e.clientX;
        startY = e.clientY;
        startLeft = oDiv.offset().left - $('#fn_canvas').offset().left;
        startTop = oDiv.offset().top - $('#fn_canvas').offset().top;//这是容器减去顶部的高度
        if (oDiv.setCapture)
        /* setCapture()可以用在对DIV的拖动效果上。就不用给body设置onmousemove事件了，直接给DIV设置，然后通过setCapture()让它捕获所有的鼠标事件。*/
        {
            oDiv.on("mousemove", doDrag);
            /*鼠标移动事件 */
            oDiv.on("mouseup", stopDarg);
            /*鼠标松开事件*/
            oDiv.setCapture();
            /*IE独享 事件捕获setCapture() */
        }
        else {
            document.addEventListener("mousemove", doDrag, true);
            /* DOM中事件捕获 */
            document.addEventListener("mouseup", stopDarg, true);
        }
    }

    function doDrag(e) {
        e.preventDefault();
        var e = e || window.event;
        var l = e.clientX - startX + startLeft;
        var t = e.clientY - startY + startTop + $('#fn_canvas').scrollTop();
        /*y滚动条拖了要加上*/
        if (l < 0) /* 阻止超出浏览器可视宽度 */
        {
            l = 0;
        }
        if (oDiv.width() > rangeWidth) {
            l = 0
        } else {
            if (l > (rangeWidth - oDiv.width())) /* 阻止超出浏览器可视宽度 */
            {
                l = rangeWidth - oDiv.width();
            }
        }

        if (t < 0)/* 阻止超出浏览器可视高度 */
        {
            t = 0
        }
        else if (t > ($("#uploaded").height() - oDiv.height())) {/*这尼玛得取图片高度,而不是容器高度*/
            t = $("#uploaded").height() - oDiv.height();
        }

        oDiv.parent().css("left", l);
        oDiv.parent().css("top", t);

        get_task_area();
    }

    function stopDarg() {

        if (oDiv.releaseCapture) /* 删除事件监听 */
        {
            oDiv.onmousemove = doDrag;
            oDiv.onmouseup = stopDarg;
            oDiv.releaseCapture();
        }
        else {
            document.removeEventListener("mousemove", doDrag, true);
            document.removeEventListener("mouseup", stopDarg, true);
        }
        oDiv.onmousemove = null;
        oDiv.onmouseup = null;
    }
}


/*
* 绑定需要拖拽改变大小的元素对象
* el 元素对象
* minW 最小宽度
* minH 最小高度
* keepProportion 保持长宽比，默认false
*/
function bindResize(el, minW, minH, keepProportion) {
    keepProportion = typeof keepProportion !== 'undefined' ? keepProportion : false;//如果keepProportion没有传入，那就默认不保持长宽比
    var ela = $(el).parent();
    //初始化参数
    //var els = ela.style,
    //鼠标的 X 和 Y 轴坐标
    var x, y, Xm, Ym;
    x = y = Xm = Ym = 0;
    var percent = 1;
    //邪恶的食指
    $(el).mousedown(function (e) {
        //按下元素后，计算当前鼠标与对象计算后的坐标
        x = e.clientX - ela.width();
        y = e.clientY - ela.height();
        //在支持 setCapture 做些东东
        ela.setCapture ? (
            //捕捉焦点
            el.setCapture(),
                //设置事件
                el.onmousemove = function (ev) {
                    mouseMove(ev || event)
                },
                el.onmouseup = mouseUp
            ) : (
            //绑定事件
            $(document).bind("mousemove", mouseMove).bind("mouseup", mouseUp)
            );
        //防止默认事件发生
        e.preventDefault();
        percent = ela.height() / ela.width();
    });
    //移动事件
    function mouseMove(e) {
        //宇宙超级无敌运算中...
        Xm = e.clientX - x;
        Ym = e.clientY - y;
        //限制高宽
        Xm <= minW && (Xm = minW);
        Ym <= minH && (Ym = minH);
        Xm >= 320 - (x - ela.offset().left) - $('#do_task_area').position().left && (Xm = 320 - (x - ela.offset().left) - $('#do_task_area').position().left);
        Ym + $('#fn_canvas').scrollTop() >= $("#uploaded").height() - $('#do_task_area').position().top && (Ym = $("#uploaded").height() - $('#do_task_area').position().top);
        //设置大小
        ela.width(Xm);
        //按比例设置Ym
        if (keepProportion) {
            Ym = Xm * percent;
        }
        ela.height(Ym);

        get_task_area();
    }

    //停止事件
    function mouseUp() {
        //在支持 releaseCapture 做些东东
        el.releaseCapture ? (
            //释放焦点
            el.releaseCapture(),
                //移除事件
                el.onmousemove = el.onmouseup = null
            ) : (
            //卸载事件
            $(document).unbind("mousemove", mouseMove).unbind("mouseup", mouseUp)
            );
    }
}
function get_task_area() {
    $('#task_area').val('{"w":' + $('#do_task_area').width() + ',"h":' + $('#do_task_area').height() + ',"x":' + $('#do_task_area').position().left + ',"y":' + $('#do_task_area').position().top + '}');
}

$("#form_config").submit(function () {
    $.ajax({
        type:"POST",
        url:"/index.php/form/update",
        data:$(this).serialize(),
        success:function (msg) {
            $(".page_config").slideUp();
            $(".page_task_summary").slideDown();
        }
    });
    return false;
});

$('#fn_canvas').click(function () {
    $('#do_task_area').show();
});
cpDrag("#do_move", 320);
bindResize("#do_resize", 30, 30);
</script>
</body>
</html>