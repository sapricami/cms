<!-- NAVBAR -->
<nav class="navbar navbar-default navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url();?>"><?=(isset($site_name))?$site_name:'';?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <?php if (isset($navbar_array)){ ?>
    <?php 
    foreach ($navbar_array as $key => $value) {
        if($value['menu_parent']==''){
            $new_menu[$value['menu_id']]= array( 'menu_title'=>$value['menu_title'] , 'menu_slug'=>$value['menu_slug'] );
        }else{
            $childern[$value['menu_id']] = array( 'menu_title'=>$value['menu_title'] , 'menu_slug'=>$value['menu_slug'] , 'menu_parent' => $value['menu_parent']);
        }
    }
    foreach ($childern as $key => $value) {
        $new_menu[$value['menu_parent']]['menu_childern'][] = $value;
    }
    ?>
        <ul class="nav navbar-nav navbar-right">
            <?php foreach ($new_menu as $key => $menu_item){ ?>
                <?php if( isset($menu_item['menu_childern']) && (!empty($menu_item['menu_childern']))){ ?>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$menu_item['menu_title']?> <span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <?php foreach($menu_item['menu_childern'] as $child) { ?>
                            <li><a href="<?=$child['menu_slug']?>"><?=$child['menu_title']?></a></li>
                        <?php } ?>
                      </ul>
                    </li>
                <?php }else{ ?>
                    <li class="<?php if(isset($current_slug)&&($current_slug==$menu_item['menu_slug'])){ ?>active<?php } ?>">
                        <a href="<?=$menu_item['menu_slug']?>" ><?=$menu_item['menu_title']?></a>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>
    <?php } ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<!-- NAVBAR END -->