<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Sign In</title>
    <style>
      #loader {
        transition: all 0.3s ease-in-out;
        opacity: 1;
        visibility: visible;
        position: fixed;
        height: 100vh;
        width: 100%;
        background: #fff;
        z-index: 90000;
      }

      #loader.fadeOut {
        opacity: 0;
        visibility: hidden;
      }

      .spinner {
        width: 40px;
        height: 40px;
        position: absolute;
        top: calc(50% - 20px);
        left: calc(50% - 20px);
        background-color: #333;
        border-radius: 100%;
        -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
        animation: sk-scaleout 1.0s infinite ease-in-out;
      }

      @-webkit-keyframes sk-scaleout {
        0% { -webkit-transform: scale(0) }
        100% {
          -webkit-transform: scale(1.0);
          opacity: 0;
        }
      }

      @keyframes sk-scaleout {
        0% {
          -webkit-transform: scale(0);
          transform: scale(0);
        } 100% {
          -webkit-transform: scale(1.0);
          transform: scale(1.0);
          opacity: 0;
        }
      }
    </style>
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
    <div class="peers ai-s fxw-nw h-100vh">
      <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style='background-image: url("<?= base_url('assets-admin/images/bg.jpg') ?>")'>
        <div class="pos-a centerXY">
          <div class="bgc-white bdrs-50p pos-r" style="width: 120px; height: 120px;">
            <img class="pos-a centerXY" src="<?= base_url('assets-admin/images/logo.png') ?>" style="height:60px;" alt="">
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width: 320px;">
        <h4 class="fw-300 c-grey-900 mB-40">Login</h4>
        <?php
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])){
          echo '<div class="alert alert-danger" role="alert">
                      '. $_SESSION['error'] .'
                    </div>';
        }
        ?>
        <form method="POST">
          <div class="mb-3">
            <label class="text-normal text-dark form-label">email</label>
            <input type="email" name="email" required class="form-control" placeholder="email">
          </div>
          <div class="mb-3">
            <label class="text-normal text-dark form-label">Password</label>
            <input type="password" name="password" required class="form-control" placeholder="Password">
          </div>
          <div class="">
            <div class="peers ai-c jc-sb fxw-nw">
              <div class="peer">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                  <input type="checkbox" id="inputCall1" name="inputCheckboxesCall" class="peer">
                  <label for="inputCall1" class="peers peer-greed js-sb ai-c form-label">
                    <span class="peer peer-greed">Remember Me</span>
                  </label>
                </div>
              </div>
              <div class="peer">
                <button class="btn btn-primary btn-color">Login</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
