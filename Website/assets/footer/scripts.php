    <script>
      function onReseize() {
        if (document.body.offsetHeight > screen.height) {
          document.getElementById("footer").style.position = "relative";
        } else {
          document.getElementById("footer").style.position = "fixed";
        }
      }
    </script>