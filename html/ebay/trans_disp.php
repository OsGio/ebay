<?php
/*
 * written by minohara (archtype engine KYOTO)
 * 2013.06.01
 */

//var_dump(sys_get_temp_dir().'/'.$_REQUEST['tmp_filename']);
echo file_get_contents(sys_get_temp_dir().'/'.$_REQUEST['tmp_filename']);

?>