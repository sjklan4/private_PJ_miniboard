<?php
        define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); //dcounemtroot는 아파치 안에 있는 htdocs에 있는 주소가 저장 되고 뒤에 상세 주로를 입력
        define( "URL_DB", DOC_ROOT."private_PJ_miniboard/src/common/db_common.php" ); // DOC_ROOOT에 상위 define이 들어가 있고 이것을 include에서 사용한다.
        define( "URL_HEADER", DOC_ROOT."private_PJ_miniboard/src/board_header.php" );
        include_once( URL_DB ); //경로상의 파일을 가져오는 함수구문 / 파일들의 위치가 많기 때문에 상수로 주소를 고정 시켜 놓고 가져온다.

        $http_method = $_SERVER["REQUEST_METHOD"]; //: method가 get인지 post인지 확인 하는 구문

        if ( $http_method === "POST" )
        {
            $arr_post = $_POST;
            
            $result_cnt = insert_board_info( $arr_post ); //resutl_cnt의 출처 확인! - cnt , info들의 출처들
            
            header( "Location: board_list.php" );
            exit();
        }
        

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./board_insert.css"> 
    <title>게시글 작성</title>
</head>
<body>
<?php include_once( URL_HEADER ); ?>
    <form method = "post" action="board_insert.php" >
        <div class='update_list'>
            <div class='title_style'>
                <div class='ti'>BOARD.TITLE</div> 
                <!-- <span><?php //echo $result_info["board_title"] ?></span> -->
                <input type='text' name='board_title' id='title'>
            </div>
                <br>
            <div class='contents_style'>
                <div class='tx'>BOARD.CONT </div>
                <!-- <span><?php //echo $result_info["board_contents"] ?></span> -->
                    <input type='text' name='board_contents' id='contents'>
            </div>
                <br>
            <div class='submit_style'>
                <button type ='submit'><a id = "write_a">WRITE</a></button>
                <button type="button"><a href="board_list.php?page_num=<?php echo $page_num = 1 ?>" id = "write_a">ESC</a></button>
            </div>
            
        </div>    
    </form>
</body>
</html>