<?php build('content')?>
<div class="container py-5">
  <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-body">
            <?php Flash::show()?>
            <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
            <img src="<?php echo _path_upload_get('hotpotlogo.png');?>" alt="<?php echo COMPANY_NAME?> Logo"
              style="width:150px; margin:0px auto; display:block">
            <?php  __( $form->start() ); ?>
              <div class="mb-3">
                <?php __( $form->getCol('email' , ['required' => true]) ); ?>
              </div>
              <div class="mb-3">
                <?php __( $form->getCol('password') ); ?>
              </div>
              <div>
                <?php __($form->get('submit')) ?>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <a href="<?php echo _route('auth:register')?>" class="d-block mt-3 text-muted">Not a user? Sign up</a>
                </div>
                <div class="col-md-6" style="text-align:right;">
                  <a href="<?php echo _route('forget-pw:index')?>" class="d-block mt-3 text-muted">Forgot Password?</a>
                </div>
              </div>
            <?php __( $form->end() )?>
        </div>
      </div>
  </div>
</div>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>


