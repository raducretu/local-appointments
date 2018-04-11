<script type="text/x-template" id="locaapp-template__appearance">
  <div class="locapp--view locapp-sticky-header">
    <locapp-navigation></locapp-navigation>
    <div class="locapp-header">
      <el-row align="middle" type="flex">
        <el-col :span="12">
          <h1><?php esc_html_e( 'Appearance', 'local-appointments' ) ?></h1>
        </el-col>
        <el-col :span="12" class="locapp-text--align-right">
          <el-button v-if="hasChanges()"v-on:click="reventChanges" type="text"><i class="fa far fa-undo-alt locapp-margin--right-05"></i><?php esc_attr_e( 'Revert Changes', 'local-appointments' ) ?></el-button>
          <el-button v-on:click="saveChanges" type="success" size="medium" round :disabled="!hasChanges()"><?php esc_attr_e( 'Save Changes', 'local-appointments' ) ?></el-button>
        </el-col>
      </el-row>
    </div>
    <div class="locapp-content" v-loading="loading">
        <el-row :gutter="60" type="flex" class="locapp-padding--bottom-4"  v-if="form.services">
          <el-col :span="17">
              <locapp-shortcode-services-choose-service
                :options="form.services"
                :preview="true"
                v-on:service-selected="openDay">
              </locapp-shortcode-services-choose-service>
          </el-col>
          <el-col :span="6" :offset="1">
            <h3><?php esc_attr_e( 'Services Panel', 'local-appointments' ) ?></h3>
            <p><?php esc_html_e( 'sdfsdf sdf sdf sdf sdf sd fs df sdf sd fs df sd f sdf sd fs df sd f sdfsdfsdfsd fsdfsdfsd fsdfsdfsd fsd', 'local-appointments' ) ?></p>
            <el-button type="primary" size="medium" @click="dialog_services = true"><i class="far fa-edit"></i> &nbsp;&nbsp; <?php esc_attr_e( 'Edit Settings', 'local-appointments' ) ?></el-button>
            <el-dialog title="<?php esc_attr_e( 'Services Options', 'local-appointments' )?>" :visible.sync="dialog_services" custom-class="el-dialog--large">
              <el-form ref="form" :model="form" label-position="left" label-width="200px">
                <el-tabs v-model="tabs_services">
                  <el-tab-pane label="<?php esc_attr_e( 'General Options', 'local-appointments' )?>" name="general">
                    <el-form-item label="<?php esc_attr_e( 'Tagline Visibility', 'local-appointments' ) ?>">
                      <el-switch v-model="form.services.show_tagline" active-text="<?php esc_attr_e( 'Visible', 'local-appointments' ) ?>" inactive-text="<?php esc_attr_e( 'Hidden', 'local-appointments' ) ?>"></el-switch>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Duration Visibility', 'local-appointments' ) ?>">
                      <el-switch v-model="form.services.show_duration" active-text="<?php esc_attr_e( 'Visible', 'local-appointments' ) ?>" inactive-text="<?php esc_attr_e( 'Hidden', 'local-appointments' ) ?>"></el-switch>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Price Visibility', 'local-appointments' ) ?>">
                      <el-switch v-model="form.services.show_price" active-text="<?php esc_attr_e( 'Visible', 'local-appointments' ) ?>" inactive-text="<?php esc_attr_e( 'Hidden', 'local-appointments' ) ?>"></el-switch>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Columns', 'local-appointments' ) ?>">
                      <el-input-number v-model="form.services.columns" :min="1" :max="2"></el-input-number>
                    </el-form-item>
                  </el-tab-pane>
                  <el-tab-pane label="Filtering" name="filters" disabled>
                  </el-tab-pane>
                </el-tabs>
              </el-form>
            </el-dialog>
          </el-col>
        </el-row>
        <hr>
        <el-row :gutter="60" type="flex"  class="locapp-padding--top-3 locapp-padding--bottom-4" v-if="form.days">
          <el-col :span="17">
            <locapp-shortcode-services-choose-day
              :options="form.days"
              :service="selected_service"
              :preview="true"
              v-on:day-selected="openTime">
            </locapp-shortcode-services-choose-day>
          </el-col>
          <el-col :span="6" :offset="1">
            <h3><?php esc_attr_e( 'Days Panel', 'local-appointments' ) ?></h3>
            <p><?php esc_html_e( 'sdfsdf sdf sdf sdf sdf sd fs df sdf sd fs df sd f sdf sd fs df sd f sdfsdfsdfsd fsdfsdfsd fsdfsdfsd fsd', 'local-appointments' ) ?></p>
            <el-button type="primary" @click="dialog_days = true" size="medium"><i class="far fa-edit"></i> &nbsp;&nbsp; <?php esc_attr_e( 'Edit Settings', 'local-appointments' ) ?></el-button>
            <el-dialog title="<?php esc_attr_e( 'Days Options', 'local-appointments' ) ?>" :visible.sync="dialog_days" custom-class="el-dialog--large">
              <el-form ref="form" :model="form" label-position="left" label-width="200px">
                <el-tabs v-model="tabs_days">
                  <el-tab-pane label="<?php esc_attr_e( 'General Options', 'local-appointments' ) ?>" name="general">
                    <el-form-item label="<?php esc_attr_e( 'Days limit', 'local-appointments' ) ?>">
                      <el-input-number v-model="form.days.days_limit" :min="2" :max="100"></el-input-number>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Columns', 'local-appointments' ) ?>">
                      <el-input-number v-model="form.days.columns" :min="1" :max="5"></el-input-number>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Back Label', 'local-appointments' ) ?>">
                      <el-input v-model="form.days.label_back"></el-input>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Available Label', 'local-appointments' ) ?>">
                      <el-input v-model="form.days.label_available"></el-input>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Select a Day Label', 'local-appointments' ) ?>">
                      <el-input v-model="form.days.label_select_day"></el-input>
                    </el-form-item>
                  </el-tab-pane>
                  <el-tab-pane label="<?php esc_attr_e( 'Filtering', 'local-appointments' ) ?>" name="filters">
                    <el-form-item label="<?php esc_attr_e( 'Days Filters', 'local-appointments' ) ?>">
                      <el-switch v-model="form.days.show_filters_days" active-text="<?php esc_attr_e( 'Visible', 'local-appointments' ) ?>" inactive-text="<?php esc_attr_e( 'Hidden', 'local-appointments' ) ?>"></el-switch>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Hours Filters', 'local-appointments' ) ?>">
                      <el-switch v-model="form.days.show_filters_hours" active-text="<?php esc_attr_e( 'Visible', 'local-appointments' ) ?>" inactive-text="<?php esc_attr_e( 'Hidden', 'local-appointments' ) ?>"></el-switch>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Starting Time Label', 'local-appointments' ) ?>">
                      <el-input v-model="form.days.label_starting"></el-input>
                    </el-form-item>
                    <el-form-item label="<?php esc_attr_e( 'Ending Time Label', 'local-appointments' ) ?>">
                      <el-input v-model="form.days.label_ending"></el-input>
                    </el-form-item>
                  </el-tab-pane>
                </el-tabs>
              </el-form>
            </el-dialog>
          </el-col>
        </el-row>
        <hr>
        <el-row :gutter="60" type="flex" class="locapp-padding--top-3 locapp-padding--bottom-4" v-if="form.time">
          <el-col  :span="17">
            <locapp-shortcode-services-choose-time
              :options="form.time"
              :service="selected_service"
              :preview="true"
              :day="form_builder.day"
              v-on:time-selected="openDetails">
            </locapp-shortcode-services-choose-time>
          </el-col>
          <el-col :span="6" :offset="1">
            <h3><?php esc_attr_e( 'Times Panel', 'local-appointments' ) ?></h3>
            <p><?php esc_html_e( 'sdfsdf sdf sdf sdf sdf sd fs df sdf sd fs df sd f sdf sd fs df sd f sdfsdfsdfsd fsdfsdfsd fsdfsdfsd fsd', 'local-appointments' ) ?></p>
            <el-button type="primary" @click="dialog_time = true" size="medium"><i class="fa fa-edit"></i> &nbsp;&nbsp; <?php esc_attr_e( 'Edit Settings', 'local-appointments' ) ?></el-button>
            <el-dialog title="<?php esc_attr_e( 'Days Options', 'local-appointments' ) ?>" :visible.sync="dialog_time" custom-class="el-dialog--large">
              <el-form ref="form" :model="form" label-position="left" label-width="200px">
                <el-tabs v-model="tabs_time">
                  <el-tab-pane label="<?php esc_attr_e( 'General Options', 'local-appointments' ) ?>" name="general">
                    <el-form-item label="<?php esc_attr_e( 'Service Duration', 'local-appointments' ) ?>">
                      <el-radio-group v-model="form.time.time_increments" class="app-wp__form-edit-type__duration-radio"  size="small">
                        <el-radio-button :label="5">5 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                        <el-radio-button :label="10">10 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                        <el-radio-button :label="15">15 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                        <el-radio-button :label="20">20 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                        <el-radio-button :label="30">30 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                        <el-radio-button :label="60">60 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                      </el-radio-group>
                    </el-form-item>
                      <br>
                      <el-switch v-model="form.time.show_noon" class="locapp-margin--right-1"></el-switch> <?php esc_attr_e( 'Show Noon', 'local-appointments' ) ?>
                  </el-tab-pane>
                  <el-tab-pane label="<?php esc_attr_e( 'Filtering', 'local-appointments' ) ?>" name="filters" disabled>
                  </el-tab-pane>
                </el-tabs>
              </el-form>
            </el-dialog>
          </el-col>
        </el-row>
        <hr>
        <el-row :gutter="60"  type="flex" class="locapp-padding--top-3 locapp-padding--bottom-4" v-if="form.details">
          <el-col :span="17">
            <locapp-shortcode-services-choose-details
              :options="form.details"
              :service="selected_service"
              :preview="true"
              :day="form_builder.day"
              :time="form_builder.time"
              :fields="form.details.fields"
              v-on:fields-updated="updateFields">
            </locapp-shortcode-services-choose-details>
          </el-col>
          <el-col :span="6" :offset="1">
            <h3><?php esc_attr_e( 'Services Panel', 'local-appointments' ) ?></h3>
            <p><?php esc_html_e( 'sdfsdf sdf sdf sdf sdf sd fs df sdf sd fs df sd f sdf sd fs df sd f sdfsdfsdfsd fsdfsdfsd fsdfsdfsd fsd', 'local-appointments' ) ?></p>
            <el-button type="primary" @click="dialog_details = true" size="medium"><i class="fa fa-edit"></i> &nbsp;&nbsp; <?php esc_attr_e( 'Edit Settings', 'local-appointments' ) ?></el-button>
            <el-dialog title="<?php esc_attr_e( 'Details Options', 'local-appointments' ) ?>" :visible.sync="dialog_details" custom-class="el-dialog--large">
              <el-form ref="form" :model="form" label-position="left" label-width="200px">
                <el-tabs v-model="tabs_details">
                  <el-tab-pane label="<?php esc_attr_e( 'Details Options', 'local-appointments' ) ?>" name="general">
                    sdfsdfsdf
                  </el-tab-pane>
                  <el-tab-pane label="<?php esc_attr_e( 'Add Field', 'local-appointments' ) ?>" name="filters">
                    <el-row :gutter="20" class="locapp-margin--bottom-1">
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('text')"><i class="fa far fa-text-width"></i> <?php esc_attr_e( 'Single Line Text', 'local-appointments' ) ?></el-button>
                      </el-col>
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('textarea')"><i class="fa far fa-paragraph"></i> <?php esc_attr_e( 'Multiline Text', 'local-appointments' ) ?></el-button>
                      </el-col>
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('date')"><i class="fa far fa-calendar-alt"></i> <?php esc_attr_e( 'Date', 'local-appointments' ) ?></el-button>
                      </el-col>
                    </el-row>
                    <el-row :gutter="20" class="locapp-margin--bottom-1">
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('checkbox')"><i class="fa far fa-check-square"></i> <?php esc_attr_e( 'Single Checkbox', 'local-appointments' ) ?></el-button>
                      </el-col>
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('checkboxes')"><i class="fa far fa-list"></i> <?php esc_attr_e( 'Checkbox List', 'local-appointments' ) ?></el-button>
                      </el-col>
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('radio')"><i class="fa far fa-dot-circle"></i> <?php esc_attr_e( 'Radio List', 'local-appointments' ) ?></el-button>
                      </el-col>
                    </el-row>
                    <el-row :gutter="20">
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('multiselect')"><i class="fa far fa-square"></i> <?php esc_attr_e( 'Multi Select', 'local-appointments' ) ?></el-button>
                      </el-col>
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('select')"><i class="fa far fa-angle-down"></i> <?php esc_attr_e( 'Single Select', 'local-appointments' ) ?></el-button>
                      </el-col>
                      <el-col :span="8">
                        <el-button type="info" class="el-button--block el-button--left" v-on:click="addField('textblock')"><i class="fa far fa-align-justify"></i> <?php esc_attr_e( 'Text Block', 'local-appointments' ) ?></el-button>
                      </el-col>
                    </el-row>
                  </el-tab-pane>
                </el-tabs>
              </el-form>
            </el-dialog>
          </el-col>
        </el-row>
    </div>
  </div>
</script>
