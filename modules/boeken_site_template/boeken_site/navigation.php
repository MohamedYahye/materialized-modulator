<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<nav>
    <div class="container">
        <div class="multi-page-nav sticky-wrapper" id="tmNavbar">
            <ul>
                <a href="index.php"><li>Home</li></a>
                <a href="index.php"><li>Authors</li></a>
                <a href="uploadBook.php"><li>new book</li></a>
                <a href="books.php"><li>Books</li></a>
                <a href="toCome.php"><li>to come</li></a>
                <a href="logout.php"><li>Logout</li></a>
                    <form class="searchForm" action="search.php?search=All" method="post">
                        <br>
                        <input type="text" name="search" placeholder="Search on website"/>&nbsp;&nbsp;&nbsp;
                        <input class="button_example" type="submit" value="Go" />

                    </form>
                    <form class="searchForm" action="search.php?search=User" method="post">
                        <br>
                        <input type="text" name="search" placeholder="Search in user books"/>&nbsp;&nbsp;&nbsp;
                        <input class="button_example" type="submit" value="Go" />
                    </form>
            </ul>
        </div>   
    </div>
    <div class="handle">menu</div>
</nav>
<script>
$('.handle').on('click', function(){
    $('nav ul').toggleClass('showing');
});
</script>

<!-- <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="multi-page-nav sticky-wrapper" id="tmNavbar">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php">Authors</a></li>
                <li><a href="uploadBook.php">new book</a></li>
                <li><a href="books.php">Books</a></li>
                <li><a href="toCome.php">to come</a></li>
                <li><a href="logout.php">Logout</a></a></li>
                    <form class="searchForm" action="search.php?search=All" method="post">
                        <br>
                        <input type="text" name="search" placeholder="Search on website"/>&nbsp;&nbsp;&nbsp;
                        <input class="button_example" type="submit" value="Go" />

                    </form>
                    <form class="searchForm searchRight" action="search.php?search=User" method="post">
                        <br>
                        <input type="text" name="search" placeholder="Search in user books"/>&nbsp;&nbsp;&nbsp;
                        <input class="button_example" type="submit" value="Go" />
                    </form>
            </ul>
        </div>   
    </div>
</nav> -->