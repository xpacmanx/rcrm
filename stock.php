<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title>Фотографии</title>
  <?php require_once "templates/scripts.tpl" ;?>
</head>
<body>

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
                      <a class="navbar-brand" href="#">Склад</a>
                  </div>

              </div>
          </nav>

          <?php

          $mongo = new MongoClient("mongodb://localhost");

          // Choose the database and collection
          $db = $mongo->rcrm;
          $coll = $db->stock;
          $stock = $coll->find();

          $gadgets = array('Смартфон');
          $health = array('Новый', 'Хорошее', 'Небольшие потертости', 'Незначительные повреждения', 'Разбит', 'Неремонтопригоден');

          ?>

          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <?php if (count($stock) > 0): ?>
                        <table class="table table-striped">
                          <thead>
                            <th>
                              Тип устройства
                            </th>
                            <th>
                              Бренд
                            </th>
                            <th>
                              Модель
                            </th>
                            <th>
                              Комплектация
                            </th>
                            <th>
                              Состояние
                            </th>
                          </thead>
                          <tbody>
                          <?php foreach ($stock as $key => $st): ?>
                          <tr>
                            <td><?=$gadgets[$st['type']];?></td>
                            <td><?=$st['brand'];?></td>
                            <td><?=$st['model'];?></td>
                            <td>
                              <?php $kit = explode(',',$st['kit']);
                              foreach ($kit as $k) {
                                print('<span class="label label-info">'.$k.'</span> ');
                              }
                              ?>
                            </td>
                            <td><?=$health[$st['health']];?></td>
                          </tr>
                          <?php endforeach;?>
                          </tbody>
                        </table>
                      <?php else:?>
                        <p class="text-center">Пока ничего нет</p>
                      <?php endif;?>
                    </div>
                  </div>
              </div>
          </div>

      </div>
  </div>


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

      <!--  Google Maps Plugin    -->
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

      <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  	<script src="assets/js/light-bootstrap-dashboard.js"></script>

  	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
  	<script src="assets/js/demo.js"></script>
    <script src="assets/js/dropzone.js"></script>

  	<script type="text/javascript">
        var dragzone1 = new Dropzone("#dragdrop", {
          url: "upload.php",
          previewsContainer: ".dragdrop-container"
        });

        $(function(){


          $('.photo').hover(function(){
            var orig = $(this).data('original');
            $('.nowphoto').html('<img src="'+orig+'" />');
          })
          	// $.notify({
            //   	icon: 'pe-7s-gift',
            //   	message: "Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."
            //
            //   },{
            //       type: 'info',
            //       timer: 4000
            //   });

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
