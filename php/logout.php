<?php 
    /***
     * @brief 로그아웃 페이지
     * 이 페이지에 접속하면 session_unset, destroy로 인해
     * 세션이 삭제됩니다.
     */
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../html/logoutOk.html");
