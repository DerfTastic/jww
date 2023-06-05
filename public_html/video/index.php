<!DOCTYPE html>
<!--
    Jacob's Wacky World - Video page

    Since: May 14th, 2023
    By: Jacob Applebaum
-->
<html>

<head>

    <?php
error_reporting(E_ALL);

$vlfile = fopen("video-list.csv", "r") or die("Unable to load video list... ask jakey how he broke the site this time");
$l = fgetcsv($vlfile, 552, ",", "\"", "\\") or die("Unable to load video list... ask jakey how he broke the site this time"); // Get column labels

$is404 = false;
$t = NULL;

if (!array_key_exists('t', $_GET)) {
    $is404 = true;
    fclose($vlfile);
}
else {
    $t = $_GET['t'];
    echo "<title>".$t."</title>";
}

    ?>
    <meta charset="utf-8"/>
    <meta name="keywords" content="Applebaum Jacob wacky world jacob's electronics programming videos games"/>
    <meta name="description" content="Jacob's Wacky World is a portfolio website for Jacob Applebaum to show off his projects."/>

    <!-- <meta http-equiv="refresh" content="5"/> -->

    <link rel="stylesheet" href="/style.css" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>

    <style>
    video {
		width: 250px;
  		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.90);
  		text-align: center;
    }
    </style>

    <!-- video.js stuff -->
    <link href="https://vjs.zencdn.net/7.6.5/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

</head>
<body>
    <header>
        <table>
            <tr>
                <td colspan = 5 ><img id="banner" src="/images/top-banner.jpg" alt="top banner with jacob"></td>
            </tr>

            <form action="/index.php" method="get">
            <tr id="nav">
                <td>
                    <button type="submit" name="p" value="home"> <b>HOME</b> </button>
                </td>
                <td>
                    <button type="submit" name="p" value="projects"> <b>PROJECTS</b> </button>
                </td>
                <td>
                    <button type="submit" name="p" value="videos"> <b>VIDEOS</b> </button>
                </td>
                <td>
                    <button type="submit" name="p" value="about-me"> <b>ABOUT ME</b> </button>
                </td>
                <td>
                    <button type="submit" name="p" value="resume"> <b>RESUME</b> </button>
                </td>
            </tr>
            </form>
        </table>
    </header>

    <main>
        <?php
        // Search csv for title name match
        $is404 = true;
        $row = 0;

        // debug
        // print($t);

        while (($data = fgetcsv($vlfile, 552, ",", "\"", "\\")) !== FALSE) {
            $row++;

            // debug
            // print($data[0]);
            // echo "<br>";

            if ($data[0] === $t) {
                $is404 = false;

                // Make webpage

                $thumbpath = substr($data[6], 17);
                $videopath = substr($data[5], 6);

                echo <<<video
                <video id="my-video" class="video-js" controls preload="auto" width="768" height="432" poster="/images/thumbnails/videos/$thumbpath" data-setup="{}">
                    <source src="/video/$videopath" type="video/mp4">
                    <p class="vjs-no-js">
                    To see my video you need to enable JavaScript , and consider upgrading to a new web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video.</a>
                    </p>
                </video>
                <script src="https://vjs.zencdn.net/7.6.5/video.js"></script>
                video;
                echo "<h2>".$data[0]."</h2>";
                echo "<p><i>".$data[3]."</i></p>";
                echo "<p>".$data[4]."</p>";
                break;
            }
        }
        fclose($vlfile);
        ?>
    </main>
</body>
</html>


