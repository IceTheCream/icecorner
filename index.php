<?php 
  header('Content-Type: text/html; charset=utf-8');
  ini_set('error_reporting', E_ALL);
  ini_set ('display_errors', 1);
  require("scripts/config.php");
  require("scripts/tools.php");
  //phpinfo();
?>

<!--DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" -->
<html>
  <?php echo getHead($gasConfig) ?> 


  <!-- body class="body"> <!-- background=img/bkg.jpg -->
  <body> <!-- background=img/bkg.jpg -->
  
<p class="banner">
"Уголок Айса"
<p>
<!--
      <table class="table" id="invisible"  align="center" width="100%" summary="Глобальная таблица">
      <tbody><tr><td>
      "Уголок Айса"
      </td></tr></tbody>
      </table>      
-->      
      
<table class="table" id="invisible"  align="center" width="100%" summary="Глобальная таблица">

<colgroup> 
<col width="20%">
<col width="*%">
</colgroup>

<tbody>
<tr valign="top" summary="Left column" >
<td> 

<?php 
//writeMainMenu($gasConfig,$gasMainMenuStyle,$gasMainMenuItems) ;
manageLayout("menu.cfg");  
manageLayout("index_side.cfg");  
?>                    

<!--
<table class="table" id="noborder" align="center" width="100%" summary="погода">
  <tbody>
    <tr>
      <td align="center">
        <a href="http://www.gismeteo.ru/towns/26781.htm">
          <img alt="GISMETEO.RU: погода в г. Смоленск" src="http://informer.gismeteo.ru/26781-7.GIF" border=0 width=120 height=120>
        </a>
      </td>
    </tr>
  </tbody>
</table>
<p>
<a href="http://ru.windows7sins.org/">
  <img src="http://ru.windows7sins.org/i/widget.png" alt="Windows 7 грехов" />
</a></p> 
-->
</td>
<td valign="top"> 
  <?php 
    //$lasLayouts=array("index.cfg");
    //manageLayout($gasLayoutStyle,$gasContentStyle,$lasLayouts);  
    manageLayout("index.cfg");  
    //manageLayout($gasLayoutStyle,$gasContentStyle,"index.cfg");  
  ?>
</td> 

</tr>
</tbody>
</table>
</body>
</html>
