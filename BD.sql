CREATE DATABASE bdinventario;
USE bdinventario;

drop table if exists id_value_tbl;
drop table if exists products;
drop table if exists stores;
drop table if exists suppliers;
drop table if exists brands;
drop table if exists categories;
drop table if exists workers;
drop table if exists document_type;


drop table if exists id_value_tbl;
create table id_value_tbl
(
	id int(6) primary key auto_increment,
    name int
);

drop table if exists stores;
create table stores
(
	id int auto_increment not null primary key,
    address varchar(200) not null,
    description varchar(200),
    created_at datetime,
    updated_at datetime
);

drop table if exists suppliers;
CREATE TABLE suppliers
(
	id int auto_increment not null primary key,
    bussiness_name varchar(100) not null,
    ruc varchar(11) not null,
    address varchar(255),
    phone varchar(25),
    landline varchar(25),
    created_at datetime,
    updated_at datetime
);

drop table if exists brands;
create table brands
(
	id int auto_increment not null primary key,
    name varchar(30) not null,
    created_at datetime,
    updated_at datetime
);

drop table if exists categories;
CREATE TABLE categories
(
	id int auto_increment not null primary key,
    name varchar(50),
    created_at datetime,
    updated_at datetime
);

drop table if exists document_type;
CREATE TABLE document_type
(
	id int auto_increment not null primary key,
    document_type varchar(50) not null
);

drop table if exists workers;
CREATE TABLE workers
(
	id int auto_increment not null primary key,
    name varchar(50) not null,
    lastname varchar(50) not null,
    document_type_id int not null,
    document varchar(25),
    created_at datetime,
    updated_at datetime,    
	foreign key (document_type_id) references document_type(id)
);

drop table if exists products;
CREATE TABLE products
(
	id int auto_increment not null primary key,
    code varchar(200) unique,
    product_name varchar(150) not null,
    supplier_id int not null,
    brand_id int not null,
    category_id int not null,
    store_id int not null,    
    description varchar(255),
    price decimal(7,2),
    stock int,
    created_at datetime,
    updated_at datetime,
    foreign key (supplier_id) references suppliers(id),
    foreign key (brand_id) references brands(id),
    foreign key (category_id) references categories(id),
    foreign key (store_id) references stores(id)
);

drop table if exists worker_product;
CREATE TABLE worker_product
(
	id int auto_increment not null primary key,    
    worker_id int not null,
    product_id int not null,        
    amount int,
    created_at datetime,
    updated_at datetime,
    foreign key (worker_id) references workers(id),
    foreign key (product_id) references products(id)
);

-- ------------------------------------------- DATA DE PRUEBA -------------------------------------------

INSERT INTO stores(address, description) VALUE('OFICINA PONCE SALON 4 TERCER PISO', 'SE GUARDA TODO LO RELACIONADO CON CAMARAS, Y LO USADO PARA SALIR A CAMPO');
INSERT INTO stores(address, description) VALUE('OFICINA PONCE SALON 2 TERCER PISO', 'SE GUARDA TODO LO QUE SE USA PARA CASA DE LA COMEDIA');
-- SELECT * FROM stores;

INSERT INTO suppliers(bussiness_name, ruc, address, phone, landline) VALUE('IMPORTACIONES RIO', '45132164578', 'LIMA', '+51 988-246-123', '01 3754687');
INSERT INTO suppliers(bussiness_name, ruc, address, phone, landline) VALUE('GRUPO COMPUTEL', '20608449320', 'AV. GARCILAZO DE LA VEGA NRO. 1348 TDA 1A-179 (CENTRO COMERCIAL CIBERPLAZA) LIMA-LIMA-LIMA', '+51 951803761', '01 0000000');
-- SELECT * FROM suppliers;

INSERT INTO brands(name) VALUE('KINGSTON');
INSERT INTO brands(name) VALUE('LENOVO');
INSERT INTO brands(name) VALUE('ASUS');
INSERT INTO brands(name) VALUE('HP');
-- SELECT * FROM brands;

INSERT INTO categories(name) VALUE('COMPUTO');
INSERT INTO categories(name) VALUE('UTILERÍA');
-- SELECT * FROM categories;

INSERT INTO products(code, product_name, supplier_id, brand_id, category_id, store_id, description, price, stock) VALUES('PRO_0000001', 'ALL IN ONE', 1, 1, 1, 1, 'TODO EN UNO', 750.50, 4);
INSERT INTO products(code, product_name, supplier_id, brand_id, category_id, store_id, description, price, stock) VALUES('PRO_0000002', 'MONITOR', 1, 1, 1, 1, 'MONITORES', 750.50, 4);
INSERT INTO products(code, product_name, supplier_id, brand_id, category_id, store_id, description, price, stock) VALUES('PRO_0000003', 'TECLADO', 1, 1, 1, 1, 'TECLADOS RGB', 750.50, 4);
-- TRUNCATE products;
-- SELECT * FROM products;

INSERT INTO document_type(document_type) VALUES('DNI');
INSERT INTO document_type(document_type) VALUES('CARNET DE EXTRANJERÍA');

INSERT INTO workers(name, lastname, document_type_id, document) VALUES('CRISTHIAN', 'RIVEROS', 2, '760569381246461234567');
SELECT * FROM workers;

SELECT * FROM id_value_tbl;