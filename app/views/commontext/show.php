<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Review</h4>
            <?php Flash::show()?>
        </div>

        <div class="card-body">
            <div class="col-md-7">
                <?php if(isEqual(whoIs('user_type'), ['admin', 'supervisor'])) :?>
                    <section class="mb-4">
                        <a href="<?php echo _route('common-text:approve', $review->id)?>" class="btn btn-primary btn-lg ">Approve</a>
                        <a href="<?php echo _route('common-text:deny', $review->id)?>" class="btn btn-primary btn-lg ">Hide</a>
                    </section>
                <?php endif?>
                
                <section class="mb-4">
                    <?php if(isEqual($review->owner_id, whoIs('id'))) :?>
                        <a href="<?php echo _route('common-text:edit', $review->id)?>" class="btn btn-primary btn-sm">
                            <i class="link-icon" data-feather="edit"></i> Edit</a>
                    <?php endif?>
                </section>
                <table class="table table-bordered table-sm">
                    <tr>
                        <td>Reviewer Name : </td>
                        <td><?php echo $review->reviewer_fullname?></td>
                    </tr>

                    <tr>
                        <td>Last Updated : </td>
                        <td><?php echo $review->updated_at?></td>
                    </tr>

                    <tr>
                        <td>Visiblity : </td>
                        <td><?php echo $review->is_visible ? 'Visible' : 'Hidden'?> </td>
                    </tr>
                </table>

                <section class="mt-5">
                    <h4 class="mb-3">Review Content</h4>
                    <?php echo $review->text_content?>
                </section>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>