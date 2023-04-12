<?php
        define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
        define( "URL_DB", DOC_ROOT."private_PJ_miniboard/src/common/db_common.php" );
        include_once( URL_DB ); //경로상의 파일을 가져오는 함수구문 

        // Request Parameter 획득(GET)
        $arr_get=$_GET;

        // DB에서 게시글 정보 획득 
        $result_info = select_board_info_no($arr_get["board_no"]);
        
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./board_detail.css">
    <title>Detail</title>
</head>
<body>
    <div class= 'detail_list'>
        <div class='bno_stlye'>
            <div class='no'>NO.</div>
                <?php echo $result_info["board_no"]?></p>
        </div>
        <div class='write_style'>
        <div class='wd'>DO.WRITE</div> 
                <?php echo $result_info["board_write_date"]?></p>
        </div>
        <div class='title_style'>
            <div class='ti'>TITLE</div> 
                <?php echo $result_info["board_title"]?></p>
        </div>
        <div class='contents_style'>
            <div class='tx'>CONTENTS</div> 
                <?php echo $result_info["board_contents"]?></p>
        </div>
    

        <div class='button_style'>
            <button type="button">
                <a href="board_update.php?board_no=<?php echo $result_info["board_no"]?>">UPDATE</a></button> 
            <!-- 수정 버튼은 현재 boardno의 것이 와야 되기 때문에 result값을 받아온다. -->
            <button type="button">
                <a href="board_list.php?page_num=<?php echo $page_num = 1 ?>">LIST</a></button>

            <button type ="button"><a href="board_delete.php?board_no=<?php echo $result_info["board_no"]?>">DELETE</a></button>
        </div>
    </div>
</body>
</html>