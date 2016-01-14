<?php
class Util{
    function h($str)
    {
        $str = trim($str);
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}