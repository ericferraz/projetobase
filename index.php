<!DOCTYPE html>
<?php
require './library/db/BaseDB.php';
require './model/UsuarioModel.php';
?>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">


        <title>Crud</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

        <script>
            baseUrl = 'ajax/usuario/';
            appendHTML = false;
            id_usuario = 0;
        </script>
    </head>

    <body>

        <!-- Fixed navbar -->
        <nav class="navbar navbar-defaul">
            <div class="container">
                <div class="navbar-header">
                    <!-- The mobile navbar-toggle button can be safely removed since you do not need it in a non-responsive implementation -->
                    <a class="navbar-brand" href="#">Crud Usuários</a>
                </div>
                <!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
                <div id="navbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home</a></li>

                    </ul>

                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Crud de Usuários</div>
                <br/>
                <div class="col-sm-3">
                    <button type="button" id="btnNovo" class="btn btn-info" title="Novo">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>

                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Celular</th>
                                <th class="col-sm-2">AÇÃO</th>
                            </tr>
                        </thead>

                        <tbody id="conteudousuario">
                            <?php
                            $usuario = new UsuarioModel();
                            $dataUsuario = $usuario->fetchAll();
                            if (!empty($dataUsuario)) {
                                foreach ($dataUsuario as $u) {
                                    ?>
                                    <tr id="linha<?php echo $u['id_usuario']; ?>">
                                        <td><?php echo $u['tx_nome']; ?></td>
                                        <td><?php echo $u['tx_email']; ?></td>
                                        <td><?php echo $u['tx_telefone']; ?></td>
                                        <td><?php echo $u['tx_celular']; ?></td>
                                        <td>
                                            <button type="button"  id_usuario="<?php echo $u['id_usuario'] ?>" class="btn btn-info btnEditar" title="Editar">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </button>

                                            <button type="button" id_usuario="<?php echo $u['id_usuario'] ?>" class="btn btn-danger btnExcluir" title="Excluir">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- /container -->

        <!-- MODAL USUÁRIO --->


        <div class="modal fade bs-example-modal-lg" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Cadastro de Usuários</h4>
                    </div>
                    <div class="modal-body form-horizontal">
                        <form id="formUsuario" method="POST">
                            <input type="hidden" name="usuario[id_usuario]" id="id_usuario">
                            <div class="form-group">
                                <label for="recipient-name" class="control-label col-sm-2">Nome:</label>
                                <div class="col-sm-9">
                                    <input type="text" name="usuario[tx_nome]" id="tx_nome" class="form-control" maxlength="45">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label col-sm-2">Email:</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" name="usuario[tx_email]" id="tx_email" class="form-control email" maxlength="45">
                                        <div class="input-group-addon">@</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name" class="control-label col-sm-2">Tel:</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" name="usuario[tx_telefone]" id="tx_telefone" class="form-control" maxlength="45">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                                    </div>
                                </div>

                                <label for="recipient-name" class="control-label col-sm-2">Cel:</label>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" name="usuario[tx_celular]" id="tx_celular" class="form-control" maxlength="45">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-3 col-sm-offset-8">
                            <button type="button" id="btnSalvarUsuario" class="btn btn-sm form-control btn-success ">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="public/js/jquery.populate.js"></script>

        <script>

            $(function () {
                $('#btnNovo').click(function () {
                    $('#formUsuario input').val('');
                    appendHTML = true;
                    openModalUsuario();
                });

                $('#btnSalvarUsuario').click(function () {
                    save();
                });

                atribuirEventos();
            });

            function openModalUsuario() {
                $('#modalUsuario').modal();
            }

            function find(id_usuario) {
                $.ajax({
                    url: baseUrl + 'find.php',
                    data: {id_usuario: id_usuario},
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data) {
                            $('#formUsuario').populate(data);
                            openModalUsuario();
                        } else {
                            alert('Nenhum usuário encontrado');
                        }
                    },
                    error: function () {
                        alert('Ocorreu um erro ao buscar o usuário');
                    }
                });
            }

            function save() {
                var dataUsuario = $('#formUsuario').serialize();
                $.ajax({
                    url: baseUrl + 'save.php',
                    data: dataUsuario,
                    type: 'POST',
                    dataType: 'json',
                    success: function (r) {
                        var html = '';
                        if (r.succes !== '' && r.usuario !== '') {

                            if (appendHTML) {
                                html = '<tr id="linha'+r.usuario.id_usuario+'">';
                                html += '  <td>' + r.usuario.tx_nome + '</td>';
                                html += '  <td>' + r.usuario.tx_email + '</td>';
                                html += '  <td> ' + r.usuario.tx_telefone + '</td>';
                                html += ' <td>' + r.usuario.tx_celular + ' </td>';
                                html += ' <td>';
                                html += ' <button type="button" id_usuario="' + r.usuario.id_usuario + '" class="btn btn-info btnEditar" title="Editar">';
                                html += ' <span class="glyphicon glyphicon-pencil"></span>';
                                html += ' </button>';
                                html += '  <button type="button" id_usuario="' + r.usuario.id_usuario + '" class="btn btn-danger btnExcluir" title="Excluir">';
                                html += ' <span class="glyphicon glyphicon-trash"></span>';
                                html += '</button>';
                                html += ' </td>';
                                html += '</tr>';
                            } else {

                                html = '  <td>' + r.usuario.tx_nome + '</td>';
                                html += '  <td>' + r.usuario.tx_email + '</td>';
                                html += '  <td> ' + r.usuario.tx_telefone + '</td>';
                                html += ' <td>' + r.usuario.tx_celular + ' </td>';
                                html += ' <td>';
                                html += ' <button type="button" id_usuario="' + r.usuario.id_usuario + '" class="btn btn-info btnEditar" title="Editar">';
                                html += ' <span class="glyphicon glyphicon-pencil"></span>';
                                html += ' </button>';
                                html += '  <button type="button" id_usuario="' + r.usuario.id_usuario + '" class="btn btn-danger btnExcluir" title="Excluir">';
                                html += ' <span class="glyphicon glyphicon-trash"></span>';
                                html += '</button>';
                                html += ' </td>';

                            }

                            if (appendHTML) {
                                $('#conteudousuario').append(html);
                            } else {
                                $('#linha' + id_usuario).html(html);
                            }
                            atribuirEventos();
                            alert(r.success);
                        }


                    },
                    error: function () {
                        alert('Ocorreu um erro ao salvar o usuário');
                    }

                });
            }

            function deletar(id_usuario) {
                if (confirm("Deseja realmente exluir esse usuário?")) {
                    $.ajax({
                        url: baseUrl + 'deletar.php',
                        data: {id_usuario: id_usuario},
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                            if (data.success !== '') {
                                var objeto = $('#linha' + id_usuario);
                                $(objeto).fadeOut(2000,function (){
                                    $(this).remove();
                                });
                            } else {
                                alert(data.error);
                            }
                        },
                        error: function () {
                            alert('Ocorreu um erro ao excluir o usuário');
                        }
                    });
                }
            }

            function atribuirEventos() {
                $('.btnEditar').unbind('click');
                $('.btnExcluir').unbind('click');
                
                $('.btnEditar').click(function () {
                    id_usuario = $(this).attr('id_usuario');
                    appendHTML = false;
                    find(id_usuario);
                });

                $('.btnExcluir').click(function () {
                    id_usuario = $(this).attr('id_usuario');
                    deletar(id_usuario);
                });
            }
            
          

        </script>

    </body>
</html>
