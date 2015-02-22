<?php

Class SKU{


public $header = array('Action', 'Category', 'RelationshipDetails[]');
public $bofy = array('Relationship', 'RelationshipDetails', 'Quantity', 'StartPrice');

public $Action = "Add";
public $Category = "";
public $Relationship = "Valiation";
public $RelationshipDetails = array();
public $Quantity;
public $StartPrice;



public __construct(){
    return $this;
}


// 該当項目間にSKUオプションカラムを挿入
public function insertSku(){
    print "test";
}



}
