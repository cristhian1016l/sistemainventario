exit;
CREATE DATABASE bdinventario;
USE bdinventario;

drop table if exists id_value_tbl;
drop table if exists requests_details;
drop table if exists worker_product;

drop table if exists model_has_permissions;
drop table if exists model_has_roles;
drop table if exists role_has_permissions;
drop table if exists permissions;
drop table if exists users;

drop table if exists requests;
drop table if exists teams;
drop table if exists workers;
drop table if exists areas;
drop table if exists roles;
drop table if exists products;
drop table if exists stores;
drop table if exists brands;
drop table if exists suppliers;
drop table if exists categories;
drop table if exists document_type;
drop table if exists worker_type;
drop table if exists type_worker;

-- -------------------- TABLAS EXCLUSIVAS DEL SISTEMA WEB PARA PARA PERMISOS Y ROLES ------------------------------------------------------

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
	id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,	
    email varchar(255)UNIQUE,
    email_verified_at varchar(255),
    password varchar(255),
    active tinyint(4),    
    remember_token varchar(100),
    created_at timestamp,
    updated_at timestamp
) ENGINE=innodb DEFAULT CHARSET=utf8;

-- -------------------- TABLAS EXCLUSIVAS DEL SISTEMA WEB PARA PARA PERMISOS Y ROLES ------------------------------------------------------

drop table if exists id_value_tbl;
create table id_value_tbl
(
	id int auto_increment not null primary key
);

drop table if exists stores;
create table stores
(
	id int auto_increment not null primary key,
    name varchar(200),
    manager varchar(50),
    address varchar(200) not null,        
    phone varchar(25),
    city varchar(50),
    in_use tinyint(4),
    created_at datetime,
    updated_at datetime
);

-- SELECT * FROM stores;

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

drop table if exists worker_type;
CREATE TABLE worker_type
(
	id int auto_increment not null primary key,
    name varchar(50) not null
);

drop table if exists areas;
CREATE TABLE areas
(
	id int auto_increment not null primary key,
    name varchar(50) not null
);

drop table if exists workers;
CREATE TABLE workers
(
	id int auto_increment not null primary key,
    name varchar(50) not null,
    lastname varchar(50) not null,
    address varchar(255),
    document_type_id int not null,
    worker_type_id int not null,
    area_type_id int not null,
    document varchar(25),
    birthdate date,
    phone varchar(12),
    email varchar(50),
    company_id int not null,
    deleted_at datetime,
    created_at datetime,
    updated_at datetime,    
	foreign key (document_type_id) references document_type(id),
    foreign key (worker_type_id) references worker_type(id),
    foreign key (area_type_id) references areas(id),
    foreign key (company_id) references companies(id)
);

-- ALTER TABLE workers
-- ADD COLUMN area_type_id int not null AFTER worker_type_id;

drop table if exists products;
CREATE TABLE products
(
	id int auto_increment not null primary key,
    code varchar(200) unique,
    product_name varchar(150) not null,
    supplier_id int not null,
    brand_id int not null,
    category_id int not null,
    color varchar(50), 
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
    foreign key (worker_id) references workers(id) ON DELETE CASCADE,
    foreign key (product_id) references products(id) ON DELETE CASCADE
);

drop table if exists requests;
CREATE TABLE requests
(	
	cod_request varchar(12) not null primary key,
    responsible_id int not null,
    date datetime,
    since_date datetime,
    to_date datetime,
    deadline datetime,
    was_entered boolean,
    created_at datetime,
    updated_at datetime,
    foreign key (responsible_id) references workers(id)
);
-- SELECT * FROM requests;

drop table if exists requests_details;
CREATE TABLE requests_details
(
	id int auto_increment not null primary key,
    cod_request varchar(12) not null,
    product_id int not null,
    amount int,
    created_at datetime,
    updated_at datetime,
    foreign key (cod_request) references requests(cod_request) ON DELETE CASCADE,
    foreign key (product_id) references products(id)
);

drop table if exists teams;
CREATE TABLE teams
(
	id int auto_increment not null primary key,
    name varchar(50),
    productor_id int not null,
	foreign key (productor_id) references workers(id)
);

drop table if exists flashdrives;
CREATE TABLE flashdrives
(
	id int auto_increment not null primary key,
    speed varchar(20),
    storage varchar(20),
    color varchar(20),
    description varchar(255),
    stock int,
    brand_id int not null,
	foreign key (brand_id) references brands(id)
);

drop table if exists companies;
CREATE TABLE companies
(
	id int auto_increment not null primary key,
    name varchar(255)
);

-- --------------- RELACIONES DE LOS ROLES Y PERMISOS --------------- 

ALTER TABLE model_has_permissions
ADD FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE model_has_permissions
ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE role_has_permissions 
ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE role_has_permissions
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;  

ALTER TABLE model_has_roles 
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE model_has_roles 
ADD FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
  
-- --------------- FIN DE LAS RELACIONES DE LOS ROLES Y PERMISOS --------------- 

-- ------------------------------------------- DATA DE PRUEBA -------------------------------------------

-- ************ SACAR LOS TRIGGUERS ************
		-- SELECT  ACTION_STATEMENT
		-- FROM    INFORMATION_SCHEMA.TRIGGERS
		-- WHERE   TRIGGER_SCHEMA = 'bd_name'
		-- AND     TRIGGER_NAME = 'trigguer_name';
-- ************ SACAR LOS TRIGGUERS ************

SELECT * FROM flashdrives;
SELECT * FROM workers;
SELECT * FROM areas;
SELECT * FROM categories;
SELECT * FROM products;
SELECT * FROM worker_product;
SELECT * FROM worker_type;
SELECT * FROM requests;
SELECT * FROM companies;

-- EJECUTAR ESTO

ALTER TABLE workers
ADD birthdate date AFTER document;

ALTER TABLE workers
ADD phone varchar(20) AFTER birthdate;

ALTER TABLE workers
ADD email varchar(50) AFTER phone;

ALTER TABLE worker_type
ADD area_id int not null AFTER name;

ALTER TABLE worker_type
ADD FOREIGN KEY (area_id) REFERENCES areas(id);

SELECT * FROM areas;
SELECT * FROM worker_type WHERE area_id = 2;

UPDATE workers SET worker_type_id = 6 WHERE worker_type_id = 3;
 
ALTER TABLE workers
DROP area_type_id;

SELECT * FROM products p
INNER JOIN categories c
ON p.category_id = c.id
ORDER BY p.stock DESC LIMIT 5;

SELECT SUM(Precios) FROM Productos WHERE Categoria = 'Guitarra';
SELECT SUM(stock) FROM products WHERE category_id = '3';

SELECT * FROM worker_type;
ALTER TABLE products 
ADD COLUMN color varchar(50) AFTER category_id