<?php build('content') ?>
    <div class="container py-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <?php Flash::show()?>
                    <div class="text-center">
                        <h4>Enter Verification Code</h4>
                            <?php  Form::open(['method' => 'post'])?>
                            <div class="form-group mt-3">
                                <?php Form::text('verification_code', '' , ['class' => 'form-control form-control-lg','placeholder' => 'Enter 4 Digit Verification Code'])?>
                            </div>
                            <div class="form-group mt-4">
                                <?php Form::submit('', 'Verify Code')?>
                            </div>
                        <?php  Form::close()?>
                    </div>
                </div>

                <?php echo wDivider(80)?>
                <img src="<?php echo _path_upload_get('hotpotlogo.png');?>" alt="<?php echo COMPANY_NAME?> Logo"
                style="width:150px; margin:0px auto; display:block">
            </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>