<?php build('content') ?>
    <div class="mx-auto col-md-6">
        <div>
            <div class="text-center">
                <h1>#<?php echo $order->reference?></h1>
                <p>Order Receipt</p>
            </div>
            <h3>Customer Info</h3>
            <table class="table table-bordered">
                <tr>
                    <td>Customer Name : </td>
                    <td><?php echo $order->customer_name?></td>
                </tr>
                <tr>
                    <td>Mobile Number : </td>
                    <td><?php echo $order->mobile_number?></td>
                </tr>
                <tr>
                    <td>Address : </td>
                    <td><?php echo $order->address?></td>
                </tr>
            </table>
            <h3>Particulars</h3>
            <table class="table-bordered table">
                <thead>
                    <th>Quantity</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Total</th>
                </thead>

                <tbody>
                    <?php foreach($items as $key => $row):?>
                        <tr>
                            <td><?php echo $row->quantity?></td>
                            <td>
                                <?php echo $row->name?>
                                <div><?php echo wLinkDefault( _route('home:catalog-view', $row->item_id), 'Show Item')?></div>
                            </td>
                            <td><?php echo amountHTML($row->price)?></td>
                            <td>
                                <?php echo amountHTML($row->sold_price)?>
                                <?php if($row->discount_price) :?>
                                    <div><small>(<?php echo amountHTML($row->discount_price)?>)</small></div>
                                <?php endif?>
                            </td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>

            <section>
                <p class="infosec">
                    You have received a total of <strong><?php echo $order->discount_amount?></strong> Discount on this order
                </p>
            </section>

            <section>
                <h1>Total : <?php echo amountHTML($order->net_amount)?></h1>
            </section>
            
            <?php if($payment) :?>
            <section class="mt-2">
                <div class="row">
                    <div class="col-md-5">
                        <table class="table-bordered table">
                            <tr>
                                <td>Reference #</td>
                                <td><?php echo $payment->reference?></td>
                            </tr>
                            <tr>
                                <td>Amount Paid</td>
                                <td><?php echo $payment->amount?></td>
                            </tr>
                            <tr>
                                <td>Remarks</td>
                                <td><?php echo $payment->remarks?></td>
                            </tr>

                            <?php if(!empty($payment->organization)) :?>
                                <tr>
                                    <td>Organization / Bank Name / Wallet Name</td>
                                    <td><?php echo $payment->organization?></td>
                                </tr>
                                <tr>
                                    <td>Payment Reference</td>
                                    <td><?php echo $payment->external_reference?></td>
                                </tr>
                            <?php endif?>
                        </table>
                    </div>

                    <?php if($paymentImage) :?>
                        <div class="col-md-7">
                            <img src="<?php echo $paymentImage->full_url?>" alt="Payment Image" style="width:100%">
                        </div>
                    <?php endif?>
                </div>
            </section>
            <?php endif?>

            <section class="mt-5">
                <?php if(empty(whoIs())) :?>
                    <a href="<?php echo _route('home:shop')?>" class="btn btn-primary btn-sm">Back</a>
                <?php else:?>
                    <a href="<?php echo _route('transaction:purchase')?>" class="btn btn-primary btn-sm">Back</a>
                <?php endif?>
                
                <?php if(!$payment) :?>
                    <?php echo wLinkDefault('#', 'Pay Now', [
                        'class' => 'btn btn-primary btn-sm',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#addPayment'
                    ])?>
                <?php endif?>
                <!-- paymentForm
                paymentOnlineForm -->
            </section>
        </div>
    </div>

    <div class="modal fade" id="addPayment" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Payment Form</h5>
                <button type="button" class="btn-close" 
                    data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <?php echo $paymentForm->start()?>
                    <?php echo $paymentForm->getCol('order_id')?>
                    <?php echo $paymentForm->getCol('payer_name')?>
                    <?php echo $paymentForm->getCol('amount')?>
                    <?php echo $paymentOnlineForm->getCol('external_reference')?>
                    <?php echo $paymentOnlineForm->getCol('organization')?>
                    <?php echo $_attachmentForm->getCol('file')?>

                    <input type="submit" name="" value="Add Payment" class="btn btn-primary btn-sm mt-3">
                <?php echo $paymentForm->end()?>
            </div>
        </div>
        </div>
    </div>
<?php endbuild()?>
<?php loadTo()?>