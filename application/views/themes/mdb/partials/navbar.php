<!-- NAVBAR -->
<nav class="navbar navbar-toggleable-md navbar-dark">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav1" aria-controls="navbarNav1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <strong>Sapricami CMS</strong>
        </a>
        <div class="collapse navbar-collapse" id="navbarNav1">
            <ul class="navbar-nav ml-auto ">

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

    <?php foreach ($new_menu as $key => $menu_item){ ?>
        <?php if( isset($menu_item['menu_childern']) && (!empty($menu_item['menu_childern']))){ ?>
            <li class="nav-item dropdown btn-group">
                <a class="nav-link dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$menu_item['menu_title']?></a>
                <div class="dropdown-menu dropdown" aria-labelledby="dropdownMenu1">
                    <?php foreach($menu_item['menu_childern'] as $child) { ?>
                        <a href="<?=$child['menu_slug']?>" class="dropdown-item"><?=$child['menu_title']?></a>
                    <?php } ?>
                </div>
            </li>
        <?php }else{ ?>
            <li class="nav-item <?php if(isset($current_slug)&&($current_slug==$menu_item['menu_slug'])){ ?>active<?php } ?>">
                <a href="<?=$menu_item['menu_slug']?>" class="nav-link"><?=$menu_item['menu_title']?> <span class="sr-only">(current)</span></a>
            </li>
        <?php } ?>
    <?php } ?>
<?php } ?>

            </ul>
        </div>
    </div>
</nav>
<!-- NAVBAR END -->