<?php

/**
 * @package  WebkimaElements
 *
 */

namespace WebkimaElements\Widgets;

class Gotoup
{
  public function register()
  {
    add_action("wp_footer", [$this, "gotoup_widget"]);
  }

  public function gotoup_widget()
  {
    ?>
<div id="gotoup" aria-label="gotoup"> <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" > <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/> </svg> </div>
  <style>html{scroll-behavior:smooth}#gotoup{position:fixed;right:20px;bottom:20px;background:#fff;width:40px;height:40px;line-height:40px;display:flex;justify-content:center;align-items:center;border:1px solid #141414;color:#141414;border-radius:10px;cursor:pointer;transform:translateY(150%);opacity:.7;pointer-events:none;transition:opacity .3s ease-in-out,transform .4s ease-in-out;z-index: 9999}#gotoup:hover{opacity:1;animation:1.3s linear .2s infinite pop}#gotoup svg{width:20px;height:20px}#gotoup.active{transform:translateY(0);pointer-events:auto}@keyframes pop{0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)}}</style>
  <script>let gotoup=document.getElementById("gotoup");window.onscroll=function(){document.body.scrollTop>20||document.documentElement.scrollTop>20?gotoup.classList.add("active"):gotoup.classList.remove("active")},gotoup.addEventListener("click",(()=>{document.body.scrollTop=0,document.documentElement.scrollTop=0}));</script>
    <?php
  }
}
