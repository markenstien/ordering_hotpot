<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"></h4>
            <?php echo wLinkDefault(_route('bank-org:create'), 'Add Bank')?>
            <?php Flash::show()?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Bank Code</th>
                        <th>Bank Name</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
                        <?php foreach($banks as $key => $row) :?>
                            <tr>
                                <td><?php echo ++$key?></td>
                                <td><?php echo $row->bank_code?></td>
                                <td><?php echo $row->bank_name?></td>
                                <td>
                                    <?php echo wLinkDefault(_route('bank-org:edit', $row->id), 'Edit')?> &nbsp; | &nbsp;
                                    <?php echo wLinkDefault(_route('bank-org:delete', $row->id), 'Delete')?>
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