<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title><?= isset($title) ? esc($title) : 'Appkita' ?></title>
    <style>
     #loader{transition:.3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:1s ease-in-out infinite sk-scaleout;animation:1s ease-in-out infinite sk-scaleout}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}
    </style>
    <?= $this->renderSection('style') ?>
  <script defer="defer" src="<?= base_url('assets-admin/main.js') ?>"></script><link href="<?= base_url('assets-admin/style.css') ?>" rel="stylesheet"></head>
  <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>

    <script>
      window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
            loader.classList.add('fadeOut');
        }, 300);
      });
    </script>
    
    <div>
      <!-- left-sidebar -->
      <?= $this->include('Template/left_sidebar') ?>
      <!-- left-sidebar -->

      <!-- #Main ============================ -->
      <div class="page-container">
        <!-- ### $Topbar ### -->
        <?= $this->include('Template/header') ?>
         <!-- ### $Topbar ### -->

        <!-- ### $App Screen Content ### -->
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            <div class="full-container">
                <?= $this->renderSection('content'); ?>
            </div>
          </div>
        </main>

        <?= $this->renderSection('javascript') ?>
        <!-- ### $App Screen Footer ### -->
        <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
          <span>Copyright © 2021 Designed by <a href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a>. All rights reserved.</span>
        </footer>
      </div>
    </div>
  </body>
</html>
