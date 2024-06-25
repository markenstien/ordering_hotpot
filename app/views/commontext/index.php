<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Reviews</h4>
            <?php echo wLinkDefault(_route('common-text:create'), 'Add Review')?>
            <?php Flash::show()?>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Reviewer</th>
                        <th>Message</th>
                        <th>Visiblity</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($reviews as $key => $row) :?>
                            <tr>
                                <td> <?php echo ++$key?> </td>
                                <td> <?php echo $row->reviewer_name?> </td>
                                <td> <?php echo crop_string($row->text_content, 50)?> </td>
                                <td> <?php echo wBadgeWrap($row->is_visible ? 'Visible' : 'Hidden', $row->is_visible ? 'success' : 'danger') ?> </td>
                                <td> <?php echo $row->updated_at?> </td>
                                <td>
                                    <?php echo wLinkDefault(_route('common-text:show', $row->id), 'show')?>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>