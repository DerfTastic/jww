<!DOCTYPE html>
<!--
    Jacob's Wacky World homepage

    Since: December 16th, 2022
    By: Jacob Applebaum
-->
<html>

<head>

    <title>Jacob's Wacky World!</title>
    <meta charset="utf-8"/>
    <meta name="keywords" content="Applebaum Jacob wacky world jacob's electronics programming videos games"/>
    <meta name="description" content="Jacob's Wacky World is a portfolio website for Jacob Applebaum to show off his projects."/>

    <!-- <meta http-equiv="refresh" content="5"/> -->

    <link rel="stylesheet" href="style.css" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="favicon.ico"/>

    <script>
    function dateCMP(a, b) {
        if (a.dataset.date < b.dataset.date)
            return -1;
        if (a.dataset.date > b.dataset.date)
            return 1;
        return 0;
    }

    function categoryCMP(a, b) {
        var result = a.dataset.category.localeCompare(b.dataset.category);
        console.log(a.dataset.category + " > " + b.dataset.category + " ?: " + result);
        return result;
    }
      
    function sortBy(attr) {
        var indexes = document.querySelectorAll("[data-" + attr + "]");
        var indexesArray = Array.from(indexes);
        var sorted;
        switch (attr) {
        case 'date': sorted = indexesArray.sort(dateCMP); break;
        case 'category': sorted = indexesArray.sort(categoryCMP); break;
        }
        sorted.forEach(e =>
            document.querySelector("#list").appendChild(e));
    }

    function menuUpdate() {
        console.log(document.getElementById("sortmenu").value);
        sortBy(document.getElementById("sortmenu").value);
    }
    </script>
        

</head>

<body>
    <header>
        <table>
            <tr>
                <td colspan = 5 ><img id="banner" src="images/top-banner.jpg" alt="top banner with jacob"></td>
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
                    <button type="submit" name="p" value="courses"> <b>COURSES</b> </button>
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
        <p>This is actually going to end up being a re-vamp to <a href="https://jacobswackyworld.ca">my current site</a> by the end of the semester, since I think it's long overdue for an update (almost 3 years).</p>

        <h2>Background</h2>
        <p>Technically I've been "coding" since middle school, but it was really just HTML and Scratch (even though I'd consider the ladder more of a <i>programming language</i>). At that time I was more into <a href="https://jacobswackyworld.ca/videos">making and editing videos.</a></p>
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
            <option value="featured">Featured Order</option>
            <option value="date">Date</option>
            <option value="category">Category</option>
          </select>
        </form>
        <!--
        <button onclick="sortBy('date')">Date</button>
        <button onclick="sortBy('category')">Category</button>
        -->
        </h3>
        <br>

        <div id="list">

<?php
/* error_reporting(E_ERROR|E_PARSE); */
error_reporting(E_ALL);

$plfile = fopen("data/proj-list.json", "r") or die("Unable to open the list of projects... ask jakey how he broke the site this time");
$json = fread($plfile, filesize("data/proj-list.json"));
$obj = json_decode($json, true);

foreach($obj as $id => $article) {
    echo "<div id=\"".$id."\" class=\"".$article["Category"]."\" data-category=\"".$article["Category"]."\" data-date=\"".$article["Date"]."\"><a href=\"/\"><article>";
    echo "<div id=\"text\">";
        echo "<h2>".$article["Name"]."</h2>";
        echo "<p>" .$article["Desc"]."</p>";
    echo "</div>";
    echo "<img src=\"/images/thumbnails/".$id.".png\" alt=\"Thumbnail of ".$article["Name"]."\">";

    $datestr = getDateStr($article["Date"]);
    echo "<div id=date><p>".$datestr."</p></div>";
    echo "</article></a></div>";
}

fclose($plfile);

