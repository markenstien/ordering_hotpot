<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Item</h4>
            <?php echo btnList(_route('item:index'))?>
            <?php Flash::show()?>
        </div>

        <div class="card-body">
            <?php echo $item_form->start()?>
                <div class="row">
                    <div class="col-md-7">
                        <fieldset>
                            <legend>General</legend>
                            <?php __($item_form->getCol('name'))?>
                            <div class="row">
                                <div class="col"><?php __($item_form->getCol('sku'))?></div>
                                <div class="col"><?php __($item_form->getCol('barcode'))?></div>
                            </div>
                            <div class="row">
                                <div class="col"><?php __($item_form->getCol('cost_price'))?></div>
                                <div class="col"><?php __($item_form->getCol('sell_price'))?></div>
                            </div>
                            <?php __($item_form->getCol('manufacturer_id'))?>
                            <?php __($item_form->getCol('brand_id'))?>
                            <div class="row">
                                <div class="col"><?php __($item_form->getCol('packing'))?></div>
                                <div class="col"><?php __($item_form->getCol('qty_per_case'))?></div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-5">
                        <fieldset>
                            <legend>Secondary</legend>
                            <div class="row">
                                <div class="col"><?php __($item_form->getCol('min_stock'))?></div>
                                <div class="col"><?php __($item_form->getCol('max_stock'))?></div>
                            </div>
                            <div class="row">
                                <div class="col"><?php __($item_form->getCol('variant'))?></div>
                                <div class="col"><?php __($item_form->getCol('remarks'))?></div>
                            </div>
                        </fieldset>

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