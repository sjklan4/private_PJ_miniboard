<?php
// 아래 구문은 함수를 통한 db연동 식이다. html에 필요한 데이터를 DB에서 부터 가져오기 위해서 필요한 구문들

function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "prject_mini_boardproject";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
        array(
            PDO::ATTR_EMULATE_PREPARES      => false
            ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
        );
    
    try //try구문의 try는 설정한 값을 실행 시킴과 동시에 catch 구문이 가동 되도록 하는 종합적인 역활을 진행한다.  -  print, echo 등과 같이 실행시 동작을 하는 함수의 일종.
    {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option);
    }

    catch( Exception $e )
    {
        $param_conn = null;
        throw new Exception( $e -> getmessage());

    }

}

function select_board_info_paging( &$param_arr)
{
    $sql = 
    " SELECT " 
    ." board_no "
	." ,board_title "
    ." ,board_write_date " 
    ." FROM " 
    ." board_info "
    ." WHERE " 
    ." board_del_flg = '0' "
    ." ORDER BY "
    ." board_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare = 
        array(
            ":limit_num" => $param_arr["limit_num"] // 배열로 불러 오기 때문에 앞에 형식에 맞추기 위해 이름을 똑같이 쓴다.
            ,":offset"   => $param_arr["offset"]
        );

    $conn = null;
    try 
    {
        db_conn( $conn ); //데이터 베이스 연동이 유지가 되게 되면 다른 유저들이 접근을 할 수가 없어서 쿼리 연동시 항상 종료 하는 조건을 붙인다.
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchall();

    } 
    catch ( Exception $e) 
    {
        return $e->getMessage();
    }
    finally //성공여부와 상관없이 null로 커넥션을 초기화 시켜준다.
    {
        $conn = null;
    }
 //비정상 작동시 try문에서 finally를 실행시키고 catch 문의 값을 리턴시킨다. 그러나 정상 작동시 finally가 작동하고 return을 시킨다. 
    return $result;
}

function select_board_info_cnt()
{
    $sql = 
    " SELECT "
    ." count(*) cnt "
    ." FROM "
    ." board_info "
    ." where "
    ." board_del_flg = '0' ";
    

    $arr_prepare = array();

    $conn = null;
    try 
    {
        db_conn( $conn ); //데이터 베이스 연동이 유지가 되게 되면 다른 유저들이 접근을 할 수가 없어서 쿼리 연동시 항상 종료 하는 조건을 붙인다.
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchall();

    } 
    catch ( Exception $e) 
    {
        return $e->getMessage();
    }
    finally //성공여부와 상관없이 null로 커넥션을 초기화 시켜준다.
    {
        $conn = null;
    }
 //비정상 작동시 try문에서 finally를 실행시키고 catch 문의 값을 리턴시킨다. 그러나 정상 작동시 finally가 작동하고 return을 시킨다. 
    return $result;
}

//작성 내용에 관련된 데이터와 작성일자 데이터 추출을 위한 함수 추가
function select_board_info_no( &$param_no)
{
    $sql =" SELECT board_no, board_title, board_contents, board_write_date
            FROM board_info
            WHERE board_no = :board_no " ;
                

    $arr_prepare = array(
        ":board_no" => $param_no
    );

    $conn = null;
    try 
    {
        db_conn( $conn ); //데이터 베이스 연동이 유지가 되게 되면 다른 유저들이 접근을 할 수가 없어서 쿼리 연동시 항상 종료 하는 조건을 붙인다.
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchall(); //데이터 베이스에서 넘겨주는 정보를 가져오는것


    } 
    catch ( Exception $e) 
    {
        return $e->getMessage();
    }
    finally //성공여부와 상관없이 null로 커넥션을 초기화 시켜준다.
    {
        $conn = null;
    }
 //비정상 작동시 try문에서 finally를 실행시키고 catch 문의 값을 리턴시킨다. 그러나 정상 작동시 finally가 작동하고 return을 시킨다. 
    return $result[0];
};  

// 게시판 특정 게시글 정보 수정(업데이트시에 변경된 행의 번호를 숫자로 넘겨 받는다.)
function update_board_info_no( &$param_arr )
{
    $sql = 
        " UPDATE "
        ." board_info "
        ." SET "
        ." board_title = :board_title "
        ." ,board_contents =:board_contents "
        ." WHERE "
        ." board_no =:board_no "
        ; 

    $arr_prepare = 
        array(
            ":board_title" => $param_arr["board_title"]
            ,":board_contents" => $param_arr["board_contents"]
            ,":board_no" => $param_arr["board_no"]
        );

        $conn = null;
        try 
        {
            db_conn( $conn ); //PDO object 셋
            $conn->beginTransaction(); //Transaction 시작
            $stmt = $conn->prepare( $sql ); //statement object 셋팅
            $stmt->execute( $arr_prepare ); //DB request
            $result_cnt = $stmt->rowCount(); // 업데이트 되서 영향을 받은 행의 숫자를 가져온다.
            $conn->commit();
        } 
        catch ( Exception $e) 
        {
            $conn->rollbakc(); // 트랜잭션이 진행중에 오류가 나면 롤백을 시켜서 돌려 준다.
            return $e->getMessage();
        }
        finally //성공여부와 상관없이 null로 커넥션을 초기화 시켜준다.
        {
            $conn = null;
        }
     //비정상 작동시 try문에서 finally를 실행시키고 catch 문의 값을 리턴시킨다. 그러나 정상 작동시 finally가 작동하고 return을 시킨다. 
        return $result_cnt;
}

//delete_board_info_no 게시판 특정 게시글 정보 삭ㅈ플러그 갱신
function delete_board_info_no( &$param_no )
{
    $sql = " UPDATE " 
            ." board_info "
            ." SET " 
            ." board_del_flg = '1' "
            ." ,board_del_date = NOW() "
            ." WHERE " 
            ." board_no = :board_no "
            ;
    $arr_prepare = 
        array(
            ":board_no" => $param_no
        );
    $conn = null;
    
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute($arr_prepare);
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch(Exception $e)
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }
    return $result_cnt;
}

// $arr = 
//     array(
//         "board_no" => 1
//         ,"board_title" => "test1"
//         ,"board_contents" => "testtest1"
//     );

// echo update_board_info_no( $arr );


// //TODO : test start

// $i=20;
// print_r(select_board_info_no( $i ));
// //TODO : test End









?>