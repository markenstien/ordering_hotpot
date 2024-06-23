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

            if(!empty($paymentData['external_reference']) && !empty($paymentData['organization'])) {
                $_fillables['payment_method'] = 'ONLINE';
            }

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
                parent::_addRetval('order_id', $order->id);
                /**
                 * check payment amount
                 */
                if(floatval($payment->amount) >=  floatval($order->net_amount)) {
                    $isOkay = parent::update([
                        'remarks' => 'Payment Approved'
                    ], $id);

                    $this->modelOrder->update([
                        'is_paid' => true,
                    ], $order->id);

                    $this->addMessage("Payment Approved");
                    return true;
                } else {
                    $this->addError("Invalid Payment amount");
                    parent::update([
                        'remarks' => 'Invalid Payment'
                    ], $order->id);
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

        public function invalidate($id) {
            $payment = parent::get($id);

            if($payment) {
                if(!isset($this->modelOrder)) {
                    $this->modelOrder = model('OrderModel');
                }
                $order = $this->modelOrder->get($payment->order_id);

                if($order->is_paid) {
                    $this->modelOrder->update([
                        'is_paid' => false
                    ], $id);
                }

                $resp = parent::update([
                    'remarks' => 'Invalid Payment'
                ], $id);

                $this->addMessage("Payment Denied");

                return $resp;
            }
            $this->addError("payment not found");
            return false;
        }

        public function getImage($id) {
            if(!isset($this->_attachmentModel)) {
                $this->_attachmentModel = model('AttachmentModel');
            }
            return $this->_attachmentModel->single([
                'global_id' => $id,
                'global_key' => 'ORDER_PAYMENT_IMAGE'
            ]);
        }
    }