<?php 

    class CommonTextModel extends Model
    {
        public $table = 'common_texts';

        public function getCompanyReviews($params = []) {
            $where = null;
            $order = null;
            $limit = null;

            if(!empty($params['where'])) {
                $where = " WHERE " . parent::conditionConvert($params['where']);
            }

            if(!empty($params['order'])) {
                $order = " ORDER BY " . $params['order'];
            }

            if(!empty($params['limit'])) {
                $limit = " LIMIT " . $params['limit'];
            }

            $this->db->query(
                "SELECT review.*, user.firstname as reviewer_name, 
                    concat(user.firstname, ' ' , user.lastname) as reviewer_fullname,
                    user.profile as reviewer_profile
                    
                    FROM {$this->table} as review
                    LEFT JOIN users as user 
                        ON user.id = review.owner_id
                    {$where} {$order} {$limit}"
            );

            return $this->db->resultSet();
        }

        public function deny($id) {
            return parent::update([
                'is_visible' => false
            ], $id);
        }
        
        public function approve($id) {
            return parent::update([
                'is_visible' => true
            ], $id);
        }
    }