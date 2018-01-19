<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link rel="stylesheet" href="../funcoes/modal-message/modal-message.css" type="text/css">
<script type="text/javascript" src="../funcoes/modal-message/ajax.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/modal-message.js"></script>
<script type="text/javascript" src="../funcoes/modal-message/ajax-dynamic-content.js"></script>

<script type="text/javascript">
messageObj = new DHTML_modalMessage();	// We only create one object of this class
messageObj.setShadowOffset(5);	// Large shadow


function displayMessage(url,xx,yy)
{
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(xx,yy);
	messageObj.setShadowDivVisible(false);	// Enable shadow for these boxes
	messageObj.display();

}

function closeMessage()
{
	messageObj.close();	

}


</script>

</head>

<body>

<?php if ($apagarpreco == "1"){?>
              
<a href="#"  onclick="displayMessage('../configuracoes/zerar.php','550','450');return false">
ZERAR PREÇO DE VENDA DE PRODUTOS</a>
              
              <?php  } else {  ?>
            <?php } ?>
<br>
<br>
<?php if ($apagarpreco == "1"){?>
              
<a href="#"  onclick="displayMessage('../configuracoes/atualizar_data.php','550','450');return false">
ATUALIZAR DATA</a>
              
              <?php  } else {  ?>
            <?php } ?>


<br />
<br />
<a href="#"  onclick="displayMessage('../configuracoes/enviar_tabela.php','550','450');return false">ENVIAR TABELA DE REVENDA</a><br />
</body>
</html>