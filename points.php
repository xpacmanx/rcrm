<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title>Точки приёма</title>
  <?php require_once "templates/scripts.tpl";?>
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
                      <a class="navbar-brand" href="/points">Точки приёма</a>
                  </div>
              </div>
          </nav>
          <button type="button" class="btn"  data-toggle="modal" data-target="#addclient">Новый точка приёма</button>

          <?php

          $mongo = new MongoClient("mongodb://localhost");

          // Choose the database and collection
          $db = $mongo->rcrm;
          $coll = $db->points;
          $points = $coll->find();
          $status = array('Работает', 'Не работает');
          ?>

          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <?php if (count($points) > 0): ?>
                        <table class="table table-striped">
                          <thead>
                            <th>
                              Название
                            </th>
                            <th>
                              Адрес
                            </th>
                            <th>
                              Время работы
                            </th>
                            <th>
                              Статус
                            </th>
                          </thead>
                          <tbody>
                          <?php foreach ($points as $key => $point): ?>
                          <tr>
                            <td><?=$point['title'];?></td>
                            <td><?=$point['address'];?></td>
                            <td><?=$point['worktime'];?></td>
                            <td><?=$status[$point['status']];?></td>
                          </tr>
                          <?php endforeach;?>
                          </tbody>
                        </table>
                      <?php else:?>
                        <p class="text-center">Пока отсутствуют</p>
                      <?php endif;?>
                    </div>
                  </div>
              </div>
          </div>

      </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addclient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Новый работник</h4>
        </div>
        <div class="modal-body">
          <form class="ajax-submit" action="/ajax">
            <input type="hidden" name="module" value="points">
            <div class="form-group">
              <label for="fio">Название</label>
              <input type="text" class="form-control" name="title" id="fio" placeholder="Название" /><br/>
              <label for="tel">Адрес</label>
              <input type="address" class="form-control" id="tel" name="address" placeholder="Адрес" /><br/>
              <label for="email">Время работы</label>
              <input type="title" class="form-control" id="email" name="worktime" placeholder="Время работы" /><br/>
              <label>Работает</label><br/>
              <select class="form-control" name="status">
                <?php foreach ($status as $sk => $s):?>
                  <option value="<?=$sk?>"><?=$s?></option>
                <?php endforeach;?>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
          <button type="button" class="btn btn-success btn-ajax-submit">Добавить</button>
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

      <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
  	<script src="assets/js/light-bootstrap-dashboard.js"></script>

    <script src="assets/js/scripts.js"></script>


</body>
</html>
