<?php
    /**
     * @brief 데이터베이스 연결
     * 
     * @param void
     * @return 연결된 db 정보를 담고있는 객체
     */
    
    include __DIR__ . '/var/info.php';
    
    $con = mysqli_connect($host, $userName, $password, $dbName);
    if (!$con) {
        die("DB 접속중 문제가 발생했습니다. : ".mysqli_connect_error());
    }