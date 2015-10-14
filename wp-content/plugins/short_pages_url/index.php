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
 * Добавляем в админку подстраничку в настройки
 * */
add_action('admin_menu', 'slp_spu_admin_menu_setup');
function slp_spu_admin_menu_setup() {
    add_submenu_page(
        'options-general.php',
        'Настройки коротких ссылок страниц',
        'Короткие ссылки',
        'manage_options',
        'slpshortpageurl',
        'slp_spu_admin_page_screen'
    );
}


/*
 * Вывод подстранички настроек плагина в админке
 * */
function slp_spu_admin_page_screen() {
    global $submenu;

    $page_data = array();
    foreach ($submenu['options-general.php'] as $i => $menu_item) {
        if ($submenu['options-general.php'][$i][2] == 'slpshortpageurl') {
            $page_data = $submenu['options-general.php'][$i];
        }
    }
    ?>

    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php echo $page_data[3]; ?></h2>
        <form id="slp_spu_options" action="options.php" method="post">
            <?php
            settings_fields('slp_spu_options');
            do_settings_sections('slpshortpageurl');
            submit_button('Save options', 'primary', 'msp_helloworld_options_submit');
            ?>
        </form>
    </div>

    <?php
}


/*
 * Регистрация настроек в системе
 * */
add_action('admin_init', 'slp_spu_settings_init');
function slp_spu_settings_init() {

    /* Регистрируем группу настроек */
    register_setting(
        'slp_spu_options',          // group
        'slp_spu_options',          // name
        'slp_spu_options_validate'  // validate callback
    );

    /* Добавляем секцию настроек */
    add_settings_section(
        'slp_spu_basic_settinngs_section',  // id
        'Основные',                         // title
        'slp_spu_basic_desc',               // callback
        'slpshortpageurl'                   // page
    );
    /* Еще одна секция */
    add_settings_section(
        'slp_spu_adding_settings_section',  // id
        'Дополнительно',                    // title
        'slp_spu_section_desc',             // callback
        'slpshortpageurl'                   // page
    );

    add_settings_field(
        'slp_spu_extension',                    // id
        'Добавить к name страницы',             // title
        'slp_spu_extention_field',              // callback
        'slpshortpageurl',                      // page
        'slp_spu_basic_settinngs_section'       // section
    );
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
 * Описание секции настроек
 * */
function slp_spu_section_desc() {
    echo "<p>&nbsp;</p>";
}


/*
 * Вывод полей
 * */
function slp_spu_extention1_field() {
    $options   = get_option('slp_spu_options');
    $extension = (isset($options['extension'])) ? $options['extension'] : '';
    $extension = esc_textarea($extension);
    ?>
    <textarea id="extension" name="slp_spu_options[extension]" cols="50" rows="5" class="large-text code">
    <?php echo $extension; ?>
    </textarea>
    <?php
}
function slp_spu_extention_field() {
    $options   = get_option('slp_spu_options');
    $extension = (isset($options['extension'])) ? $options['extension'] : '';
    $extension = esc_html($extension);
    ?>
    <input type="text"  id="extension" name="slp_spu_options[extension]" class="code" value="<?php echo $extension; ?>">
    <?php
}


/*
 * Фильтр для правки функции get_page_link
 * */
add_filter( 'page_link', 'slp_spu_page_link_filter', null, 2);
function slp_spu_page_link_filter($url, $post){

    $post = get_post($post);
    if(!$post || $post->post_type != 'page') return $url;

    $options   = get_option('slp_spu_options');
    $extension = (isset($options['extension'])) ? $options['extension'] : '';

    return get_option('home') . '/' . $post->post_name . $extension;
}

/*
 * Фильтр для правки функции get_term_link
 * */
add_filter( 'term_link', 'slp_spu_term_link_filter', null, 2);
function slp_spu_term_link_filter($url, $post){

    $options   = get_option('slp_spu_options');
    $extension = (isset($options['extension'])) ? $options['extension'] : '';

    return get_option('home') . '/' . $post->slug . $extension;
}




add_filter( 'request', 'slp_spu_request_filter');
function slp_spu_request_filter($query_vars){
    /** @var $wpdb wpdb */
    global $wpdb;

    // Возьмем пример третьей вложенности придет сюда
    //  $query_vars = array(2) {
    //      ["page"]     => string(0) ""
    //      ["pagename"] => string(36) "structure_car/engine/design_features"
    //  }
    //
    //  Для рубрик
    //  $query_vars = array(2) {
    //      ["category_name"]     => string(0) "blog"
    //  }
    //

    // Значит если это отдавать всегда, то мы увидим всегда эту страницу
    // значит нам надо найти страницу по имени из pagename и вернуть полный ее путь ("structure_car/engine/design_features")


//    return $query_vars;

//    return array(
//        "page" => "",
//        "pagename" => "structure_car/engine/design_features"
//    );

    // Получаем имя страницы

    $pagename = explode('/', $query_vars['name']);
    $pagename = array_pop($pagename);

    if (!$pagename) return $query_vars;

    if($page = $wpdb->get_row("SELECT * FROM `$wpdb->posts` WHERE `post_name` = '$pagename' AND `post_type` = 'page'")){
        // Подменяем данные $query_vars данными найденной статьи
        $full_page_name = $page->post_name;
        while ($page->post_parent > 0) {
            $page = $wpdb->get_row("SELECT * FROM `$wpdb->posts` WHERE `ID` = '" . $page->post_parent . "'");
            $full_page_name = $page->post_name . '/' . $full_page_name;
        }
        return array('name' => '', 'pagename' => $full_page_name);
    }elseif($page = $wpdb->get_row("SELECT * FROM `$wpdb->terms` WHERE `slug` = '$pagename'")){
        return array('category_name' => $pagename);
    }


    return $query_vars;






}

add_filter( 'widget_pages_args', 'slp_spu_widget_pages_args');
function slp_spu_widget_pages_args($query_vars){
    /** @var $wpdb wpdb */

    global $wpdb;

//    array {
//        ["title_li"]=> string(0) ""
//        ["echo"]=> int(0)
//        ["sort_column"]=> string(22) "menu_order, post_title"
//        ["exclude"]=> string(0) ""
//    }

    $query_vars['child_of'] = 91;

    return $query_vars;

}


?>