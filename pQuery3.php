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



        $sql ="SELECT c.Customer_ID, c.FirstName
                FROM Customer c
                WHERE NOT EXISTS
                (SELECT * FROM Cars v
                WHERE NOT EXISTS
                (SELECT * FROM scheduler s
                WHERE s.Car_ID = v.Car_ID
                AND s.Customer_ID = c.Customer_ID));";

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
                                    'th' => array('Customer ID', "First Name"),
                                    'type' => 'Division- Customer rent all vehicle'
        ));

        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
