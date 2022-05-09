<?php 
use Projet_Web_parcours\Assets\settings\Settings;
      echo' 
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="'.Settings::RACINE.'"><img src="../../template/" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="'.Settings::RACINE.'"><img src="#" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="#">
                        <span class="menu-icon">
                            <i class="mdi mdi-help"></i>
                        </span>
                        <span class="menu-title">Help</span>
                    </a>
                </li>
            </ul>
        </nav> '        
?>      