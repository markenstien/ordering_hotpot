<?php

    class SupplyOrderItemModel extends Model
    {
        public $table = 'supply_order_items';
        
        public $_fillables = [
            'supply_order_id',
            'product_id',
            'quantity',
            'supplier_price',
            'damaged_quantity',
            'damage_notes',
            'created_at'
        ];

        public function createOrUpdate($itemData, $id = null) {
            $_fillables = parent::getFillablesOnly($itemData);

            if (!is_null($id)) {
                return parent::update($_fillables, $id);
            } else {
                return parent::store($_fillables);
            }
        }

        public function getItems($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if (isset($params['where'])) {
                $where = " WHERE ".parent::conditionConvert($params['where']);
            }

            if (isset($params['order'])) {
                $order = " ORDER BY ".$params['order'];
            }

            if (isset($params['limit'])) {
                $limit = " LIMIT ".$params['limit'];
            }

            $this->db->query(
                "SELECT soi.*, item.name as name 
                    FROM {$this->table} as soi
                        LEFT JOIN items as item 
                        ON item.id = soi.product_id
                {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }
    }