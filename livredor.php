
<div id="page_livredor">
  <!--
  <p class="texte_contact">N'hésitez pas à laisser un message !</p>
  -->
  <div id="form_livredor">
    
    <script type="text/javascript">
      function afficheSaisieCommentaire(){
        zone = document.getElementById("blockAjoutCommentaire");
        btnAjout = document.getElementById("btnAjoutCommentaire");
        
        if (zone.style) {
          if (zone.style.display == 'none') {
            Effect.SlideDown(zone); 
            btnAjout.value = 'Cacher la zone de saisie de commentaire';
          } else {
            Effect.SlideUp(zone); 
            btnAjout.value = 'Ajouter un commentaire';
          }
        }
        
        return false;
      }
	  </script>
    
    <input id="btnAjoutCommentaire" type="submit" value="Ajouter un commentaire" onclick="afficheSaisieCommentaire()" />
    <div id="blockAjoutCommentaire" style="display:none;">
      <fieldset id="fieldsetAjoutCommentaire">
        <legend class="fsetLegend_livredor"><strong>Ajouter votre commentaire</strong></legend>
        <form method="post" action="index.php?page=livredor">        
          <table class="tableAjoutCommentaire">
            <tr>
              <td>
                <p class="champs_livredor">Nom :    </p>
              </td>
              <td>
                <input name="nom"/>
              </td>
              <td>
              </td>
              <td rowspan="7">
                <p class="champs_livredor">Message : </p><br />
                <textarea name="message" rows="8" cols="100"></textarea><br />
              </td>
            <tr>
            <tr>
              <td>
                <p class="champs_livredor">E-mail : </p>
              </td>
              <td>
                <input name="email"/>
              </td>
              <td>
              </td>
              <td>
              </td>
            <tr>
            <tr>
              <td colspan="2">
                <?php dsp_crypt(2,'Réactualiser'); ?>                                
              </td>
              <td>
              </td>
              <td>
              </td>
              <td>
              </td>
            <tr>  
            <tr>
              <td colspan="2">
                <p class="champs_livredor">Recopier le code:</p>
                <input type="text" name="codeCaptcha">
              </td>
              <td>           
              </td>
              <td>
              </td>
              <td>
              </td>
            <tr>            
          </table>          
          <p id="envoyerCommentaire"><input  type="submit" value="Envoyer" /></p>          
        </form>
        
      </fieldset>
    </div>
  </div>  
  <br/>
  <div id="livredor">
  <?php
    // Analyse des paramètres de la base de donnée
    $ini_array = parse_ini_file("config.ini", TRUE);

    // Connexion à la base de donnée
    mysql_connect($ini_array["bdd"]["hote"], $ini_array["bdd"]["utilisateur"], $ini_array["bdd"]["motdepasse"]) or die("Impossible de se connecter : ".mysql_error());    
    $link = mysql_select_db($ini_array["bdd"]["basededonnee"]);
    if (!$link) {
      die('Impossible de se connecter : ' . mysql_error());
    }
    
    
    // On vérifie que le code passé dans le captcha est correct  
    if (isset($_POST['codeCaptcha']) AND chk_crypt($_POST['codeCaptcha']))  {
      // --------------- Etape 1 -----------------
      // Si un message est envoyé, on l'enregistre
      // -----------------------------------------
      if (isset($_POST['nom']) AND isset($_POST['email']) AND isset($_POST['message'])) {
        // On utilise mysql_real_escape_string et htmlspecialchars par mesure de sécurité
        $nom = mysql_real_escape_string(htmlspecialchars($_POST['nom'])); 
        $email = mysql_real_escape_string(htmlspecialchars($_POST['email'])); // De même pour l'e-mail
        $message = mysql_real_escape_string(htmlspecialchars($_POST['message'])); // De même pour le message
        
        if ((trim($nom) != '') && (trim($message) != '') && (substr_count($message, 'http') == 0)) {
          // On peut enregistrer
          $result = mysql_query("insert into LIVRE_D_OR (LDO_NOM, LDO_MAIL, LDO_MESSAGE) values('$nom', '$email', '$message')");          
          if (!$result) {
              die('Requête invalide : ' . mysql_error());
          } else {
          
            // --------------- Etape -----------------
            // Envoi d'un mail 
            // ---------------------------------------
            $corpsMail = '<html><head><title>Titre</title></head><body>';
            $corpsMail .= 'Nom : '.htmlspecialchars($_POST['nom']).'<br/>';
            $corpsMail .= 'Adresse email : '.htmlspecialchars($_POST['email']).'<br/>';
            
            // Conversion des retours chariot
            $order   = array("\r\n", "\n", "\r");
            $replace = '<br />';
            $newstr = str_replace($order, $replace, htmlspecialchars($_POST['message']));
            $corpsMail .= '<br/>'; 
            $corpsMail .= $newstr; 
            
            $corpsMail .= '</body></html>';
            
            require_once("util_mail.php");
            
            // Envoi du mail
            envoi_mail2(htmlspecialchars($_POST['email']), "Message dans Livre d'or", stripslashes($corpsMail));
          
          }
        }   
      }
    } else {
      if (isset($_POST['codeCaptcha'])) {
        echo '<p id="texte_error">Votre saisie est incorrecte</p>';
      }
    }
    
    
     
    // --------------- Etape 2 -----------------
    // On écrit les liens vers chacune des pages
    // -----------------------------------------
    // On met dans une variable le nombre de messages qu'on veut par page
    $nombreDeMessagesParPage = 8; 
    // On récupère le nombre total de messages
    $retour = mysql_query('select count(*) as NB_MESSAGES from LIVRE_D_OR');
    $donnees = mysql_fetch_array($retour);
    $totalDesMessages = $donnees['NB_MESSAGES'];
    // On calcule le nombre de pages à créer
    $nombreDePages  = ceil($totalDesMessages / $nombreDeMessagesParPage);
    ?>
     
    
     
    <?php
     
     
    // --------------- Etape 3 ---------------
    // Maintenant, on va afficher les messages
    // ---------------------------------------
     
    if (isset($_GET['index'])) {
      $page = $_GET['index']; 
    }
    else {
      $page = 1; // On se met sur la page 1 (par défaut)
    }
     
    // On calcule le numéro du premier message qu'on prend pour le LIMIT de MySQL
    $premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;
    
    // Récupération des messages dans la base de donénes
    $reponse = mysql_query('select * from LIVRE_D_OR order by LDO_ID desc limit ' . $premierMessageAafficher . ', ' . $nombreDeMessagesParPage);
    
    // Nombre de messages récupérés
    $nb_messages = mysql_num_rows($reponse);
    
    // Parcours des messages lus en base
    while ($donnees = mysql_fetch_array($reponse)) {
        echo '<div class="bloc_message_livredor">
                  <p class="nom_livredor">'.stripslashes($donnees['LDO_NOM']).'</p>
                  <p class="message_livredor">'.stripslashes(nl2br($donnees['LDO_MESSAGE'])) . '</p>
              </div>';
        
        /*    echo '<table class="table_message_livredor">
                    <tr>
                      <td class="table_message_haut_gauche"><img src="./images/coins/hautgauche.png"></td>
                      <td class="table_message_haut"></td>
                      <td class="table_message_haut_droit"><img src="./images/coins/hautdroit.png"></td>
                    </tr>
                    <tr>
                      <td class="table_message_gauche"></td>
                      <td class="table_message_center">
                        <p class="nom_livredor">'.stripslashes($donnees['LDO_NOM']).'</p>
                        <p class="message_livredor">'.stripslashes(nl2br($donnees['LDO_MESSAGE'])) . '</p>
                      </td>
                      <td class="table_message_droit"></td>
                    </tr>
                    <tr>
                      <td class="table_message_bas_gauche"><img src="./images/coins/basgauche.png"></td>
                      <td class="table_message_bas"></td>
                      <td class="table_message_bas_droit"><img src="./images/coins/basdroit.png"></td>
                    </tr>
                  </table>';*/
            
    }
    
    
    // On affiche les pages si il y en a plusieurs 
    if($nombreDePages > 1) {
      echo '<p class="page_livredor">Page : ';
      for ($i = 1 ; $i <= $nombreDePages ; $i++) {
        if ($page == $i) {
          echo '<a href="index.php?page=livredor&index=' . $i . '"><strong>' . $i . '</strong>  </a>';
        } else {
          echo '<a href="index.php?page=livredor&index=' . $i . '">' . $i . '  </a> ';
        }
      }
      echo '</p>';        
    }
    
    // On n'oublie pas de fermer la connexion à MySQL
    mysql_close(); 
    
    ?>
     
  </div>
  
   
</div>
