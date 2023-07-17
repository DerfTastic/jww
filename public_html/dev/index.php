<?php
/** dev/index.php DEVELOPER PAGE TO UPLOAD CONTENT 
 * 
 * Yes I know this makes the website easily hackable
 */

error_reporting(E_ALL);
require_once("../php-code/makeDefaultPage.php");

function showFiles($path, $ol = false) {
    echo $ol ? "<ol>" : "<ul>";
    foreach (new DirectoryIterator($path) as $file) {
        if ($file->isDot()) continue;
        $filename = $file->getFilename();
        echo "<li><a href=\"".$path.($path[strlen($path)-1] == '/' ? "" : "/" ).$filename."\">".$filename."</a></li>";
    }
    echo $ol ? "</ol>" : "</ul>";
}

function showImgs($path, $ol = false) {
    echo $ol ? "<ol>" : "<ul>";
    foreach (new DirectoryIterator($path) as $file) {
        if ($file->isDot()) continue;
        $filename = $file->getFilename();
        $filepath = $path."/".$filename;
        echo "<li><a href=\"".$filepath."\">".$filename."<img height=\"100px\" alt=\" [noooo, file can't be displayed] \" src=".$filepath."></a></li>";
    }
    echo $ol ? "</ol>" : "</ul>";
}
?>

<html>
<head><style>
.box {
    padding: 10px;
    border: 2px solid black;
    margin: 5px;
}
.boxInline {
    padding: 3px;
    border: 2px solid black;
    color: black;
}
.json-display {
    border: 2px solid lightgrey;
    background-color: darkgrey;
    padding: 10px;
}
</style></head>
<body>

<h1>Upload wacky content</h1>

<h2>Input:</h2>

<div class="box" style="background-color: lightgreen;">
<form id="id-form" action="" method="post">
  Type a project id:
  <input type="text" name="id" id="id" oninput="destChange()" value="<?php if(isset($_POST['id'])) echo $_POST['id'];?>">
  <input type="submit" value="View ID Directories" name="enteredID">
</form>
</div>

<div class="box" style="background-color: pink;">
<form id="dir-form" action="" method="post">
  Type a directory to view:
  <input type="text" name="dir" id="dir" value="<?php if(isset($_POST['dir'])) echo $_POST['dir'];?>">
  <input type="submit" value="View Directory" name="enteredDir">
</form>
</div>

<div class="box" style="background-color: lightblue;">
<form id="upload-form" action="" method="post" enctype="multipart/form-data">
  <label for="fileToUpload">Select image to upload:</label>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <br><br>
  <label for="destination">Target Image Destination:</label>
  <input type="text" name="destination" id="destination" size="40" value="<?php if(isset($_POST['destination'])) echo $_POST['destination'];?>">
  <button type="button" id="proj-img-btn" onclick="putID('destination', '../images/proj-img/')">../images/proj-img<?php if(isset($_POST['id'])) echo "/<span style=\"color:green;\">".$_POST['id']."</span>";?></button>
  <button type="button" id="thumbnail-btn" onclick="putID('destination', '../images/thumbnails/', '.png')">../images/thumbnails<?php if(isset($_POST['id'])) echo "/<span style=\"color:green;\">".$_POST['id']."</span>.png"; else echo "/<span style=\"color:red;\">!default.png</span>";?></button>
  <br><br>
  <input type="submit" value="Upload Image" name="uploadedPic">
</form>
</div>

<div class="box" style="background-color: yellow;">
<form id="defaultID-form" action="" method="post">
  Convert default article to a custom, editable HTML file: <b>/proj/pages/<i style="color:green;">&lt;id&gt;</i>.html</b>
  <input type="text" name="defaultID" id="defaultID" value="<?php if(isset($_POST['defaultID'])) echo $_POST['defaultID'];?>">
  <button type="button" id="defaultID-btn" onclick="putID('defaultID')"><?php if(isset($_POST['id']) && $_POST['id'] !== "") echo "<span style=\"color:green;\">".$_POST['id']."</span>"; else echo "<span style=\"color:red;\">(no id typed)</span>";?></button>
  <br><br>
  <input type="submit" value="Convert to a custom HTML" name="convertHTML">
</form>
</div>

