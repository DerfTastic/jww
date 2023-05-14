<!DOCTYPE html>
<html>
<body>
<p>
<?php

if (!array_key_exists('id', $_GET)) {
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
</p>
</body>
</html>