/** getDateStr
@param $datestr A string like "2019.2". Two numbers separated by a ".", the first one being the year and the second one being the time period during the year relative to periods in school (see below)
    1 = January - April, 2nd semester of the old school year
    2 = May - August, Summer
    3 = September - December, 1st semester of the new school year
*/
function getDateStr($datestr) {
    $arr = explode(".", $datestr);
    $year = $arr[0];

    // The following takes the year and part of the year, and makes the $initgrade and $sem out of it.

    // $sem

    switch ($arr[1]) {
    case 1: $sem = 2; break; // 2nd semester, new year
    case 2: $sem = 0; break; // No semester: summer!
    case 3: $sem = 1; break; // 1st semester, year coming to end
    default: $sem = 0; break;
    }

    // $initgrade

    $initgrade = $year - 2009;
    if ($sem == 1) {
        $initgrade += 1;
    }

    // Up to this point, three vars are set: 
    // - $initgrade (14 = 2nd year BSc b/c I was in 2nd year when this date's year started)
    // - $sem (1 = 1st sem; 2 = 2nd sem)

    // To make $gradestr:

    if ($initgrade < 13) { // Before uni
        $gradestr = $initgrade."th grade"; // fix if you add projects from 3rd grade or earlier
    }
    else { // During / after uni
        switch ($initgrade) {
        case 13: $gradestr = "1st year of BSc"; break;
        case 14: $gradestr = "2nd year of BSc"; break;
        case 15: $gradestr = "3rd year of BSc"; break;
        case 16: $gradestr = "4th year of BSc"; break;
        case 17: $gradestr = "5th year of BSc"; break;
        default: $gradestr = "Post-university"; break;
        }
    }

    // To make final $timeofyear string

    if ($sem > 0) { // If sem is valid (if sem were 0, it would be summer, so not valid)
        switch ($sem) {
        case 1: 
            $semstr = "1st semester";
            return "<b>".$year."</b> - ".$gradestr.", ".$semstr;
            break;
        case 2: 
            $semstr = "2nd semester";
            return "<b>".$year."</b> - ".$gradestr.", ".$semstr;
            break;
        case 3:
            return "wait wtf code isn't working";
            break;
        }
    }
    else {
        return "<b>".$year."</b> - "."Summer after ".$gradestr;
    }
}

