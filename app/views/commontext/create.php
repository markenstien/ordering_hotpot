<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Reviews</h4>
            <?php Flash::show()?>
            <?php echo wLinkDefault(_route('common-text:index'), 'Reviews')?>
        </div>

        <div class="card-body">
            <div class="col-md-7">
                <?php echo $commonTextForm->start()?>
                    <div class="form-group">
                        <?php echo $commonTextForm->getRow('text_content')?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Submit Review</button>
                    </div>
                <?php echo $commonTextForm->end();?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>