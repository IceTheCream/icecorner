  <!-- [COMPAT]                                             `
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"
          "http://www.w3.org/TR/REC-html40/loose.dtd"-->
<?php 
  //header('Content-Type: text/html; charset=utf-8');
  ini_set('error_reporting', E_ALL);
  ini_set ('display_errors', 1);
  require("scripts/config.php");
  require("scripts/tools.php");
?>

<!--DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en"-->
<html>
  <?php echo getHead($gasConfig) ?> 

<body class="body"> <!-- background=img/bkg.jpg -->

<p class="banner">
"Уголок Айса"
<p>

<table class="table" id="invisible"  align="center" valign="top" width="100%" summary="Глобальная таблица">
<colgroup> 
<col width="20%">
<col width="*%">
</colgroup>
<tbody>
<tr valign="top" summary="Left column" >
<td> 

<!-- Главное меню. -->
<?php 
manageLayout("menu.cfg");  
manageLayout("freeware_side.cfg");  
?>                    
</td>

<td valign="top"> 
<?php 
  manageLayout("desktop.cfg");  
?>
</td> 

</tr>
</tbody>
</table>
</body>
</html>
