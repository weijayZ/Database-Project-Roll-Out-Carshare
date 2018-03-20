<?php

    require_once './vendor/autoload.php';
    $loader = new Twig_Loader_Filesystem('./templates');
    $twig = new Twig_Environment($loader);

    $hFont = $_GET['hFont'];
    $hColor  = $_GET['hColor'];
    $fSize  = $_GET['fSize'];
    $bgColor  = $_GET['bgColor'];
    $themeFont  = $_GET['themeFont'];
    $cardColor  = $_GET['cardColor'];
    $cardFont = $_GET['cardFont'];

    $template = $twig->load('Style.less');
    echo $template->render(array('bg' => 'black',
                                'hFont' => $hFont,
                                'hColor' => $hColor,
                                'fSize' => $fSize,
                                'bgColor' => $bgColor,
                                'themeFont' => $themeFont,
                                'cardColor' => $cardColor,
                                'cardFont' => $cardFont


));


?>
