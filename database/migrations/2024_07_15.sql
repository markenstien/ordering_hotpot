create table bank_orgs(
    id int(10) not null primary key auto_increment,
    bank_name varchar(100),
    bank_code varchar(50),
    created_at timestamp default now()
);