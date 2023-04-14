<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); //dcounemtroot는 아파치 안에 있는 htdocs에 있는 주소가 저장 되고 뒤에 상세 주로를 입력
    define( "URL_DB", DOC_ROOT."private_PJ_miniboard/src/common/db_common.php" ); // DOC_ROOOT에 상위 define이 들어가 있고 이것을 include에서 사용한다.
    define( "URL_HEADER", DOC_ROOT."private_PJ_miniboard/src/board_header.php" );
    include_once( URL_DB ); //경로상의 파일을 가져오는 함수구문 / 파일들의 위치가 많기 때문에 상수로 주소를 고정 시켜 놓고 가져온다.
  


    $http_method = $_SERVER["REQUEST_METHOD"]; //서버에 관련된 정보를 담고 있다.
    // GET 일때
    if( $http_method === "GET" )
    {
        $board_no = 1;
        if( array_key_exists( "board_no", $_GET ))
        {
            $board_no =$_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no ); 
    }
    
    // post 일때
    else
    {
        $arr_post = $_POST;
        $arr_info = 
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"] //가능한 원본데이터는 직접 가져와서 사용 하지 않는다. (주로 변수로 주고 사용 하는것을 추천)
            );
        
        // update 
        $result_cnt = update_board_info_no($arr_info);

        // // select 업데이트한 데이터를 수정페이지에 표시 시켜준다.
        // $result_info = select_board_info_no( $arr_post["board_no"] );0412 del

        //다른 화면으로 넘어가기 위한 방벙식.
        header( "Location: board_detail.php?board_no=".$arr_post["board_no"]);
        exit(); //36행에서 redirect 했기 때문에 이후의 소스코드는 실행할 필요 없디.이 밑으로 있는것들은 코드 실행 안함(버그 방지 안닫아도 문제는 크게 없다.)

    }

    
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./board_update.css"> 
    <title>boardupdate</title>
</head>

<body>
<div class='head'><?php include_once( URL_HEADER ); ?></div>
<form method = "post" action="board_update.php" >
    <div class='update_list'>
        <div class='bno_style'>
            <div class='no'>BOARD.NUM</div>
            <span><?php echo $result_info["board_no"] ?></span>
            <input type='hidden' name='board_no' value='<?php echo $result_info["board_no"] ?>'id ='bno' readonly>
        </div>
            <br>
        <div class='title_style'>
            <div class='ti'>BOARD.TITLE</div> 
            <!-- <span><?php //echo $result_info["board_title"] ?></span> -->
            <input type='text' name='board_title' value='<?php echo $result_info["board_title"] ?>' id='title'>
        </div>
            <br>
        <div class='contents_style'>
            <div class='tx'>BOARD.CONT </div>
            <!-- <span><?php //echo $result_info["board_contents"] ?></span> -->
        <input type='text' name='board_contents' value='<?php echo $result_info["board_contents"] ?>' id='contents'>
        </div>
            <br>

        <div class='submit_style'>
            <button type ='submit'><a id = "write_a">UPDATE</a></button>
            <button type ='submit'>
                <a href="board_list.php?page_num=<?php echo $page_num = 1 ?>" id = "write_b">LIST</button>
            <button type="button">
            <a href="board_detail.php?board_no=<?php echo $result_info["board_no"]?>" id = "write_c">ESC</a></button>
        </div>
        
    </div>    
</form>



</body>
</html>
