
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="YTzRSYyKzrPFZFsvmOjyYK1sDve5PzBDS2cy1bdZ">

    <title>皇后</title>
    <meta name="description" content="">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://cdn.91dawan.com/statics/tpl/css/show.css">
    <script type="text/javascript">
        var library = @json($library);
        var lib_index = Math.floor((Math.random() * library.length));
    </script>
    <script src="http://cdn.91dawan.com/statics/tpl/js/clipboard.min.js"></script>
    <script src="http://cdn.91dawan.com/statics/tpl/js/knockout.min.js"></script>

</head>
<body>
<div id="app">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="color1">未完待续...</p>
                        <p class="color1">页面篇幅有限，点击下方<span class="color2">“复制公众号”</span>按钮，打开微信搜索公众号即可继续阅读全文哦~</p>
                        <p class="color3">请认准官方唯一认证公众号:</p>
                        <p class="color2 font1">海量畅读</p>
                        <p>打开微信 → 右上角+号 → 添加朋友 → 公众号</p>
                        <p><button type="button" class="btn1" onclick="showDialog()"><span data-bind="text: wechat_key" class="mpkeys"></span></button></p>
                        <p><button type="button" class="btn2" onclick="showDialog()">一键复制公众号</button></p>
                        <div class="tips">
                            <img src="http://cdn.91dawan.com/statics/tpl/img/1.gif">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--弹窗-->
    <div class="mask-web" id="mask-web" style="display: none;">
        <div class="mask-web-box">
            <div class="col-black">点击确定复制公众号，前往微信粘贴搜索</div>
            <div class="mask-web-btn">
                <!-- <div class="mask-web-btn-close" id="mask-web-close1" onClick="closeDialog()">取消</div> -->
                <div class="mask-web-btn-close" id="mask-web-close1"><a class="wx-copy-btn" data-clipboard-text="sywx_0" href="weixin://" onClick="closeDialog()">取消</a></div>
                <div class="mask-web-btn-confirm" id="mask-web-close2"><a class="wx-copy-btn" data-clipboard-text="sywx_0" href="weixin://" onClick="closeDialog()">确定</a></div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
    var showDialog = function () {
        var wap_mask = document.getElementById('mask-web');
        wap_mask.style.display = 'block';
    }
    var closeDialog = function () {
        var wap_mask = document.getElementById('mask-web');
        wap_mask.style.display = 'none';
    }

    var clipboard = new ClipboardJS('.wx-copy-btn');

    clipboard.on('success', function(e) {
        console.info('Text:', e.text);
        e.clearSelection();

        changeWeChatKey();


    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);

    });

    var changeWeChatKey = function() {
        var mpext = library[lib_index].mpext;
        mpext = JSON.parse(mpext);
        randKey = Math.floor((Math.random() * mpext.length));

        var rands = library[lib_index].rands;
        rands = JSON.parse(rands);
        if (rands['r1'] != undefined) {
            rands['r1'] = rands['r1'].split(' ');
        }
        if (rands['r2'] != undefined) {
            rands['r2'] = rands['r2'].split(' ');
        }
        if (rands['r3'] != undefined) {
            rands['r3'] = rands['r3'].split(' ');
        }
        if (rands['r4'] != undefined) {
            rands['r4'] = rands['r4'].split(' ');
        }

        var currentKey = library[lib_index].wechat_key;
        if (mpext.length == 0) {
            if (rands['r1'].length > 0) {
                randKey1 = Math.floor((Math.random() * rands['r1'].length));
                if (rands['r1'][randKey1] != undefined) {
                    currentKey += rands['r1'][randKey1];
                }
            }
            if (rands['r2'].length > 0) {
                randKey2 = Math.floor((Math.random() * rands['r2'].length));
                if (rands['r2'][randKey2] != undefined) {
                    currentKey += rands['r2'][randKey2];
                }
            }
            if (rands['r3'].length > 0) {
                randKey3 = Math.floor((Math.random() * rands['r3'].length));
                if (rands['r3'][randKey3] != undefined) {
                    currentKey += rands['r3'][randKey3];
                }
            }
            if (rands['r4'].length > 0) {
                randKey4 = Math.floor((Math.random() * rands['r4'].length));
                if (rands['r4'][randKey4] != undefined) {
                    currentKey += rands['r4'][randKey4];
                }
            }
        } else {
            if (mpext[randKey] != undefined) {
                currentKey += mpext[randKey];
            }
        }

        var gid = 211;
        if (gid==83) {
            currentKey = library[lib_index].wechat_key;
        }

        var copy_btn = document.getElementsByClassName('wx-copy-btn');
        for (var i = 0; i < copy_btn.length; i++) {
            copy_btn[i].setAttribute('data-clipboard-text', currentKey);
        }

        $('.mpkeys').each(function(i, o){
            $(o).text(currentKey);
        });

        library[lib_index].current_key = currentKey;
    }

    changeWeChatKey();

    // Here's my data model
    var pageModel = function (name, wechat_key) {
        this.lib_name = ko.observable(name);
        this.wechat_key = ko.observable(wechat_key);
    };

    ko.applyBindings(new pageModel(library[lib_index].name, library[lib_index].current_key));
    $('.font1').html(library[0].name);
</script>

</body>
</html>