<div class="box" style="background-color: #BA68C8;">
<form id="json-add-form" action="" method="post">
  New entry in <a href="../proj/proj-list.json">/proj/proj-list.json</a>:<br><br>

  <label for="json-id">ID:</label>
  <input type="text" name="json-id" id="json-id" value="<?php if(isset($_POST['json-id'])) echo $_POST['json-id'];?>">
  <button type="button" id="json-btn" onclick="putID('json-id')"><?php if(isset($_POST['id']) && $_POST['id'] !== "") echo "<span style=\"color:green;\">".$_POST['id']."</span>"; else echo "<span style=\"color:red;\">(no id typed)</span>";?></button><br>

  <label for="json-name">Name:</label>
  <input type="text" name="json-name" id="json-name" value="<?php if(isset($_POST['json-name'])) echo $_POST['json-name'];?>"><br>

  Date:
  <label for="json-date-year">Year:</label>
  <input type="number" name="json-date-year" id="json-date-year" max="<?php echo getdate()['year']; ?>" step="1" size="5" value="<?php if(isset($_POST['json-date-year'])) echo $_POST['json-date-year']; else echo 2023;?>">

  <label for="json-date-period">Period:</label>
  <select name="json-date-period" id="json-date-period">
    <option value="1">1. Last semester of school year <b>(January - April)</b></option>
    <option value="2">2. Summer <b>(Late April - End of August)</b></option>
    <option value="3">3. First semester of school year <b>(September - December)</b></option>
  </select>
  <br>

  <label for="json-cat">Category:</label>
  <select name="json-cat" id="json-cat">
    <option onclick="showOther()" >electronics</option>
    <option onclick="showOther()" >game</option>
    <option onclick="showOther()" >programming</option>
    <option onclick="showOther()" >school</option>
    <option onclick="showOther()" >science</option>
    <option onclick="showOther()" >other</option>
  </select>
  <input type="text" name="other-field" id="other-field" placeholder="Specify..." hidden>
  <br>

  <label for="json-desc">Description:</label>
  <textarea name="json-desc" id="json-desc" rows="2" cols="80" maxlength="150" placeholder="I built/made/programmed..." value="<?php if(isset($_POST['json-desc'])) echo $_POST['json-desc']; else echo "";?>"></textarea>

  <br><br>
  <input type="submit" value="Add entry to JSON file" name="jsonAdded">
</form>
</div>

<script>
function destChange() {
    var idname = document.getElementById("id").value;
    if (idname === "") {
        document.getElementById("json-btn").innerHTML = "<span style=\"color:red;\">(no id typed)</span>";
        document.getElementById("defaultID-btn").innerHTML = "<span style=\"color:red;\">(no id typed)</span>";
        document.getElementById("thumbnail-btn").innerHTML = "../images/thumbnails/<span style=\"color:red;\">!default.png</span>";
        document.getElementById("proj-img-btn").innerHTML = "../images/proj-img";
    }
    else {
        document.getElementById("json-btn").innerHTML = "<span style=\"color:green;\">" + idname + "</span>";
        document.getElementById("defaultID-btn").innerHTML = "<span style=\"color:green;\">" + idname + "</span>";
        document.getElementById("thumbnail-btn").innerHTML = "../images/thumbnails/<span style=\"color:green;\">" + idname + "</span>.png";
        document.getElementById("proj-img-btn").innerHTML = "../images/proj-img/<span style=\"color:green;\">" + idname + "</span>";
    }
}

function putID(putLocation, prefix = "", suffix = "") {
    var id = document.getElementById("id").value;
    document.getElementById(putLocation).value = prefix + (id === "" ? (putLocation === "thumbnail-btn" ? "!default.png" : "") : id + suffix);
}

function showOther() {
    var picked = document.getElementById("json-cat").value;
    if (picked === "Other") {
        document.getElementById("other-field").hidden = false;
    }
    else {
        document.getElementById("other-field").hidden = true;
    }
}
</script>

<?php

echo "<h2>Output:</h2>";

echo "<b style=\"color:purple;\">\$_POST:  </b>";
var_dump($_POST);
echo "<br>";

echo "<div class=\"box\" style=\"background-color: orange;\">";
 

