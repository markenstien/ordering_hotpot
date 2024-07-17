<?php build('content') ?>

<div class="container-xxl py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Reservation</h1>
    </div>
</div>

<!-- Start Content -->
<div class="container py-5">
    <div class="col-md-6 mx-auto">
        <h1>Reserve a table</h1>
        <?php Flash::show() ?>
        <?php echo $appointmentForm->start() ?>
            <div class="form-group">
                <?php echo $appointmentForm->getRow('guest_name')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('guest_phone')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('guest_email')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('date')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('branch')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('number_of_people')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('start_time')?>
            </div>

            <div class="form-group">
                <?php echo $appointmentForm->getRow('notes')?>
            </div>
            
            <?php if(whoIs()) :?>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-sm">Reserve</button>
            </div>
            <?php else :?>
                <p>To reserve you must have an account with us <?php echo wLinkDefault( _route('auth:register'), 'Register here.')?></p>
            <?php endif?>
        <?php echo $appointmentForm->end() ?>
    </div>
</div>

<?php endbuild()?>

<?php build('styles') ?>
 <style>
    #branch{
        background-color: #fff;
    }
 </style>
<?php endbuild()?>
<?php loadTo('tmp/landing')?>