?>
        </div>

        <table align="center" cellpadding="10px">
            <tr>
                <th colspan="3" bgcolor="#00B000">School Assignments</th>
            </tr>
            <tr>
                <td colspan="3" bgcolor="lightgrey" >
                    <h4 align="left">Assignment 4 - <a href="/~ja20gp/A4/o8Sdv/login.html">login.html</a> <a href="/~ja20gp/A4/o8Sdv/loginAsync.html">loginAsync.html</a></h4>
                    <p>This assignment was split up into three parts:</p>
                    <ul>
                    <li>Synchronous CGI (login.html)</li>
                    <li>Asynchronous (loginAsync.html)</li>
                    <li>Substitution Cypher (loginAsync.html)</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="lightgrey" >
                    <h4 align="left">Assignment 3 - <a href="/~ja20gp/A3/9oClQ/">index.html</a> <a href="/~ja20gp/A3/9oClQ/form.html">form.html</a></h4>
                    <p>This assignment was split up into two parts:</p>
                    <ul>
                    <li><u>Responsive Design:</u> Making our Assignment 2 webpage responsive, pretty, and interactive. (index.html)</li>
                    <li><u>Forms:</u> Making a registration form. (form.html)</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="lightgrey" >
                    <h4 align="left">Assignment 2 - <a href="/~ja20gp/A2/">Link</a></h4>
                    <p>We were asked to recreate a specific example webpage as closely as possible. I'm just gonna tell you I spent 3+ hours making the image below, mapping out everything, and you'll get an idea of how I went about doing this one.</p>
                    <img src="images/A2-diagram.png" alt="a super detailed analyzation of the example image">
                </td>
            </tr>
            <tr>
                <td colspan="3" bgcolor="lightgrey" >
                    <h4 align="left">Assignment 1 - <a href="/~ja20gp/A1/">Link</a></h4>
                    <p>We were asked to create a simple personal web site (for the first time) with four pages: Home, Schedule, About Me, and another page (which I chose to make my projects page). The kicker was that we weren't allowed to use ANY JS or even CSS! I'm actually surprised how much I learned you can do to the visual aspect of the site by just using HTML atributes.</p>
                </td>
            </tr>
            <tr>
                <th colspan="3" bgcolor="#B0B000">Electronics</th>
            </tr>
            <tr align="left" valign="top">
                <td bgcolor="darkgrey" align="left">
                    <h4 align="center">8-bit Breadboard CPU</h4>
                    <p>Modules made so far:</p>
                    <ul>
                        <li>Clock module</li>
                        <li>Registers</li>
                        <li><s>ALU</s></li>
                        <li><s>Memory</s></li>
                    </ul>
                    <img src="images/8bit-CPU.png" alt="image of 8-bit CPU on breadboards"/>
                </td>
                <td bgcolor="lightgrey" align="left">
                    <h4 align="center">Graphics Card on breadboards</h4>
                    <p>Specs:</p>
                    <ul>
                        <li>100x64 Display Resolution</li>
                        <li>1 frame/second</li>
                        <li>64 color</li>
                        <li>71% CPU overhead</li>
                    </ul>
                    <img src="images/vga.png" alt="image of a graphics card on breadboards"/>
                </td>
                <td bgcolor="darkgrey">
                    <h4 align="center">6502 Breadboard Computer</h4>
                    <p>A computer made with a retro CPU used on the:</p>
                    <ul>
                        <li>Original Nintendo (NES)/Famicom</li>
                        <li>Commodore 64/128/VIC-20/PET</li>
                        <li>Atari 2600/5200/7800</li>
                        <li>Apple I/II/IIe</li>
                        <li>BBC Micro/Master</li>
                        <li>TurboGrafx-16</li>
                    </ul>
                    <img src="images/6502.jpg" alt="image of 6502 computer connected to my graphics card on breadboards"/>
                </td>
            </tr>
            <tr>
                <th colspan="3" bgcolor="#B00000">Programming</th>
            </tr>
            <tr>
                <td bgcolor="lightgrey">
                    <h4 align="center"><a href="https://www.jacobswackyworld.ca/games/aaa/ji.jacobswackyworld.ca/index.html">Jacob Invaders</a><h4>
                            <img src="images/jacob-invaders-thumbnail.png" alt="an image of the title screen for jacob invaders"/>
                </td>
            </tr>
                </td>
            </tr>
        </table>

        <br>
        <p><a href="#top">^^ Back to top ^^</a></p>
    </main> <!-- #projects END -->

    <main id="courses">
        <h1>Courses</h1>
        <p><b>My Program:</b> BSc in Computer Science with a Minor in Physics</p>
        <h2>2nd Year</h2>
        <ul>
            <li>COSC 2P03</li>
            <li>COSC 2P12</li>
            <li style="color:red;">COSC 2P89</li>
            <li>MATH 1P12</li>
            <li>PHYS 1P21</li>
        </ul>
        <h2>1st Year</h2>
        <ul>
            <li>COSC 1P03</li>
            <li>MATH 1P67</li>
            <li>IASC 1P06</li>
            <li>VISA 1Q98</li>
            <li>PSYC 1F90</li>
        </ul>
        <ul>
            <li>COSC 1P02</li>
            <li>COSC 1P50</li>
            <li>MATH 1P67</li>
            <li>SCIE 0N90</li>
            <li>PSYC 1F90</li>
        </ul>

        <h1>Schedule</h1>
        <p>2022-2023 D2 (September 2022 - December 2022)</p>

        <table border="1">
            <tr bgcolor="lightgrey">
                <th bgcolor="darkgrey">Time</th> <th>Monday</th> <th>Tuesday</th> <th>Wednesday</th> <th>Thursday</th> <th>Friday</th>
            </tr>
            <tr>
                <td>07:00</td> <td rowspan="6" width="100px"></td> <td rowspan="5" width="100px"></td> <td rowspan="12" width="100px"></td> <td rowspan="2" width=120px></td> <td rowspan="5" width=100px></td> 
            </tr>
            <tr>
                <td>07:30</td>
            </tr>
            <tr>
                <td>08:00</td> <td rowspan="3" align="center" bgcolor="purple">TUT 1<br>PHYS<br>1P21<br>THSOS</td>
            </tr>
            <tr>
                <td>08:30</td>
            </tr>
            <tr>
                <td>09:00</td>
            </tr>
            <tr>
                <td>09:30</td> <td rowspan="3" align="center" bgcolor="aqua">LEC<br>COSC<br>2P03<br>STH203</td> <td rowspan="5"></td> <td rowspan="3" align="center" bgcolor="aqua">LEC<br>COSC<br>2P03<br>STH203</td>
            </tr>
            <tr>
                <td>10:00</td> <td rowspan="4" align="center" bgcolor="orange">LAB<br><a href="https://cosc.brocku.ca/~bockusd/2p12/2p12.html" target="_blank">COSC<br>2P12</a><br>MCD205</td>
            </tr>
            <tr>
                <td>10:30</td>
            </tr>
            <tr>
                <td>11:00</td> <td></td> <td></td>
            </tr>
            <tr>
                <td>11:30</td> <td rowspan="3" align="center" bgcolor="orange">LEC<br><a href="https://cosc.brocku.ca/~bockusd/2p12/2p12.html" target="_blank">COSC<br>2P12</a><br>STH204</td> <td rowspan="3" align="center" bgcolor="orange">LEC<br><a href="https://cosc.brocku.ca/~bockusd/2p12/2p12.html" target="_blank">COSC<br>2P12</a><br>STH204</td>
            </tr>
            <tr>
                <td>12:00</td> <td rowspan="2"></td> <td rowspan="2" align="center" bgcolor="aqua">TUT 2<br>COSC<br>2P03<br>STH203</td>
            </tr>
            <tr>
                <td>12:30</td>
            </tr>
            <tr>
                <td>13:00</td> <td rowspan="2" align="center" bgcolor="purple">LEC<br>PHYS<br>1P21<br>THSOS</td> <td rowspan="7"></td> <td rowspan="2" align="center" bgcolor="purple">LEC<br>PHYS<br>1P21<br>THSOS</td> <td rowspan="2" align="center" bgcolor="purple">LEC<br>PHYS<br>1P21<br>THSOS</td> <td rowspan="7"></td>
            </tr>
            <tr>
                <td>13:30</td>
            </tr>
            <tr>
                <td>14:00</td>  <td></td>  <td rowspan=8></td>  <td></td>
            </tr>
            <tr>
                <td>14:30</td> <td rowspan=3 align="center" bgcolor="red">LEC<br>MATH<br>1P12<br>STH204</td> <td rowspan=3 align="center" bgcolor="red">LEC<br>MATH<br>1P12<br>STH204</td>
            </tr>
            <tr>
                <td>15:00</td>
            </tr>
            <tr>
                <td>15:30</td>
            </tr>
            <tr>
                <td>16:00</td> <td rowspan="4"></td> <td rowspan="17"></td>
            </tr>
            <tr>
                <td>16:30</td> <td rowspan="3" align="center" bgcolor="LIME">LEC<br><a href="https://www.cosc.brocku.ca/archive/offerings/cosc2p89" target="_blank" rel="noopener noreferrer">COSC<br>2P89</a><br>STH204</td> <td rowspan="3" align="center" bgcolor="LIME">LEC<br><a href="https://www.cosc.brocku.ca/archive/offerings/cosc2p89" target="_blank" rel="noopener noreferrer">COSC<br>2P89</a><br>STH204</td> 
            </tr>
            <tr>
                <td>17:00</td>
            </tr>
            <tr>
                <td>17:30</td>
            </tr>
            <tr>
                <td>18:00</td> <td rowspan=4 align="center" bgcolor="LIME">LAB 5<BR><A HREF="HTTPS://WWW.COSC.BROCKU.CA/archive/offerings/cosc2p89" TARGET="_BLANK" REL="NOOPENER NOREFERRER">COSC<br>2P89</A><BR>MCJ310</TD> <td rowspan=13></td> <td rowspan=2 align="center" bgcolor=red>LAB 2<br><a href="https://www.cosc.brocku.ca/archive/offerings/math1p12" target="_blank" rel="noopener noreferrer">MATH<br>1P12</a></td> <td rowspan=13></td> 
            </tr>
            <tr>
                <td>18:30</td>
            </tr>
            <tr>
                <td>19:00</td> <td rowspan=11></td>
            </tr>
            <tr>
                <td>19:30</td>
            </tr>
            <tr>
                <td>20:00</td> <td rowspan=9></td>
            </tr>
            <tr>
                <td>20:30</td>
            </tr>
            <tr>
                <td>21:00</td>
            </tr>
            <tr>
                <td>21:30</td>
            </tr>
            <tr>
                <td>22:00</td>
            </tr>
            <tr>
                <td>22:30</td>
            </tr>
            <tr>
                <td>23:00</td>
            </tr>
            <tr>
                <td>23:30</td>
            </tr>
            <tr>
                <td>24:00</td>
            </tr>
        </table>
    </main> <!-- #courses END -->

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

    <footer>
        <button class="smallb" onclick="delete_acc()">Delete Account</button>
    </footer>

