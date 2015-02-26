<?php

Class SKU{

// var_dump('here');exit;
public $header = array('Action', 'Category', 'RelationshipDetails[]');
public $bofy = array('Relationship', 'RelationshipDetails', 'Quantity', 'StartPrice');

public $Action = "Add";
public $Category = "";
public $Relationship = "Valiation";
public $RelationshipDetails = array();
public $Quantity;
public $StartPrice;

//select-sku項目中から抽出する必須タイプ
public $must = array('item_url', 'option_name01', 'optoin_id01', 'option_name02', 'option_id02', 'quantity');
//またそれらが何行目にあるかを配列番号に換算して保持
public $col = array(1, 5, 6, 7, 8, 10);


public function __construct(){
    return $this;
}


protected function mustSelect($total){
    foreach($this->col as $c)
    {
        $selected[] = $total[ $c ];
    }
    return $selected;
}



// 配列の最後が改行コードのみならば除外 ...beta
public function releaseN($rows){
    if(preg_match('/.*[a-zA-Z0-9].*/', end($rows))==false)
    {
        array_pop($rows);
        return $rows;
    }
    else
    {
        return $rows;
    }
}


// 各配列に分割 かつ 必要項目をキーに値を抽出
public function castVal($row){
    foreach($row as $r)
    {
        $rows[] = explode(',', $r);
    }

    foreach($rows as $r)
    {
        $fined[] = $this->mustSelect($r);
    }

    //header作成
    $header = array_shift($fined);
    //table用キー変換 兼 バリデート
    foreach($header as $key => $val)
    {
        switch($val){
            case "商品管理番号（商品URL）":
                $val = "item_url";break;
            case "項目選択肢別在庫用横軸選択肢":
                $val = "option_name_01";break;
            case "項目選択肢別在庫用横軸選択肢子番号":
                $val = "option_id_01";break;
            case "項目選択肢別在庫用縦軸選択肢":
                $val = "option_name_02";break;
            case "項目選択肢別在庫用縦軸選択肢子番号":
                $val = "option_id_02";break;
            case "項目選択肢別在庫用在庫数":
                $val = "quantity";break;
        }
        $headers[] = $val;
    }

    foreach($fined as $f)
    {
        $result[] = array_combine($headers, $f);
    }

    return $result;

}

public function createMaster($result){


    $relationship_details = self::array_column($result, 'option_name_01');
    //$relationship_details = $array_map('makeUnion', $result);
var_dump($relationship_details);exit;

/*
    foreach($result as $r)
    {
        $item_url = $r['item_url'];
        $relationship_details = function($r){
            $option_name = array_column($r['option_name_01']);
            return $option_name;
        }
    }
*/

}




public function importSku($result){

    $db = new dbclass();

    foreach($result as $r)
    {
        $sql = "INSERT INTO sku_items (category, relationship, relationsshipDetails, quantity, start_price) VALUES (

        )";

    }
var_dump($rows);exit;

}








// 該当項目間にSKUオプションカラムを挿入
public function insertSku(){
    print "test";
}










/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2013 Ben Ramsey <http://benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
// if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
// }







}
