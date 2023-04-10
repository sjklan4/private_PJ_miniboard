-- CREATE DATABASE prject_Mini_boardProject;
USE  prject_Mini_boardProject;

CREATE TABLE board_info(
					board_no INT NOT NULL
					,board_title VARCHAR(100) NULL
					,board_contents VARCHAR(1000) NULL
					,board_write_date DATETIME NULL
					,board_del_flg CHAR(1) NULL DEFAULT '0'
					,board_del_date DATETIME NULL
					);
			

-- 테이블의 정보를 알려주는 구문 		
DESC board_info;