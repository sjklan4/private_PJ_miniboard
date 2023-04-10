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
        return $e->getmessage() === "오류 다시 보세요";
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
        return $e->getmessage() === "오류 다시 보세요";
    }
    finally //성공여부와 상관없이 null로 커넥션을 초기화 시켜준다.
    {
        $conn = null;
    }
 //비정상 작동시 try문에서 finally를 실행시키고 catch 문의 값을 리턴시킨다. 그러나 정상 작동시 finally가 작동하고 return을 시킨다. 
    return $result;
}






//TODO : test start

// $arr = array("limit_num" => 5
//             ,"offset" => 0 );
// $result = select_board_info_paging( $arr );

// print_r( $result );

//TODO : test End









?>