alter table items 
    add column manufacturer_id int(10),
    add column brand_id int(10);


alter table items 
    add column packing tinyint,
    add column qty_per_case tinyint;


alter table users add column user_type char(50);