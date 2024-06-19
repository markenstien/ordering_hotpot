<?php build('content')?>
<div class="container-xxl py-5 bg-dark hero-header mb-5">
		<div class="container my-5 py-5">
			<div class="row align-items-center g-5">
				<div class="col-lg-6 text-center text-lg-start">
					<h1 class="display-3 text-white animated slideInLeft">Register Your Account</h1>
				</div>
				<div class="col-lg-6 text-center text-lg-end overflow-hidden">
					<img class="img-fluid" src="img/hero.png" alt="">
				</div>
			</div>
		</div>
	</div>


<div class="container py-5">
  <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-body">
            <?php Flash::show()?>
            <img src="<?php echo _path_upload_get('hotpotlogo.png');?>" alt="<?php echo COMPANY_NAME?> Logo"
              style="width:150px; margin:0px auto; display:block">
            <h5 class="text-muted fw-normal mb-4">Create your account.</h5>
            <?php  __( $form->start() ); ?>
              <div class="row">
                <div class="col mb-3">
                  <?php __( $form->getCol('firstname' , ['required' => true]) ); ?>
                </div>
                <div class="col mb-3">
                  <?php __( $form->getCol('lastname' , ['required' => true]) ); ?>
                </div>
              </div>
              <div class="mb-3">
                <?php __( $form->getCol('email' , ['required' => true]) ); ?>
              </div>
              <div class="mb-3">
                <?php __( $form->getCol('phone' , ['required' => true]) ); ?>
              </div>
              <div class="mb-3">
                <?php __( $form->getCol('password') ); ?>
              </div>
              <div>
                <?php __($form->get('submit')) ?>
              </div>
              <a href="<?php echo _route('auth:login')?>" class="d-block mt-3 text-muted">Already a user? Sign-In Here</a>
            <?php __( $form->end() )?>
        </div>
      </div>
  </div>
</div>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>