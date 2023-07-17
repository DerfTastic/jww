<!DOCTYPE html>
<!--
    Jacob's Wacky World homepage

    Since: December 16th, 2022
    By: Jacob Applebaum
-->
<html>

<?php
error_reporting(E_ERROR|E_PARSE);
// error_reporting(E_ALL);

require_once('php-code/functions.php');

?>


<head>

    <title>Jacob's Wacky World!</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content="Applebaum Jacob wacky world jacob's electronics programming videos games"/>
    <meta name="description" content="Jacob's Wacky World is a portfolio website for Jacob Applebaum to show off his projects."/>

    <!-- <meta http-equiv="refresh" content="5"/> -->

    <link rel="stylesheet" href="/style.css" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>

    <script>
    function dateACMP(a, b) {
        if (a.dataset.date < b.dataset.date)
            return -1;
        if (a.dataset.date > b.dataset.date)
            return 1;
        return 0;
    }

    function dateDCMP(a, b) {
        if (a.dataset.date < b.dataset.date)
            return 1;
        if (a.dataset.date > b.dataset.date)
            return -1;
        return 0;
    }

    function categoryCMP(a, b) {
        var result = a.dataset.category.localeCompare(b.dataset.category);
        // console.log(a.dataset.category + " > " + b.dataset.category + " ?: " + result);
        return result;
    }
      
    function sortBy(attr, order = 0) {
        var indexes = document.querySelectorAll("[data-" + attr + "]");
        var indexesArray = Array.from(indexes);
        var sorted;
        switch (attr) {
        case 'date': 
            sorted = indexesArray.sort(order == 0 ? dateACMP : dateDCMP);
            break;
        case 'category':
            sorted = indexesArray.sort(categoryCMP);
            break;
        default:
            console.error("Attribute to sort by is missing");
            return;
        }
        sorted.forEach(e =>
            document.querySelector("#list").appendChild(e));
        if (attr === 'category') {
           // idk yet 
        }
    }

    function menuUpdate() {
        var str = document.getElementById("sortmenu").value;
        var params = str.split(',');
        if (params.length == 0)
            sortBy(params);
        else 
            sortBy(params[0], params[1]);

        // console.log("Params: " + params);
    }
    </script>
        

</head>

<body>
    <header>
        <table>
            <tr>
                <td colspan = 5 ><img id="banner" src="/images/top-banner.jpg" alt="top banner with jacob"></td>
            </tr>

            <form method="get">
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

    <main id="home">

        <p>Yooo what's good! My name's Jacob Applebaum and welcome to my site!</p>

        <h2>Background</h2>
        <p>Technically I've been "coding" since middle school, but it was really just HTML and Scratch (even though I'd consider the ladder more of a <i>programming language</i>). At that time I was more into <a href="/index.php?p=videos">making and editing videos.</a></p>
        <p>In High School, I got into Python, Arduino-C, C#, Java, and JS on my own time. Then when I actually started taking Computer Science as a class I dove deeper into Java and Python, making games with a group of friends (artist, musician, and other programmer) over the summers, and I even made <a href="https://www.jacobswackyworld.ca/">my own website</a>.</p>
        <p>I also got more into hardware in high school. Arduinos, Raspberry Pis, basic circuits, robotics, etc. in Computer Engineering class. But outside of class, I stumbled upon <a href="https://eater.net">Ben Eater</a>'s videos, which finally made the connection between hardware and software 'click' in my head. And ever since, I've been really interested in the intersection between software and hardware.</p>
        <p>Now, I spend my days at Brock University, studying Computer Science. I'm learning more than ever before about software (in class) and hardware (mostly outside of class, if I have time). I'm enjoying residence for second year too, just because it was so fun last year. It makes me sad that I'll probably never live in that kind of ecosystem again... </p>

        <h2>Academic Interests</h2>
        <ul>
            <li>Computer Architecture</li>
            <li>Assembly Programming</li>
            <li>Computer Graphics</li>
            <li>Electronics</li>
            <li>Hardware Design and HDLs</li>
            <li>Game Programming</li>
            <li>Web Development</li>
            <li>FPGAs</li>
        </ul>
    </main> <!-- #home END -->

    <main id="projects" hidden>

        <h1 name="top">Projects</h1>
        <h3>Sort by:
        <form onchange="menuUpdate()" style="display: inline;">
          <select name="sortBy" id="sortmenu">
            <option value="featured" hidden selected>None</option>
            <option value="date,1">Date (newest)</option>
            <option value="date,0">Date (oldest)</option>
            <option value="category">Category</option>
          </select>
        </form>
        </h3>

        <div id="list">

