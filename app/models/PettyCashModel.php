<?php
    use Services\StockService;
    load(['StockService'],SERVICES);

    class PettyCashModel extends Model
    {
        public $table = 'petty_cash';
        public $_fillables = [
            'reference',
            'user_id',
            'amount',
            'entry_type',
            'category_id',
            'remarks',
            'date',
            'created_by'
        ];

        public function createOrUpdate($pettyCashData, $id = null) {
            
            $_fillables = parent::getFillablesOnly($pettyCashData);
            $amount = $this->_convertAmount($_fillables);
            $_fillables['amount'] = $amount;

            if (!is_null($id)) {
                $this->addMessage(parent::$MESSAGE_UPDATE_SUCCESS);
                return parent::update($_fillables, $id);
            } else {
                $this->addMessage(parent::$MESSAGE_CREATE_SUCCESS);
                $_fillables['reference'] = referenceSeries(parent::lastId(),'6','PT');
                return parent::store($_fillables);
            }
        }
        
        private function _convertAmount($entryData) {
            $quantity = $entryData['amount'];
            if ($entryData['amount'] <= 0) {
                $this->addError("Invalid Quantity Amount");
                return false;
            }
            if ($entryData['entry_type'] == StockService::ENTRY_DEDUCT) {
                $quantity = $entryData['amount'] * (-1);
            }

            return $quantity;
        }

        public function all($where = null , $order_by = null , $limit = null) {

            if (!is_null($where)) {
                $where = " WHERE ".parent::conditionConvert($where);
            }

            if(!is_null($order_by)) {
                $order_by = " ORDER BY " . $order_by;
            }

            if(!is_null($limit)) {
                $limit = " LIMIT {$limit}";
            }

            $this->db->query(
                "SELECT petty.*, concat(user.firstname, user.lastname) as staff_name,
                    category.name as category
                    FROM {$this->table} as petty
                        LEFT JOIN users as user
                        ON user.id = petty.user_id

                        LEFT JOIN categories as category
                        ON petty.category_id = category.id
                        {$where} {$order_by} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function get($id) {
            $petty = $this->all(['petty.id' => $id]);
            if(!$petty)
                return false;
            return $petty[0];
        }

        public function getSummary($where = null, $order_by = null , $limit = null) {
            if (!is_null($where)) {
                $where = " WHERE ".parent::conditionConvert($where);
            }

            if(!is_null($order_by)) {
                $order_by = " ORDER BY " . $order_by;
            }

            if(!is_null($limit)) {
                $limit = " LIMIT {$limit}";
            }

            $this->db->query(
                "SELECT petty.*, SUM(amount) as total_amount, 
                    concat(user.firstname, user.lastname) as staff_name
                    FROM {$this->table} as petty
                    LEFT JOIN users as user
                    ON user.id = petty.user_id
                    {$where} 
                        GROUP BY user_id
                    {$order_by} {$limit}"
            );

            return $this->db->resultSet();
        }
    }