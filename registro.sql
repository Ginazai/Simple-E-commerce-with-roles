create database e_commerce_admin_module;
use e_commerce_admin_module;
create table permissions(
	permission_id int auto_increment primary key not null,
	_read boolean not null,
	_write boolean not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table roles(
	role_id int auto_increment primary key not null,
	role varchar(50) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table users(
	user_id int auto_increment primary key not null,
	email varchar(100) not null,
	password varchar(30) not null,
	name varchar(50) not null,
	last_name varchar(100) not null,
	dob date not null,
	phone_number varchar(9) not null,
	active boolean not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table user_roles(
	id int auto_increment primary key not null,
	user_id int not null,
	role_id int not null,
	permission_id int not null,

	constraint fk_user_id_role
	foreign key (user_id)
	references users (user_id)
	on update cascade
	on delete cascade,

	constraint fk_permission_id_role
	foreign key (permission_id)
	references permissions (permission_id)
	on update cascade
	on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE user_roles ADD UNIQUE INDEX(role_id);
ALTER TABLE user_roles ADD constraint 
fk_role_id_user
foreign key (role_id)
references roles (role_id)
on update cascade
on delete cascade;
create table provinces(
	province_id int auto_increment primary key not null,
	province varchar(15) not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table districts(
	district_id int auto_increment primary key not null,
	district varchar(50) not null,
	province_id int not null,

	constraint fk_province_id_districts
	foreign key (province_id)
	references provinces (province_id)
	on update cascade 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table corregimientos(
	corregimiento_id int auto_increment primary key not null,
	corregimiento varchar(100) not null,
	district_id int not null,

	constraint fk_district_id_corregimientos
	foreign key (district_id)
	references districts (district_id)
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table address(
	address_id int auto_increment primary key not null,
	line_1 varchar(100) not null,
	line_2 varchar(100),
	corregimiento_id int not null,

	constraint fk_corregimiento_id_address
	foreign key (corregimiento_id)
	references corregimientos (corregimiento_id)
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table user_addresses(
	id int auto_increment primary key not null,
	user_id int not null,
	address_id int not null,
	preferred boolean not null,

	constraint fk_user_id_address
	foreign key (user_id)
	references users (user_id)
	on delete cascade
	on update cascade,

	constraint fk_address_id_user
	foreign key (address_id)
	references address (address_id)
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table inventory(
	product_id int auto_increment primary key not null,
	image varchar(65535),
	product varchar(100) not null,
	description varchar(300),
	price float not null,
	amount int not null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table categories(
	category_id int auto_increment primary key not null,
	category varchar(100)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table subcategories(
	sub_id int auto_increment primary key not null,
	name varchar(100) not null,
	category_id int not null,

	constraint fk_category_id_sub
	foreign key (category_id)
	references categories (category_id)
	on delete cascade
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table product_categories(
	id int auto_increment primary key not null,
	product_id int not null,
	subcategory_id int not null,

	constraint fk_product_id_category
	foreign key (product_id)
	references inventory (product_id)
	on update cascade
	on delete cascade,

	constraint fk_subcategory_id_product
	foreign key (subcategory_id)
	references subcategories (sub_id)
	on update cascade
	on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table cart(
	cart_id int auto_increment primary key not null,
	product_id int not null,
	user_id int not null,
	amount int not null,

	constraint fk_product_id_cart
	foreign key (product_id)
	references inventory (product_id)
	on delete cascade
	on update cascade,

	constraint fk_user_id_cart
	foreign key (user_id)
	references users (user_id)
	on delete cascade
	on update cascade 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table receipt(
	receipt_id int auto_increment primary key not null,
	user_id int not null, 
	r_time timestamp not null,

	constraint fk_user_id_receipt
	foreign key (user_id)
	references users (user_id)
	on delete cascade 
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table shipping(
	shipping_id int auto_increment primary key not null,
	user_addresses_id int not null,
	receipt_id int not null,
	delivered boolean not null,

	constraint fk_user_addresses_id_shipping
	foreign key (user_addresses_id)
	references user_addresses (id)
	on update cascade,

	constraint fk_receipt_id_shipping
	foreign key (receipt_id)
	references receipt (receipt_id)
	on delete cascade 
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table order_details(
	id int auto_increment primary key not null,
	receipt_id int not null,
	product_id int not null,
	amount int not null,

	constraint fk_receipt_id_order
	foreign key (receipt_id)
	references receipt (receipt_id)
	on delete cascade 
	on update cascade,

	constraint fk_product_id_order
	foreign key (product_id)
	references inventory (product_id)
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table claims(
	claim_id int auto_increment primary key not null,
	user_id int not null,
	receipt_id int not null,
	issue varchar(500) not null,
	solve boolean not null,

	constraint fk_user_id_claims
	foreign key (user_id)
	references users (user_id)
	on update cascade,

	constraint fk_receipt_id_claims
	foreign key (receipt_id)
	references receipt (receipt_id)
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table data_trace(
	trace_id int auto_increment primary key not null,
	user_id int not null, 
	data_before varchar(250) not null,
	data_after varchar(250) not null,
	_time timestamp not null,

	constraint fk_user_id_data
	foreign key (user_id)
	references users (user_id)
	on delete cascade 
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table data_session(
	session_id int auto_increment primary key not null,
	user_id int not null,
	activity boolean not null,
	_time timestamp not null,

	constraint fk_user_id_data_session
	foreign key (user_id)
	references users (user_id)
	on delete cascade
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
create table user_interests(
	id int auto_increment primary key not null,
	user_id int,
	product_id int,

	constraint fk_user_id_interest
	foreign key (user_id)
	references users (user_id)
	on update cascade,

	constraint fk_product_id_interest 
	foreign key (product_id)
	references inventory (product_id)
	on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
----------------------------------------
---------------Triggers-----------------
----------------------------------------
create trigger 
	auto_role
	after insert 
	on users 
	for each row
	insert into user_roles (user_id,role_id,permission_id)
	values (new.user_id,2,2);
--(not implemented yet)
create trigger 
	track_interests
	after update 
	on cart
	for each row
	insert into user_interests (user_id,product_id) 
	values (cart.user_id, cart.product_id);
