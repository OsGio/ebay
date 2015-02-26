CREATE TABLE sku_tbl(
    id INT not null auto_increment,
    item_url varchar(255),
    type_name_A varchar(255),
    type_id_A varchar(50),
    type_quantity_A int,
    type_name_B varchar(255),
    type_id_B varchar(50),
    type_quantity_B int,
    created_time timestamp default now
);

INSERT INTO ebay_item_specifics (id, name) VALUES(
0, 'Relationship'
);
INSERT INTO ebay_item_specifics (id, name) VALUES(
0, 'RelationshipDetails'
);

CREATE TABLE sku_items (
    id INT not null auto_increment primary key,
    item_url VARCHAR(255) null,
    action VARCHAR(255) DEFAULT 'Add',
    relationship VARCHAR(255) DEFAULT 'Variation',
    relationship_details VARCHAR(255) null,
    quantity INT(11) DEFAULT 0,
    start_price float(11) null,
    master_flg TINYINT(4) DEFAULT 0
);
