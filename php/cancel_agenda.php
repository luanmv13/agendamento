<?php

	include "conexao.php";
	// acentuação
	  mysqli_query($conexao,"SET NAMES 'utf8'");  
	  mysqli_query($conexao,'SET character_set_connection=utf8');
	  mysqli_query($conexao,'SET character_set_client=utf8');  
	  mysqli_query($conexao,'SET character_set_results=utf8'); 

	$id_agenda=$_POST["id_agenda"];
	$efetiva=$_POST["efetiva"]; 
	  date_default_timezone_set("Brazil/East");
	  $dataatual=date("y-m-d");
	  
	 
	  $insert_can= "UPDATE `tb_agendamento` SET `status_agenda`='Cancelado' WHERE id_agenda='$id_agenda'";

	  $insert_can2= "UPDATE `tb_agendamento` SET `status_agenda`='Produto Retirado' WHERE id_agenda='$efetiva'";
	
	  $query_up=mysqli_query( $conexao, $insert_can);
	  $query_up2=mysqli_query($conexao,$insert_can2);

	  if ($query_up>0) {
		 
	 	echo "Operação realizada com sucesso!";
		?>
		<br><br>
		<a href="listar.php" ><button class="button">Voltar</a>
		<?php
	  }
	  else if($query_up2>0) {
	  	echo "Seu produto foi retirado com sucecsso!";
		  ?>
		<br><br>
		<a href="listar.php" ><button class="button">Voltar</a>
		<?php
	  }

	  else{
		 echo "Não foi possível realizar a operação!";
		 ?>
	   <br><br>
	   <a href="listar.php" ><button class="button">Voltar</a>
	   <?php
	 }




	
	//insere uma nova notificação
	$scont=	"SELECT * FROM `tb_agendamento` WHERE dt_agenda='$dataatual'";
	$qcont=mysqli_query($conexao,$scont);
	$i=0;
		while($l=mysqli_fetch_array($qcont)){ $i++; }
	 
	if ($i == 1) { 
		$icont=mysqli_query ($conexao,'INSERT INTO `tb_notificacoes`( `titulo_notifica`, `texto_notifica`, `data_notifica`, `status_notifica`) VALUES ("Cancelamento","Um cancelamento foi realizado.","'.$dataatual.'","Não visualizado")');	 
	}
	else{
		$ucont=mysqli_query ($conexao,'UPDATE `tb_notificacoes` SET `texto_notifica`="Houve '.$i .' cancelamentos hoje.",`status_notifica`="Não visualizado"  WHERE titulo_notifica="Cancelamento" AND data_notifica="'.$dataatual.'"');  
	}

?>
