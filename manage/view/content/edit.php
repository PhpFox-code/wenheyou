            <?php echo view('content/nav.php')?>
            <div id="myTabContent" class="tab-content" style="padding:10px 0px;">
              <div class="tab-pane fade active in" id="news">
                    <!-- Form -->
                <form role="form" method="post" action="/content/save" style="padding:10px;">
                  <div class="form-group">
                    <label>内容标题</label>
                    <input type="hidden" name="content_id" value="<?php e($this->content->content_id)?>">
                    <input type="text" class="form-control" name="content_title" value="<?php e($this->content->content_title)?>"  placeholder="名称">
                  </div>
                  
                  <div class="form-group">
                    <label>内容摘要</label>
                    <textarea type="textarea" class="form-control" name="content_description"  placeholder="预览的描述信息" rows="4"><?php e($this->content->content_description)?></textarea>
                  </div>
            
                  <div class="form-group">
                    <label>内容正文, 第一张图片将被用作微信news信息的封面</label>
                    <textarea  id="edit" name="content_text" placeholder="这里输入内容" autofocus><?php e($this->content->content_text)?></textarea>
                  </div>
            
                  <div class="form-group ">
                      <button type="submit" class="btn btn-primary">提交保存</button>
                  </div>
                </form>



              </div>
              <div class="tab-pane fade" id="sound">
                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
              </div>
              <div class="tab-pane fade" id="video">
                <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
              </div>
            </div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#edit').editable({
            inlineMode: false,
            imageUploadURL: "/content/upload",
            // Set content changed callback.
            contentChangedCallback: function () {
              console.log ('content has been changed');
            }
          })

    })
</script>