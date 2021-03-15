DROP DATABASE mylist;

CREATE DATABASE myList;

CREATE TABLE category (
    id SERIAL,
    name varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE product (
    id SERIAL,
    name varchar(255),
    created_at date,
    category_id int,
    PRIMARY KEY (id),
    CONSTRAINT fk_category_id
    FOREIGN KEY(category_id)
    REFERENCES category(id)
    ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE table shopping_list (
	id SERIAL, 
	name varchar(255),
	created_at date,
	PRIMARY KEY (id)
)

CREATE TABLE shopping_list_product (
	shopping_list_id int,
	product_id int,
	PRIMARY KEY (shopping_list_id, product_id),
	CONSTRAINT fk_shopping_list_id FOREIGN KEY (shopping_list_id)
		REFERENCES shopping_list(id) 
			ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT fk_product_id FOREIGN KEY (product_id)
		REFERENCES product(id) 
			ON DELETE NO ACTION ON UPDATE NO ACTION
)




