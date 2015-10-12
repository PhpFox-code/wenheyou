<?php echo view('message/nav.php')?>
            <div id="myTabContent" class="tab-content" style="padding:10px 0px;">
              <div class="tab-pane fade active in" id="news">
                
                <div id="masonry" class="container-fluid">
                    <?php foreach($this->rows as $row):?>
                	<div class="thumbnail" > 
                        <div class="panel-heading">
                            <img src="<?php echo $row->user->user_avatar?>" width="30" height="30" class="img-circle">  
                            <?php echo $row->user->user_name?>
                            <h6><?php echo date('Y-m-d H:i:s',$row->create_time)?></h6>         
                        </div>
                        <div style="min-height:30px">
                            <?php $content = json_decode($row->message_content, true);?>
                            <?php if($content['MsgType'] == 'text'):?>
                            <div class="row">
                                <div class="pull-left"><button type="button" class="btn btn-primary btn-sm"><?php echo $content['Content']?></button></div>
                            </div>
                            <?php endif;?>
                            <?php if($content['MsgType'] == 'image'):?>
                            <div class="row">
                                <div class="pull-left">
                                    <img width="100" src="<?php $message = new \Enterprise\Message(); echo $message->get_media($content['MediaId'])?>" alt="..." class="img-thumbnail">
                                </div>
                            </div>
                            <?php endif;?>
                            <?php if($content['MsgType'] == 'event'):?>
                            <div class="row">
                                <div class="pull-left">
                                <button type="button" style="text-align:left; width:200px;" class="btn btn-primary btn-sm">
                                <?php 
                                foreach ($content as $key => $val)
                                {
                                    if (is_array($val))
                                    {
                                        foreach ($val as $k => $v)
                                        {
                                            $str .= $key .":{$v}";
                                        }
                                    }
                                    else 
                                    {
                                        $str = $val;
                                    }
                                    echo $key.':'.$str.'<br>';
                                }
                                ?>
                                </button>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                        <?php if('nomal'== get('active')):?>
                        <div class="panel-footer">
                            <form class="form-inline" method="post" action="/message/reply" role="form" style="margin:0px;">
                              <div class="form-group">
                                <input type="text" name="content" class="form-control" id="inputPassword2" placeholder="回复内容">
                                <input type="hidden" name="to_user" value="<?php e($row->user->user_id)?>">
                              </div>
                              <button type="submit" class="btn btn-default">提交</button>
                            </form>
                        </div>
                        <?php endif;?>
                    </div>
                    <?php endforeach;?>


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