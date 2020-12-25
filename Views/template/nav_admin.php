  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
          <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>images/uploads/cv.svg" alt="User Image">
                  <div>
                          <p class="app-sidebar__user-name">Karen Rodriguez</p>
                          <p class="app-sidebar__user-designation">Administrador</p>
                  </div>
          </div>
          <ul class="app-menu">
                  <li><a class="app-menu__item" href="<?= base_url(); ?>dashboard"><i class="app-menu__icon fa fa-dashboard"></i>
                                  <span class="app-menu__label">Dashboard</span></a></li>
                  <li><a class="app-menu__item" href="<?= base_url(); ?>usuarios"><i class="app-menu__icon fa fa-user"></i>
                                  <span class="app-menu__label">Usuarios</span></a></li>
                  <li><a class="app-menu__item" href="<?= base_url(); ?>proyectos"><i class="app-menu__icon fa fa-archive"></i>
                                  <span class="app-menu__label">Proyectos</span></a></li>
                  <li><a class="app-menu__item" href="<?= base_url(); ?>lenguajes"><i class="app-menu__icon fa fa-shopping-cart"></i>
                                  <span class="app-menu__label">Lenguajes</span></a></li>
                  <li><a class="app-menu__item" href="<?= base_url(); ?>articulos"><i class="app-menu__icon fa fa-sign-out"></i>
                                  <span class="app-menu__label">Articulos</span></a></li>
                  <li><a class="app-menu__item" href="<?= base_url(); ?>dashboard"><i class="app-menu__icon fa fa-file-code-o"></i>
                                  <span class="app-menu__label">Docs</span></a></li>

          </ul>
  </aside>