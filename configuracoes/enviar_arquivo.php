

<?php 

$arquivo1 = $_FILES['arquivo1_pdf'];

set_time_limit(0);
$diretorio = "../revendas";
$id_arquivo1 = "arquivo1_pdf";
$nome_arquivo1 = $_FILES[$id_arquivo1]["name"];
$arquivo_temporario1 = $_FILES[$id_arquivo1]["tmp_name"];
move_uploaded_file($arquivo_temporario1, "$diretorio/$nome_arquivo1");

?>