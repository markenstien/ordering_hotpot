DROP TABLE IF EXISTS orders;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` text NOT NULL,
  `reference` varchar(50) NOT NULL,
  `customer_name` varchar(100),
  `address` varchar(255),
  `mobile_number` varchar(50),
  `email` varchar(100),
  `date_time` varchar(255),
  `gross_amount` varchar(255),
  `net_amount` varchar(255),
  `discount_amount` varchar(255),
  `is_paid` int(11),
  `remarks` text DEFAULT NULL,
  `staff_id` int(10),
  `order_status` enum('completed','cancelled','ongoing') DEFAULT 'ongoing',
  `created_at` timestamp DEFAULT now(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8