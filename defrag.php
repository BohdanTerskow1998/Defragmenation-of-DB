<?php
$link=new mysqli('localhost', 'root', '');
if (!$link) {
    die('Ошибка соединения: ' . mysql_error());
}
echo "Успешно соединились\n";
$res = mysqli_query($link,'SHOW DATABASES');
while (list($dbname) = mysqli_fetch_row($res))
{
        mysqli_select_db($link, $dbname);
        $rec = mysqli_query($link, 'SHOW TABLE STATUS');
        while ($data = mysqli_fetch_object($rec))
        if ($data->Engine == 'InnoDB')
        {
                echo 'Processing ', $dbname, '.', $data->Name, ' ... '; flush();
                mysqli_query($link, "ALTER TABLE {$data->Name} ENGINE=InnoDB");
                mysqli_query($link, "OPTIMIZE TABLE  {$data->Name};");
                echo "done.n";
        }
        mysqli_free_result($rec);
}
mysqli_free_result($res);
