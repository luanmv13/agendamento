<?php
session_start();
include_once("conexao.php");
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar</title>
</head>
<body>
    <!-- cancelar ou efetivar o agendamento -->
        


    <h1> AGENDAMENTOS </h1>
    <?php
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset ($_SESSION['msg']);
    }
    //aqui vamos puxar do banco de dados o que ta armazenado para mostrar ao usuario.


    //receber o numero de pagina
    $pagina_atual=filter_input(INPUT_GET,'pagina',FILTER_SANITIZE_NUMBER_INT);
    $pagina= (!empty($pagina_atual))? $pagina_atual:1;

    //setar a quantidade de itens por página
    $quant_result_pag=3;

    //calcular o inicio de visualização
    $inicio=($quant_result_pag*$pagina)-$quant_result_pag;

    $result_usuarios="SELECT * from tb_agendamento inner join tb_dadoscliente on tb_agendamento.cod_dadosC = tb_dadoscliente.cod_dadosC LIMIT $inicio, $quant_result_pag";
    $resultado_query= mysqli_query($conexao,$result_usuarios);
    if($resultado_query->num_rows>0){
    while($row_usuario=mysqli_fetch_array($resultado_query)){
        $efetiva=$row_usuario['id_agenda'];
        $id_agenda=$row_usuario['id_agenda'];
        $status=$row_usuario['status_agenda'];
    
        
        echo "Nome: ". $row_usuario['nome_dadosC']."<br>";
        echo "Efetuado em: ". $row_usuario['dt_agenda']."<br>";
        echo "Local: ". $row_usuario['local_agenda']."<br>";
        echo "Data do agendamento: ". $row_usuario['data_agenda']."<br>";
        echo "Horario da consulta: ". $row_usuario['horario_agenda']."<br>";
        echo " N° do pedido: ". $row_usuario['pedido_venda']."<br>";
        echo "Responsavel pela retirada: ". $row_usuario['responsavel']. "<br>";
        echo "Status: ". $row_usuario['status_agenda']. "<br>";  
        
       
        
            if($status=="Agendado") {

                  ?>
                  <div> 
                    <div>
                    
                    <br>
                    <form method="post" action="cancel_agenda.php" id="form_cancel" onsubmit='return confirm("Realmente deseja cancelar o agendamento?")'>
                      <input type="hidden" name="id_agenda" value=<?php echo $id_agenda; ?> />
                      <input type="submit" name="del_mensagem" class="cancel_cons"  value="Cancelar Consultoria"/>
                      
                    </form> 
                      <br>               
                    <form method="post" action="cancel_agenda.php"  onsubmit='return confirm("COnfirma a retirada do produto?")'>
                      <input type="hidden" name="efetiva" value=<?php echo $efetiva; ?> />
                      <input type="submit" value="Confirmar Retirada"/>
                      <hr>
                    </form> 

                     </div>
                  </div>
                                   
                  
                                           
        <?php
          }else{
            echo "<hr>";
          } 
          } 
          }
          //Somar a quantidade de usuarios
          $result_pg= mysqli_query($conexao,"SELECT count(id_agenda) AS num_result FROM tb_agendamento");
          $row_pg= mysqli_fetch_assoc($result_pg);
          
          //Quantidade de página
          $quantidade_pag=ceil($row_pg['num_result']/$quant_result_pag);
          //Limitar o link antes e depois
          $max_links=2;
          echo "<a href='listar.php?pagina=1'> Primeira </a>";

          for($pag_ant=$pagina-$max_links; $pag_ant<=$pagina-1; $pag_ant++){
            if($pag_ant>=1){
              echo "<a href='listar.php?pagina=$pag_ant'>  $pag_ant  </a>";
            }
          }
          echo "$pagina";

          for($pag_dep=$pagina+1; $pag_dep<=$pagina+$max_links;$pag_dep++){
            if($pag_dep<=$quantidade_pag){
              echo "<a href='listar.php?pagina=$pag_dep'>  $pag_dep  </a>";
            }
          }  
         echo "<a href='listar.php?pagina=$quant_result_pag'> Ultima </a>";
          ?> 
          
        
       
</body>
</html>