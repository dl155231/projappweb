<h1>Kontakt</h1>
<?php


function ShowContactForm()
{
    echo '<form method="post" name="contact-form" enctype="multipart/form-data" action="">

            <label for="id_email">
                <h2>Adres e-mail:</h2>
            </label>
            <input class="form-control" id="id_email" type="email" name="email" /><br />
        
            <label for="id_subject">
                <h2>Temat:</h2>
            </label>
            <input class="form-control" id="id_subject" type="text" name="subject" /><br />
        
            <label for="id_message">
                <h2>Wiadomość:</h2>
            </label>
            <textarea class="form-control" id="id_message" name="message" style="height: 200px; width: 100%;"></textarea>
            
            <button class="btn btn-primary" type="submit" name="email-submit" >Wyślij</button>
            <button class="btn btn-primary" type="reset">Resetuj</button>
            </form>';
}

function SendContactEmail($odbiorca)
{
    if (empty($_POST['subject']) || empty($_POST['message']) || empty($_POST['email'])) {
        echo 'Wszystkie pola formularza są obowiązkowe.';
    } else {
        $mail['subject'] = $_POST['subject'];
        $mail['body'] = $_POST['message'];
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

ShowContactForm();

if (isset($_POST['email-submit'])) {
    SendContactEmail('155231@student.uwm.edu.pl');
}

?>