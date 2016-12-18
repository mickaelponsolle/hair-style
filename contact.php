<div id="page_contact">
  <div class="texte_contact">
    Si vous désirez en savoir plus, vous pouvez me contacter soit par téléphone soit grâce au formulaire suivant.
  </div>
  
  <div class="formulaire">
    <form method="post" action="index.php?page=contact">        
      <table>
        <tr>
          <td class="champs_contact">Nom :</td>
          <td><input name="nom"/></td>
        </tr>
        <tr>
          <td class="champs_contact">Prénom :</td>
          <td><input name="prenom"/></td>
        </tr>
        <tr>
          <td class="champs_contact">Numéro de téléphone :</td>
          <td><input name="noTel"/></td>
        </tr>
        <tr>
          <td class="champs_contact">Votre adresse email :</td>
          <td><input class="email" name="email"/></td>
        </tr>
        <tr>
          <td class="champs_contact">Sujet :</td>
          <td><input class="sujet" name="sujet"/></td>
        </tr>
        <tr>
          <td class="champs_contact">Message :</td>
          <td><textarea name="message" rows="8"></textarea></td>
        </tr>
      </table>
      <input type="submit" value="Envoyer"class="boutonEnvoyer" />
    </form>
  
  <?php
  
    // --------------- Etape 1 -----------------
    // On envoie le mail
    // -----------------------------------------
    if ((isset($_POST['nom']) OR isset($_POST['prenom'])) AND (isset($_POST['message']) OR isset($_POST['sujet']))) {
    
        $nom = htmlspecialchars($_POST['nom']); // On utilise mysql_real_escape_string et htmlspecialchars par mesure de sécurité
        $prenom = htmlspecialchars($_POST['prenom']);
        $noTel = htmlspecialchars($_POST['noTel']);
        $email = htmlspecialchars($_POST['email']);
        $sujet = htmlspecialchars($_POST['sujet']);
        //$message = mysql_real_escape_string(htmlspecialchars($_POST['message'])); // De même pour le message
        $message = '<html><head><title>Titre</title></head><body>';
        $message .= 'Nom : '.$nom.'<br/>';
        $message .= 'Prénom : '.$prenom.'<br/>';
        $noTelToCall = str_replace(' ','',$noTel);
        if (strpos($noTelToCall, "0") == 0) {
            $noTelToCall = str_replace('0','+33',$noTelToCall);    
        }
        $message .= 'Numéro de téléphone : '.$noTel.'       <a href=tel:'.$noTelToCall.'>Appeller</a><br/>';
        $message .= 'Adresse email : '.$email.'<br/>';
        $message .= 'Sujet : '.$sujet.'<br/><br/>';
        
        // Conversion des retours chariot
        $order   = array("\r\n", "\n", "\r");
        $replace = '<br />';
        $newstr = str_replace($order, $replace, htmlspecialchars($_POST['message']));
        $message .= $newstr; // De même pour le message
        
        $message .= '</body></html>';
        
        require_once("util_mail.php");
        
        // Envoi du mail
        envoi_mail2($email, stripslashes($sujet), stripslashes($message));
    }
  ?>   
  </div>
  
</div>
