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

        $min = $_GET['min'];
        $max = $_GET['max'];

        if ($min==null && $max==null) {
          $sql = "SELECT Car_ID, Make, Model, Mileage FROM Cars";
        }else if($min == null){
          $sql = "SELECT Car_ID, Make, Model, Mileage FROM Cars WHERE Mileage <= $max";
        } else if( $max == null){
          $sql = "SELECT Car_ID, Make, Model, Mileage FROM Cars WHERE Mileage >= $min";
        } else if($min != 0 && $max != 0){
          $sql = "SELECT Car_ID, Make, Model, Mileage FROM Cars WHERE Mileage >= $min AND Mileage <= $max";
        }


        $type = "Profile";
        $result = $conn->query($sql);

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

        $template = $twig->load('table.html');
        echo $template->render(array('product' => $result,
                                    'th' => array('Car ID', 'Make', 'Model', 'Mileage'),
                                    'type' => 'Selection Query - Mileage'
        ));

        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