<script>

<?php 

if (!array_key_exists('p', $_GET)) {
  echo "showMain('home');";
}
else {
  $p = $_GET['p'];

  echo "
    try {
      showMain('".$p."')
    }
    catch(err) {
      console.log(err.message); // Debug
      showMain('home');
    }; ";
}

?>

const fivechars = new RegExp(/^\w{5,}$/);

// verifies if the input field (given by the "id" parameter) is valid i.e. filled and it might abides by some other condition, depending on which field it is
// If it's not valid, it won't let the user click the button (given by the "button" parameter)
function verify(id, button) {

    var value = document.getElementById(id).value;
    
    var noticeTag = document.getElementById(id + "Notice");

    var valid; // false = there's an error in this field

    switch (id) {
        case 'user':
        case 'pass':
        case 'SUuser':
            valid = (value != "");
            break;
        case 'SUpass':
            valid = (value != "") && fivechars.test(value);
            break;
        case 'SUconfpass':
            valid = (value != "") && (document.getElementById("SUpass").value == value);
            break;
    }

    if (!valid) {
        noticeTag.hidden = false;
        return false;
    } else {
        noticeTag.hidden = true;
        return true;
    }
};

// True if at least one of the radio buttons was clicked
function radioClicked() {
    radioButtons = document.getElementsByClassName("radiobut");
    var radioValid = false;
    for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
            radioValid = true;
            break;
        }
    }
    return radioValid;
}

function tryUndisablingLogin() {
    const buttonTag = document.getElementById('loginb');
    if (verify('user', 'loginb') &&
        verify('pass', 'loginb') ) {
        buttonTag.disabled = false;
    } else { buttonTag.disabled = true; }
}

function tryUndisablingSignup() {
    const buttonTag = document.getElementById('signupb');
    if (verify('SUuser', 'signupb') &&
        verify('SUpass', 'signupb') &&
        verify('SUconfpass', 'signupb') &&
        radioClicked() ) {
        buttonTag.disabled = false;
    } else { 
        buttonTag.disabled = true; }
}

function showMsg(id, str, color) {
    document.getElementById(id).style.color = color;
    document.getElementById(id).innerHTML = str;
    document.getElementById(id).hidden = false;
}

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

function showRight(id) {
    var rightEles = document.getElementById("right").childNodes;
    for (var i = 0; i < rightEles.length; i++) {
        rightEles[i].hidden = true;
    }
    document.getElementById(id).hidden = false;
}

</script>

</body>

</html>
