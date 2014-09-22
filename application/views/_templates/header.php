<?php
    if(!isset($_SESSION))
    {
        ob_start();
        session_start();
    }

    if(isset($_SESSION['pc_user']) || isset($_COOKIE['pc_user'])){
        if(isset($_COOKIE['pc_user'])) {
            $userid = $_COOKIE['pc_user'];
            $_SESSION['pc_user'] = $userid;
        }

        $userid = $_SESSION['pc_user'];
?>
<nav class="navigation-bar dark">
                <div class="navigation-bar-content">
                    <a href="<?php echo URL; ?>" class="element" style="padding:5px"><img src="<?php echo URL; ?>public/img/Box.png" style="max-height:100%"> Pirate Chest <sup>1.0</sup></a>
                    <span class="element-divider"></span>

                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <img src="<?php echo URL; ?>public/img/User.png" style="max-height: 100%">
                                <?php echo $user_model->db->select("pc_user", "ID = $userid")[0]['Username']; ?>
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="<?php echo URL; ?>">All files</a></li>
                                <li><a href="<?php echo URL; ?>chat">Pirate Chat</a></li>
                                <li><a href="<?php echo URL; ?>logout">Logout</a></li>
                            </ul>
                        </div>

                        <!-- <div class="element place-right">
                            <div class="input-control text">
                                <input type="text" placeholder="Search...">
                                <button class="btn-search"></button>
                            </div>
                        </div> -->
                    </ul>
                </div>
            </nav>
<?php
    }else {
 ?>
<nav class="navigation-bar dark">
                <div class="navigation-bar-content">
                    <a href="<?php echo URL; ?>" class="element" style="padding:5px"><img src="<?php echo URL; ?>public/img/Box.png" style="max-height:100%"> PirateChest <sup>1.0</sup></a>
                    <a class="pull-menu" href="#"></a>
                    <ul class="element-menu">
                        <div class="element place-right">
                            <a class="dropdown-toggle" href="#">
                                <img src="<?php echo URL; ?>public/img/User.png" style="max-height: 100%">
                                Anonymous
                            </a>
                            <ul class="dropdown-menu place-right" data-role="dropdown">
                                <li><a href="<?php echo URL; ?>">All files</a></li>
                                <li><a href="<?php echo URL; ?>chat">Pirate Chat</a></li>
                                <li><a href="<?php echo URL; ?>logout">Logout</a></li>
                            </ul>
                        </div>

                        <!-- <div class="element place-right">
                            <div class="input-control text">
                                <input type="text" placeholder="Search...">
                                <button class="btn-search"></button>
                            </div>
                        </div> -->
                    </ul>
                </div>
            </nav>
<?php 
    } 
?>