<?php
$plfile = fopen("proj/proj-list.json", "r") or die("Unable to open the list of projects... ask jakey how he broke the site this time");
$json = fread($plfile, filesize("proj/proj-list.json"));
$obj = json_decode($json, true);

foreach($obj as $id => $article) {
    echo "<div id=\"".$id."\"
    class=\"".$article["Category"]."\"
    data-category=\"".$article["Category"]."\"
    data-date=\"".$article["Date"]."\">
    <form method=\"post\" action=\"/proj?id=".$id."\">
        <button type=\"submit\" name=\"fromsite\" class=\"artbut\" value=\"woah\">
        <article>";

    echo "<div id=\"cat\">";
        echo ucfirst($article["Category"]);
    echo "</div>";

    echo "<div id=\"text\">";
        echo "<h2>".$article["Name"]."</h2>";
        echo "<p>" .$article["Desc"]."</p>";
    echo "</div>";
    echo "<img src=\"/images/thumbnails/".$id.".png\" alt=\"Thumbnail of ".$article["Name"]."\">";

    $datestr = getDateStr($article["Date"]);
    echo "<div id=date><p>".$datestr."</p></div>";
    echo "</article>
        </button>
    </form>
    </a></div>";
}

fclose($plfile);

?>
        </div>

        <!-- <tr>
                <td bgcolor="lightgrey">
                    <h4 align="center"><a href="https://www.jacobswackyworld.ca/games/aaa/ji.jacobswackyworld.ca/index.html">Jacob Invaders</a><h4>
                            <img src="images/jacob-invaders-thumbnail.png" alt="an image of the title screen for jacob invaders"/>
                </td>
            </tr>
                </td>
            </tr>
        -->

        <br>
        <p><a href="#top">^^ Back to top ^^</a></p>
    </main> <!-- #projects END -->

    <main id="videos">

        <p>Welcome to <b>videos</b>! Here you'll find lots of videos I've made since 2016.<br>I mainly use Adobe Premiere and After Effects to create these now.</p>
        <h3 style="margin: 0em;padding: 0em;"><u>Legend:</u></h3><ul>
        <li style="padding-bottom: 0.5em;">Videos I made fully by myself have a <span style="background-color: white;padding:5px;border:1px solid black;">white</span> panel.</li>
        <li style="padding-bottom: 0.5em;">Videos I helped make with other people (but I still did all the editing for) have a <span style="background-color: rgb(161, 255, 246);padding:5px;border:1px solid black;">teal</span> panel.</li>
        <li style="padding-bottom: 0.5em;">Videos I helped make with other people (editing work was also shared among collaborators) have a <span style="background-color: rgb(255, 190, 255);padding:5px;border:1px solid black;">magenta</span> panel.</li>
        <li style="padding-bottom: 0.5em;">(All panels, when hovered over, turn <span style="background-color: rgb(150, 255, 150);padding:5px;border:1px solid black;">green</span>)</li>
        </ul>
        <h2 class="header">School Videos</h2>
        <div class = "row">
            <div class="column">
                <a class="thumb-title" href="/video?t=THE POWER OF JAKERS">
                <div class="content">
                    <img src="images/thumbnails/videos/THE POWER OF JAKERS.png" alt="THE POWER OF JAKERS Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>THE POWER OF JAKERS</strong><br>04.23.2021</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=一剪梅 | 动力学印刷">
                <div class="content">
                    <img src="images/thumbnails/videos/yijianmei.png" alt="一剪梅 Thumbnail" style="width:100%">
                    <p class="thumb-title"><span class="thumb-title-c2"><strong>一剪梅 | 动力学印刷</strong></span><br>04.05.2021</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Forced Success">
                <div class="content">
                    <img src="images/thumbnails/videos/forced-success.png" alt="Forced Success Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Forced Success</strong><br>02.16.2021</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=MCV4UP Performance Task Video %232: Presentation on Derivatives">
                <div class="content">
                    <img src="images/thumbnails/videos/calc-2.png" alt="MCV4UP PT #2: Presentation on Derivatives Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>MCV4UP PT #2: Presentation on Derivatives</strong><br>01.31.2021</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=MCV4UP Performance Task Video %231: Optimization Question">
                <div class="content">
                    <img src="images/thumbnails/videos/calc-1.png" alt="MCV4UP PT #1: Optimization Question Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>MCV4UP PT #1: Optimization Question</strong><br>01.30.2021</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=用務員遊び | A Jolly Jaunt with the Janitor">
                <div class="contente">
                    <img src="images/thumbnails/videos/clean-min.png" alt="A Jolly Jaunt with the Janitor Thumbnail" style="width:100%">
                    <p class="thumb-title"><span class="thumb-title-c"><strong>用務員遊び | A Jolly Jaunt with the Janitor</strong></span><br>10.10.2019</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Billy Madison Scene Re-creation - The Game Show Scene">
                <div class="contente">
                    <img src="images/thumbnails/videos/billy-madison.png" alt="Billy Madison Scene Re-creation Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Billy Madison Scene Re-creation</strong><br>08.21.2019</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The Dramatic Devious Deadly Dump 2">
                <div class="contente">
                    <img src="images/thumbnails/videos/ddd-dump-2.png" alt="The Dramatic Devious Deadly Dump 2" style="width:100%">
                    <p class="thumb-title"><strong>The Dramatic Devious Deadly Dump 2</strong><br>06.19.2019</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The Dramatic Devious Deadly Dump">
                <div class="contente">
                    <img src="images/thumbnails/videos/Lower-quality-videos/21.png" alt="The Dramatic Devious Deadly Dump" style="width:100%">
                    <p class="thumb-title"><strong>The Dramatic Devious Deadly Dump</strong><br>03.03.2019</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The Opponent of the Rodent">
                <div class="contente">
                    <img src="images/thumbnails/videos/rodent.png" alt="The Opponent of The Rodent Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>The Opponent of the Rodent</strong><br>02.19.2019</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Giuseppe's Operation">
                <div class="contente">
                    <img src="images/thumbnails/videos/Guiseppe's Operation Video.png" alt="Giuseppe's Operation Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Giuseppe's Operation</strong><br>11.12.2018</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The Original Gameboy vs. The Nintendo Switch">
                <div class="content">
                    <img src="images/thumbnails/videos/gameboy vs. switch.png" alt="The Original Gameboy vs. The Nintendo Switch Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>The Original Gameboy vs. The Nintendo Switch</strong><br>04.13.2018</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=How Carpooling can reduce your ecological footprint | School Video">
                <div class="contente">
                    <img src="images/thumbnails/videos/Lower-quality-videos/18.jpg" alt="How Carpooling can reduce your ecological footprint | School Video Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>How Carpooling can reduce your ecological footprint | School Video</strong><br>03.28.2018</p>
                </div>
                </a>
            </div>
        </div>
        <h2 class="header">Old videos</h2>
        <div class = "row">
            <div class="column">
                <a class="thumb-title" href="/video?t=Cringey Kids Trying to be Funny">
                <div class="contente">
                    <img src="images/thumbnails/videos/cringey-kids-trying-to-be-funny - Copy.png" alt="Cringey Kids Trying to be Funny Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Cringey Kids Trying to be Funny</strong><br>08.30.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The Safety Kids Club">
                <div class="contente">
                    <img src="images/thumbnails/videos/the-safety-kids-club-thumbnail - Copy.png" alt="The Safety Kids Club Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>The Safety Kids Club</strong><br>08.20.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Playing Old Games - With Ben!">
                <div class="contente">
                    <img src="images/thumbnails/videos/playing-old-games-with-ben-thumbnail - Copy.png" alt="Playing Old Games - With Ben! Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Playing Old Games - With Ben!</strong><br>02.26.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=What the Gamecube Handle Really Does">
                <div class="content">
                    <img src="images/thumbnails/videos/what-the-gamecube-handle-does-thumbnail - Copy.png" alt="What the Gamecube Handle Really Does Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>What the Gamecube Handle Really Does</strong><br>02.06.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Failing at Solving Rubik's Cubes">
                <div class="content">
                    <img src="images/thumbnails/videos/failing-at-solving-rubiks-cubes-thumbnail.png" alt="Failing at Solving Rubik's Cubes Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Failing at Solving Rubik's Cubes</strong><br>01.27.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The DS Curse">
                <div class="content">
                    <img src="images/thumbnails/videos/the-ds-curse - Copy.png" alt="The DS Curse Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>The DS Curse</strong><br>12.19.2016</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Summation Notation and Halloween Evolution">
                <div class="content">
                    <img src="images/thumbnails/videos/summation-notation - Copy.png" alt="Summation Notation and Halloween Evolution Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Summation Notation and Halloween Evolution</strong><br>11.22.2016</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=My Biased Thoughts on Nintendo">
                <div class="content">
                    <img src="images/thumbnails/videos/my-biased-thoughts-on-nintendo-thumbnail - Copy.png" alt="My Biased Thoughts on Nintendo Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>My Biased Thoughts on Nintendo</strong><br>10.12.2016</p>
                </div>
                </a>
            </div>
        </div>
        <h2 class="header">Old and Low-quality videos</h2>
        <div class = "row">
            <div class="column">
                <a class="thumb-title" href="/video?t=I just cut the cheese">
                <div class="content">
                    <img src="images/thumbnails/videos/Lower-quality-videos/20.jpg" alt="I just cut the cheese Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>I just cut the cheese</strong><br>01.31.2019</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Darude Chairstorm (Darude Sandstorm YTPMV)">
                <div class="contente">
                    <img src="images/thumbnails/videos/Lower-quality-videos/14.jpg" alt="Darude Chairstorm (Darude Sandstorm YTPMV) Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Darude Chairstorm (Darude Sandstorm YTPMV)</strong><br>09.03.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=The Basketball Bros.">
                <div class="contente">
                    <img src="images/thumbnails/videos/Lower-quality-videos/13.jpg" alt="The Basketball Bros. Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>The Basketball Bros.</strong><br>08.19.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=How to Put Effects on Your Messages in iMessage!">
                <div class="content">
                    <img src="images/thumbnails/videos/Lower-quality-videos/10.jpg" alt="How to Put Effects on Your Messages in iMessage! Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>How to Put Effects on Your Messages in iMessage!</strong><br>06.01.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=Closest. Race. Ever.">
                <div class="contentc">
                    <img src="images/thumbnails/videos/Lower-quality-videos/06.jpg" alt="Closest. Race. Ever. Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>Closest. Race. Ever.</strong><br>02.13.2017</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=I can properly exit a room">
                <div class="content">
                    <img src="images/thumbnails/videos/Lower-quality-videos/04.jpg" alt="I can properly exit a room Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>I can properly exit a room</strong><br>02.11.2017</p>
                </div>
                </a>
            </div>
        </div>
        <h2 class="header">Other Videos</h2>
        <div class = "row">
            <div class="column">
                <a class="thumb-title" href="/video?t=【Collab】otoMEDkulec ~mikulec gaming 4~">
                <div class="contentc">
                    <img src="images/thumbnails/videos/mmg4.png" alt="otoMEDkulic | Mr. Mikulec Gaming 4 Thumbnail" style="width:100%">
                    <p class="thumb-title"><span class="thumb-title"><strong>【Collab】otoMEDkulec ~mikulec gaming 4~</strong></span><br>04.13.2021</p>
                </div>
                </a>
            </div>
            <div class="column">
                <a class="thumb-title" href="/video?t=LEAP Meme Review">
                <div class="contente">
                    <img src="images/thumbnails/videos/leap.png" alt="LEAP Meme Review Thumbnail" style="width:100%">
                    <p class="thumb-title"><strong>LEAP Meme Review</strong><br>07.27.2019</p>
                </div>
                </a>
            </div>
        </div>
    </main> <!-- #videos END -->

    <main id="about-me">
        <td colspan = "4" align = "left" valign = "top">
            <h1>About me</h1>
            <img width="700px" src="images/jacob-aboutme.png" alt="a collage of various pictures of jacob applebaum, including one where he is eatin' da ice cream, one where he's at Walmart buying a shitty router sitting next to the ronald mcdonald bench in the store as a 14-year-old, and one where he is frouning at a piece of pizza."/>
            <p>What's good? I'm Jacob Applebaum and I'm a 19-year-old Canadian University Student. But that's not all. I'm a real person... I think. A collection of memories emotions, interests, motives, desires, flesh, blood, and more. Never fully tangible, even if you were to meet me in person, and especially not online.</p>
            <p>Here are some things I'm good at I guess:</p>
            <ul>
                <li>Programming</li>
                <li>Video Editing</li>
                <li>Soldiering</li>
                <li>Being honest most of the time</li>
                <li>Using NeoVim</li>
                <li>Mario Kart</li>
                <li>Staying up until 8 AM</li>
            </ul>
        </td>
    </main> <!-- #about-me END -->

    <main id="resume">
        <h1>Resume</h1>
        <iframe src="files/resume.pdf" width="100%" height="900px"></iframe>
    </main> <!-- #resume END -->

    <!--
    <footer>
        <button class="smallb" onclick="delete_acc()">Delete Account</button>
    </footer>
    -->

    <script>

    <?php 

    if (!array_key_exists('p', $_GET)) {
      echo "showMain('home');";
    }
    else {
      $p = $_GET['p'];

      echo <<<JS
        try {
          showMain("$p");
        }
        catch(err) {
          console.error(err.message); // Debug
          showMain('home');
        };
        JS;
    }

    ?>

    function show(id) {
        document.getElementById(id).hidden = false;
    }

    function hide(id) {
        document.getElementById(id).hidden = true;
    }

    /* showMain( String id )
     *    hides all main elements but reveals element with id of parameter id
     */
    function showMain(id) {
        var mains = document.getElementsByTagName("main");
        for (var i = 0; i < mains.length; i++) {
            mains[i].hidden = true;
        }
        document.getElementById(id).hidden = false;
    }

    </script>
</body>
</html>
