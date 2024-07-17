<?php

    namespace Classes\Report;

    class SalesReport{

        private $_items;
        private $_calc;
        /**
         * list of items
         */
        public function setItems($items = []) {
            $this->_items = $items;
            $this->_initCalc();
            return $this;
        }
        /**
         * what to get in summary
         */
        private function _initCalc() 
        {
            $retVal = [
                'totalSalesInQuantity' => 0,
                'totalSalesInAmount' => 0,
                'totalDiscountAmount' => 0,
                'totalSoldItemVariety' => 0
            ];

            if ($this->_items) {
                $items = $this->_items;
                foreach($items as $key => $row) {
                    $retVal['totalSoldItemVariety']++;
                    $retVal['totalSalesInQuantity'] += $row->quantity;
                    $retVal['totalSalesInAmount'] += $row->quantity * $row->price;
                    $retVal['totalDiscountAmount'] += $row->discount_price;
                }
            }

            $this->_calc = $retVal;
        }

        public function getSummary() {
            return $this->_calc;
        }
        /**
         * GROUPINGS
         * DAILY,WEEKLY,MONTHLY
         */
        private function _groupItems($groupType) {
            $totalSales = 0;
            switch($groupType) {
                case 'monthly':

                break;
            }
        }
        public function computeSalesPerMonth($orders) {
            $salesPerMonth = [];

            foreach($orders as $key => $row) {
                $date = date('M-Y', strtotime($row->date_time));
                
                if(!isset($salesPerMonth[$date])) {
                    $salesPerMonth[$date] = 0;
                }

                $salesPerMonth[$date] += $row->net_amount;
            }

            return $salesPerMonth;
        }

        public function topItems($order_items) {
            
        }
    }