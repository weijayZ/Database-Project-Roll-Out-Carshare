<!DOCTYPE html>
<html>
    <?php
        error_reporting(0);
        require_once './vendor/autoload.php';
        require_once 'sqlinfo.php';
        session_start();

        $connInfo = getSqlinfo();

        $conn = new mysqli($connInfo->servername, $connInfo->username, $connInfo->password, $connInfo->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $vType = $_GET['vType'];
        //echo "<h1>$vType</h1>";

        if ($vType == null){
          $sql = "CALL myProc()";
          $type = "Vehicles";
        } else {
          $sql = "CALL myProc2('$vType')";
          $type = $vType;
        }

        $result = $conn->query($sql);
        $thisArray = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $thisRow = array();
                $make = $row['Make'];
                $model = $row['Model'];
                $img = $row["VehicleImage"];
                array_push($thisRow,$make, $model, $img);
                array_push($thisArray, $thisRow);
            }
        };

        $loader = new Twig_Loader_Filesystem('./templates');
        $twig = new Twig_Environment($loader);

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

        $template = $twig->load('product.html');
        echo $template->render(array('menu' =>array(array('All','vehicles.php'),
                                                    array('Sedan', 'vehicles.php?vType=Sedan'),
                                                    array('Coupe', 'vehicles.php?vType=Coupe'),
                                                    array('Van', 'vehicles.php?vType=Van'),
                                                    array('SUV', 'vehicles.php?vType=SUV'),
                                                    array('Truck', 'vehicles.php?vType=Truck')),
                                'type' => $type,
                                'product' => $thisArray
        ));


        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Galaxy Express Co.',
                                'cpDate' => 'Copyright 2369'));


        ?>
        </html>
