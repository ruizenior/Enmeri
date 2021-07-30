<?php
    include_once('../php/header.php');
    // echo( $_SESSION['userTipe']);
    // echo($row['nombres']);
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../package/bootstrap-5.0.1-dist/css/bootstrap.rtl.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- Hoja de estilo perzonalizada -->
    <link rel="stylesheet" href="../mycss/chats.css">
    <title>ENMERI</title>
    <link rel="shortcut icon" href="../img/ENMERI-icon.png">
</head>
<body>
    <div id="wraper">
        <div id="sidepanel">
            <div id="profile">
                <div id="infouser-img">
                        <img  id="inf-img" src="../img/user.png" class="online" alt="" />
                </div>

                <div id="infouser-name">
                    <?php
                        if(isset($_SESSION['userid'])){
                            ?>
                            <h4 class="username"><?php echo($row['nombres'] . ' ' . $row['apellidos']);?></h4>
                            <?php
                        }else{
                            ?>
                            <h4 class="username">Nombre de usuario </h4>
                            <?php
                        }
                    ?>
                </div>

                <div id="icon-down" class="">
                    <button id="btn-menu-conexion" class="own-btn own-btn-light">
                        <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
                    </button>
                </div>

                <div id="menu-conexion" class="">
                    <ul>
                        <li class="">
                            Activo
                        </li>
                        <li class="">
                            No disponible
                        </li>
                        <li class="">
                            Desconectado
                        </li>
                        <a  href="../php/cerrar.php">
                            <li class="botton">
                                <i class="fas fa-sign-out-alt i"></i> <span> Cerrar secion</span>
                            </li>
                        </a>
                    </ul>
                </div>
			</div>

            <div id="search">
                <div id='s-input'>
                    <input type="text" name="txt-search" id="txt-search" placeholder="buscar">
                </div>

                <a href="" id='s-btn'>
                    <i class="fas fa-search"></i>
                </a>

                <a href="" id='filter-btn'>
                    <i class="fas fa-align-left"></i>
                </a>
            </div>

            <div id="chats">
                <?php
                    if ($_SESSION['userTipe']=='paciente'){
                        $usersChats = listChats($link,$_SESSION['userid']);
                        while ($chat = mysqli_fetch_array($usersChats, MYSQLI_ASSOC)) {
                            $lastDM= ultimoMensaje($link,$chat['id_chat']); 
                            $destinatario= consultarUsuario($link,$chat['id_medico'],'medico');     ?>
                            <a class="chat" href="../ventanas/chats.php?chat=<?php echo $chat['id_chat']?>">
                                <div class="img-chat">
                                    <img src="../img/user.png" alt="" class="img-xs img-round">
                                </div>
                                <div class="dm">
                                    <div class="username">
                                        <h6>
                                            <?php echo $destinatario['nombres'] ?>
                                        </h6>
                                    </div>
                                    <div class="last-dm">
                                        <p><?php echo(substr($lastDM['mensaje'], 0, 26  ) . '...
                                        ');?></p>
                                        <!-- // Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere modi iure aspernatur sint ea! Rem dolore eligendi perspiciatis iusto doloremque. Culpa qui nesciunt atque quibusdam cumque aliquam deserunt sint ea officia nam, placeat omnis accusamus quae voluptas, distinctio possimus? Soluta labore quisquam reprehenderit ad molestiae suscipit impedit enim maxime alias! -->
                                    </div>
                                </div>
                                <div class="date"><?php  $date = date_create($lastDM['fecha_registro']); echo date_format($date, 'H:i')?></div>
                            </a>
                <?php }}?>
            </div>

            <div id="menubar">
                <a href="" id="btn1">
                    <div class="img-btn-menu">
                        <img class="img-xs img-menu" src="../img/guardados.png" alt="">
                    </div>
                    <div class="lbl-btn-menu">
                        <p>GUARDADOS</p>
                    </div>
                </a>
                
                <a href="" id="btn2">
                    <div class="img-btn-menu">
                        <img class="img-Xs img-menu" src="../img/chats.png" alt="">
                    </div>
                    <div class="lbl-btn-menu">
                        <p>CHATS</p>
                    </div>
                </a>
                
                <a href="" id="btn3">
                    <div class="img-btn-menu">
                        <img class="img-Xs img-menu" src="../img/config.png" alt="">
                    </div>
                    <div class="lbl-btn-menu">
                        <p>CONFIG</p>
                    </div>
                </a>
            </div>


        </div>

        <div id="content">
            <!-- <?php 
                if (!empty($_GET['chat'])) {
                    $idchat = $_GET['chat'];
                    $contentChat = consultarChat($link,$idchat);
                
            ?>
            <div id="header-chat">
                <div id="btn-back">
                    <button type="button" id="sidepanelCollapseOut" class="own-btn own-btn-light">
                        <i class="fas fa-chevron-left"></i>
                        <span></span>
                    </button>
                </div>

                <div id="img-user-chat">
                    <a href="#">
                        <img src="../img/user.png" alt="" class="img-s img-round">
                    </a>
                </div>

                <div id="username-chat">
                    <h5><?php 
                        if ($contentChat['id_paciente']==$_SESSION['userid'] and $_SESSION['userTipe']== 'paciente'){
                            $destinatarioContent = consultarUsuario($link,$contentChat['id_medico'],'medico');
                            echo ($destinatarioContent['nombres']);
                        }
                        elseif ($contentChat['id_paciente']!=$_SESSION['userid'] and $_SESSION['userTipe']== 'medico'){
                            $destinatarioContent = consultarUsuario($link,$contentChat['id_paciente'],'paciente');
                            echo ($destinatarioContent['nombres']);
                        }
                    }
                    ?></h5>
                </div>

                <a href="#" id="btn-options">
                    <i class="fas fa-bars"></i>
                </a> -->
            </div>

            <div id="content-chat">
                <div class="dm-sent">
                    <div class="wrap-dm">
                        <div class="date-dm">18:01</div>
                        <div class="txt-dm">
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo ratione, ad quasi tenetur facere ea iste itaque sit neque, maxime totam vel dignissimos consequuntur voluptates quia laudantium recusandae, qui eos!.</p>
                        </div>
                    </div>
                </div>
                <div class="dm-received">
                    <div class="wrap-dm ">
                        <div class="txt-dm">
                            <!-- Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aliquid voluptatem est aut ea unde officiis earum maiores quod ipsam quas in ab nisi pariatur natus veniam excepturi voluptates facilis necessitatibus, assumenda error dolorem possimus ducimus doloremque explicabo! Aspernatur, distinctio necessitatibus quam id harum similique, repellendus ad eius ratione totam tempora. -->
                            <p>hola</p>
                        </div>
                        <div class="date-dm">
                            <p>19:31</p>
                        </div>
                    </div>
                </div>
            </div>

            <div  id="sendbar-chat">
                <a href="#" id="add-btn">
                    <i class="fas fa-plus"></i>
                </a>
                <div id="input-dm">
                    <textarea id="txt-dm"></textarea>
                </div>
                <a href="#" id="send-btn">
                    <i class="fas fa-caret-up"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#sidepanelCollapseIn').on('click', function () {
                $('#sidepanel').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('#sidepanelCollapseOut').on('click', function () {
                $('#sidepanel').toggleClass('active');
                $('#content').toggleClass('active');
                
            });
            $('#btn-menu-conexion').on('click', function () {
                $('#menu-conexion').toggleClass('active');
            });
            // $('#btn-menu-conexion').on('focusout', function () {
            //     $('#menu-conexion').removeClass('active');
            // });

            if (screen.width <= 700){
                $('.chat').on('click', function () {
                    $('#sidepanel').toggleClass('active');
                    $('#content').toggleClass('active');
                });
            };
        });
    </script>
    
	<script >
		// function newMessage() {
		// 	message = $(".message-input input").val();
		// 	if($.trim(message) == '') {
		// 		return false;
		// 	}
		// 	$('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
		// 	$('.message-input input').val(null);
		// 	$('.contact.active .preview').html('<span>You: </span>' + message);
		// 	$(".messages").animate({ scrollTop: $(document).height() }, "fast");
		// };

		// $('.submit').click(function() {
		// newMessage();
		// });

		// $(window).on('keydown', function(e) {
		// if (e.which == 13) {
		// 	newMessage();
		// 	return false;
		// }
		// });
		//# sourceURL=pen.js
	</script>

</body>
</html>