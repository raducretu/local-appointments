<script type="text/x-template" id="locapp-template__routes-global-navigation">
  <el-menu mode="horizontal" :router="true" class="locapp-navigation">
    <el-menu-item index="logo" disabled class="locapp-padding--left-0">
      <img src="<?php echo plugins_url('/local-appointments/assets/admin/svg/logo.svg'); ?>">
    </el-menu-item>
    <el-menu-item index="dashboard" :route="{name:'dashboard'}" :class="$route.path === '/' ? 'is-active' : ''">
      <?php esc_attr_e( 'Dashboard', 'local-appointments' ) ?>
    </el-menu-item>
    <el-menu-item index="services" :route="{name:'services'}"  :class="$route.path.indexOf( '/services' ) >= 0 ? 'is-active' : ''">
      <?php esc_attr_e( 'Services', 'local-appointments' ) ?>
    </el-menu-item>
    <el-menu-item index="appearance" :route="{name:'appearance'}" :class="$route.path === '/appearance' ? 'is-active' : ''">
      <?php esc_attr_e( 'Appearance', 'local-appointments' ) ?>
    </el-menu-item>
    <el-menu-item index="settings" :route="{name:'settings'}" :class="$route.path === '/settings' ? 'is-active' : ''"  class="locapp-pull--right locapp-padding--right-0">
      <i class="fa fa-cog"></i> <?php esc_attr_e( 'Settings', 'local-appointments' ) ?>
    </el-menu-item>

    <el-menu-item index="event-types" :route="{name:'services'}"  class="locapp-pull--right el-menu-item--gray">
      <i class="fa-book far"></i> <?php esc_attr_e( 'Documentation', 'local-appointments' ) ?>
    </el-menu-item>
    <el-menu-item index="event-types" :route="{name:'services'}"  class="locapp-pull--right el-menu-item--gray">
      <i class="fa-question-circle far"></i> <?php esc_attr_e( 'Support', 'local-appointments' ) ?>
    </el-menu-item>
  </el-menu>
</script>
