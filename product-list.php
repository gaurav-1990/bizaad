<?php include_once ("includes/header.php"); ?>
<div class="inner-top-banner">

    <?php
    $cat_id = $nav->encrypt_decrypt("decrypt", $_GET["catid"]);
    $subcat = " ";

    $subcat = $nav->getSubCategory($cat_id);
    
    ?>
    <div class="inner-top-banner-in" style="background: url(../img/tour.jpg) no-repeat;">
<!--        <img src="<?= BASEURL ?>img/tour.jpg" alt=""/>-->
 
        <div class="headline">
            
            <h2><?=$subcat[0]->cat_name?> </h2>
            <a href="#"><?=$subcat[0]->cat_desc?></a>
        </div>

    </div>
</div>

<div class="product-category">
    <div class="container">
        <div class="product-category-in">
            <?php
            foreach ($subcat as $key => $value) {
                # code...
                //sub_name
                //ID
                //cat_name
                //base/catname/subname/id

                $catname = $nav->cleanString($value->cat_name);
                $subname = $nav->cleanString($value->sub_name);
                $ID = $nav->encrypt_decrypt("encrypt", $value->ID);
                ?>
                <div onclick="window.location.href = '<?= BASEURL ?><?= $catname ?>/<?= $subname ?>/<?= $ID ?>'" class="col-md-6 col-sm-6 col-xs-12 cat-pad">
                    <div class="product-show">
                        <img src="<?= BASEURL ?>Panel/uploads/subcategory/<?= $value->sub_img ?>" alt="">
                        <div class="pro-cont">
                            <h3><?= $value->sub_name ?></h3>
                            <p><?= $value->sub_desc ?></p>

                        </div>


                        <div class="but-set">
                            <button class="book" onclick="window.location.href = '<?= BASEURL ?>product-detail.php'"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<?php include_once ("includes/footer.php"); ?>