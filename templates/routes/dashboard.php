<script type="text/x-template" id="local-appointments-template__dashboard">
  <div>
    <locapp-navigation></locapp-navigation>
    <div class="locapp-header">
      <el-row align="middle" type="flex">
        <el-col :span="12">
            <h1><?php esc_html_e( 'My Appointments', 'app-wp' ) ?></h1>
        </el-col>
        <el-col :span="12" class="locapp-text--align-right">
          <el-dropdown>
            <span class="el-dropdown-link">
              All Upcoming<i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>All Past</el-dropdown-item>
              <el-dropdown-item>All Upcoming</el-dropdown-item>
              <el-dropdown-item>Today</el-dropdown-item>
              <el-dropdown-item>This Week</el-dropdown-item>
              <el-dropdown-item>This Month</el-dropdown-item>
              <el-dropdown-item>Custom Dates</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </el-col>
      </el-row>
    </div>
    <div class="locapp__dashboard__filters">
      <el-dropdown>
        <span class="el-dropdown-link">
          <strong>Filter by type:</strong> All Types Visible<i class="el-icon-arrow-down el-icon--right"></i>
        </span>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item>All Past</el-dropdown-item>
          <el-dropdown-item>All Upcoming</el-dropdown-item>
          <el-dropdown-item>Today</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
      &nbsp; &nbsp; &nbsp;
      <el-dropdown>
        <span class="el-dropdown-link">
          <strong>Filter by status:</strong> Only Active<i class="el-icon-arrow-down el-icon--right"></i>
        </span>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item>All Past</el-dropdown-item>
          <el-dropdown-item>All Upcoming</el-dropdown-item>
          <el-dropdown-item>Today</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
    <div class="locapp-content">

      <template v-for="(bookings, bookings_index) in bookings_by_day">
          <h2 v-if="typeof bookings[0] !== 'undefined'" class="app-wp__dashboard__bookings__day-title">{{ bookings[0].date | moment('dddd, MMMM DD, YYYY') }}</h2>
          <el-table :data="bookings" :show-header="true">
            <el-table-column prop="data" label="Starting Time">
              <template slot-scope="scope">
                <i class="fa fa-circle" :style="'color:' + scope.row.color"></i>
                {{ scope.row.date | moment('hh:mm a') }} - {{ scope.row.date | moment('hh:mm a') }}
              </template>
            </el-table-column>
            <el-table-column prop="title" label="Class">
              <template slot-scope="scope">
                <strong>{{scope.row.title}}</strong>
              </template>
            </el-table-column>
            <el-table-column prop="favoriteFruit" label="Room" sortable>
              <template slot-scope="scope">
                Room 1
              </template>
            </el-table-column>
            <el-table-column prop="favoriteFruit" label="Type" sortable>
              <template slot-scope="scope">
                Adults
              </template>
            </el-table-column>
            <el-table-column prop="title" width="160" label="Reserved">
              <template slot-scope="scope">
                <el-progress :percentage="getRandomInt(20,100)"></el-progress>
              </template>
            </el-table-column>
            <el-table-column type="expand">
              <template slot-scope="props">
                <el-table :data="orders" size="mini">
                  <el-table-column prop="name" label="Student" width="240" sortable>
                    <template slot-scope="scope">
                      <yg-avatar :image="scope.row.picture" :name="scope.row.name" :dot="scope.row.isActive" class="yg-m--right-1 yg-max--3"></yg-avatar>
                      <span class="yg-text--weight-400 yg-text--color-black">{{ scope.row.name}}</span>
                    </template>
                  </el-table-column>
                  <el-table-column prop="registered" label="Booking Date" sortable>
                    <template slot-scope="scope">
                      {{ scope.row.registered | moment( "YYYY-MM-DD @ HH:mm" )  }}
                    </template>
                  </el-table-column>
                  <el-table-column prop="gender" label="Status" align="center">
                    <template slot-scope="scope">
                      <el-tag size="mini" :type="scope.row.gender === 'male' ? 'success' : 'danger'" v-text="scope.row.gender === 'male' ? 'Accepted' : 'Canceled'"></el-tag>
                    </template>
                  </el-table-column>
                  <el-table-column prop="favoriteFruit" label="Plan" sortable>
                    <template slot-scope="scope">
                      <i class="fa fa-circle" :style="'color:' + scope.row.eyeColor"></i>
                      {{ scope.row.favoriteFruit}}
                    </template>
                  </el-table-column>
                  <el-table-column prop="registered" label="Plan Expire" sortable>
                    <template slot-scope="scope">
                      {{ scope.row.registered | momentToNow  }}
                    </template>
                  </el-table-column>
                </el-table>
              </template>
            </el-table-column>
          </el-table>
        </template>
    </div>
  </div>
</script>
