<?php

    class PaymentModel extends Model
    {
        public $table = 'payments';
        public $_fillables = [
            'order_id',
            'reference',
            'amount',
            'payment_method',
            'mobile_number',
            'address',
            'remarks',
            'organization',
            'account_number',
            'external_reference',
            'created_by'
        ];

        public function createOrUpdate($paymentData, $id = null) {
            $_fillables = parent::getFillablesOnly($paymentData);

            if (!is_null($id)) {
                return parent::update($_fillables, $id);
            } else {
                $_fillables['reference'] = $this->generateRefence();
                return parent::store($_fillables);
            }
        }

        public function getOrderPayment($id) {
            return parent::single(['order_id'=>$id]);
        }

        public function generateRefence() {
            return number_series(random_number(7));
        }

        public function approve($id) {

            /**
             * validate payment
             */

            $payment = parent::get($id);

            if($payment) {
                if(!isset($this->modelOrder)) {
                    $this->modelOrder = model('OrderModel');
                }
                $order = $this->modelOrder->get($payment->order_id);

                /**
                 * check payment amount
                 */
                if(floatval($payment->amount) >=  floatval($order->net_amount)) {
                    $isOkay = parent::update([
                        'remarks' => 'Payment Approved'
                    ], $id);

                    $this->addMessage("Payment Approved");
                    return true;
                } else {
                    $this->addError("Invalid Payment amount");
                    parent::update([
                        'remarks' => 'Invalid Payment'
                    ], $id);

                    $this->modelOrder->update([
                        'is_paid' => false
                    ], $id);


                    return false;
                }
            } else {
                $this->addError("Payment not found");
                return false;
            }
        }
    }