<?php

/**
 * @package  WebkimaElements
 *
 */

namespace WebkimaElements\Widgets;

class Gotoup
{
  public $bg_color = "#fff";
  public $text_color = "#282600";
  public $border_color = "#282600";
  public $size = "45";
  public $position = "right";
  public $radius = "10";
  public function register()
  {
    add_action("wp_footer", [$this, "gotoup_widget"]);
    $this->options();
  }

  public function options()
  {
    $this->bg_color = get_option("webkima_elements")["we_goup_bgcolor"];
    $this->text_color = get_option("webkima_elements")["we_goup_textcolor"];
    $this->border_color = get_option("webkima_elements")["we_goup_bordercolor"];
    $this->size = get_option("webkima_elements")["we_goup_size"];
    $this->radius = get_option("webkima_elements")["we_goup_radius"];

    if (!get_option("webkima_elements")["we_goup_position"]) {
      $this->position = "left";
    }
  }

  public function gotoup_widget()
  {
    ?>
<div id="gotoup" class="<?= $this->radius ?>" aria-label="gotoup"> <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" > <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/> </svg> </div>
  <style>html{scroll-behavior:smooth}#gotoup{position:fixed;<?= $this->position ?>:20px;bottom:20px;background:<?= $this->bg_color ?>;width:<?= $this->size ?>px;height:<?= $this->size ?>px;line-height:<?= $this->size ?>px;display:flex;justify-content:center;align-items:center;border:1px solid <?= $this->border_color ?>;color:<?= $this->text_color ?>;border-radius:<?= $this->radius ?>px;cursor:pointer;transform:translateY(150%);pointer-events:none;transition:opacity .3s ease-in-out,transform .4s ease-in-out;z-index: 9999}#gotoup:hover{animation:1.3s linear .2s infinite pop}#gotoup svg{width:20px;height:20px}#gotoup.active{transform:translateY(0);pointer-events:auto}@keyframes pop{0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)}}</style>
  <script>let gotoup=document.getElementById("gotoup");window.onscroll=function(){document.body.scrollTop>20||document.documentElement.scrollTop>20?gotoup.classList.add("active"):gotoup.classList.remove("active")},gotoup.addEventListener("click",(()=>{document.body.scrollTop=0,document.documentElement.scrollTop=0}));</script>
    <?php
  }
}