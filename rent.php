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

        $location = $_GET['location'];

        $sql = "CALL findCars('$location')";
        $type = "Vehicles in Your Area";

        $result = $conn->query($sql);
        $thisArray = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $thisRow = array();
                $make = $row['Make'];
                $model = $row['Model'];
                $img = $row['VehicleImage'];
                $carid = $row['Car_ID'];
                array_push($thisRow,$make, $model, $img, $carid);
                array_push($thisArray, $thisRow);
            }
        };


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

        $template = $twig->load('closeCars.html');
        echo $template->render(array(
                                'type' => $type,
                                'product' => $thisArray,
                                'loc' => $location
        ));

        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
