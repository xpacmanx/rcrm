<?php
require_once "lib/auth.php";
$auth = new AuthClass();
header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title>Панель управления</title>
  <?php require_once "templates/scripts.tpl" ;?>
</head>
<body>

<?php if (!$auth->isAuth()):?>
  <div class="wrapper login">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
              <div class="col-md-12"><h2 class="text-center">Авторизация</h2></div>
            </div>
            <div class="row">
              <div class="col-md-2 col-md-offset-5">
                <form action="/login" method="POST">
                    <div class="form-group">
                      <input type="text" name="login" class="form-control" placeholder="Логин" /><br/>
                      <input type="password" name="pass" class="form-control" placeholder="Пароль" />
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
              </div>
            </div>
        </div>
    </div>
  </div>

<?php else:?>
  <div class="wrapper">
      <div class="sidebar" data-color="azure" data-image="assets/img/sidebar-4.jpg">

      	<div class="sidebar-wrapper">
                  <?php require_once "templates/menu.tpl" ;?>
      	</div>
      </div>

      <div class="main-panel">
          <nav class="navbar navbar-default navbar-fixed">
              <div class="container-fluid">
                  <div class="navbar-header">
                      <a class="navbar-brand" href="#">Панель управления</a>
                  </div>

              </div>
          </nav>

          <?php

          $mongo = new MongoClient("mongodb://localhost");

          // Choose the database and collection
          $db = $mongo->rcrm;
          $orders = $db->orders;
          $clients = $db->clients;

          ?>

          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <h3>Заказы</h3>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="card">
                              <div class="header">
                                  <h4 class="title">Новые</h4>
                                  <p class="category">Необработанные заказы</p>
                              </div>
                              <div class="content">
                                  <div class="dashboard-num"><?=$orders->count(array('status'=>0))?></div>

                                  <div class="footer">
                                      <hr>
                                      <div class="stats">
                                          <i class="fa fa-clock-o"></i> Последний заказ
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card">
                              <div class="header">
                                  <h4 class="title">Обработка</h4>
                                  <p class="category">Заказы находящиеся у мастеров</p>
                              </div>
                              <div class="content">
                                  <div class="dashboard-num"><?=$orders->count(array('status'=>1))?></div>

                                  <div class="footer">
                                      <hr>
                                      <div class="stats">
                                          <i class="fa fa-clock-o"></i> Последний заказ
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card">
                              <div class="header">
                                  <h4 class="title">Готовые</h4>
                                  <p class="category">Заказы готовые к выдачи</p>
                              </div>
                              <div class="content">
                                  <div class="dashboard-num"><?=$orders->count(array('status'=>2))?></div>

                                  <div class="footer">
                                      <hr>
                                      <div class="stats">
                                          <i class="fa fa-clock-o"></i> Последний заказ
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <h3>Клиенты</h3>
                    </div>
                  </div>

                  <div class="row">
                      <div class="col-md-4">
                          <div class="card">
                              <div class="header">
                                  <h4 class="title">Новые</h4>
                              </div>
                              <div class="content">
                                  <div class="dashboard-num"><?=$clients->count(array('status'=>0))?></div>

                                  <div class="footer">
                                      <hr>
                                      <div class="stats">
                                          С заказом в процессе
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card">
                              <div class="header">
                                  <h4 class="title">Разовый</h4>
                              </div>
                              <div class="content">
                                  <div class="dashboard-num"><?=$clients->count(array('status'=>1))?></div>

                                  <div class="footer">
                                      <hr>
                                      <div class="stats">
                                          С завершенным заказом
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="card">
                              <div class="header">
                                  <h4 class="title">Постоянный</h4>
                              </div>
                              <div class="content">
                                  <div class="dashboard-num"><?=$clients->count(array('status'=>2))?></div>

                                  <div class="footer">
                                      <hr>
                                      <div class="stats">
                                          Более 2 завершенных заказов
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

              </div>
          </div>

      </div>
  </div>


<?php endif;?>
  </body>

      <!--   Core JS Files   -->
      <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
  	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

  	<!--  Checkbox, Radio & Switch Plugins -->
  	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

  	<!--  Charts Plugin -->
  	<script src="assets/js/chartist.min.js"></script>

      <!--  Notifications Plugin    -->
      <script src="assets/js/bootstrap-notify.js"></script>

      <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  	<!-- <script src="assets/js/light-bootstrap-dashboard.js"></script> -->

  	<script type="text/javascript">

        $(function(){


          $('.photo').hover(function(){
            var orig = $(this).data('original');
            $('.nowphoto').html('<img src="'+orig+'" />');
          })

          <?php if (isset($_GET['message'])): ?>
          $.notify({
            	icon: 'pe-7s-attention',
            	message: "<?=$_GET["message"]?>"

            },{
                type: 'danger',
                timer: 4000
            });
          <?php endif ?>


      	});

        $(document).on('click','.photo',function(){
            $(this).parent().toggleClass('focus');
            var count = $('.focus').length;
            console.log(count);
            $('.form-result').text('Выбрано фотографий: '+count);
        });

        $(document).on('click','.photo-menu a',function(){
          var txt = $(this).text();
          $(this).parent().parent().parent().find('.result').html(txt);
        })

  	</script>


</body>
</html>
