<!DOCTYPE html>
<html>
    <?php

        require_once './vendor/autoload.php';
        require_once 'sqlinfo.php';
        $loader = new Twig_Loader_Filesystem('./templates');
        $twig = new Twig_Environment($loader);
        session_start();
        //error_reporting(0);

        $connInfo = getSqlinfo();

        $conn = new mysqli($connInfo->servername, $connInfo->username, $connInfo->password, $connInfo->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }



        $navbar = array(array('Admin','admin.php'),
                          array('Logout', 'logout.php'));


        $template = $twig->load('lessStuff.html');
        echo $template->render(array('hFont' => 'Lobster',
                                'cardColor' => 'grey',
                                'cardFont' => 'grey',
                                'hColor' => 'Grey',
                                'fSize' => '7rem',
                                'bgColor' => 'Pink',
                                'themeFont' => 'Lobster'

        ));

        $template = $twig->load('thisHeader.html');
        echo $template->render(array('title' => 'Roll-Out: Car Share'));

        $template = $twig->load('thisMenu.html');
        echo $template->render(array('menu' => $navbar
        ));

        $carid = $_GET['carid'];
        $cond = $_GET['cond'];

        if ($carid==null || $cond==null) {
          echo "<div class='content'><h3>Input Error, Please Input Car ID and Condition</h3></div>";
        }else {

          $sql = "UPDATE Cars SET itCondition = '$cond' WHERE Car_ID = '$carid'";
          $result = $conn->query($sql);

          clearConnection($conn);

          $sql2 = "SELECT Car_ID, itCondition FROM Cars";
          $result2 = $conn->query($sql2);

          $template = $twig->load('table.html');
          echo $template->render(array('product' => $result2,
                                      'th' => array('Car ID', 'Make', 'Model', 'Mileage'),
                                      'type' => 'Update: '.$carid.' '.$cond
          ));

        }


        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
