<script type="text/x-template" id="local-appointmentstemplate__notifications">
  <div>
    <local-appointmentsnavigation></local-appointmentsnavigation>
    <div class="app-wp__content">
      <el-row class="app-wp__content-header" align="middle" type="flex">
        <el-col :span="12">
          <h1><?php esc_html_e( 'Notifications', 'app-wp' ) ?></h1>
        </el-col>
        <el-col :span="12" class="app-wp__text--right">
          <el-button type="primary" size="medium" round plain v-on:click="routeTo( { name: 'new-notification' } )"><i class="fa fa-plus fas local-appointmentsm--right-05"></i> New Notification</el-button>
        </el-col>
      </el-row>
      <el-table :data="$router.app.notifications"  v-loading="loading">
        <el-table-column prop="name" label="Notification Name" sortable>
          <template slot-scope="scope">
             <router-link :to="{ name: 'notification', params: { id: scope.row.id, notification: scope.row } }">{{ scope.row.name}}</router-link>
          </template>
        </el-table-column>
        <el-table-column label="Trigger" align="center" header-align="center">
          <template slot-scope="scope">
            <el-tag>{{scope.row.trigger}}</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Type" align="center" header-align="center">
          <template slot-scope="scope">
            <el-tag><i class="fa far fa-envelope-open"></i></el-tag>
          </template>
        </el-table-column>
        <el-table-column align="right" width="80">
          <template slot-scope="scope">
            <el-dropdown :show-timeout="1" v-on:command="handleCommand">
                <span class="el-dropdown-link">
                  <i class="fa far fa-cog"></i> <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item :command="{notification:scope.row, method: 'edit'}"><i class="fa far fa-calendar-edit local-appointmentsm--right-05"></i> Edit</el-dropdown-item>
                  <el-dropdown-item  :command="{notification:scope.row, method: 'duplicate'}"><i class="fa far fa-copy local-appointmentsm--right-05"></i> Duplicate</el-dropdown-item>
                  <el-dropdown-item :command="{notification:scope.row, method: 'delete'}"><i class="fa far fa-trash-alt local-appointmentsm--right-05"></i> Delete</el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>
          </template>
        </el-table-column>
      </el-table>
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-sizes="[10, 20, 50, 100]"
        :page-size="perPage"
        layout="total, sizes, prev, pager, next"
        :total="$router.app.notifications_total"
        prev-text="Prev"
        next-text="Next"
        class="local-appointmentsm--top-1">
      </el-pagination>
    </div>
  </div>
</script>
