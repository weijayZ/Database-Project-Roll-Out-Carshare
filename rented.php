<!DOCTYPE html>
<html>
    <?php

        require_once './vendor/autoload.php';
        require_once 'sqlinfo.php';
        $loader = new Twig_Loader_Filesystem('./templates');
        $twig = new Twig_Environment($loader);
        session_start();

        $connInfo = getSqlinfo();

        $conn = new mysqli($connInfo->servername, $connInfo->username, $connInfo->password, $connInfo->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
          $navbar = array(array('Account','user.php'),
                                                    array('Lease', 'lease.php'),
                                                    array('Log Out', 'logout.php'),
                                                    array('Vehicles', 'vehicles.php'),
                                                    array('Support', 'support.php'));
        }else{
            $navbar = array(array('Home','index.php'),
                                                      array('About Us', 'aboutUs.php'),
                                                      array('Log On', 'log.php'),
                                                      array('Vehicles', 'vehicles.php'),
                                                      array('Support', 'support.php'));
        };

        $location = $_GET['loc'];
        $dest = $_GET['dest'];
        $date = $_GET['date'];
        $dur = $_GET['dur'];
        $start = $_GET['start'];
        $car = $_GET['car'];
        $id = $_SESSION['id'];

        $timestamp = strtotime($start) + $dur;
        $end = date('H:i:s', $timestamp);
        $start = strtotime($start);

        echo $end;//11:09
        if(date("Y-m-d") == $date && date("H:i:s") >= $start && date("H:i:s") <= strtotime($end)){
          $sql = "CALL used('$car')";
          $result = $conn->query($sql);
          clearConnection($conn);
        }

        $sql = "CALL scheduleAdd('$date','$start','$timestamp', '$dur','$id', '$dest', '$location', '$car')";
        $result = $conn->query($sql);
        $type = "Vehicles in Your Area";

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

        $template = $twig->load('thisMenu.html');
        echo $template->render(array('menu' => array(array('Add','lease.php'),
                                                  array('Delete', 'lease.php?delete=yes')
        )));

        echo '<div class="content"><h2>Vehicle Has Been Rented</h2></div>';

        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
