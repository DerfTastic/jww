<?php
/** makeDefaultPage.php
 *  Designed to be include in another php code file with 
 *      `require_once("/php-code/makeDefaultPage.php");` 
 */

error_reporting(E_ERROR|E_PARSE);

// HEADER 
$headersrc = <<<HEADERSRC
<header> 
<table> 
<tr> <td colspan = 5 ><img id="banner" src="/images/top-banner.jpg" alt="top banner with jacob"></td> </tr> 
<form method="get" action="/"> 
<tr id="nav"> 
<td> <button type="submit" name="p" value="home"> <b>HOME</b> </button> </td> 
<td> <button type="submit" name="p" value="projects"> <b>PROJECTS</b> </button> </td> 
<td> <button type="submit" name="p" value="videos"> <b>VIDEOS</b> </button> </td> 
<td> <button type="submit" name="p" value="about-me"> <b>ABOUT ME</b> </button> </td> 
<td> <button type="submit" name="p" value="resume"> <b>RESUME</b> </button> </td> 
</tr>
</form> 
</table>
</header>
HEADERSRC;

/** A function to create an default HTML document for a given project ID
 * @returns A DOMDocument object that is the created HTML document
 */
function makeDefaultPage($get_id) {

    global $headersrc; // Requires a string in this file that is the HTML code for the jww header

    // TOP HALF   (if custom page is not found)
    $top = <<<TOP
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="/proj/proj.css" type="text/css"/>
    </head>
    <body>
    $headersrc
    <main id="$get_id">
    TOP;

    $plfile = fopen("../proj/proj-list.json", "r") or die("Unable to open the list of projects... ask jakey how he broke the site this time");
    $json = fread($plfile, filesize("../proj/proj-list.json"));
    $pl = json_decode($json, true);
    $obj = $pl[$get_id];

    // INFO OF ARTICLE
    $info = "<h1>".   $obj["Name"]."</h1>" .
            "<h3><i>".$obj["Date"]."</i></h3>" .
            "<p>".    $obj["Desc"]."</p>";


    // IMAGES ON ARTICLE
    $images = "";

    $HTML_imgfolder = "/images/proj-img/".$get_id; // Is the string actually put in the html file
    $PHP_imgfolder = "../images/proj-img/".$get_id; // Will actually reference this path relative to this file (php-code/makeDefaultHTML.php)
    // The reason I've done this (above) is because if you haven't noticed with the other files in this repo, I HAVE NO IDEA HOW TO DO ABSOLUTE PUBLIC_HTML PATHS IN PHP. Like I know how to get an absolute path, but it gets the root folder of the computer the code is actually running on, not the public_html folder. PLEASE HELP ME IF YOU KNOW.

    if (file_exists($PHP_imgfolder)) { // If a project image folder actually exists

        foreach (new DirectoryIterator($PHP_imgfolder) as $file) {
            if ($file->isDot()) continue;
            $filename = $file->getFilename();
            $images .= "<img width=\"400px\" src=\"".$HTML_imgfolder."/".$filename."\" alt=\"".$filename."\">\n";
        }

    }
    else {
        $images .= "<img src=\"/images/thumbnails/".$get_id.".png\"><br>" . 
        "<p>Uh oh... jakey hasn't added any more content here...</p>" . 
        "<p>I guess you were expecting more content than what was on the list of projects, huh.</p>" . 
        "<p>Don't fret, if you're curious about this project, just ask jakey himself!</p>";
    }


    // BOTTOM HALF
    $bottom = <<<BOTTOM
    </main>
    </body>
    </html>
    BOTTOM;

    $outputdoc = new DOMDocument();
    $fullPage = implode("\n", array($top, $info, $images, $bottom));
    // echo htmlspecialchars($fullPage, 0); // debug
    $outputdoc->loadHTML($fullPage);
    return $outputdoc;

}
