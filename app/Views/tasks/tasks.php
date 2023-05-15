<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager</title>
</head>
<style type="text/css">

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap');

*, body, html{
    margin: 0;
    padding: 0;
    background: #ddd;
    font-family: 'Roboto', sans-serif;
}

.box {
    display: flex;
    margin: 0 auto;
    width: 80%;
    margin-top: 30px;
    flex-direction: column;
    margin-bottom: 50px;
}

.box .titulo, .footer {
    background: #eee;
    display: flex;
    align-items: center;
    padding: 10px 0px;
    width: 100%;
    justify-content: center;
    border-bottom: 1px solid #ddd;
}

.titulo {
    display:flex;
    flex-direction: column;
}

.titulo p {
    display:block;
    font-size: 16px;
    padding: 10px;
    color: green;
}

.titulo h3 {
    color: #333;
    background-color: transparent;
    font-size: 22px;
}

.tasks {
    display: flex;
    width: 100%;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    background: #fff;
    padding: 20px 0px;
}

.task-item {
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    background-color: transparent;
    border-bottom: 2px solid #ededed;
    padding: 20px;
    width: 90%;
}

.task-item h1 {
    background-color: #036;
    font-size: 35px;
    padding: 10px;
    margin-bottom: 7px;
    color: #fff;
    font-weight: 700;
    border-radius: 8px;
}

.task-item h4, p {
    background-color: transparent;
    margin-bottom: 4px;
    display: block;
}

.task-client-name {
    font-size: 1.3em;
    color:#036;
}

.tasks .task-item .task-description {
    font-size: 18px;
    color:#666;
    margin-top:15px;
    margin-bottom:22px;
}

.footer {
    display: flex;
    flex-direction: column;
    padding: 30px 0 30px 0px;
}

.form {
    width: 400px;
    padding: 15px;
    display:flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
    margin-top:20px;
    display:none;
}

.form-fields{
    margin-bottom:15px;
}

.form-fields input{
    border: 0;
    padding: 8px;
    color: #036;
    font-size:1em;
    margin-bottom: 7px;
    width: 390px;
    background-color: #eee;
}

.footer .form .form-fields label {
    display: block;
    padding:4px;
}

.footer button {
    background-color: #036;
    color: #fff;
    padding: 7px;
    border-radius: 5px;
    border: 0;
    cursor: pointer;
}

.btn-tasks-links {
    background-color: transparent;
    padding: 15px 0 15px 0;
}

.btn {
    padding: 10px;
    margin-top: 5px;
    text-decoration: none;
    margin-left: 5px;
    margin-right: 5px;
    color:#fff;
    border-radius: 10px;
}

.btn-task-green {
    background-color: rgb(103, 145, 30);
}

.btn-task-blue {
    background-color: rgb(202, 86, 86);
}

.btn-task-orange {
    background-color: rgb(231, 133, 53);
}    
</style>
<body>
    
    <div class="box">

        <div class="titulo">
            <p>VAGNER FRANCO MOREIRA</p>
            <h3>Ranking Prioritário de Tarefas</h3>

            <?php if( session()->getFlashdata('msg')):?>
                <p>
                    <?= session()->getFlashdata('msg') ?>
                </p>
            <?php endif;?>

        </div>

        <div class="tasks">

    <?php 

    //ordena o ranking
    $p = 1;

    if ($data) {

    foreach ($data as $key => $value) {

        $data  = date('d/m/Y', strtotime($value['data']));
        $prazo = date('d/m/Y', strtotime($value['limite']));
        
        $data_cad = new DateTime($value['data']);
        $data_fim = new DateTime($value['limite']);
        $dias  = $data_fim->diff($data_cad);

        $hoje = new DateTime(date('Y-m-d'));
        $resta = $data_fim->diff($hoje);

    ?>
            <div class="task-item">
                <h1><?=$p?>º</h1>
                <h4 class="task-client-name"><?=mb_strtoupper($value['cliente'])?></h4>
                [Processo: <?=$value['processo']?>]
                <p class="task-description">"<?=$value['tarefa']?>"</p>
                <p><b>&nbsp;Data&nbsp;</b>: <?=$data?> - <b>&nbsp;Prazo&nbsp;</b>: <?=$prazo?> [<?=$dias->d?> dias]</p>
                <div class="btn-tasks-links">
                    <a class="btn btn-task-green" href="">Realizada</a>
                    <a class="btn btn-task-orange" href="">Alterar</a>
                    <a class="btn btn-task-blue" href="<?=base_url('Home/deletar/'.$value['id'])?>">Cancelar</a>
                </div>
                <div style="margin-top:10px;padding:7px">&nbsp;&nbsp;Tempo restante: <?=$resta->d?> dias.&nbsp;&nbsp;</div>
            </div>
    <?php
          $p++;  
        }
    
    }else{

        echo '<p>AVISO: Nenhuma tarefa cadastradas no sistema.</p>';

    }

    ?>

        </div>

        <div class="footer">
            <button id="new_task">Cadastrar Tarefa</button>

            <div class="form">
                
                <form action="./Home/salvar_tarefa" method="post" name="form_task">
                    <div class="form-fields">
                        <label for="cliente">Cliente</label>
                        <input id="first" type="text" name="cliente" required>
                    </div>
                    <div class="form-fields">
                            <label for="tarefa">Tarefa</label>
                        <input type="text" name="tarefa" required>
                    </div>
                    <div class="form-fields">
                        <label for="prazo">Prazo/Hora</label><br>
                        <input class="date" type="text" name="prazo" required>
                    </div>
                    <div class="form-fields">
                        <label for="processo">Processo</label>
                        <input type="text" name="processo" value="0" required>
                    </div>
                    <div class="form-fields">
                        <input style="background-color:green;color:#fff;cursor:pointer" class="btn btn-task-green" type="submit" value="Salvar" name="btn-save">
                    </div>
                </form>

            </div>
        </div>


    </div>



</body>
</html>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

<script>
(function( $ ) {
  $(function() {
    $('.date').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.time').mask("00:00", {placeholder: "__:__"});
    $('.fallback').mask("00r00r0000", {
      translation: {
        'r': {
          pattern: /[\/]/,
          fallback: '/'
        },
        placeholder: "__/__/____"
      }
    });

    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});

    $('.cep_with_callback').mask('00000-000', {onComplete: function(cep) {
        console.log('Mask is done!:', cep);
      },
       onKeyPress: function(cep, event, currentField, options){
        console.log('An key was pressed!:', cep, ' event: ', event, 'currentField: ', currentField.attr('class'), ' options: ', options);
      },
      onInvalid: function(val, e, field, invalid, options){
        var error = invalid[0];
        console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
      }
    });

    $('.crazy_cep').mask('00000-000', {onKeyPress: function(cep, e, field, options){
      var masks = ['00000-000', '0-00-00-00'];
        mask = (cep.length>7) ? masks[1] : masks[0];
      $('.crazy_cep').mask(mask, options);
    }});

    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.money').mask('#.##0,00', {reverse: true});

    var SPMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.sp_celphones').mask(SPMaskBehavior, spOptions);

    $(".bt-mask-it").click(function(){
      $(".mask-on-div").mask("000.000.000-00");
      $(".mask-on-div").fadeOut(500).fadeIn(500)
    })

    $('pre').each(function(i, e) {hljs.highlightBlock(e)});
  });
})(jQuery);

$(document).ready(
    
    $('#new_task').on('click', function(){
        $('.form').show();
        $('#first').focus();
    })
);

</script>