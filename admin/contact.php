<h2>Kontakt</h2>
<?php
if (!isset($_SESSION['login'])) {
    echo '
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="">
                <button id="pass-remind" class="btn btn-primary" type="submit" name="password-remind">test</button>
        </form>
        ';
}

function PokazKontakt()
{
    echo '
            <form method="post" name="contact-form" enctype="multipart/form-data" action="">
            <label for="email">
                <h2>Adres e-mail:</h2>
            </label>
            <input class="form-control" type="email" name="email" /><br />
        
            <label for="subject">
                <h2>Temat:</h2>
            </label>
            <input class="form-control" type="text" name="subject" /><br />
        
            <label for="message">
                <h2>Wiadomość:</h2>
            </label>
            <textarea class="form-control" name="message" style="height: 200px; width: 100%;"></textarea>
            <button class="btn btn-primary" type="submit">Wyślij</button>
            <button class="btn btn-primary" type="reset">Resetuj</button>
            </form>
        ';
}

function PrzypomnijHaslo()
{
    echo '
        <script type="text/javascript">
            window.alert("Wiadomość Zawierająca hasło do panelu panel została wysłana na e-mail administratora")
        </script>
        ';
}

function WyslijMailKontakt($odbiorca)
{
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie wypełniono formularza]';
        echo PokazKontakt();
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipient'] = $odbiorca;

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 7bit \n";
        $header .= "X-Sender: <" . $mail['sender'] . ">\n";
        $header .= "X-Mailer: PRapWWW mail 1.2\n";
        $header .= "X-Priotity: 3\n";
        $header .= "Return-Path: <" . $mail['sender'] . ">\n";

        mail($mail['recipient'], $mail['subject'], $mail['body'], $header);
    }
}

PokazKontakt();

if (isset($_POST['email-submit'])) {
    WyslijMailKontakt('155231@student.uwm.edu.pl');
}
if (isset($_POST['password-remind'])) {
    PrzypomnijHaslo();
}

?>