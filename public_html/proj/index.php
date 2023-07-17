<?php
error_reporting(E_ERROR | E_PARSE);

require_once("../php-code/makeDefaultPage.php");

// var_dump($_POST);
// var_dump($_GET);

if (array_key_exists('id', $_GET)) {
    $get_id = $_GET['id'];
    $doc = new DOMDocument();
    $filepath = "pages/".$get_id.".html";

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
        echo makeDefaultPage($get_id)->saveHTML();
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