if (isset($_POST["enteredDir"]))
{
    if (isset($_POST["dir"]) && $_POST["dir"] !== "")
    {
        echo "<h3>What already exists in \"".$_POST["dir"]."\":</h3>";
        showFiles($_POST["dir"]);
    }
    else {
        echo "<p>ok, well you have type a directory at least.</p>";
    }

}
else if (isset($_POST["enteredID"]))
{
    if (isset($_POST["id"]) && $_POST["id"] !== "")
    {

        echo "<h3>/images/proj-img/<span style=\"color:blue\">".$_POST["id"]."</span>:</h3>";
        $imgpath = "../images/proj-img/".$_POST["id"];
        $projimgExists = file_exists($imgpath);
        if ($projimgExists) {
            showFiles($imgpath, true);
            echo "<p style=\"color:green;\">It does exist here!</p>";
        }
        else {
            echo "<p style=\"color:red;\">Doesn't exist!</p>";
        }
        echo "<h3>/images/thumbnails/<span style=\"color:blue\">".$_POST["id"]."</span>.png:</h3>";
        $thumbpath = "../images/thumbnails/".$_POST["id"].".png";
        $thumbExists = file_exists($thumbpath);
        if ($thumbExists)
        {
            showFiles($thumbpath, true);
            echo "<p style=\"color:green;\">It does exist here!</p>";
        }
        else {
            echo "<p style=\"color:red;\">Doesn't exist!</p>";
        }
        if (!$projimgExists || !$thumbExists) 
            echo "<p style=\"color:red;\">Use the <span class=\"boxInline\" style=\"background-color: lightblue;\">Blue</span> box to upload some images! (It also creates a new image directory if there isn't one right now)</p>";


        echo "<h3><a href=\"/proj/proj-list.json\">/proj/proj-list.json</a> ---> [\"<span style=\"color:blue;\">".$_POST["id"]."</span>\"]:</h3>";
        $plfile = fopen("../proj/proj-list.json", "r") or die("Unable to open the list of projects... ask YOURSELF how he broke the site this time");
        $json = fread($plfile, filesize("../proj/proj-list.json"));
        $pl = json_decode($json, true);
        if (array_key_exists($_POST["id"], $pl))
        {
            $obj = $pl[$_POST["id"]];
            echo json_encode($obj);
            echo "<p style=\"color:green;\">It does exist here!</p>";
        }
            echo "<p style=\"color:red;\">Doesn't exist! <br><br>Use the <span class=\"boxInline\" style=\"background-color: #BA68C8;\">Purple</span> box to add a new entry to /proj/proj-list.json</p>";


        echo "<h3>/proj/pages/<span style=\"color:blue;\">".$_POST["id"].".html</span></h3>";
        showFiles("../proj/pages/");

        $pagePath = "../proj/pages/".$_POST["id"].".html";

        echo "<p><u><b>Its contents:</b></u> <span style=\"color:red;\">(There will be a corresponding warning if it's empty or invalid syntax in the file)</span></p>";
        $dummydoc = new DOMDocument();
        $status = $dummydoc->loadHTMLFile($pagePath);
        echo "<code>".htmlspecialchars($dummydoc->saveHTML(), 0)."</code>";

        if (file_exists($pagePath)) 
        {
            echo "<p style=\"color:green;\">It does exist here!</p>";
        }
        else 
        {
            echo "<p style=\"color:red;\">Doesn't exist! <br><br>Use the <span class=\"boxInline\" style=\"background-color: yellow;\">Yellow</span> box to create a base for a custom HTML file</p>";
        }
    }
    else {
        echo "<p>ok, well you have type an id name at least.</p>";
    }
}
else if (isset($_POST["uploadedPic"])) 
{

if (isset($_POST["destination"]))
{
    $target_dir = $_POST["destination"];

    // New directories are only created for proj-img images since each id of images has its own folder
    if (str_starts_with($target_dir, '../images/proj-img/') && !file_exists($target_dir))
        mkdir($target_dir);

    $target_file = $target_dir."/".basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // print($imageFileType."<br>");

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if ($check !== false) 
    {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } 
    else 
    {
        echo "<br>File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "<br>Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
      echo "<br>Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "<br>Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "<br>Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<br>The file \"". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). "\" has been uploaded.";

      } else {
        echo "<br>Sorry, there was an error uploading your file.";
      }
    }

    echo "<h3>".$target_dir.":</h3>";
    showImgs($target_dir, true);
}
else {
    echo "<p>ok, well you have to at least put an image destination.</p>";
}

}
else if (isset($_POST["convertHTML"]))
{
    if (isset($_POST["defaultID"]))
    {
        $defaultID = $_POST["defaultID"];
        $defaultPath = "../proj/pages/".$defaultID.".html";

        // If user clicked "Delete and overwrite" button when prompted
        if ($_POST["convertHTML"] == "overwrite")
        {
            $canonPath = realpath($defaultPath);
            if (is_writable($canonPath))
                unlink($canonPath) or die("ok wtf, deleting didn't work");
        }

        if (!file_exists($defaultPath))
        {
            // Make a new file and write a default HTML code string to it
            $convdHTMLfile = fopen($defaultPath, "w") or die("bruh, we can't open the file");
            $defaultsrc = makeDefaultPage($defaultID)->saveHTML();
            fwrite($convdHTMLfile, $defaultsrc);
            fclose($convdHTMLfile);

            // Show that a new file was in fact created
            echo "<h3>/proj/pages/<span style=\"color:blue;\">".$defaultID.".html</span></h3>";
            showFiles("../proj/pages");
            if (file_exists($defaultPath)) 
            {
                echo "<p style=\"color:green;\">File was created! Look above!</p>";
            }
            else 
            {
                echo "<p style=\"color:red;\">File wasn't created somehow...</p>";
            }
        }
        else 
        {
            echo "<p>That file already exists lol</p>";
            echo "<p><u><b>Its contents:</b></u> <span style=\"color:red;\">(There will be a warning if it's empty)</span></p>";
            $dummydoc = new DOMDocument();
            $status = $dummydoc->loadHTMLFile($defaultPath);
            echo "<pre>".$dummydoc->saveHTML()."</pre>";
            echo <<<FORM
            <form id="id-form" action="" method="post">
              <input type="hidden" name="defaultID" value="$defaultID">
              <button type="submit" value="overwrite" name="convertHTML"> <span style="color:red;"> Delete and overwrite existing content with a default HTML page of </span><span style="color:blue;">$defaultPath</span> </button>
            </form>
            FORM;
        }
    }
    else
        echo "<p>ok, well you have to at least specify which default's ID you want to convert.</p>";
}
else if (isset($_POST['jsonAdded']))
{
    $missingKey = checkPOST('json-id', 'json-name', 'json-date-year', 'json-date-period', 'json-cat', 'json-desc');

    if ($missingKey !== false) {
        $namename = substr($missingKey, 5); // It's the name of the name tho
        echo "<p>ok, well you have to at least put the <b><span style=\"color: #8B0000;\">".$namename."</span></b> if you're gonna add to the json.</p>";
    }
    else {
        addJson();
    }
}

