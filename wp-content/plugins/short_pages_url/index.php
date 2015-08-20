<?php
/*
Plugin Name: Short Page URL
Plugin URI: http://страница_с_описанием_плагина_и_его_обновлений
Description: Позволяет любые SEO URL для страниц
Version: 1.0
Author: staser007
Author URI: http://easyinet.ru
*/

//define('slp_spu_', 'slp_spu_'); // staser lab prefix short page url
//define('SLP_SPU_DIR', plugin_dir_path(__FILE__)); // /home/admin/web/pro-logan.ru/public_html/wp-content/plugins/short_pages_url/
//define('SLP_SPU_URL', plugin_dir_url(__FILE__)); // http://pro-logan.ru/wp-content/plugins/short_pages_url/

/*
 * Регистрируем метод активации плагина
 * */
register_activation_hook  (__FILE__, 'slp_spu_activation');
function slp_spu_activation() {

}


/*
 * Регистрируем метод деактивации плагина
 * */
register_deactivation_hook(__FILE__, 'slp_spu_deactivation');
function slp_spu_deactivation() {

}


/*
 * Добавляем в админку подстраничку в настройки
 * */
add_action('admin_menu', 'slp_spu_admin_menu_setup');
function slp_spu_admin_menu_setup() {
    add_submenu_page(
        'options-general.php',
        'Настройки Short Page URL',
        'Short PageURL',
        'manage_options',
        'slp_shortpageurl',
        'slp_spu_admin_page_screen'
    );
}


/*
 * Добавляем ссылку "Настройки" на страницу управления плагинами
 * */
add_filter('plugin_action_links', 'slp_spu_settings_link', 2, 2);
function slp_spu_settings_link($actions, $file) {
    if ($file == 'short_pages_url/index.php') {
        $actions['settings'] = '<a href="options-general.php?page=slp_shortpageurl">Настройки</a>';
    }
    return $actions;
}


/*
 * Регистрация настроек в системе
 * */
add_action('admin_init', 'slp_spu_settings_init');
function slp_spu_settings_init() {
    register_setting(
        'slp_spu_options',
        'slp_spu_options',
        'slp_spu_options_validate'
    );

    add_settings_section(
        'slp_spu_authorbox',
        'Author\'s box',
        'slp_spu_authorbox_desc',
        'slp_shortpageurl'
    );

    add_settings_field(
        'slp_shortpageurl_authorbox_template',
        'Template',
        'slp_shortpageurl_authorbox_field',
        'slp_shortpageurl',
        'slp_spu_authorbox'
    );
}

/*
 * Вывод формы настроек плагина в админке
 * */
function slp_spu_admin_page_screen() {
    global $submenu;

    // access page settings
    $page_data = array();

    foreach ($submenu['options-general.php'] as $i => $menu_item) {
        if ($submenu['options-general.php'][$i][2] == 'slp_shortpageurl') {
            $page_data = $submenu['options-general.php'][$i];
        }
    }

//    var_dump($page_data);
//    array(4) {
//      [0]=>string(13) "Short PageURL"
//      [1]=>string(14) "manage_options"
//      [2]=>string(16) "slp_shortpageurl"
//      [3]=>string(33) "Настройки Short Page URL"
//  }


    // output
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php echo $page_data[3]; ?></h2>
        <form id="msp_helloworld_options" action="options.php" method="post">
            <?php
            settings_fields('slp_spu_options');
            do_settings_sections('slp_shortpageurl');
            submit_button('Save options', 'primary', 'msp_helloworld_options_submit');
            ?>
        </form>
    </div>
    <?php
}


/*
 * Обработка ввода
 * */
function slp_spu_options_validate($input) {
    global $allowedposttags, $allowedrichhtml;

    if (isset($input['authorbox_template'])) {
        $input['authorbox_template'] = wp_kses_post($input['authorbox_template']);
    }

    return $input;
}


/*
 * Описание
 * */
function slp_spu_authorbox_desc() {
    echo "<p>Enter the template markup for author box using placeholders: [gauthor_name], [gauthor_url], [gauthor_desc] for name, URL and description of author correspondingly.</p>";
}


/*
 * вывод полей
 * */
function slp_shortpageurl_authorbox_field() {
    $options = get_option('slp_spu_options');
    $authorbox = (isset($options['authorbox_template'])) ? $options['authorbox_template'] : '';
    $authorbox = esc_textarea($authorbox);
    ?>
    <textarea id="authorbox_template" name="msp_helloworld_options[authorbox_template]" cols="50" rows="5" class="large-text code">
    <?php echo $authorbox; ?>
    </textarea>
    <?php
}


/*
 * Фильтр для правки функции get_page_link
 * */
add_filter( 'page_link', 'slp_spu_page_link_filter', null, 2);
function slp_spu_page_link_filter($url, $post){

    $post = get_post($post);
    if(!$post || $post->post_type != 'page') return $url;

    return get_option('home') . '/' . $post->post_name . '.html';
}



?>