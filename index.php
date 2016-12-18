<?php
  session_start(); // On demarre la session AVANT toute chose
?>

<?php 
 $cryptinstall="./tools/crypt/cryptographp.fct.php";
 include $cryptinstall;  
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
    <head>
        <title>
            Hair Style - Coiffure à domicile
        <?php 
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                if ($page == 'zone') echo '- Mobilité';
                if ($page == 'tarifs') echo '- Tarifs';
                if ($page == 'produits') echo '- Produits';
                if ($page == 'partenaires') echo '- Partenaires';
                if ($page == 'livredor') echo '- Livre d\'or';
                if ($page == 'contact') echo '- Contact';
            }
        ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta content="fr" name="language"/>
        <meta lang="fr" content="Hair Style, Hair Style Coiffure à domicile, Coiffure a domicile, Coiffeuse, Coiffeur, Mariage, Gironde, Bordeaux, Aquitaine, Emilie" name="keywords"/>
        <meta lang="fr" content="Coiffure à domicile" name="description"/>
        <meta content="Hair Style - Coiffure à domicile" name="author"/>
        <meta content="Hair Style - Coiffure à domicile" name="creator"/>
        <meta content="Hair Style - Coiffure à domicile" name="DC.title"/>
        <meta content="Hair Style - Coiffure à domicile" name="DC.creator"/>
        <meta content="Copyright Hair Style. All rights reserved." name="DC.rights"/>

        <link rel="stylesheet" media="screen" type="text/css" title="CoiffureStyle" href="css/coiffure.css" />
        <link href="images/logo/logo-mini.jpg" rel="shortcut icon"/>
        
        <script type="text/javascript">
            function PreSelectMenu(element){
            element.style.backgroundImage = "url('./images/fond-menu-selectionne.jpg')";
            }

            function DeselectMenu(element){
            element.style.backgroundImage = "url('./images/fond-menu.jpg')";
            }

            
        </script>

        <?php  
        // On inclut les librairies Scriptaculous et prototype uniquement quand on en a besoin 
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'livredor' || $page == 'produits') {
                include 'includes_scriptaculous.php';
            }
        }
          

        // On inclut le script du carousel uniquement quand on est sur la page d'acceuil
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if (($page != 'accueil') && ($page != 'zone') && ($page != 'tarifs') && ($page != 'produits') && ($page != 'partenaires') 
                  && ($page != 'contact') && ($page != 'livredor') && ($page != 'messageNonEnvoye') && ($page != 'messageEnvoye')) {
                include 'carousel.php';
            }
        }
        else {
            include 'carousel.php';
        } 
        ?> 
    </head>
  
    <body id="body_plan">
        <div id="section_principale">    
            <div id="haut">
                <table id="table_haut">
                    <tr>
                        <td>
                            <div id="reference_gauche">
                                <img id="logo" src="images/logo/logo2-site.png" alt="diplôme d'état, brevet professionnel"></img>            
                            </div>			
                        </td>       
                        <td>
                            <h1><img id="titre" src="images/logo/titre.png" alt="Hair Style"></img></h1>
                        </td>
                        <td>
                            <div id="reference_droite">
                                <h2>
                                    Coiffure à domicile              
                                </h2>
                                <div>
                                    <a id="telephone" href="tel:+33619146188">06 19 14 61 88</a>       
                                </div>
                            </div>
                        </td>
                    </tr>       
                </table>      
            </div>

            <div id="menu">
                <table>
                    <tr>
                        <td class="cellule_menu" onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php" class="texte_menu" >
                                <span>Accueil</span>            
                            </a>
                        </td>
                        <td class="cellule_menu"  onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php?page=zone" class="texte_menu">  
                                <span>Mobilité</span>            
                            </a>        
                        </td>		  
                        <td class="cellule_menu"  onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php?page=tarifs" class="texte_menu">
                                <span>Tarifs</span>            
                            </a>      
                        </td>
                        <td class="cellule_menu"  onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php?page=produits" class="texte_menu">
                                <span>Produits</span>            
                            </a>      
                        </td>
                        <td class="cellule_menu"  onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php?page=partenaires" class="texte_menu">
                                <span>Partenaires</span>            
                            </a>      
                        </td>
                        <td class="cellule_menu"  onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php?page=livredor" class="texte_menu">
                                <span>Livre d'or</span>            
                            </a>      
                        </td>
                        <td class="cellule_menu"  onmouseover="PreSelectMenu(this)" onmouseout="DeselectMenu(this)">
                            <a href="index.php?page=contact" class="texte_menu">
                                <span>Contact</span>            
                            </a>      
                        </td>
                    </tr>      
                </table>      
            </div>

            <div id="contenu">      
                <?php  
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    if (($page != 'accueil') && ($page != 'zone') 
                          && ($page != 'tarifs') && ($page != 'produits') && ($page != 'partenaires') 
                          && ($page != 'contact') && ($page != 'livredor') 
                          && ($page != 'messageNonEnvoye') && ($page != 'messageEnvoye')) {
                      $page = 'accueil';
                    }
                }
                else {
                    $page = 'accueil';
                }
                include $page.'.php';
                ?> 
            </div>

            <div id="bas">
                <div class="right">
                    © <?php echo strftime("%Y"); ?> 
                    <a title="Accueil" href="index.php">www.hair-style.fr</a>
                </div> 
                <div class="left">
                    Créé par <a href="http://www.equipe-web.fr" target="_blank">www.equipe-web.fr</a>
                </div> 
            </div>
        </div>
    </body>
</html> 
