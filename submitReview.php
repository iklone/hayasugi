<body>
    <?php
        echo "Starting PHP";
        echo "<br>";
        error_reporting(E_ERROR | E_PARSE);

        $anime = $_POST["anime"];
        $review = $_POST["review"];
        $score = $_POST["score"];

        $name = $_POST["name"];
        if ($name == "") {
            $name = "Anonymous";
        }
        echo "Name set as " . $name;
        echo "<br>";

        $datetime = date("d M Y @ h:ia");

        $cIDFile = fopen("cID", "r") or die("Unable to open cID file");
        $cID = fread($cIDFile, filesize("cID"));
        fclose($cIDFile);
        echo "Read cID file. Old ID = " . $cID;
        echo "<br>";

        $cID = $cID + 1;
        $cIDFile = fopen("cID", "w") or die("Unable to open cID file");
        fwrite($cIDFile, $cID);
        fclose($cIDFile);
        echo "Updated stat file. New ID = " . $cID;
        echo "<br>";

        $fileText = $anime . "\n" . $name . "\n" . $datetime . "\n" . $score . "\n" . "$review";
        $file = fopen("./reviews/" . str_pad($cID, 5, "0", STR_PAD_LEFT), "w") or die("Unable to open review file");
        fwrite($file, $fileText);
        fclose($file);
        echo "Created review file";
        echo "<hr>";

        header('Location: .');
    ?>
</body>