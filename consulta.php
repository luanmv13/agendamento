<?php 
	include "php/conexao.php";  
   // acentuação
    mysqli_query($conexao,"SET NAMES 'utf8'");  
    mysqli_query($conexao,'SET character_set_connection=utf8');
    mysqli_query($conexao,'SET character_set_client=utf8');
    mysqli_query($conexao,'SET character_set_results=utf8');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Agendamento | R.Sanches</title>
  <meta charset="UTF-8">
   <!-- Icon -->
   <link rel="icon" href="imagens/icon.jpg"> 
	 <!-- Font Awesome -->
   <script defer src="font-awesome/fontawesome-all.js"></script> 
   <!-- Css --> 
   <link rel="stylesheet" href="css/agendamento.css">
   <!-- Jquery -->
  <script type="text/javascript" src="js/jquery.min.js"></script>


  <script type="text/javascript">
    function dataEhora(){
      var data_consulta=document.getElementById("data_consulta").value;
      var local_consulta=document.getElementById("local_consulta").value;
      var resp_consulta=document.getElementById("resp_consulta").value;
      
      if (data_consulta && local_consulta && resp_consulta !="") {
        document.getElementById("dt_a").value=data_consulta;
        document.getElementById("hr_a").value=resp_consulta;
        document.getElementById("loc_a").value=local_consulta;
      }
    }
  </script>
</head>

<body>
	
   <?php include "nav.php";
    ?>

	<div id="container-agen">
		<div id="rgba">


      <?php
        if(isset($_SESSION['logado'])==true AND $_SESSION['logado']>0){
          $busca=mysqli_query($conexao,"SELECT * FROM  tb_dadoscliente WHERE cod_dadosC=$cod_dados");
          $row_busca=mysqli_fetch_array($busca);
          $nome_dadosC=$row_busca['nome_dadosC'];
          $telefone_dadosC=$row_busca['telefone_dadosC'];
          $rg_dadosC=$row_busca['rg_dadosC'];
      ?>



      
        <!-- _________________________________________________________________________________________________________ -->




        <div id="div-todos" class="box-s bk-azul-escuro ">
          <h3 style="margin: 7px;" class="color-white">Meus Agendamentos</h3>
          <?php 
            $sel_agenda=mysqli_query($conexao,"SELECT * FROM tb_agendamento INNER JOIN tb_dadoscliente ON (tb_agendamento.cod_dadosC=tb_dadoscliente.cod_dadosC) where tb_dadoscliente.login_dadosC='$email_user' order by tb_agendamento.id_agenda desc");  

          if ($sel_agenda->num_rows>0) {
            while($row_agenda=mysqli_fetch_array($sel_agenda)){ 
              $id_agenda=$row_agenda['id_agenda'];
              $status=$row_agenda['status_agenda'];
              ?>

              <div class="card">
                 <p style="font-size: 16px;" class="frase destaque">Escritório: <?php echo $row_agenda['local_agenda'].' - <span id="cor">'. $status .'</span>'; ?></p>
                 <p class="espaco destaque font15"><?php echo date('d/m/Y', strtotime($row_agenda['data_agenda'])).' - '.$row_agenda['horario_agenda']; ?> </p> 
                 <p class="frase font15"><span class="destaque">RG:</span> <?php echo $row_agenda['rg_dadosC']; ?> </p>
                 <p class="frase font15"><span class="destaque">Nome:</span> <?php echo $row_agenda['nome_dadosC']; ?> </p>
                 <p class="frase font15"><span class="destaque">Telefone:</span> <?php echo $row_agenda['telefone_dadosC']; ?> </p>
                 <p class="frase font15"><span class="destaque">Data de Nascimento:</span> <?php echo date('d/m/Y', strtotime($row_agenda['dt_nasc_dadosC'])); ?> </p>
                 <p class="frase font15"><span class="destaque">N° Pedido de Venda:</span> <?php echo $row_agenda['pedido_venda']; ?> </p>
                 <p class="frase font15"><span class="destaque">Responsavel: </span> <?php echo $row_agenda['responsavel']; ?> </p>
                  <?php   
                    if($status=="Agendado") {
                  ?>
                    <form method="post" action="" id="form_cancel" onsubmit='return confirm("Realmente deseja cancelar o agendamento?")'>
                      <input type="hidden" name="id_agenda" value=<?php echo $id_agenda?> />
                      <input type="submit" name="del_mensagem" class="cancel_cons" value="Cancelar Consultoria">
                    </form> 
                  <?php
                    } //if($status=="Agendado")
                  ?>
              </div> card

          <?php
            } // fecha o while mysqli_fetch_array
          } // fecha o if num_rows
          else{
            echo "<h2 class='inexistente'> Não há nenhum agendamento!</h2>";
          }   ?>
        </div><!--  div-todos -->
      </div><!-- container-a -->

      <?php
        } //se o usuário estiver logado
        else{
          echo "<div id='restrito' class='bk-azul color-white'>";
          echo '<i class="fas fa-ban" style="font-size:50px;"></i><br><br>';
          echo "<h1 style='margin:0;'>É necessário estar logado para acessar esta página!</h1><br>";
          echo "<h3 style='margin:0;'> <a href='index.php' class='color-white'>Ir para tela inicial</a></h3>";
          echo "</div>";
        }

      ?>
    </div><!-- rgba -->
	</div><!-- container-agen -->

<!-- 
#008B00
#8B0000
#EE7600 
-->

  <?php include "rodape.php"; ?>
</body>