<?php
    namespace Services;
    class CategoryService {
        const ITEM = 'ITEMS';
        const COMMON_TRANSACTIONS = 'COMMON_TRANSACTIONS';

        const BRAND = 'BRAND';
        const MANUFACTURER = 'MANUFACTURER';

        public function getCategories() {

            return [
                self::BRAND,
                self::MANUFACTURER
            ];
        }

    }