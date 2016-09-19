<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="assets/img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Фотографии</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />
  <!-- Bootstrap core CSS     -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Animation library for notifications   -->
  <link href="assets/css/animate.min.css" rel="stylesheet"/>
  <!--  Light Bootstrap Table core CSS    -->
  <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
  <!--  CSS for Demo Purpose, don't include it in your project     -->
  <link href="assets/css/demo.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <!--     Fonts and icons     -->
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
  <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/dropzone.css">
</head>
<body>

  <div class="wrapper">
      <div class="sidebar" data-color="azure" data-image="assets/img/sidebar-4.jpg">

      	<div class="sidebar-wrapper">
              <div class="logo">
                  <a href="/content2/photos" class="simple-text">
                      R-CRM
                  </a>
              </div>

              <ul class="nav">
                  <?php require_once "templates/menu.php" ;?>
              </ul>
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


          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-8">
                      <?php if (count($photos) > 0): ?>
                        <div class="container-fluid">
                            <div class="row">
                            <?php foreach ($photos as $key => $photo): ?>
                              <div class="col-md-3">
                                <div class="dropdown">
                                  <ul class="dropdown-menu photo-menu">
                                    <li><a href="#" data-val="1">Фронт</a></li>
                                    <li><a href="#" data-val="2">Бок</a></li>
                                    <li><a href="#" data-val="3">Спина</a></li>
                                    <li><a href="#" data-val="4">Лук</a></li>
                                    <li><a href="#" class="btn-danger" data-val="5">На удаление</a></li>
                                  </ul>
                                  <a href="javascript://" class="photo-status dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                                  <div class="photo" data-original="<?=$photo;?>">
                                    <img src="input/thumbs/<?= basename($photo)?>" />
                                  </div>
                                  <p class="text-center result"></p>
                                </div>
                              </div>
                            <?php endforeach;?>
                          </div>
                        </div>
                      <?php endif;?>
                    </div>
                    <div class="col-md-4">
                      <div class="nowphoto">
                        <!-- <img src="<?=$photo?>" /> -->
                      </div>
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
