<!DOCTYPE html>
<html>
    <?php

        require_once './vendor/autoload.php';
        $loader = new Twig_Loader_Filesystem('./templates');
        $twig = new Twig_Environment($loader);
        session_start();

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

        $template = $twig->load('thisMenu.html');
        echo $template->render(array('menu' => array(array('Add','lease.php'),
                                                  array('Delete', 'lease.php?delete=yes')
        )));

        $template = $twig->load('location.html');
        echo $template->render();

        $template = $twig->load('thisFooter.html');
        echo $template->render(array('cpNotice' => 'Roll-Out Co.',
                                'cpDate' => 'Copyright 2017'));

        ?>
        </html>
