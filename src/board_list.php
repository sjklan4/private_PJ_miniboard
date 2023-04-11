<!-- html에 필요한 데이터를 php데이터 구문으로 부터 받아서 표시를 해주기 위한 구문 -->
<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."private_PJ_miniboard/src/common/db_common.php" );
    include_once( URL_DB ); //경로상의 파일을 가져오는 함수구문 
    

    //if구문을 통해서 page_num배열의 키값을 받아와서 키값이 있을때 와 없을때는 1로 받아서 리턴 시킨다. $_GET은 슈퍼 글로벌 변수 
    if( array_key_exists( "page_num", $_GET ))
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }



    $limit_num = 5; //db_common의 sql문에 limit_num에 있는 값을 조정할때 사용한다.
    // $page_num = $arr_get["page_num"];
    // 게시판 정보 테이블 전체 카운트 획득 
    $result_cnt =  select_board_info_cnt();

    //max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num );

    // 1페이지일때 0, 2페이지 일때 5, 3페이지 일때 10...(offset)
    $offset = ((int)$page_num * $limit_num) - $limit_num;


    $arr_prepare = 
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
    

    // sql 함수 구문을 불러오는 변수
    $result_paging = select_board_info_paging( $arr_prepare); 
    
    // print_r( $max_page_num );


?>



<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="./board_list.css"> 
    <title>게시판</title>
    
</head>

<div class='wrap'>
    <div class='cap'> BOARD INFORMATION</div>
    <table class='table table-striped'>
    <!-- php와 연동을 위해서 '' 로 추가구문 작성 -->
        <thead> 
            <tr>
                <th class='board_no'>INF.NO</th>
                <th class='board_title'>BOARD TITLE</th>
                <th class='board_date'>TODATE</th>
                </div>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result_paging as $recode) 
                {
            ?>
            <!-- tr은 html 값으로 php 범위 밖에 지정하였다. a태그를 사용해서 제목 내용을 선택시 업데이트 창으로 움직이도록 만든다. -->
                <tr> 
                    <td><?php echo $recode["board_no"] ?></td>
                    <td><a href="board_update.php?board_no=<?php echo $recode["board_no"]?>"><?php echo $recode["board_title"] ?></a></td> 
                    <td><?php echo $recode["board_write_date"] ?></td>
                </tr>

            <?php
                }
            ?>
        </tbody>
    </table>
    <div class='tag_a'>

        <a href ='board_list.php?page_num=1'>
            <img src = "./img/left_end.png"/></a>   

        <?php
            if ((int)$page_num > 1) 
            {            
        ?>  
            <a href = 'board_list.php?page_num=<?php echo (int)$page_num - 1 ?>'>
                <img src = "./img/left.png"></a>
        <?php
            }
        ?>
        <?php
                for ($i= 1; $i <= $max_page_num; $i++)  // 페이지를 보여주고 페이지에 따라서 이동 하게 해주는 구분
                { 

            ?>
            <a href = 'board_list.php?page_num=<?php echo $i ?>'><?php echo $i ?></a>  
            <?php
                }
            ?>

            <?php
            if ($page_num < $max_page_num) 
            {  
            ?>
                <a href ='board_list.php?page_num=<?php echo (int)$page_num + 1  ?>'>
                    <img src = "./img/right.png"/></a>

            <?php
            }
            ?> 
        <a href ='board_list.php?page_num=<?php echo (int)$max_page_num ?>'>
            <img src = "./img/right_end.png"/></a>
        </div>
</div>
</body>
</html>