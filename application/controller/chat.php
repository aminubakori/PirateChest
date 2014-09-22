<?php

/**
 * Class Chat
 */
class Chat extends Controller
{
    public function index()
    {
        require 'application/views/chat/index.php';
    }

    public function add()
    {
        if(!isset($_SESSION)) {
            ob_start();
            session_start();
        }

        $user_model = $this->loadModel('UserModel');

        if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['message']) && !empty($_POST['message']) && isset($_POST['color']) && !empty($_POST['color'])) {
            $username = trim(htmlentities($_POST['username']));
            $message = trim(htmlentities($_POST['message']));
            $color = trim(htmlentities($_POST['color']));

            $_chat = array(
                "Username" => $username,
                "Message" => $message,
                "MsgColor" => $color
            );

            $user_model->db->insert('pc_chat', $_chat);
            header("Location:".URL."chat");

        }else {
            header("Location:".URL."chat");
        }
    }

    public function get()
    {
        if(!isset($_SESSION)) {
            ob_start();
            session_start();
        }

        $user_model = $this->loadModel('UserModel');
        $chats = $user_model->db->run('SELECT * FROM pc_chat ORDER BY ID DESC LIMIT 100');

        foreach ($chats as $key => $chat) {
            $ID = $chat['ID'];
            $Username = $chat['Username'];
            $Message = $chat['Message'];
            $MsgColor = $chat['MsgColor'];

            echo "
                <div class='msg'>
                    <p class='fg-".$MsgColor."'><b>".$Username."</b> - ".$Message."</p>
                </div>
            ";
        }
    }
}
