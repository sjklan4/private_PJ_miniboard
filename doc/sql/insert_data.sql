
-- INSERT INTO board_info(board_title, board_contents, board_write_date)
-- VALUES('제목 1', '내용 1', NOW());

INSERT INTO board_info(board_title, board_contents, board_write_date)
VALUES('제목 14', '내용 14', NOW())
,('제목 22', '내용 22', NOW())
,('제목 23', '내용 23', NOW())
,('제목 24', '내용 24', NOW())
,('제목 25', '내용 25', NOW())
,('제목 26', '내용 26', NOW());

-- 
-- 

-- 
-- COMMIT;
-- SELECT board_no
-- 			,board_title
-- 			,board_write_date 
-- FROM board_info
-- WHERE board_del_flg = '0'
-- ORDER BY board_no ASC
-- LIMIT 5 OFFSET 0;
-- COMMIT;

-- SELECT COUNT(*) FROM board_info;