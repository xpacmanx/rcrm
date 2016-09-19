<?php header('Content-Type: text/html; charset=utf-8');?><html>
<head>
  <title>Заказы</title>
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
                      <a class="navbar-brand" href="/clients">Заказы</a>
                  </div>
              </div>
          </nav>
          <button type="button" class="btn"  data-toggle="modal" data-target="#addclient">Новый заказ</button>

          <?php

          $mongo = new MongoClient("mongodb://localhost");

          // Choose the database and collection
          $db = $mongo->rcrm;
          $coll = $db->orders;
          // $orders = $coll->find();
          $query = array(
            array(
              '$lookup' => array(
                  'from' => 'clients',
                  'localField' => 'client_id',
                  'foreignField' => '_id',
                  'as' => 'client'
              ),
            ),
            array(
              '$lookup' => array(
                  'from' => 'stock',
                  'localField' => 'gadget_id',
                  'foreignField' => '_id',
                  'as' => 'gadget'
              ),
            )
          );
          $type = @$_GET['type'];
          if (empty($type))
            $type = 0;
          if ($type == 0) {
            $query[] = array('$match' => array('status' => 0));
          } elseif ($type == 1) {
            $query[] = array('$match' => array('status' => 1));
          } elseif ($type == 2) {
            $query[] = array('$match' => array('status' => 2));
          } elseif ($type == 3) {
            $query[] = array('$match' => array('status' => 3));
          }
          $query[] = array('$limit' => 10);
          $orders = $coll->aggregate($query);
          $orders = $orders['result'];

          $status = array('Принят','Выполнение','Готов','Архив');
          $service = array('Ремонт');
          $gadgets = array('Смартфон');
          $health = array('Новый', 'Хорошее', 'Небольшие потертости', 'Незначительные повреждения', 'Разбит', 'Неремонтопригоден');

          ?>

          <div class="content">
              <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-12">
                      <ul class="sub-menu">
                        <li><a href="/orders" class="btn btn-primary">Новые</a></li>
                        <li><a href="/orders?type=1" class="btn">Обработка</a></li>
                        <li><a href="/orders?type=2" class="btn">Готовые</a></li>
                        <li><a href="/orders?type=3" class="btn">Архив</a></li>
                      </ul>
                      <?php if (count($orders) > 0): ?>
                        <table class="table table-striped">
                          <thead>
                            <th>
                              Дата поступления
                            </th>
                            <th>
                              Статус
                            </th>
                            <th>
                              Услуга
                            </th>
                            <th>
                              Устройство
                            </th>
                            <th>
                              Клиент
                            </th>
                            <th>
                              Мастер
                            </th>
                          </thead>
                          <tbody>
                          <?php foreach ($orders as $key => $order): ?>
                          <tr>
                            <td><?=$order['date'];?></td>
                            <td><?=$status[$order['status']];?></td>
                            <td><?=$service[$order['service']];?></td>
                            <td>
                              <?=$gadgets[$order['gadget'][0]['type']];?><br/>
                              <?=$order['gadget'][0]['brand'];?> <?=$order['gadget'][0]['model'];?>
                            </td>
                            <td>
                              <?=$order['client'][0]['name'];?>
                            </td>
                            <td>
                              <?php if (isset($order['master'][0]['fio'])):?>
                                <?=$order['master'][0]['fio'];?>
                                <?else:?>
                                <a href="#">Назначить мастера</a>
                              <?php endif;?>
                            </td>
                          </tr>
                          <?php endforeach;?>
                          </tbody>
                        </table>
                      <?php else:?>
                        <p class="text-center">Данных пока нет</p>
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
          <h4 class="modal-title" id="myModalLabel">Новый заказ</h4>
        </div>
        <div class="modal-body">
          <form class="ajax-submit" action="/ajax">
            <input type="hidden" name="module" value="orders" />

            <div class="form-group">
              <label for="fio">Услуга</label>
              <select name="service" class="form-control">
                <?php foreach ($service as $sk=>$s):?>
                  <option value="<?=$sk?>"><?=$s?></option>
                <?php endforeach;?>
              </select>
            </div>

            <div class="form-group">
              <label for="gadget_type">Устройство</label>
              <select class="form-control" name="gadget_type">
                <?php foreach ($gadgets as $gk => $g):?>
                  <option value="<?=$gk?>"><?=$g?></option>
                <?php endforeach;?>
              </select>
              <br/>
              <input type="text" class="form-control" id="brand" name="gadget_brand" placeholder="Производитель" /><br/>
              <input type="text" class="form-control" id="model" name="gadget_model" placeholder="Модель" />
            </div>
            <div class="form-group form-kit">
              <label>Комплект</label><br/>
              <span class="label label-default">Телефон</span>
              <span class="label label-default">ЗК</span>
              <span class="label label-default">Аккумулятор</span>
              <span class="label label-default">USB-провод</span>
              <span class="label label-default">ЗУ</span>
              <span class="label label-default">Гарантийный талон</span>
              <span class="label label-default">Коробка</span>
              <span class="label label-default">Чек</span>
              <input type="hidden" name="gadget_kit" value="" />
            </div>
            <div class="form-group">
              <label>Состояние</label><br/>
              <select class="form-control" name="gadget_health">
                <?php foreach ($health as $hk => $h):?>
                  <option value="<?=$hk?>"><?=$h?></option>
                <?php endforeach;?>
              </select><br/>
              <label>Комментарий</label><br/>
              <textarea class="form-control" name="comment" placeholder="Комментарий"></textarea>
            </div>

            <label class="radio">
              <input type="radio" data-toggle="radio" name="clientType" id="optionsRadios1" value="1" checked />
              Существующий клиент
            </label>
            <label class="radio">
              <input type="radio" data-toggle="radio" name="clientType" id="optionsRadios2" value="2" />
              Новый клиент
            </label>

            <div class="form-group user-exist">
                <select class="form-control" name="exist_id">
                  <?php
                  $coll2 = $db->clients;
                  $clients = $coll2->find();

                  foreach ($clients as $client): ?>
                  <option value="<?=$client['_id']?>"><?=$client['name']?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group user-new" style="display:none">
                <input type="text" name="new_fio" class="form-control" placeholder="ФИО" /><br/>
                <input type="text" name="new_email" class="form-control" placeholder="Email" /><br/>
                <input type="text" name="new_tel" class="form-control" placeholder="Номер телефона" />
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
