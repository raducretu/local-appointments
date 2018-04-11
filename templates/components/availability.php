<script type="text/x-template" id="locapp-template__component__availability">
  <div class="locapp-availability">
    <el-row align="middle" type="flex" class="locapp-margin--left-1 locapp-margin--right-1">
      <el-col :span="4">
        <el-button-group>
          <el-button v-on:click="goPrev()" size="mini" :disabled="isPrevDisabled()"><i class="fa far fa-chevron-left"></i></el-button>
          <el-button v-on:click="goNext()" size="mini"><i class="fa far fa-chevron-right"></i></el-button>
          <el-button v-on:click="goToday()" size="mini" :disabled="isTodayThisMonth()"><?php esc_attr_e( 'Today', 'local-appointments' ) ?></el-button>
        </el-button-group>
      </el-col>
      <el-col :span="16">
        <h3 v-if="days && days[0] && days[0].date" class="locapp-text--align-center">{{ days[0].date | moment( date_format ) }} - {{ days[days.length-1].date | moment( date_format ) }}</h3>
      </el-col>
      <el-col :span="4"></el-col>
    </el-row>
    <div class="locapp-availability__week locapp-availability__header">
      <div v-for="day in week" v-html="getDayName(day)"  class="locapp-availability__day"></div>
    </div>
    <div v-for="weeks_count in Math.ceil( days.length / 7 )" class="locapp-availability__week">
      <div v-for="(day, day_key) in getWeek(weeks_count)" :key="day_key" class="locapp-availability__day" :class="getDayClasses(day)" v-on:click="editDay(day)">
        <small>{{day.date | moment( 'DD' ) }}</small>
        <div v-for="(slot, slot_key) in getDaySlots(day.date)" :key="slot_key" class="locapp-availability__slot" v-if="!day.past">
          <span>{{ slot[0] | toHours }}</span>
          <span>{{ slot[1] | toHours }}</span>
        </div>
      </div>
    </div>
    <el-dialog title="Edit Availability Intervals" :visible.sync="dialogVisible" center custom-class="locapp__modal-edit-availability" append-to-body>
      <div v-if="edit_day_slots.length === 0" class="locapp__modal-edit-availability__unavailable">
        <?php esc_attr_e( 'UNAVAILABLE', 'local-appointments' ) ?>
        <small><?php esc_attr_e( 'No availability intervals set', 'local-appointments' ) ?></small>
      </div>
      <div v-else>
        <div v-for="(slot, slot_key) in edit_day_slots" :key="slot_key">
          <el-row align="middle" type="flex">
            <el-col :span="8">
              <small><?php esc_attr_e( 'From ', 'local-appointments' ) ?></small><strong>{{ edit_day_slots[slot_key][0] | toHours }}</strong><small><?php esc_attr_e( ' to ', 'local-appointments' ) ?></small><strong>{{ edit_day_slots[slot_key][1] | toHours }}</strong>
            </el-col>
            <el-col :span="14">
              <el-slider v-model="edit_day_slots[slot_key]" range :min="0" :step="5" :max="1440" :format-tooltip="$options.filters.minToHours"></el-slider>
            </el-col>
            <el-col :span="2" class="locapp-text--align-right">
              <i class="fa fa-trash-alt far" v-on:click="deleteSlot(slot_key)"></i>
            </el-col>
          </el-row>
        </div>
      </div>
      <el-alert
        title="<?php esc_attr_e( 'Your Interevals are overlapping. ', 'local-appointments' ) ?>"
        type="error" class="locapp-margin--top-1 locapp-margin--bottom-2"
        v-if="!checkIntervals()"><?php esc_attr_e( 'Please correct this before saving.', 'local-appointments' ) ?>
      </el-alert>
      <div class="locapp-text--align-center locapp-margin--top-1">
        <el-button size="small" :disabled="!checkIntervals()" v-on:click="addInterval" type="success" round plain><i class="fa fa-plus fas locapp-margin--right-05"></i> <?php esc_attr_e( 'New interval', 'local-appointments' ) ?></el-button>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-row :gutter="20">
          <el-col :span="12"><el-button :disabled="!checkIntervals()" v-on:click="saveHours()" type="primary" style="display: block; width: 100%"><?php esc_attr_e( 'Apply to ', 'local-appointments' ) ?>{{ edit_day | moment('MMMM D') }} <?php esc_attr_e( 'only', 'local-appointments' ) ?></el-button></el-col>
          <el-col :span="12"><el-button :disabled="!checkIntervals()" v-on:click="saveHours(true)" type="primary" style="display: block; width: 100%"><?php esc_attr_e( 'Apply to all ', 'local-appointments' ) ?>{{ edit_day | moment('dddd') }}</el-button></el-col>
        </el-row>
      </div>
    </el-dialog>
  </div>
</script>
