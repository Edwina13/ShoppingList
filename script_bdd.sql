CREATE DATABASE IF NOT EXISTS myList;

create table category
(
    id   serial       not null
        constraint category_pkey
            primary key,
    name varchar(255) not null
);

create unique index uniq_64c19c15e237e06
    on category (name);

create table product
(
    id            serial       not null
        constraint product_pkey
            primary key,
    category_id   integer      not null
        constraint fk_d34a04ad12469de2
            references category,
    name          varchar(255) not null,
    creation_date date         not null
);

create index idx_d34a04ad12469de2
    on product (category_id);

create unique index uniq_d34a04ad5e237e06
    on product (name);

create table shopping_list
(
    id            serial       not null
        constraint shopping_list_pkey
            primary key,
    name          varchar(255) not null,
    creation_date date         not null
);

create table shopping_list_product
(
    id               serial not null
        constraint shopping_list_product_pkey
            primary key,
    shopping_list_id integer
        constraint fk_dd8a4b6623245bf9
            references shopping_list,
    product_id       integer
        constraint fk_dd8a4b664584665a
            references product,
    quantity         integer
);

create index idx_dd8a4b6623245bf9
    on shopping_list_product (shopping_list_id);

create index idx_dd8a4b664584665a
    on shopping_list_product (product_id);

INSERT INTO category(name) VALUES('Frais'),('Boisson'),('Féculent'),('Fruit'),('Ménager');

INSERT INTO product(name, creation_date, category_id) 
VALUES('Oeufs','2021-03-14', '1'),('Fromage','2021-03-14', '1'),('Eau','2021-03-13', '2'),
('Fraise','2021-03-10', '4'),('Poire','2021-03-09', '4'),('Lessive','2021-03-12', '5');

