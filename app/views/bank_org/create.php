<?php build('content') ?>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>
                <?php echo wLinkDefault(_route('bank-org:index'), 'Bank to banks')?>
            </div>
            <div class="card-body">
                <?php echo $bankOrgForm->start()?>
                    <?php echo $bankOrgForm->getRow('bank_code')?>
                    <?php echo $bankOrgForm->getRow('bank_name')?>

                    <button type="submit" role="button" class="btn btn-primary btn-sm">Create</button>
                <?php echo $bankOrgForm->end()?>
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>