<!DOCTYPE html>
<html>
    <?php
    require 'sqlinfo.php';
    session_start();
    require_once './vendor/autoload.php';
    $connInfo = getSqlinfo();
    $loader = new Twig_Loader_Filesystem('./templates');
    $twig = new Twig_Environment($loader);
    require('connect.php');

    if (isset($_POST['username']) and isset($_POST['password'])){

      $username = $_POST['username'];
      $password = $_POST['password'];

      $query = "SELECT Customer_ID FROM customer WHERE username='$username' and pass_word='$password' UNION SELECT StaffID FROM Administrator WHERE Username='$username' and sPassword='$password'";

      $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
      $count = mysqli_num_rows($result);
      while($row = $result->fetch_assoc()) {
        if($row['Customer_ID']){
          $_SESSION['id'] = $row['Customer_ID'];
        } else {
          $_SESSION['id'] = $row['StaffID'];
        }
      }

      if ($count == 1){
        $_SESSION['username'] = $username;
        }else{

        echo "Invalid Login Credentials.";
        }
      }

      if (isset($_SESSION['username'])){
        if($_SESSION['id'][0] == 'C'){
         header( "Location: user.php" );
        } else {
          header( "Location: admin.php" );
        }
    }else{

    };

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

    $template = $twig->load('log.html');
    echo $template->render();


    $template = $twig->load('thisFooter.html');
    echo $template->render(array('cpNotice' => 'Galaxy Express Co.',
                            'cpDate' => 'Copyright 2369'));

    ?>
    </html>
