<?php
    /**
     * @brief 데이터베이스 연결
     * 
     * @param void
     * @return 연결된 db 정보를 담고있는 객체
     */
    
    include __DIR__ . '/var/info.php';
    
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4');
    
    try {
        $con = new PDO("mysql:host={$host};dbname={$dbName}", $userName, $password, $options);
    } catch (Exception $e) {
        die("db 연결에 실패했습니다!: " . $e->getMessage());
    }
    
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);