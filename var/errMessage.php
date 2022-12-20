<?php
    /***
     * @brief 에러메세지 출력 창
     * 
     * @param $str-출력하려는 경고문
     * @return void
     */
    function errMessage($str) {
        echo "<script type=\"text/javascript\">alert('$str');</script>";
        echo "<script type=\"text/javascript\">history.back(-1);</script>";
    }