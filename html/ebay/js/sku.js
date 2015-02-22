
//----- exec = 4で仮置き -----
function importSku(){
// alert('sku');

  	if(document.frm.sku.value == "") {
  		alert("設定CSVファイルを選択してください");
  		document.frm.sku.focus();
 		return;
  	}
  	document.frm.action = "./import_sku.php?exec=4";
  	document.frm.submit();
}
