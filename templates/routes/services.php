<script type="text/x-template" id="locapp-template__services">
  <div>
    <locapp-navigation></locapp-navigation>
    <div class="locapp-header">
      <el-row align="middle" type="flex">
        <el-col :span="12">
          <h1><?php esc_html_e( 'Services', 'local-appointments' ) ?></h1>
        </el-col>
        <el-col :span="12" class="locapp-text--align-right">
          <el-button type="success" size="medium" round plain v-on:click="routeTo( { name: 'new-service' } )"><i class="fa fa-plus fas locapp-margin--right-05"></i> New Service</el-button>
        </el-col>
      </el-row>
    </div>
    <div class="locapp-content">
      <el-row :gutter="30" v-loading="loading">
        <el-col v-for="service in services" :span="8" class="locapp-margin--bottom-2">
          <el-card shadow="hover">
            <div slot="header" class="clearfix">
              <i :style="'color:' + service.color" class="fa fas fa-circle fa-fw locapp-margin--right-05"></i>
              <router-link :to="{ name: 'service', params: { id: service.id, service: service } }">{{ service.name}}</router-link>
              <el-dropdown :show-timeout="1" class="locapp-pull--right" v-on:command="handleCommand" size="small">
                <span class="el-dropdown-link">
                  <i class="fa far fa-sliders-h"></i> <i class="el-icon-arrow-down el-icon--right"></i>
                </span>
                <el-dropdown-menu slot="dropdown">
                  <el-dropdown-item :command="{service:service, method: 'edit'}"><i class="fa far fa-fw fa-edit locapp-margin--right-05"></i> Edit</el-dropdown-item>
                  <el-dropdown-item><i class="fa far fa-fw fa-code locapp-margin--right-05"></i> Shortcode</el-dropdown-item>
                  <el-dropdown-item  :command="{service:service, method: 'duplicate'}"><i class="fa far fa-fw fa-copy locapp-margin--right-05"></i> Duplicate</el-dropdown-item>
                  <el-dropdown-item :command="{service:service, method: 'delete'}"><i class="fa far fa-fw fa-trash-alt locapp-margin--right-05"></i> Delete</el-dropdown-item>
                </el-dropdown-menu>
              </el-dropdown>
            </div>
            <el-row class="locapp-text--color-gray">
              <el-col :span="10">
                <i class="far fa-money-bill-alt fa-fw locapp-margin--right-05"></i> {{service.price | currency(currency_symbol, currency_decimals, currency_options)}}
              </el-col>
              <el-col :span="6">
                <i class="far fa-clock locapp-margin--right-05"></i> {{service.duration|minToHours}}
              </el-col>

              <el-col :span="8" class="locapp-text--align-right">
                <el-tag  :type=" service.status === 'draft' ? 'info' : 'success' " size="mini" v-text=" service.status === 'draft' ? 'Draft' : 'Published' "></el-tag>
              </el-col>
            </el-row>
          </el-card>
        </el-col>
      </el-row>
      <el-pagination v-if="total > 9"
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="perPage"
        layout="prev, pager, next"
        :total="total"
        prev-text="Prev"
        next-text="Next"
        class="locapp-margin--top-1">
      </el-pagination>
    </div>
  </div>
</script>
