<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."private_PJ_miniboard/src/common/db_common.php" );
    include_once( URL_DB ); //경로상의 파일을 가져오는 함수구문 


$arr_get = $_GET;

$result_cnt = delete_board_info_no( $arr_get["board_no"] );

header( "Location: board_list.php" );
exit();



?>