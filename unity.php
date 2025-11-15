<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unity Game • Configurador Diabetis Web</title>
    <link rel="shortcut icon" href="TemplateData/favicon.ico">
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style scoped>
      main {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-gray);
        min-height: 92vh;
      }
      .unity-wrapper {
        background: var(--bg-white);
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        padding: 16px 20px 26px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 1010px;
        width: 100%;
      }
      #unity-container {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      #unity-canvas {
        width: 960px;
        height: 600px;
        background: #231F20;
        border-radius: 8px;
      }
      @media (max-width: 1050px) {
        #unity-canvas {
          width: 100vw;
          min-width: 280px;
          max-width: 98vw;
          height: 62vw;
          max-height: 70vh;
        }
      }
      #unity-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
        width: 100%;
      }
      #unity-logo-title-footer {
        width: 48px;
        height: 48px;
        background: url("TemplateData/unity-logo-title-footer.png") no-repeat center center;
        background-size: contain;
      }
      #unity-fullscreen-button {
        width: 48px;
        height: 48px;
        background: url("TemplateData/fullscreen-button.png") no-repeat center center;
        background-size: 28px 28px;
        cursor: pointer;
        border-radius: 8px;
        transition: background-color 0.2s;
      }
      #unity-fullscreen-button:hover {
        background-color: var(--ligth-blue);
      }
      #unity-build-title {
        font-weight: 600;
        color: var(--text-primary);
        letter-spacing: 1px;
        font-size: 1.12rem;
        min-width: 110px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <header><span>UNITY GAME</span></header>
    <main>
      <section class="unity-wrapper">
        <div id="unity-container" class="unity-desktop">
          <canvas id="unity-canvas" width=960 height=600 tabindex="-1"></canvas>
          <div id="unity-loading-bar">
            <div id="unity-logo"></div>
            <div id="unity-progress-bar-empty">
              <div id="unity-progress-bar-full"></div>
            </div>
          </div>
          <div id="unity-warning"> </div>
          <div id="unity-footer">
            <div id="unity-logo-title-footer"></div>
            <div id="unity-fullscreen-button"></div>
            <div id="unity-build-title">Diabetes</div>
          </div>
        </div>
      </section>
    </main>
    <script>
      var canvas = document.querySelector("#unity-canvas");
      function unityShowBanner(msg, type) {
        var warningBanner = document.querySelector("#unity-warning");
        function updateBannerVisibility() {
          warningBanner.style.display = warningBanner.children.length ? 'block' : 'none';
        }
        var div = document.createElement('div');
        div.innerHTML = msg;
        warningBanner.appendChild(div);
        if (type == 'error') div.style = 'background: red; padding: 10px;';
        else {
          if (type == 'warning') div.style = 'background: yellow; padding: 10px;';
          setTimeout(function() {
            warningBanner.removeChild(div);
            updateBannerVisibility();
          }, 5000);
        }
        updateBannerVisibility();
      }
      var buildUrl = "Build";
      var loaderUrl = buildUrl + "/prova web.loader.js";
      var config = {
        arguments: [],
        dataUrl: buildUrl + "/prova web.data",
        frameworkUrl: buildUrl + "/prova web.framework.js",
        codeUrl: buildUrl + "/prova web.wasm",
        streamingAssetsUrl: "StreamingAssets",
        companyName: "DefaultCompany",
        productName: "Diabetes",
        productVersion: "1.0",
        showBanner: unityShowBanner,
      };
      if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
        var meta = document.createElement('meta');
        meta.name = 'viewport';
        meta.content = 'width=device-width, height=device-height, initial-scale=1.0, user-scalable=no, shrink-to-fit=yes';
        document.getElementsByTagName('head')[0].appendChild(meta);
        document.querySelector("#unity-container").className = "unity-mobile";
        canvas.className = "unity-mobile";
      } else {
        canvas.style.width = "960px";
        canvas.style.height = "600px";
      }
      document.querySelector("#unity-loading-bar").style.display = "block";
      var script = document.createElement("script");
      script.src = loaderUrl;
      script.onload = () => {
        createUnityInstance(canvas, config, (progress) => {
          document.querySelector("#unity-progress-bar-full").style.width = 100 * progress + "%";
        }).then((unityInstance) => {
          document.querySelector("#unity-loading-bar").style.display = "none";
          document.querySelector("#unity-fullscreen-button").onclick = () => {
            unityInstance.SetFullscreen(1);
          };
        }).catch((message) => {
          alert(message);
        });
      };
      document.body.appendChild(script);
    </script>
  </body>
</html>