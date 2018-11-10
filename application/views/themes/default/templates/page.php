
<div class="container" id="main-content">

    <?php if(isset($page_data['page_subtitle'])) { ?>
        <h1 class="text-center"><?php echo $page_data['page_subtitle'];?></h1>
    <?php } ?>
    <!--First row-->
    <?php if(isset($page_data['page_content_html'])) { ?>
        <?php echo $page_data['page_content_html'];?>
    <?php } ?>
    <!--/.First row-->

</div>
<hr class="extra-margins">