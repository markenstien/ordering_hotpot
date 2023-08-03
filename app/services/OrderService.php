<?php
    namespace Services;
    use Session;
    class OrderService {
        public static function startPurchaseSession($name = 'purchase'){
            $token = get_token_random_char(20);
            Session::set($name, $token);
            return $token;
        }

        public static function endPurchaseSession($name = 'purchase'){
            Session::remove($name);
        }

        public static function getPurchaseSession($name = 'purchase'){
            return Session::get($name);
        }
        
        public function getOrdersWithin30days($endDate) {
            $startDate30Days = date('Y-m-d',strtotime($endDate.'-30 days'));
            $orderItemModel = model('OrderItemModel');
            $items = $orderItemModel->getItemsByParam([
                'where' => [
                    'ordr.created_at' => [
                        'condition' => 'between',
                        'value' => [$startDate30Days, $endDate]
                    ]
                ]
            ]);

            $summary = $orderItemModel->getItemSummary($items); 
            return $summary['netAmount'];
        }
    }