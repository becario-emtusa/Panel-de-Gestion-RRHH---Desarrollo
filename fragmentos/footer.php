<footer>
  <div id="divFooter" class="text" <?php if (isset($_SESSION['login'])) {
                                      if ($_SESSION['login'] == 'ADMIN')
                                        echo 'style="background: rgb(34,193,195);"';
                                    }
                                    ?>>
    Copyright &copy; 2021.
    <a class="text-white" href="https://www.emtusahuelva.com/">www.emtusahuelva.com</a>
    <p><b>Versión:</b> 0.0.2 - <strong style="color: black;">DESARROLLO</strong></p>
  </div>
</footer>