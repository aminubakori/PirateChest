<?php

class UserModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established. '. $e->getMessage());
        }
    }

    public function throwUser($domain,$currentPage) {
        if(isset($_SESSION['pc_user'])){
            
        }else if(isset($_COOKIE['pc_user'])) {
            $userid = $_COOKIE['pc_user'];
            $_SESSION['pc_user'] = $userid;
        }else {
            header("Location:".$domain);
        }
    }

    public function pretty_filesize($size) {
        if($size<1024){
            $size=$size." Bytes";
        }elseif(($size<1048576) && ($size>1023)){
            $size=round($size/1024, 1)." KB";
        }elseif(($size<1073741824) && ($size>1048575)){
            $size=round($size/1048576, 1)." MB";
        }else{
            $size=round($size/1073741824, 1)." GB";
        }

        return $size;
    }

    public function pretty_timeago($time){
       $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
       $lengths = array("60","60","24","7","4.35","12","10");

       $now = time();

           $difference     = $now - $time;
           $tense         = "ago";

       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
           $difference /= $lengths[$j];
       }

       $difference = round($difference);

       if($difference != 1) {
           $periods[$j].= "s";
       }

       return "$difference $periods[$j] ago ";
    }
}
