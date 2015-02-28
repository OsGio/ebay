-- CREATE TABLE sku_tbl(
--     id INT not null auto_increment,
--     item_url varchar(255),
--     type_name_A varchar(255),
--     type_id_A varchar(50),
--     type_quantity_A int,
--     type_name_B varchar(255),
--     type_id_B varchar(50),
--     type_quantity_B int,
--     created_time timestamp default now
-- );

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
alter table sku_items add username varchar(30) not null;




ALTER TABLE ebay_result_tbl ADD Relarionship varchar(255);

ALTER TABLE ebay_result_tbl ADD RelationshipDetails  varchar(255);

alter table ebay_result_tbl ADD item_url varchar(255);

--
-- ebay_result_tbl.custom_label join sku_items.item_url
--
-- ebay_result_tbl に sku判別用の Item_url テーブルを追加
-- ebay_result_tbl.custom_label = sku_items.item_url
