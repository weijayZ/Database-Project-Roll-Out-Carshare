<!DOCTYPE html>
<html>
    <?php

        require_once './vendor/autoload.php';
        require_once 'sqlinfo.php';
        $loader = new Twig_Loader_Filesystem('./templates');
        $twig = new Twig_Environment($loader);
        session_start();
        error_reporting(0);

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

        $connInfo = getSqlinfo();

        $conn = new mysqli($connInfo->servername, $connInfo->username, $connInfo->password, $connInfo->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $cID = $_SESSION['id'];
        $vType = $_GET['qString'];
        //echo "<h1>$vType</h1>";


        $template = $twig->load('thisHeader.html');
        echo $template->render(array('title' => 'Roll-Out: Car Share'));

        $template = $twig->load('thisMenu.html');
        echo $template->render(array('menu' => $navbar
        ));

        if ($vType == null){
          $sql = "CALL profile('$cID')";
          $type = "Profile";
          $result = $conn->query($sql);
          $thisArray = array();
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  $fname ="First Name: ".$row['FirstName'];
                  $lName= "Last Name: ".$row['LastName'];
                  $dob = "Date of Birth: ".$row["DateBirth"];
                  $sex = "Sex: ".$row["Sex"];
                  $dlNum = "Driver's License Number: ".$row["DriverLNum"];
                  $pNum = "Phone Number: ".$row["PhoneNum"];
                  $addy = "Address: ".$row["cAddress"];
                  $pCode = "Postal Code: ".$row["PostalCode"];
                  $em = "Email Address: ".$row["Email"];
                  array_push($thisArray, $fname, $lName, $dob, $sex,  $dlNum, $pNum, $addy, $pCode, $em);
              }
          };
          $template = $twig->load('account.html');
          echo $template->render(array('menu' =>array(array('Profile','user.php'),
                                                      array('Billing', 'user.php?qString=bill'),
                                                      array('Leases', 'user.php?qString=lease'),
                                                      array('Cars Used', 'user.php?qString=cars')),

                                  'type' => $type,
                                  'product' => $thisArray
          ));





        } else if($vType == 'bill'){
          $sql = "CALL bills('$cID')";
          $type = "Billing";

          $result = $conn->query($sql);

          $template = $twig->load('billing.html');
          echo $template->render(array('menu' =>array(array('Profile','user.php'),
                                                      array('Billing', 'user.php?qString=bill'),
                                                      array('Leases', 'user.php?qString=lease'),
                                                      array('Cars Used', 'user.php?qString=cars')),
                                  'th' => array('Invoice #', 'Due Date', 'Paid', 'Balance', 'Over Due', 'Past Balance', 'Customer ID'),

                                  'type' => $type,
                                  'product' => $result
          ));

        } else if($vType == 'lease'){
          $type = "Leases";

          $sql = "CALL leases('$cID')";
          $result = $conn->query($sql);

          $template = $twig->load('billing.html');
          echo $template->render(array('menu' =>array(array('Profile','user.php'),
                                                      array('Billing', 'user.php?qString=bill'),
                                                      array('Leases', 'user.php?qString=lease'),
                                                      array('Cars Used', 'user.php?qString=cars')),
                                  'th' => array('Lease ID', 'Duration (Mins)', 'Cost ($)', 'Car ID', 'Invoice', 'Customer ID'),

                                  'type' => $type,
                                  'product' => $result
          ));

        } else if($vType == 'cars'){

          $type = "Cars Used";
          $sql = "CALL usedCar('$cID')";
          $result = $conn->query($sql);

          $template = $twig->load('billing.html');
          echo $template->render(array('menu' =>array(array('Profile','user.php'),
                                                      array('Billing', 'user.php?qString=bill'),
                                                      array('Leases', 'user.php?qString=lease'),
                                                      array('Cars Used', 'user.php?qString=cars')),
                                  'th' => array('Car ID', 'Make', 'Model'),

                                  'type' => $type,
                                  'product' => $result
          ));
        }


        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
