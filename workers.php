<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title>Персонал</title>
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
                      <a class="navbar-brand" href="/workers">Персонал</a>
                  </div>
              </div>
          </nav>
          <button type="button" class="btn"  data-toggle="modal" data-target="#addclient">Новый работник</button>

          <?php

          $mongo = new MongoClient("mongodb://localhost");

          // Choose the database and collection
          $db = $mongo->rcrm;
          $coll = $db->workers;
          $workers = $coll->find();
          $status = array('Мастер', 'Администратор');
          ?>

          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <?php if (count($workers) > 0): ?>
                        <table class="table table-striped">
                          <thead>
                            <th>
                              ФИО
                            </th>
                            <th>
                              Email
                            </th>
                            <th>
                              Телефон
                            </th>
                            <th>
                              Статус
                            </th>
                          </thead>
                          <tbody>
                          <?php foreach ($workers as $key => $work): ?>
                          <tr>
                            <td><?=$work['name'];?></td>
                            <td><?=$work['email'];?></td>
                            <td><?=$work['phone'];?></td>
                            <td><?=$status[$work['status']];?></td>
                          </tr>
                          <?php endforeach;?>
                          </tbody>
                        </table>

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
            <input type="hidden" name="module" value="workers">
            <div class="form-group">
              <label for="fio">ФИО</label>
              <input type="text" class="form-control" name="fio" id="fio" placeholder="ФИО" /><br/>
              <label for="tel">Контактный номер</label>
              <input type="tel" class="form-control" id="tel" name="tel" placeholder="+7(999)000-00-00" /><br/>
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" /><br/>
              <label>Должность</label><br/>
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
