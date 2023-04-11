<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); //dcounemtroot는 아파치 안에 있는 htdocs에 있는 주소가 저장 되고 뒤에 상세 주로를 입력
    define( "URL_DB", DOC_ROOT."private_PJ_miniboard/src/common/db_common.php" ); // DOC_ROOOT에 상위 define이 들어가 있고 이것을 include에서 사용한다.
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

        // select
        $result_info = select_board_info_no( $arr_post["board_no"] );
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
    
<form method = "post" action="board_update.php" >
    <div class='update_list'>
        <div class='bno_style'>
            <div class='no'>게시글 번호</div>
            <span><?php echo $result_info["board_no"] ?></span>
            <input type='hidden' name='board_no' value='<?php echo $result_info["board_no"] ?>'id ='bno' readonly>
        </div>
            <br>
        <div class='title_style'>
            <div class='ti'><label for='title'>게시글 제목  </label></div> 
            <input type='text' name='board_title' value='<?php echo $result_info["board_title"] ?>' id='title'>
        </div>
            <br>
        <div class='contents_style'>
            <div class='tx'><label for='contents'>게시글 내용 </div></label> 
        <input type='text' name='board_contents' value='<?php echo $result_info["board_contents"] ?>' id='contents'>
        </div>
            <br>
        <div class='submit_style'>
            <button type ='submit'>수정</button>
            <button type ='submit'>
                <a href="board_list.php?page_num=<?php echo $page_num = 1 ?>"> 리스트</button>
        </div>
    </div>    
</form>



</body>
</html>
