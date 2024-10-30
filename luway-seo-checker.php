<?php
/**
 * Plugin Name: Luway SEO Checker
 * Plugin URI: https://luway.ru
 * Description: SEO Checker for WooCommerce
 * Version: 0.3.0
 * Author: Alexey Ponomarev
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: luway-seo-checker
 */

namespace Luway;

defined( 'ABSPATH' ) || exit;

class SEOChecker
{
    private $version = "0.3.0";

    public function __construct()
    {
        add_action('init', array(&$this, 'init'));
        add_action('wp_before_admin_bar_render', array(&$this, 'adminbar'), 999);
    }

    public function adminbar() {
        global $wp_admin_bar;
        $wp_admin_bar->add_menu([
            'title' => "SEO Checker",
            'id'    => "seo-checker-toggle",
            'href'  => '#'
        ]);

    }

    public function init() {
        if (current_user_can('editor') || current_user_can('administrator'))
            add_action('wp_footer', array(&$this, 'add'), PHP_INT_MAX);
    }

    public function add() {
        $url = plugins_url('/assets/', __FILE__);
        echo '
            <!-- Begin SEO Checker -->
            <style>
                .seo-checker-button {
                    visibility: hidden;
                }
            </style>
            <script type="text/javascript">
                let toggleLink = document.querySelector("[id*=\'seo-checker-toggle\']");
                toggleLink.addEventListener("click", () => {
                    let btn = document.querySelector(".seo-checker-button");
                    if (btn)
                        btn.dispatchEvent(new Event("click", { bubbles: true }));
                });
                (function(s,e,o){a=s.body;c=s.createElement("div");c.id=e,a.appendChild(c);h=s.createElement("script");h.src=o+e+".js?ver=' . $this->version . '";a.appendChild(h);k=s.createElement("link");k.href=o+e+".css?ver=' . $this->version . '";k.rel="stylesheet";a.appendChild(k),s.seo=o})(document, "seo-checker", "' . $url . '")
            </script>
            <!-- END SEO Checker -->
        ';
    }
}

new SEOChecker();