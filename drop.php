<?php

    // Create a Mongo conenction
    $mongo = new MongoClient("mongodb://localhost");

    // Choose the database and collection
    $db = $mongo->rcrm;
    $db->drop();

    header('Location: /');
