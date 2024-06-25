drop table if exists common_texts;
create table common_texts(
    id int(10) not null primary key auto_increment,
    text_title varchar(100),
    text_content text,
    owner_id int(10) not null,
    is_visible boolean default true,
    text_color varchar(50),
    catalog varchar(100),
    user_rating tinyint,
    created_at timestamp default now(),
    updated_at timestamp default now() ON UPDATE now()
);