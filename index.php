<head>
    <title>Hayasugi</title>
    <link rel = "stylesheet" type = "text/css" href = "./main.css">
    <link rel="icon" type="image/png" href="./favicon.png"/>
</head>
<body>
    <div id="banner">
        <h1><a href="." class="blankLink">Hayasugi</a></h1>
        Micro-anime reviews
        <hr>

        <button id="inputBtn">Write Review</button>
    </div>

    <form id="searchForm">
        <input type="text" id="term" name="term"
            <?php
                if (isset($_GET["term"])) {
                    echo 'value="' . $_GET["term"] . '"';
                }
            ?>
            >
        <select id="type" name="type">
            <option value="anime">Anime</option>
            <option value="author"
                <?php
                    if (isset($_GET["type"]) && $_GET["type"] == "author") {
                        echo 'selected="selected"';
                    }
                ?>
                >Author</option>
        </select>
        <button type="submit" class="redButton">Search</button>
    </form>

    <div id="feed">
        <?php
            $revList = glob('./reviews/*');
            rsort($revList);

            foreach($revList as $rev) {
                $file = fopen($rev, "r");

                $title = fgets($file);
                $author = fgets($file);
                $date = fgets($file);
                $score = fgets($file);

                if (isset($_GET["term"])) {
                    $include = FALSE;
                    $lterm = strtolower($_GET["term"]);

                    if ($_GET["type"] == "anime") {
                        if (preg_match('*' . $lterm . '*', strtolower($title))) {
                            $include = TRUE;
                        }
                    }

                    if ($_GET["type"] == "author") {
                        if (preg_match('*' . $lterm . '*', strtolower($author))) {
                            $include = TRUE;
                        }
                    }
                } else {
                    $include = TRUE;
                }

                if ($include) {
                    $review = "";
                    while(! feof($file)) {
                        $review = $review . fgets($file);
                    }
                    $review = str_replace("\n", "<br>", $review);

                    echo '<article id="review' . $rev . '">' . "\n";
                    echo "\t" . '<div class="revHead">' . "\n";
                    echo "\t\t" . '<span><h1 class="revTitle"><a class="blankLink" href="./?term=' . $title . '&type=anime">' . $title . '</a></span><span class="revButton"><a class="blankLink">♥</a></span></h1>' . "\n";
                    echo "\t\t" . '<span class="revAuthor">-<a class="blankLink" href="./?term=' . $author . '&type=author">' . $author . '</a></span>' . "\n";
                    echo "\t\t" . '<span class="revDate"><i>' . $date . '</i></span>' . "\n";
                    echo "\t" . '</div>' . "\n";
                    echo "\t" . '<div class="revBody">' . $review . '</div>' . "\n";
                    echo "\t" . '<div class="revScore">' . $score . '/10</div>' . "\n";
                    echo '</article>';
                    echo "<hr>";
                }
                
                fclose($file);
            }
        ?>
    </div>

    <div id="inputModal" class="modal">
        <div class="modalContent">
            <div class="modalHeader">
                <span id="modalClose" class="close">&times;</span>
                <h2>Submit Review</h2>
            </div>
            <div class="modalBody">
                <form action="./submitReview.php" method="post" id="reviewForm">

                    <label for="anime">Anime:</label><br>
                    <input type="text" id="anime" name="anime"><br>

                    <label for="name">Name <i>(leave blank for anonymous)</i>:</label><br>
                    <input type="text" id="name" name="name"><br>

                    <label for="review">Review:</label><br>
                    <textarea name="review" id="review" rows="5" cols="80"></textarea></br>

                    <label for="score">Score:</label><br>
                    <select id="score" name="score">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>

                    <hr>

                    <div style="float: right;">
                        <button>Cancel</button>
                        <button type="submit" class="redButton">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var modal = document.getElementById("inputModal");
        var btn = document.getElementById("inputBtn");
        var span = document.getElementById("modalClose");

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>