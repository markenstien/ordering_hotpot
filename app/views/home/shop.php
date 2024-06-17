<?php build('content') ?>

<div class="container-xxl py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Food Menu</h1>
    </div>
</div>

<?php if(!empty($_GET['q'])) :?>
<!-- Start Content -->
<div class="container py-5">
    <?php echo wLinkDefault('?', 'Remove Filter : ' . $_GET['q'])?>
    <div>Total Result : <?php echo count($items)?></div>
</div>
<?php endif?>

<?php Flash::show() ?>
<?php if(!empty($items)) :?>
    <div class="container py-5">
        <div class="row">
            <?php foreach($items as $key => $row) :?>
                <div class="col-lg-6 mb-5" onclick="window.location = '<?php echo _route('home:catalog-view', $row->id)?>'" style="cursor:pointer">
                    <div class="d-flex align-items-center">
                        <div class="w-100 d-flex flex-column text-start ps-4">
                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                <span><?php echo $row->name?></span>
                                <span class="text-primary"><?php echo amountHTML($row->sell_price, 'PHP')?></span>
                            </h5>
                            <div class="mb-2">
                                <img class="flex-shrink-0 img-fluid rounded" src="<?php echo $row->images[0]->full_url ?? ''?>" 
                                alt="" style="width: 150px;">
                            </div>
                            <small class="fst-italic"><?php echo $row->remarks?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    </div>
    <?php else:?>
        <p class="text-center">No Items found.</p>
<?php endif?>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>