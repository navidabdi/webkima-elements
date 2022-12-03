<?php

/**
 * @package WebkimaElements
 * @author Nabi Abdi https://webkima.com
 * @class Base
 */

namespace WebkimaElements\Widgets;
use WebkimaElements\DynamicAssets;

class Gotoup {

    public string $bg_color = "#fff";
    public string $text_color = "#282600";
    public string $border_color = "#282600";
    public string $size = "45";
    public string $position = "right";
    public string $radius = "10";

    public static function register(): void {
        (new Gotoup)->goToUp();
    }

    public function goToUp(): void {
        add_action("wp_footer", [$this, 'goToUpWidget']);
        $this->options();
        $this->goToUpStyles();
    }

    public function options(): void {
        $this->bg_color = get_option("webkima_elements")["we_goup_bgcolor"];
        $this->text_color = get_option("webkima_elements")["we_goup_textcolor"];
        $this->border_color = get_option("webkima_elements")["we_goup_bordercolor"];
        $this->size = get_option("webkima_elements")["we_goup_size"] . "px";
        $this->radius = get_option("webkima_elements")["we_goup_radius"] . "px";

        if (!get_option("webkima_elements")["we_goup_position"]) {
            $this->position = "left";
        }
    }

    public function goToUpWidget(): void {
        ?>
      <div id="gotoup" aria-label="gotoup"> <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" > <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/> </svg> </div>

      <script>let gotoup=document.getElementById("gotoup");window.onscroll=function(){document.body.scrollTop>20||document.documentElement.scrollTop>20?gotoup.classList.add("active"):gotoup.classList.remove("active")},gotoup.addEventListener("click",(()=>{document.body.scrollTop=0,document.documentElement.scrollTop=0}));</script>
        <?php
    }

    public function goToUpStyles(): void {
        DynamicAssets::generateStyle('gotoup.css', "html{scroll-behavior:smooth}#gotoup{position:fixed;{$this->position}:20px;bottom:20px;background: {$this->bg_color};width:{$this->size};height:{$this->size};line-height:{$this->size};display:flex;justify-content:center;align-items:center;border:1px solid {$this->border_color};color:{$this->text_color};border-radius:{$this->radius};cursor:pointer;transform:translateY(150%);pointer-events:none;transition:opacity .3s ease-in-out,transform .4s ease-in-out;z-index: 9999}#gotoup:hover{animation:1.3s linear .2s infinite pop}#gotoup svg{width:20px;height:20px}#gotoup.active{transform:translateY(0);pointer-events:auto}@keyframes pop{0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)}}");
    }
}
