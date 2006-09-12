<h2>Accept licence</h2>
<p/>
<p> <?php echo _INSTALLERLICENSE ?></p>

<form action="index.php" method="post">
<div id="iframe">
    <input type="hidden" name="install_step" value="2" />
  <div class="licence">
    <?php echo _INSTALLERGNULICENSE ?>
  </div>
</div>
  <div style="margin:10px" class="submit">
    <input type="submit" value="Accept Licence" />
  </div>
</form>