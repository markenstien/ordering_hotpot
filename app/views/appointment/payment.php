<?php build('content') ?>
    <section id="team" data-stellar-background-ratio="1">
        <div class="container">
            <h4 class="mb-5">Attach Payment</h4>
                <?php echo $paymentForm->start()?>
                    <?php Form::hidden('appointment_id', $appointment->id)?>
                    <?php Form::hidden('origin', 'Reservation')?>
                    <div class="form-group"> <?php echo $paymentForm->getRow('amount', [
                        'attributes' => [
                            'readonly' => true,
                            'class' => 'form-control'
                        ]
                    ])?> </div>
                    <div class="form-group"><?php echo $paymentForm->getRow('method')?></div>
                    <div class="form-group"> <?php echo $paymentForm->getRow('file_attachment')?> </div>
                    <div class="form-group"> <?php Form::submit('', 'Attachment payment')?> </div>
                <?php echo $paymentForm->end()?>
        </div>
    </section>
<?php endbuild()?>
<?php loadTo('tmp/public')?>