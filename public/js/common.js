define(['cute'], function(require, exports){
    //应用扩展
    window.TKJ = {
        blockSlide: function(options) {
            var self = this;
            var opt = $.extend(true, {
                width: 468, //宽度
                height: 80, //高度
                data: [], //广告列表，例：[{url:"",image:"",title:"",target:""}],
                random: false,
                showpage: true,
                interval: 5, //轮播间隔
                style: '',
                styleurl: "" //特殊样式URL
            }, options);
            var iframe = $('<iframe />', {
                frameborder: 0,
                width: opt.width,
                height: opt.height
            }).css("visibility", 'hidden').load(function() {
                var iDoc = iframe.contents();
                var _html = [];
                var _head = "<style>" +
                    "html{overflow:hidden}" +
                    "body{margin:0;padding:0;font-family:Arial;-webkit-text-size-adjust:none;overflow:hidden}" +
                    "img{border:0;}" +
                    ".ad_list,.ad_ids{margin:0;padding:0;list-style:none;}" +
                    ".ad_list li{ position:absolute;top:0;left:0;display:none;}" +
                    ".ad_ids{position:absolute;bottom:10px; right:10px;z-index:50;}" +
                    ".ad_ids li{float:left;margin-left:4px;}" +
                    ".ad_ids li a{display:inline-block;font-size:9px;padding:2px 4px; border:1px solid #ddd;background-color:#eee;text-decoration:none;color:#888;zoom:1;}" +
                    ".ad_ids li a:hover{text-decoration:none;}" +
                    ".ad_ids li a.curr{border-color:#242424;color:#fff;background-color:#242424;}" +
                    opt['style'] +
                    "</style>";
                if (opt.styleurl) _head += '<link type="text/css" rel="stylesheet" href="' + opt.styleurl + '" />';
                iDoc.find("head").html(_head);
                var content = iDoc.find("body");
                if (opt.data.length > 0) {
                    if (opt.random)
                        opt.data = Cute.Array.shuffle(opt.data);
                    $(this).css('visibility', 'visible');
                    _html.push('<ul class="ad_list">');
                    $.each(opt.data, function(i, item) {
                        _html.push('<li>');
                        if(item.url)
                            _html.push('<a href="' + item.url + '" target="' + (item.target ? item.target : "_blank") + '">');
                        _html.push('<img dynamic-src="' + item.image + '" alt="' + item.title + '" title="' + item.title + '" width="' + opt.width + '" height="' + opt.height + '" />');
                        if(item.url)
                            _html.push('</a>');
                        _html.push('</li>');
                    });
                    _html.push('</ul>');
                    if (opt.data.length > 1 && opt.showpage) {
                        _html.push('<ul class="ad_ids">');
                        $.each(opt.data, function(i, item) {
                            _html.push('<li><a href="javascript:void(0)">' + (i + 1) + '</a></li>');
                        });
                        _html.push('</ul>');
                    }
                    content.html(_html.join('')).find(".ad_ids a").click(function() {
                        setAdItem(parseInt($(this).text()) - 1);
                    });
                    setAdItem(0);
                }

                function setAdItem(num) {
                    if (num > opt.data.length - 1) {
                        num = 0;
                    }
                    var _ulList = iDoc.find(".ad_list");
                    var _ulIds = iDoc.find(".ad_ids");
                    _ulList.children("li").filter(":visible").stop(true, true).fadeOut(1000, function() {
                        $(this).css("z-index", 0);
                    }).end().eq(num).css("z-index", 1).stop(true, true).fadeIn(1000);
                    _ulList.find("img").filter(":eq(" + num + "),:eq(" + (num + 1 > opt.data.length - 1 ? 0 : (num + 1)) + ")").attr("src", function() {
                        var src = $(this).attr("dynamic-src");
                        $(this).removeAttr("dynamic-src");
                        return src;
                    });
                    if (opt.data.length > 1) {
                        _ulIds.find("a").removeClass().eq(num).addClass("curr");
                        clearTimeout(self.timer);
                        self.timer = setTimeout(function() {
                            setAdItem(num + 1);
                        }, opt.interval * 1000);
                    }
                }
            });
            return iframe;
        },
        get_upload_url: function(url, type, size) {
            if (!url) {
                if (size !== undefined) {
                    var thumPrefix = TKJ.config[type.toLowerCase()]['thumbPrefix'].split(',');
                    return TKJ.config.UPLOAD + "/images/no_" + type.toLowerCase() + ".png!" + thumPrefix[size];
                } else {
                    return TKJ.config.UPLOAD + "/images/no_" + type.toLowerCase() + ".png";
                }
            } else {
                if (size !== undefined) {
                    var thumPrefix = TKJ.config[type.toLowerCase()]['thumbPrefix'].split(',');
                    var filename = url + '!' + thumPrefix[size];
                } else {
                    var filename = url;
                }
                return TKJ.config.UPLOAD + "/" + TKJ.config[type.toLowerCase()]['path'] + "/" + filename;
            }
        },
        validator_fun: function(msg, o, cssctl) {
            var parent = o.obj.closest('td,p,div');
            if (parent.find(".Validform_checktip").length > 0) {
                var obj = parent.find(".Validform_checktip").html(msg);
            } else {
                var obj = $('<span class="Validform_checktip">' + msg + '</span>').insertAfter(o.obj);
            }
            if (o.type != 2 || o.obj.attr('ajaxurl')) {
                cssctl(obj, o.type);
            } else {
                obj.remove();
            }
        },
        URLSafeBase64Encode: function($originalStr) {
            $find = array("+", "/");
            $replace = array("-", "_");
            return str_replace($find, $replace, Cute.string.base64_encode($originalStr));
        }
    };
});