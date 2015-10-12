define(["require", "exports", 'cute','common','template'], function(require, exports){
    $("body").on('click', '[data-action]', function(e) {
        var self = $(this);
        var data_action = self.attr('data-action');
        var data_params = self.attr('data-params');
        var model = data_action.split('.')[0];
        var action = data_action.split('.')[1];
        require(['model/user'], function(){
            TKJ[model][action].call(self[0], e, data_params);
        });
        e.preventDefault();
        e.stopPropagation();
        return false;
    });

    var loadingLite = $('<div class="loading_lite" id="loading-lite" style="display:none">加载中...</div>').appendTo(document.body);
    $(document).ajaxSend(function(e, xhr, settings, exception) {
        if (settings.type == "POST") {
            loadingLite.html('提交中...').addClass("loading_lite_post").html('提交中...');
            this.mask = this.mask || $('<div class="mask_layout"></div>').appendTo(document.body);
        }
        loadingLite.show();
    }).ajaxSuccess(function(e, xhr, settings, exception) {
        if (this.mask) {
            this.mask.remove();
            this.mask = null;
        }
        loadingLite.html('加载中...').removeClass("loading_lite_post").hide();
    }).ajaxError(function(e, xhr, settings, exception) {
        if (this.mask) {
            this.mask.remove();
            this.mask = null;
        }
        loadingLite.html('发生异常').show().delay(3000).fadeOut(1500, function(){
            $(this).html('加载中...');
        });
    });
    $(document).on("click",".count .dec",function(){
        var goods_id = $(this).closest('li').attr('id').replace('goods_','');
        var input = $(this).closest('.count').find('input');
        if(input.val() == 0) return false;
        update_cart.call(input[0],goods_id,parseInt(input.val()) - 1);
    }).on("click",".count .inc",function(){
        var goods_id = $(this).closest('li').attr('id').replace('goods_','');
        var input = $(this).closest('.count').find('input');
        update_cart.call(input[0],goods_id,parseInt(input.val()) + 1);
    }).on("blur",".count input",function(){
        var goods_id = $(this).closest('li').attr('id').replace('goods_','');
        var re = /\d+$/gi;
        if(re.test($(this).val())){
            update_cart.call(this,goods_id,$(this).val());
        }else{
            $(this).val(function(){
                return this.defaultValue;
            });
        }
    });
    function update_cart(goods_id, num){
        var that = this;
        if(num > 0){
            Cute.api.post('/cart/save', {id: goods_id, nums: num}, function(json){
                if(json.code == 0){
                    $(that).val(num);
                    this.defaultValue = num;
                    $('.pay_num kbd').html(json.data.total_fee);
                    $('.detail_button .submit i').attr('title',json.data.total_nums).html(json.data.total_nums);
                    $.isFunction(window.update_cart_cb) && window.update_cart_cb.call(this, goods_id, num);
                }else{
                    alert('购物车更新失败，请重试！');
                    $(this).val(function(){
                        return this.defaultValue;
                    });
                }
            });
        }else{
            Cute.api.post('/cart/delete', {ids: goods_id}, function(json){
                if(json.code == 0){
                    $(that).val(0);
                    this.defaultValue = 0;
                    $('.pay_num kbd').html(json.data.total_fee);
                    $('.detail_button .submit i').attr('title',json.data.total_nums).html(json.data.total_nums);
                    $.isFunction(window.update_cart_cb) && window.update_cart_cb.call(this, goods_id, num);
                }else{
                    alert('购物车更新失败，请重试！');
                    $(this).val(function(){
                        return this.defaultValue;
                    });
                }
            });

        }
    }
});