
            <?php echo view('content/nav.php')?>
            <div id="myTabContent" class="tab-content" style="padding:10px 0px;">
              <div class="tab-pane fade active in" id="news">
                
                <div id="masonry" class="container-fluid">
                    <div class="thumbnail"> 
                        <div class="imgs" style="cursor: pointer;">
                            <a href="<?php echo current_url(array('action'=>'publish'))?>"> 
                            <img src="/images/01.jpg" />
                            </a>
                        </div>     
                    </div>

                    <?php  foreach ($this->content as $content):?>
                	<div class="thumbnail" style="width:270px;"> 
    <!--                     <div class="panel-heading" style="text-align:center">
                            <div class="btn-group btn-group-sm">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-resize-small"></span> 拉取</button>
                              <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-resize-full"></span> 推送</button>
                            </div>
                        </div> -->
                        <div class="imgs"> 
                            <img width="250" src="<?php echo get_content_images($content->content_text, true)?>" /> 
                        </div> 
                        <div class="caption"> 
                            <div class="title"><?php echo $content->content_tile?></div> 
                            <div class="content"> 
                                <?php echo $content->content_description?>
                            </div> 
                            <div class="author"> 
                                <?php echo date('Y-m-d H:i', $content->create_time)?>
                            </div> 
                        </div> 
                        <div class="panel-footer" style="text-align:center">
                            <div class="btn-group btn-group-sm">
                              <a href="<?php echo current_url(array('action'=>'delete', 'content_id'=>$content->content_id))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span> 删除</a>
                              <a href="<?php echo current_url(array('action'=>'edit', 'content_id'=>$content->content_id))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> 编辑</a>
                              <?php if($content->is_sync != 1):?>
                              <a href="<?php e(current_url(array('action'=>'sync', 'content_id'=>$content->content_id)))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-transfer"></span> 推送</a>
                              <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    
                </div>


              </div>
            </div>

  <script type="text/javascript">
    $(document).ready(function(){
        $("#nav-panel").height($(window).height());
        $('#myTab a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        });

        var masonryNode = $('#masonry'); 
        masonryNode.imagesLoaded(function(){ 
            masonryNode.masonry({ 
                itemSelector: '.thumbnail', 
                isFitWidth: true 
            }); 
        }); 

    })
  </script>