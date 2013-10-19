<?php
require 'includes' . DIRECTORY_SEPARATOR . 'config.php';

if (isset($_GET) && isset($_GET['author_id']))
{
	$connection = db_connect();

	$authorID = trim($_GET['author_id']);

	$authorID = (int)mysqli_real_escape_string($connection, $authorID);

	$q = mysqli_query($connection, 'SELECT author_name FROM authors WHERE author_id=' . $authorID) or $error='Възникна грешка!<br>Моля, опитайте по-късно!';
	if (mysqli_num_rows($q) == 0)
	{
		$error='Няма такъв автор!';
	}
	else
	{
		$row = mysqli_fetch_assoc($q);
		$authorName = $row['author_name'];
	}
}
else
{
	header('Location: index.php');
	exit;
}

$pageTitle = "Каталог за книги";
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

	include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';
	?>

	<section class="grid_8">
		<header>
			Книги от автор
		</header>

		<?php
		if (isset($error))
		{
			echo '<div class="error">' . $error . '</div>';
		}
		if (isset($success))
		{
			echo '<div class="success">' . $success . '</div>';
		}
		?>

		<table class="msg">
			<tr>
				<th>#</th>
				<th>Книга</th>
				<th>Автор(и)</th>
			</tr>
			<?php
			if (isset($authorName))
			{
				$connection = db_connect();
				// we select records whit books belonging to the selected author
				$query = 'SELECT * FROM books_authors AS b1, books_authors AS b2
						  LEFT JOIN authors ON authors.author_id=b2.author_id
						  LEFT JOIN books ON b2.book_id=books.book_id
						  WHERE b1.author_id='. $authorID . ' AND b2.book_id=b1.book_id';
				/*
				echo '\'' . $query . '\'';
				exit;
				*/
				$q = mysqli_query($connection, $query) or $error = 'Възникна грешка!<br>Моля, опитайте по-късно!';
				if (!isset($error))
				{
					$result = array();
					while ($row = mysqli_fetch_assoc($q))
					{
						$result[$row['book_id']]['book_title'] = $row['book_title'];
						$result[$row['book_id']]['author_names'][] = array('author_name' => $row['author_name'], 'author_id' => $row['author_id']);

						//echo '<tr><td>' . $row['book_title'] . '</td><td>' . $row['author_name'] . '</td></tr>';
					}
					//echo '<pre>' . print_r($result, true) . '</pre>';
					foreach ($result as $index => $book)
					{
						echo '<tr><td>' . $index . '</td><td>' . $book['book_title'] . '</td><td>';
						foreach ($book['author_names'] as $author)
						{
							//echo '<pre>' . print_r($author, true) . '</pre>';
							echo '<a href="author_books.php?author_id=' . $author['author_id'] . '">' . $author['author_name'] . '</a><br>';
						}
						echo '</td></tr>';
					}
				}
				else
				{
					echo '<div class="error">' . $error . '</div>';
				}
			}
			?>
		</table>

	</section>

	<?php
	include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';

include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>