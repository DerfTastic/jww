<?php
// error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);

// var_dump($_POST);
// var_dump($_GET);

if (array_key_exists('id', $_GET)) {
    $get_id = $_GET['id'];
    $doc = new DOMDocument();
    $filepath = "pages/".$get_id.".html";

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

    if (file_exists($filepath)) {
        try {
            if (!$doc->loadHTMLFile($filepath)) {
                redirect();
            }
            if (isset($_POST["fromsite"])) {

                $docsrc = $doc->saveHTML();

                $docsrc = str_replace("<!-- header -->", $headersrc, $docsrc);

                $doc->loadHTML($docsrc);

            // PLEASE PLEASE PLEASE PLEASE
            // PLEASE NEVER USE DOM LIBRARY IN PHP EVERRR AGAIN
            // IT IS SO FRUSTRATING AND TOO MANY CALLS PLEEEEEESE
            /* SOME HORROR CONTENT (BELOW):
                // Get body DOMElement
                $body = $doc->getElementsByTagName("body")->item(0);
                // print(gettype($body));
                // Load combineddoc with .html file first
                $combineddoc->loadHTML($doc->saveHTML());
                // $combineddoc->importNode($headerele, true);
            // WTF "WRONG DOCUMENT ERROR" AAAAAAHHH
                // echo "<p>Header type: ".gettype($header)."<p>";
            // (blood stains and cries from hell ensue)
                // $combineddoc->documentElement->appendChild($headerele); */

            }
            echo $doc->saveHTML();
        }
        catch (Exception $e) {
            redirect($e);
        }
    }
    else {

        // DEFAULT ARTICLE PAGE TOP HALF   (if not custom page is found)
        echo <<<MSG
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" href="/proj/proj.css" type="text/css"/>
        </head>
        <body>
        $headersrc
        <main id="$get_id">
        MSG;

        $plfile = fopen("proj-list.json", "r") or die("Unable to open the list of projects... ask jakey how he broke the site this time");
        $json = fread($plfile, filesize("proj-list.json"));
        $pl = json_decode($json, true);
        $obj = $pl[$get_id];

        echo "<h1>".$obj["Name"]."</h1>";
        echo "<h3><i>".$obj["Date"]."</i></h3>";
        echo "<p>".$obj["Desc"]."</p>";

        $imgfolder = "../images/proj-img/".$get_id;

        if (file_exists($imgfolder)) { // If a project image folder actually exists

            foreach (new DirectoryIterator($imgfolder) as $file) {
                if ($file->isDot()) continue;
                $filename = $file->getFilename();
                echo "<img width=\"400px\" src=\"".$imgfolder."/".$filename."\" alt=\"".$filename."\"><br>";
            }

        }
        else {
            echo "<img src=\"/images/thumbnails/".$get_id.".png\"><br>";
            echo "<p>Uh oh... jakey hasn't added any more content here...</p>";
            echo "<p>I guess you were expecting more content than what was on the list of projects, huh.</p>";
            echo "<p>Don't fret, if you're curious about this project, just ask jakey himself!</p>";

        }



        // DEFAULT ARTICLE PAGE BOTTOM HALF
        echo <<<MSG
        </main>
        </body>
        </html>
        MSG;

    }
}
else {
    redirect();
}


function redirect($errmsg = null) {
    $msg = null;
    if ($errmsg != null) {
        $msg = <<<ERROR
        <h2 style="color: red;">ERROR! (tell jakey about this)</h2>
        <p style="color:red;">$errmsg</p>
        ERROR;
    }
    else {
        $msg = <<<NOTFOUND
            <h2>Either this project page was deleted or it never existed to begin with</h2>
            <p>Or there was no "id" GET tag in the URL or there was an error that jakey needs to fix... (tell him!!!!11!1)</p>
        NOTFOUND;
    }

    // ERROR / DOESN'T EXIST PAGE   ( redirects to main project page )
    echo <<<MSG
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="refresh" content="8; url='/?p=projects'" />
    </head>
    <body>
        $msg
        <h2>Redirecting to main projects page in 8 seconds...</h2>
    </body>
    </html>
    MSG;

    exit(0);

}

?>
