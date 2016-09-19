<?php

    // Create a Mongo conenction
    $mongo = new MongoClient("mongodb://localhost");

    // Choose the database and collection
    $db = $mongo->rcrm;

    $module = $_POST['module'];
    $result = array('ok'=>0);

    switch ($module) {
      case 'clients':
        $coll = $db->clients;
        $result = $coll->save(array(
            "name" => @$_POST['fio'],
            "email" => @$_POST['email'],
            "phone" => @$_POST['tel'],
            "status" => @$_POST['status']
        ));
        break;
      case 'workers':
        $coll = $db->workers;
        $result = $coll->save(array(
            "name" => @$_POST['fio'],
            "email" => @$_POST['email'],
            "phone" => @$_POST['tel'],
            "status" => @$_POST['status']
        ));
        break;
      case 'points':
        $coll = $db->points;
        $result = $coll->save(array(
            "title" => @$_POST['title'],
            "address" => @$_POST['address'],
            "worktime" => @$_POST['worktime'],
            "status" => @$_POST['status']
        ));
        break;
      case 'orders':
        $orders = $db->orders;
        $clients = $db->clients;
        $stock = $db->stock;

        if ($_POST['clientType'] == 2) {
          $content = array(
            'name' => @$_POST['new_fio'],
            'email' => @$_POST['new_email'],
            'phone' => @$_POST['new_tel'],
            'status' => 0
          );
          $result = $clients->save($content);
          $id = (string) $content['_id'];
        } else {
          $id = @$_POST['exist_id'];
        }

        $gadget = array(
          "type" => @$_POST['gadget_type'],
          "brand" => @$_POST['gadget_brand'],
          "model" => @$_POST['gadget_model'],
          "kit" => @$_POST['gadget_kit'],
          "health" => @$_POST['gadget_health']
        );

        $stock->save($gadget);
        $gadget_id = (string) $gadget['_id'];

        $result = $orders->save(array(
            "service" => @$_POST['service'],
            "comment" => @$_POST['comment'],
            "date" => date('d.m.y'),
            "status" => 0,
            "client_id" => new MongoId($id),
            "gadget_id" => new MongoId($gadget_id),
            "master_id" => 0
        ));



        break;
    }

    // $coll->save(array(
    //     "name" => "Jack Sparrow",
    //     "age" => 34,
    //     "occupation" => "Pirate"
    // ));

    // $coll->drop();
    header('Content-Type: application/json');
    print json_encode(array('result'=>$result));
