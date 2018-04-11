<script type="text/x-template" id="locapp-template__new-service">
  <div class="locapp--view locapp-sticky-header">
    <locapp-navigation></locapp-navigation>
    <div class="locapp-header">
      <el-row align="middle" type="flex">
        <el-col :span="6">
          <el-switch  v-if="form"
            v-model="form.status"
            active-text="<?php esc_attr_e( 'Published', 'local-appointments' ) ?>"
            inactive-text="<?php esc_attr_e( 'Draft', 'local-appointments' ) ?>"
            active-value="publish"
            inactive-value="draft">
          </el-switch>
        </el-col>
        <el-col :span="12">
          <h1 class="locapp-text--align-center" v-text=" id ? '<?php esc_attr_e( 'Edit Service', 'local-appointments' ) ?>' : '<?php esc_attr_e( 'New Service', 'local-appointments' ) ?>' "></h1>
        </el-col>
        <el-col :span="6" class="locapp-text--align-right">
          <el-button v-if="hasChanges()"v-on:click="reventChanges" type="text"><i class="fa far fa-undo-alt locapp-margin--right-05"></i><?php esc_attr_e( 'Revert Changes', 'local-appointments' ) ?></el-button>
          <el-button v-on:click="saveChanges" type="success" size="medium" round :disabled="!hasChanges()"><?php esc_attr_e( 'Save Changes', 'local-appointments' ) ?></el-button>
        </el-col>
      </el-row>
    </div>
    <div class="locapp-content" v-loading="loading">
      <el-row v-if="form">
        <el-col :span="14" :offset="5">
          <el-form ref="form" :model="form" label-position="top" class="local-appointments__form-edit-type">
            <h2><?php esc_attr_e( 'What kind of service is this?', 'local-appointments' ) ?></h2>
            <el-row :gutter="20">
              <el-col :span="19">
                <el-form-item>
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Service Name', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                  </template>
                  <el-input v-model="form.name" size="large" placeholder="<?php esc_attr_e( 'Enter service name here', 'local-appointments' ) ?>"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="5">
                <el-form-item>
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Service Price', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="form.price" size="large" :min="0" :max="20000" :step="0.1" controls-position="right" style="width: 100%"></el-input-number>
                </el-form-item>
              </el-col>
            </el-row>
            <el-form-item>
              <template slot="label">
                <el-tooltip placement="right">
                  <div slot="content">
                    Enter a name for your service.<br>This will be used to identify the service
                  </div>
                  <span><?php esc_attr_e( 'Service Tagline', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                </el-tooltip>
              </template>
              <el-input v-model="form.tagline" size="large" placeholder="<?php esc_attr_e( 'Enter service tagline here', 'local-appointments' ) ?>"></el-input>
            </el-form-item>
            <el-form-item>
              <template slot="label">
                <el-tooltip placement="right">
                  <div slot="content">
                    Enter a name for your service.<br>This will be used to identify the service
                  </div>
                  <span><?php esc_attr_e( 'Service Description', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                </el-tooltip>
              </template>
              <el-input type="textarea" v-model="form.description" :rows="4" placeholder="<?php esc_attr_e( 'Please describe what your service is about here', 'local-appointments' ) ?>"></el-input>
            </el-form-item>
            <el-form-item>
              <template slot="label">
                <el-tooltip placement="right">
                  <div slot="content">
                    Enter a name for your service.<br>This will be used to identify the service
                  </div>
                  <span><?php esc_attr_e( 'Service Color', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                </el-tooltip>
              </template>
              <i v-for="color in colors" v-on:click="form.color = color" class="fa fas fa-2x fa-circle" :class=" color === form.color ? 'selected' : ''" :style="'color:' + color"></i>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
      <hr class="locapp-margin--top-2 locapp-margin--bottom-3">
      <el-row v-if="form">
        <el-col :span="14" :offset="5">
          <el-form ref="form" :model="form" label-position="top" label-width="120px" class="local-appointments__form-edit-type">
            <h2><?php esc_attr_e( 'When can people book this service?', 'local-appointments' ) ?></h2>
            <el-form-item>
              <template slot="label">
                <el-tooltip placement="right">
                  <div slot="content">
                    Enter a name for your service.<br>This will be used to identify the service
                  </div>
                  <span><?php esc_attr_e( 'Service Duration', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                </el-tooltip>
              </template>
              <el-radio-group v-model="form.duration_type" class="local-appointments__form-edit-type__duration-radio">
                <el-radio-button label="15">15 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                <el-radio-button label="30">30 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                <el-radio-button label="45">45 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                <el-radio-button label="60">60 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                <el-radio-button label="90">90 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                <el-radio-button label="120">120 <br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
                <el-radio-button label="-1"><?php esc_attr_e( 'custom', 'local-appointments' ) ?><br><small><?php esc_attr_e( 'min', 'local-appointments' ) ?></small></el-radio-button>
              </el-radio-group>
              <el-slider v-if="form.duration_type == -1" v-model="form.duration" show-input class="locapp-margin--top-1" :min="2" :max="360"></el-slider>
            </el-form-item>
            <el-form-item>
              <template slot="label">
                <el-tooltip placement="right">
                  <div slot="content">
                    Enter a name for your service.<br>This will be used to identify the service
                  </div>
                  <span><?php esc_attr_e( 'Service Availability & Hours', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                </el-tooltip>
              </template>
              <p class="el-form-item__description"><?php esc_attr_e( 'Set your available hours when people can schedule meetings with you.', 'local-appointments' ) ?></p>
              <locapp-availability :color="form.color" v-model="form.availability"></locapp-availability>
            </el-form-item>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item>
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Time Padding Before Service', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                      <span class="locapp-pull--right">
                        <template v-if="form.padding.after === 0">
                          <?php esc_attr_e( '(none)', 'local-appointments' ) ?>
                        </template>
                        <template v-else>
                          {{form.padding.before|minToHours}}
                        </template>
                      </span>
                  </template>
                  <el-slider v-model="form.padding.before" :min="0" :max="360" :step="5"></el-slider>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item>
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Time Padding After Service', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                    <span class="locapp-pull--right">
                      <template v-if="form.padding.after === 0">
                        <?php esc_attr_e( '(none)', 'local-appointments' ) ?>
                      </template>
                      <template v-else>
                        {{form.padding.after|minToHours}}
                      </template>
                    </span>
                  </template>
                  <el-slider v-model="form.padding.after" :min="0" :max="360" :step="5"></el-slider>
                </el-form-item>
              </el-col>
            </el-row>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item>
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Service Availability Range', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                  </template>
                  <el-select placeholder="<?php esc_attr_e( 'Select rolling method', 'local-appointments' ) ?>" v-model="form.rolling_method">
                    <el-option :label="'<?php esc_attr_e( 'Over a period of ', 'local-appointments' ) ?>' + form.rolling_days + '<?php esc_attr_e( ' days', 'local-appointments' ) ?>'" :value="1"></el-option>
                    <el-option label="<?php esc_attr_e( 'Over a specific date range', 'local-appointments' ) ?>" :value="2"></el-option>
                    <el-option label="<?php esc_attr_e( 'Infinite', 'local-appointments' ) ?>" :value="3"></el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="6">
                <el-form-item v-if="form.rolling_method === 1">
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Days Upfront', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                  </template>
                  <el-input-number v-model="form.rolling_days" :min="1" :max="100" style="width: 100%"></el-input-number>
                </el-form-item>
                <el-form-item v-if="form.rolling_method === 2">
                  <template slot="label">
                    <el-tooltip placement="right">
                      <div slot="content">
                        Enter a name for your service.<br>This will be used to identify the service
                      </div>
                      <span><?php esc_attr_e( 'Date Range', 'local-appointments' ) ?> <i class="far fa-question-circle locapp-margin--left-05 locapp-info-icon"></i></span>
                    </el-tooltip>
                  </template>
                  <el-date-picker
                  v-model="form.rolling_date_range"
                  type="daterange"
                  range-separator="<?php esc_attr_e( 'To', 'local-appointments' ) ?>"
                  start-placeholder="<?php esc_attr_e( 'Start date', 'local-appointments' ) ?>"
                  end-placeholder="<?php esc_attr_e( 'End date', 'local-appointments' ) ?>">
                </el-date-picker>
                </el-form-item>
              </el-col>
            </el-row>
          </el-form>
        </el-col>
      </el-row>

    </div>
  </div>
</script>
