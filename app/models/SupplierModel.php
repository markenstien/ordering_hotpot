<?php

    class SupplierModel extends Model
    {
        public $table = 'suppliers';
        public $_fillables = [
            'name',
            'product',
            'website',
            'remarks',
            'status',
            'date_start',
            'contact_person_name',
            'contact_person_number',
            'created_by'
        ];

        public function createOrUpdate($supplierData, $id = null) {
            $retVal = true;
            $_fillables = $this->getFillablesOnly($supplierData);

            if($supplier = $this->getByName($supplierData['name'])) {
                $supplierNameErrorMsg = "Supplier {$supplierData['name']} Already exists";
                if(!is_null($id)) {
                    /**
                     * check if name is owned by editor
                     * otherwise-error
                     */
                    if($supplier->id != $id) {
                        $this->addError($supplierNameErrorMsg);
                        return false;
                    }
                } else {
                    $this->addError($supplierNameErrorMsg);
                    return false;
                }
            }

            if (!is_null($id)) {
                $retVal = parent::update($_fillables, $id);
                if($retVal) {
                    $this->addMessage("Supplier successfully updated");
                } else {
                    $this->addError("Update supplier failed");
                    $retVal = false;
                }
            } else {
                $retVal = parent::store($_fillables);
                if($retVal) {
                    $this->addMessage("Supplier {$supplierData['name']} saved");
                } else {
                    $this->addError("Create supplier failed");
                    $retVal = false;
                }
            }
            
            return $retVal;
        }

        public function getByName($name) {
            return parent::single([
                'name' => $name
            ]);
        }
    }