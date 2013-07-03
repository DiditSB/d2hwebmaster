<html>
    <head>
        <title>Dashboard | d2hwebmaster</title>
    </head>
    <body>
        <?php if(!empty($message)) { echo $message; } ?>
        Home Dosen
        <a href="<?php echo site_url('dosen/insert_problem'); ?>">Insert Problem</a>
        <?php 
            $dateTime = new DateTime('2013-07-03 00:08:00');
            if ($dateTime->diff(new DateTime)->format('%R') == '+') {
                echo "OK";
            }
            
            $replace = array('-', ':', ' ');
            $resttimefrom = str_replace($replace, '', '2013-07-03 00:08:00');
            $resttimeto = str_replace($replace, '', '2013-07-03 00:12:00');
            
            $currentTime = date('YmdHis');
            //echo $resttimefrom.' '.$resttimeto,' '.$currentTime;
            if ($currentTime > $resttimefrom && $currentTime < $resttimeto )
            {
                echo "open";
            }
            else
            {
                echo "close";
            }
        ?>
    </body>
</html>