<?php
require 'includes' . DIRECTORY_SEPARATOR . 'config.php';

$pageTitle = "Каталог за книги";
include 'includes' . DIRECTORY_SEPARATOR . 'header.php';

	include 'includes' . DIRECTORY_SEPARATOR . 'nav.php';
	?>

	<section class="grid_8">
		<header>
			Списък на книгите
		</header>
		<table class="msg">
			<tr>
				<th>#</th>
				<th>Книга</th>
				<th>Автор(и)</th>
			</tr>
			<?php
			$connection = db_connect();
			// we select all records
			$query = 'SELECT books.book_title, books.book_id, authors.author_name, authors.author_id FROM books
					  LEFT JOIN books_authors as ba ON books.book_id=ba.book_id
					  LEFT JOIN authors ON authors.author_id=ba.author_id';
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
			?>
		</table>
	</section>

	<?php
	include 'includes' . DIRECTORY_SEPARATOR . 'aside.php';

include 'includes' . DIRECTORY_SEPARATOR . 'footer.php';
?>