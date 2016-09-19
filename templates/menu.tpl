<div class="logo">
    <a href="/" class="simple-text">
        R-CRM
    </a>
</div>
<ul class="nav">
  <li<?php if ($_SERVER['REQUEST_URI'] == '/'):?> class="active"<?php endif;?>>
      <a href="/">
          <i class="pe-7s-edit"></i>
          <p>Панель управления</p>
      </a>
  </li>
  <li<?php if (strpos($_SERVER['REQUEST_URI'],'orders')):?> class="active"<?php endif;?>>
      <a href="/orders">
          <i class="pe-7s-ticket"></i>
          <p>Заказы</p>
      </a>
  </li>
  <li<?php if (strpos($_SERVER['REQUEST_URI'],'stock')):?> class="active"<?php endif;?>>
      <a href="/stock">
          <i class="pe-7s-box1"></i>
          <p>Склад</p>
      </a>
  </li>
  <li<?php if (strpos($_SERVER['REQUEST_URI'],'clients')):?> class="active"<?php endif;?>>
    <a href="/clients">
      <i class="pe-7s-users"></i>
      <p>Клиенты</p>
    </a>
  </li>
  <li<?php if (strpos($_SERVER['REQUEST_URI'],'workers')):?> class="active"<?php endif;?>>
      <a href="/workers">
          <i class="pe-7s-user"></i>
          <p>Персонал</p>
      </a>
  </li>
  <li<?php if (strpos($_SERVER['REQUEST_URI'],'points')):?> class="active"<?php endif;?>>
      <a href="/points">
          <i class="pe-7s-map-marker"></i>
          <p>Точки приёма</p>
      </a>
  </li>
  <li<?php if (strpos($_SERVER['REQUEST_URI'],'settings')):?> class="active"<?php endif;?>>
      <a href="/settings">
          <i class="pe-7s-edit"></i>
          <p>Настройки</p>
      </a>
  </li>
  <li class="active-pro">
      <a href="/drop">
          <i class="pe-7s-trash"></i>
          <p>Очистить базы</p>
      </a>
  </li>
</ul>
