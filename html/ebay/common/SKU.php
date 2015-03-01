<?php
require 'common/db.php';
require 'common/SC_transAPI.php';
//require_once 'common/NET/Socket.php';

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

private $username;



public function __construct(){
    if($_SESSION["CONVERTER_USERID"]){
        $this->username = $_SESSION["CONVERTER_USERID"];
    }
    return $this;
}


protected function mustSelect($total){
    foreach($this->col as $c)
    {
        $selected[] = $total[ $c ];
    }
    return $selected;
}


/**
* @param rows 改行区切りの配列
* @return rows 改行のみの空の配列を取り除いたモノ
*/
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



/**
* @param row 行単位に分割したファイルの中身
* @return result ,区切りで配列化 & テーブル保存用にキーを英語に変換( 楽天仕様 2015.02.28)
* 各配列に分割 かつ 必要項目をキーに値を抽出
*/
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


/**
* @param result
*
* todo:複数アイテム一括インポート対応
*/

public function createMaster($result, $Type01='Type01', $Type02='Type02'){

    //item_url毎に配列化
    $item_url = self::array_column($result, 'item_url');
    $item_url = array_unique($item_url);
    $item_url_mst = $item_url;
    foreach($item_url_mst as $i)
    {
        foreach($result as $r)
        {
            if($i==$r['item_url'])
            {
                $results[$i][] = $r;
            }
        }
    }
// print "<pre>";
// var_dump($results);
// print "<pre>";
// exit;


    // 識別子が必要なら以下アンコメント
    // $option_id_01 = self::array_column($result, 'option_id_01');
    // $option_id_01 = array_unique($option_id_01);
    // $option_id_02 = self::array_column($result, 'option_id_02');
    // $option_id_02 = array_unique($option_id_02);

    foreach($results as $r)
    {
        $option_name_01 = self::array_column($r, 'option_name_01');
        $option_name_01 = array_unique($option_name_01);
        $option_name_02 = self::array_column($r, 'option_name_02');
        $option_name_02 = array_unique($option_name_02);

        //翻訳指定（日本語 => 英語）
        $country = array('from' => 'ja', 'to' => 'en');
        foreach($option_name_01 as $op1)
        {
            $option_name_01en[] = self::Translate($op1, $country);
        }
        foreach($option_name_02 as $op2)
        {
            $option_name_02en[] = self::Translate($op2, $country);
        }
        $relationship_details = "$Type01=". implode(';', $option_name_01en) .
                                '|'. "$Type02=". implode(';', $option_name_02en);

        $master[$r[0]['item_url']] = array( 'relationship_details' => $relationship_details, 'item_url' => $r[0]['item_url'], 'master_flg' => 1, 'Type01' => $Type01, 'Type02' => $Type02 );

        //初期化
        $option_name_01en = array(); $option_name_02en = array();
    }

    //$item_url = implode('', $item_url); //注）複数ならばここを条件分け


    return $master;

}


/**
*
*
*/
public function saveResult(){

//////    save to :: ebay_result_table.relationship
    $db = new dbclass();

    $sql = "SELECT * FROM `sku_temp` RIGHT JOIN `sku_items` USING (id)";

    $temp = $db -> Exec($sql);

    while ($arr = $temp->fetch(PDO::FETCH_ASSOC)) {
var_dump($arr);exit;
    echo $arr['name'];
 }


}


/**
*
* todo:preparedステートメントなし？
*/

public function importSku($result, $master){

    $db = new dbclass();

    $user_name = $this->username;

    foreach($master as $m)
    {
        if(!isset($m['action'])){ $m['action'] = 'Add'; }
            // sku_itemsに登録
            $sql = "insert into `sku_items` (item_url, action, relationship, relationship_details, quantity, start_price, master_flg, username)
            values (
                    '". $db->esc($m['item_url']) ."',
                    '". $db->esc($m['action']) ."',
                        null,
                    '".$db->esc($m['relationship_details'])."',
                        null,
                        null,
                        1,
                    '". $db->esc($this->username) ."'
                    )";

            $db -> Exec($sql);
//var_dump($db->insert_id);exit;


    // $Type01 = $master['Type01'];
    // $Type02 = $master['Type02'];


    }


//タイプ指定 ※要修正
$Type01 = 'Type01';
$Type02 = 'Type02';


    //翻訳して書き込み
    $country = array('from' => 'ja', 'to' => 'en');
    foreach($result as $r)
    {
        $r['relationship'] = "$Type01=". self::Translate($r['option_name_01'], $country) ."|$Type02=". self::Translate($r['option_name_02'], $country);
        $sql = "insert into `sku_items` (item_url, action, relationship, relationship_details, quantity, start_price, master_flg, username)
        values (
                '". $db->esc($r['item_url']) ."',
                null,
                null,
                '".$db->esc($r['relationship'])."',
                ". $db->esc($r['quantity']) .",
                null,
                0,
                '". $db->esc($this->username) ."'
                )";

        $db-> Exec($sql);
    }

}


/**
* translate A word into B.
* @param word 翻訳対象
* @param ( arr ) country ('from' => A, 'to' => B) 翻訳国指定 A into B.
* @return 単語
*/

private function Translate($word, $country){

    extract($country);

    $db = new dbclass;

    //翻訳APIのインスタンス生成
    $sql = "select * from  `user_tbl` where username = '".$db->esc($this->username)."'";
    $user_rc = $db -> Exec($sql);
    if ($obj_user = $db -> fetch_object($user_rc)) {
    	$trans = new SC_transAPI('203916a788aa313171d9c22e85b82cf9', $obj_user->trans_api_key, $obj_user->trans_api_secret_key);
    }

    $translated = trim(strip_tags($trans->trans($word, $from, $to)));

    return $translated;

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
