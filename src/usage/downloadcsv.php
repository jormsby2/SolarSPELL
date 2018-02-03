<?php
    if (isset($_POST['download'])){
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="tester.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        $file = fopen('php://output', 'w');
        readfile("tester.csv");
        exit();
    }
?>
