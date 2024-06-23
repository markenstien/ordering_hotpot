<?php build('content') ?>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Payment</h4>
        </div>

        <div class="card-body">
            <?php if(whoIs('user_type', ['admin', 'staff'])) :?>
            <div class="mb-3">
                <a href="<?php echo _route('payment:approve', $payment->id)?>" class="btn btn-lg btn-primary">Approve</a>
                <a href="<?php echo _route('payment:invalidate', $payment->id)?>" class="btn btn-lg btn-danger">Denied</a>
            </div>
            <?php endif?> 
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Reference: </td>
                        <td>#<?php echo $payment->reference?></td>
                    </tr>
                    <tr>
                        <td>Method</td>
                        <td><?php echo $payment->payment_method?></td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td><?php echo $order->customer_name?></td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td><?php echo $payment->remarks?></td>
                    </tr>

                    <?php if(isEqual($payment->payment_method, 'ONLINE')) :?>
                        <tr>
                            <td>External Reference: </td>
                            <td>#<?php echo $payment->external_reference?></td>
                        </tr>
                        <tr>
                            <td>Organization: </td>
                            <td><?php echo $payment->organization?></td>
                        </tr>
                        <tr>
                            <td>Account Number: </td>
                            <td><?php echo $payment->account_number?></td>
                        </tr>
                    <?php endif?>
                    <tr>
                        <td>Amount: </td>
                        <td><?php echo $payment->amount?></td>
                    </tr>
                    <tr>
                        <td>Order: </td>
                        <td><a href="<?php echo _route('order:show', $payment->order_id)?>">Show</a></td>
                    </tr>
                </table>
            </div>
            
            <?php if($paymentImage) :?>
            <section class="mt-5">
                <h4>Payment Proof</h4>
                <img src="<?php echo $paymentImage->full_url?>" alt=""style="width:250px">
            </section>
            <?php endif?>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>