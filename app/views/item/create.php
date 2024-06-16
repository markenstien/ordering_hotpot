<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Item</h4>
            <?php echo wLinkDefault(_route('item:index'), 'Item list')?>
            <?php Flash::show()?>
        </div>

        <div class="card-body">
            <?php echo $item_form->start()?>
                <div class="row">
                    <div class="col-md-7">
                        <section>
                            <h3>General</h3>
                            <?php __($item_form->getCol('name'))?>
                            <div class="row mt-2">
                                <div class="col"><?php __($item_form->getCol('sku'))?></div>
                                <div class="col"><?php __($item_form->getCol('barcode'))?></div>
                            </div>
                            <div class="row mt-2">
                                <div class="col"><?php __($item_form->getCol('cost_price'))?></div>
                                <div class="col"><?php __($item_form->getCol('sell_price'))?></div>
                            </div>

                            <div class="row mt-2">
                                <?php __($item_form->getCol('remarks'))?>
                            </div>
                        </section>
                        <?php echo wDivider(50)?>
                        <section>
                            <h3>Secondary</h3>
                            <div class="row">
                                <div class="col"><?php __($item_form->getCol('min_stock'))?></div>
                                <div class="col"><?php __($item_form->getCol('max_stock'))?></div>
                            </div>
                        </section>
                        <?php echo wDivider(20)?>
                        <?php __($item_form->getCol('submit'))?>
                    </div>
                </div>
            <?php echo $item_form->end();?>
        </div>
    </div>
<?php endbuild()?>
<script>
    $(document).ready(function() {
        $(body).on('submit', function() {
            alert('submit?');
        });
    });
</script>
<?php loadTo()?>