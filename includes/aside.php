    <aside class="grid_2">

        <div class="search">
        
        <?php
        if (isset($_GET) && isset($_GET['search']))
        {
            $connection = db_connect();
            $author = trim($_GET['search']);
            $author = mysqli_real_escape_string($connection, $author);
            $query = 'SELECT author_id FROM authors WHERE author_name="' . $author . '"';
            $q = mysqli_query($connection, $query) or $error_ = 'Възникна грешка!<br>Моля, опитайте по-късно!';
            if (!isset($error))
            {
                if (mysqli_num_rows($q) == 0)
                {
                    $error_ = 'Няма такъв автор!';
                }
                else
                {
                    $row = mysqli_fetch_assoc($q);
                    header('Location: author_books.php?author_id=' . $row['author_id']);
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