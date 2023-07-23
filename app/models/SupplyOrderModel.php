<?php

    use Services\StockService;
    load(['StockService'], SERVICES);

    class SupplyOrderModel extends Model
    {
        public $table = 'supply_orders';
        public $_fillables = [
            'reference',
            'title',
            'supplier_id',
            'date',
            'amount',
            'budget',
            'balance',
            'status',
            'payment_status',
            'description',
            'created_by'
        ];

        public function createOrUpdate($supplyOrderData, $id = null) {
            $supplyOrderData = parent::getFillablesOnly($supplyOrderData);
            $supplyOrderData['reference'] = $this->generateReference();
            $supplyOrderData['status']    = 'pending';
            $orderId = parent::store($supplyOrderData);

            return $orderId;
        }

        public function generateReference() {
            return referenceSeries(parent::lastId(),4,date('y').'-','-SO');
        }

        public function getAll($id) {
            $supplyOrderItemModel = model('SupplyOrderItemModel');
            $supplyOrder = $this->get($id);
            if(!$supplyOrder) return false;

            $supplyOrder->items = $supplyOrderItemModel->getItems([
                'where' => [
                    'supply_order_id' => $id
                ]
            ]);

            return $supplyOrder;
        }

        public function get($id) {
            $this->db->query(
                "SELECT so.*, supplier.name as supplier_name
                    FROM {$this->table} as so 
                    LEFT JOIN suppliers as supplier
                    ON supplier.id = so.supplier_id
                WHERE so.id = '{$id}'"
            );
            return $this->db->single();
        }


        public function approveAndUpdateStock($id) {
            $supplyOrder = $this->getAll($id);
            if(!$supplyOrder)
                return false;
            $this->stockModel = model('StockModel');
            if (empty($supplyOrder->items)) {
                $this->addError("No supply orders");
                return false;
            }

            foreach ($supplyOrder->items as $key => $row) {
                $this->stockModel->createOrUpdate([
                    'quantity' => $row->quantity,
                    'supply_order_id' => $id,
                    'item_id' => $row->product_id,
                    'remarks' => 'From Supply Order.'.$supplyOrder->reference,
                    'entry_type' => StockService::ENTRY_ADD,
                    'entry_origin' => StockService::PURCHASE_ORDER,
                    'date' => $supplyOrder->date
                ]);
            }

            $this->addMessage("Supply Order has been delivered and stocks are updated.");

            return parent::update([
                'status' => 'delivered'
            ], $id);
        }
    }