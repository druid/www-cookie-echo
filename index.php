<!doctype html>
<!--
  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="et">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Cookies</title>

    <link rel="shortcut icon" href="images/favicon.png">

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.0/material.teal-red.min.css">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">
      <div class="demo-ribbon"></div>
      <main class="demo-main mdl-layout__content">
        <div class="demo-container mdl-grid">
          <div class="mdl-cell mdl-cell--2-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
          <div class="demo-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--8-col">
            <h3>Küpsised</h3>
            <p>
              Tere! Selle veebilehe külastamine on osa infoturbe aine kodutööst.
            </p>
            <p>
		      Sinu veebibrauserisse on lisatud küpsis nimega <tt>infoturbe_saladus</tt>. Antud küpsise sisuks on juhuslikult genereeritud 32 sümboli pikkune väärtus.
		      Leidke kirjeldatud küpsis ning kopeerige selle väärtus allpool olevasse vormi. Enne ülesande esitamist tuleb sisestada ka enda nimi ja matriklinumber.
		      Tulemust näete hinnete tabelist pärast kodutöö tähtaja möödumist.
            </p>
<?php
  session_start();

  // Generate randomness for this session
  if (!isset($_SESSION['secret'])) {
    $bytes = function_exists('random_bytes') ? random_bytes(16) : openssl_random_pseudo_bytes(16);
    $secret = bin2hex($bytes);
    $_SESSION['secret'] = $secret;
    setcookie('infoturbe_saladus', $secret);
  }

  // Parse submission
  if (isset($_POST['submit'])) {
    if (trim($_POST['Secret']) == $_SESSION['secret']) {
      $f = fopen('data/students.csv', 'a');
      fwrite($f, join(';', array(
        date('c'),
        $_POST['StudentID'],
        $_POST['Name']
      )) . "\n");
      fclose($f);
      $_SESSION['ok'] = true;
    } else {
      $_SESSION['submit-message'] = 'Vabandust, aga esitatud küpsise väärtus ei ole see, mis oli meie poolt loodud. Palun proovi uuesti.';
    }
  }

  if (isset($_SESSION['ok'])) {
?>
                  <div class="alert alert-success" role="alert">
                    Õige vastus!
                  </div>
<?php
  } else if (isset($_SESSION['error-message'])) {
?>
              <div class="alert alert-warning" role="alert">
                <?php echo $_SESSION['error-message']; ?>
              </div>
<?php
    unset($_SESSION['error-message']); // Delete message once shown
  } else {
    if (isset($_SESSION['submit-message'])) {
?>
              <div class="alert alert-warning" role="alert">
                <?php echo $_SESSION['submit-message']; ?>
              </div>
<?php
      unset($_SESSION['submit-message']); // Delete message once shown
    }
?>
              <form action="#" method="post">
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                      <input class="mdl-textfield__input" type="text" id="Name" name="Name">
                      <label class="mdl-textfield__label" for="Name">Täisnimi...</label>
                  </div>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                      <input class="mdl-textfield__input" type="text" id="StudentID" name="StudentID">
                      <label class="mdl-textfield__label" for="StudentID">Matriklinumber...</label>
                  </div>
                  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                      <input class="mdl-textfield__input" type="text" id="Secret" name="Secret">
                      <label class="mdl-textfield__label" for="Secret">Küpsise väärtus...</label>
                  </div>
                  <p>
                      <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name="submit">
                          Esita lahendus
                      </button>
                  </p>
              </form>
<?php
  }
?>
          </div>
        </div>
        <footer class="demo-footer mdl-mini-footer">
          <div class="mdl-mini-footer--left-section">
          Disain: Material Design Lite Google'ilt.
          </div>
        </footer>
      </main>
    </div>
    <script src="https://code.getmdl.io/1.2.0/material.min.js"></script>
  </body>
</html>
