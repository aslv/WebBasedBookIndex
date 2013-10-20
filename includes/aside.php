    <aside class="grid_2">

        <div class="search">
        
        <?php
        if (isset($_GET) && isset($_GET['search']))
        {
            $connection = db_connect();
            $author = trim($_GET['search']);
            $author = mysqli_real_escape_string($connection, $author);
            if (mb_strlen($author) < 3)
            {
                $error_ = 'Дължината на името на автора не може да е по-малка от 3 символа!';
            }
            $query = 'SELECT author_id FROM authors WHERE author_name="' . $author . '"';
            $q = mysqli_query($connection, $query) or $error_ = 'Възникна грешка!<br>Моля, опитайте по-късно!';
            if (!isset($error_))
            {
                if (mysqli_num_rows($q) == 0)
                {
                    $error_ = 'Няма такъв автор!';
                }
                else
                {
                    $row = mysqli_fetch_assoc($q);
                    header('Location: author_books.php?author_id=' . $row['author_id']);
                    exit;
                }
            }
        }
        ?>
            <form action="" method="GET">
                <label>
                    <span class="labelTitle">Търсене по автор:</span>
                    <input type="text" name="search" />
                </label>
                <!--<input type="submit" value="Виж" />-->
                <button type="submit" border="0">Търсене <img src="img/search.png" alt="" /></button>
            </form>

        <?php
        if (isset($error_))
        {
            echo '<div class="error">' . $error_ . '</div>';
        }
        ?>

        </div>

    </aside>