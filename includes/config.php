<?php
mb_internal_encoding('UTF-8');

$heading = 'Каталог за книги';

// using default DB user
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db = 'books';

function db_connect() // a sample of singletone
{
	static $connection;
	if ($connection)
	{
		return $connection;
	}
    $connection = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db']) or
    											$GLOBALS['error'] = 'Възникна грешка!<br>Моля, опитайте по-късно!';
    mysqli_set_charset($connection, 'utf8') or $GLOBALS['error'] = 'Възникна грешка!<br>Моля, опитайте по-късно!';
    return $connection;
}
?>