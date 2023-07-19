<?php

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css', array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));
    // Chargement du /css/shortcodes/banniere-titre.css pour notre shortcode banniere titre
    wp_enqueue_style('section-commentaire-shortcode', get_stylesheet_directory_uri() . '/css/shortcodes/section-commentaire.css', array(), filemtime(get_stylesheet_directory() . '/css/shortcodes/section-commentaire.css'));
    wp_enqueue_style('formulaire-contact-shortcode', get_stylesheet_directory_uri() . '/css/shortcodes/formulaire-contact.css', array(), filemtime(get_stylesheet_directory() . '/css/shortcodes/formulaire-contact.css'));
    wp_enqueue_style('selecteur-fruit-shortcode', get_stylesheet_directory_uri() . '/css/shortcodes/selecteur-fruit.css', array(), filemtime(get_stylesheet_directory() . '/css/shortcodes/selecteur-fruit.css'));
}

/*HOOKS*/
add_filter('wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2);
function add_extra_item_to_nav_menu($items, $args)
{
    if (is_user_logged_in()) {
        $items .= '<li><a href="http://localhost/Planty/wp-admin/index.php" class="admin-position">Admin</a></li>';
    }
    return $items;
}
/*SHORTCODES*/

// Je dis à wordpress que j'ajoute un shortcode 'section-commentaire'
add_shortcode('section-commentaire', 'section_commentaire_func');
// Je génère le html retourné par mon shortcode
function section_commentaire_func($atts)
{
    //Je récupère les attributs mis sur le shortcode
    $atts = shortcode_atts(array(
        'src' => '',
        'titre' => 'Titre',
        'prenom' => '',
        'description' => ''
    ), $atts, 'section-commentaire');

    //Je commence à récupéré le flux d'information
    ob_start();

    if ($atts['src'] != "") {
?>

        <div class="section-commentaire-flex">
            <h2 style="background-image: url(<?= $atts['src'] ?>" class="titre section-commentaire"><?= $atts['titre'] ?></h2>
            <div class="section-commentaire-margin">
                <h3 class="section-commentaire-color"><?= $atts['prenom'] ?></h3>
                <p><?= $atts['description'] ?></p>
            </div>
        </div>
    <?php
    }

    //J'arrête de récupérer le flux d'information et le stock dans la fonction $output
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
// Je dis à wordpress que j'ajoute un shortcode 'formulaire-contact'
add_shortcode('formulaire-contact', 'formulaire_contact_func');
function formulaire_contact_func($atts)
{
    //Je récupère les attributs mis sur le shortcode
    $atts = shortcode_atts(array(
        'label-1' => '',
        'label-2' => '',
        'label-3' => '',
        'bouton' => ''
    ), $atts, 'formulaire-contact');

    //Je commence à récupéré le flux d'information
    ob_start();

    if ($atts['label-1'] != "") {
    ?>

        <div class="formulaire-contact">
            <p>
                <label class="label-color"><?= $atts['label-1'] ?><br>
                    <span class="wpcf7-form-control-wrap" data-name="your-name">
                        <input size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required wpcf7-not-valid" autocomplete="name" aria-required="true" aria-invalid="true" value="" type="text" name="your-name" aria-describedby="wpcf7-f376-p51-o1-ve-your-name">
                        <span class="wpcf7-not-valid-tip" aria-hidden="true">Veuillez renseigner ce champ.</span></span>
                </label><br>
                <label class="label-color"><?= $atts['label-2'] ?><br>
                    <span class="wpcf7-form-control-wrap" data-name="your-email">
                        <input size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email wpcf7-not-valid" autocomplete="email" aria-required="true" aria-invalid="true" value="" type="email" name="your-email" aria-describedby="wpcf7-f376-p51-o1-ve-your-email">
                        <span class="wpcf7-not-valid-tip" aria-hidden="true">Veuillez renseigner ce champ.</span></span>
                </label><br>
                <label class="label-color"><?= $atts['label-3'] ?><br>
                    <span class="wpcf7-form-control-wrap" data-name="your-message">
                        <textarea cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false" name="your-message"></textarea></span> </label>
            </p>
            <p>
                <input class="wpcf7-form-control has-spinner wpcf7-submit bouton-color" type="submit" value="<?= $atts['bouton'] ?>">
                <span class="wpcf7-spinner"></span>
            </p>
        </div>
    <?php
    }

    //J'arrête de récupérer le flux d'information et le stock dans la fonction $output
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
// Je dis à wordpress que j'ajoute un shortcode 'selecteur-fruit'
add_shortcode('selecteur-fruit', 'selecteur_fruit_func');
function selecteur_fruit_func($atts)
{
    //Je récupère les attributs mis sur le shortcode
    $atts = shortcode_atts(array(
        'min' => '',
        'max' => '',
    ), $atts, 'selecteur-fruit');

    //Je commence à récupéré le flux d'information
    ob_start();

    if ($atts['min'] != "") {
    ?>

        <div class="number-input">
            <input class="quantity" min="<?= $atts['min'] ?>" max="<?= $atts['max'] ?>" name="quantity" value="0" type="number">
            <div class="ordre-boite">
                <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="moins"></button>
            </div>
        </div>
<?php
    }

    //J'arrête de récupérer le flux d'information et le stock dans la fonction $output
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
