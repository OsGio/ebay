INSERT INTO ebay_item_specifics (id, name) VALUES(
0, 'Relationship'
);
INSERT INTO ebay_item_specifics (id, name) VALUES(
0, 'RelationshipDetails'
);

CREATE TABLE sku_items (
    id INT not null auto_increment primary key,
    action VARCHAR(255),
    relationship VARCHAR(255),
    relationship_details VARCHAR(255),
    category INT(64),
    quantity INT(11),
    start_price float(11)
);