function addJson() {

    $json = file_get_contents('../proj/proj-list.json') or die("Unable to project list file...");
    $pl = json_decode($json, true) or die("Unable to decode project list json...");

    // Sanitize date
    $date = $_POST['json-date-year'].'.'.$_POST['json-date-period'];

    // Sanitize category
    $category = $_POST['json-cat'];
    if ($category === "other") 
    {
        if (isset($_POST['other-field'])) 
        {
            $category = strtolower($_POST['other-field']);
        }
    }

    // Make new associative array entry
    $newEntry = [
        "Name"     =>  $_POST['json-name'],
        "Date"     =>  $date,
        "Category" =>  $category,
        "Desc"     =>  $_POST['json-desc']
    ];

    // Add new object to json
    $pl[$_POST['json-id']] = $newEntry;

    $updatedJsonStr = json_encode($pl, JSON_PRETTY_PRINT) or die("Unable to encode new project list json...");
    file_put_contents('../proj/proj-list.json', $updatedJsonStr);

    echo "Success! \nEntered the follow data into the json database:";
    var_dump($pl[$_POST['json-id']]);
    echo "<br><br>";

    echo "<p><a href=\"../proj/proj-list.json\" target=\"_blank\">/proj/proj-list.json</a>:</p>";

    echo "<pre class=\"json-display\">";
    echo $updatedJsonStr;
    echo "</pre>";
}

function checkPOST() {
    $keys = func_get_args();

    foreach ($keys as $key) {
        if (!isset($_POST[$key]) || empty($_POST[$key])) {
            return $key;
        }
    }

    return false;
}

echo "</div>";
?>

</body>
</html>
