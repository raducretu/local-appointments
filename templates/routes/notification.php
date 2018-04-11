<script type="text/x-template" id="local-appointmentstemplate__new-notification">
  <div>
    <local-appointmentsnavigation></local-appointmentsnavigation>
    <div class="app-wp__content" v-loading="loading">
      <el-row class="app-wp__content-header" align="middle" type="flex">
        <el-col :span="6">
          <el-button type="info" size="mini" round plain v-on:click="routeTo( {name:'notifications'} )">
            <i class="fa fa-chevron-left far local-appointmentsm--right-05"></i><?php esc_attr_e( 'Notifications', 'app-wp' ) ?>
          </el-button>
        </el-col>
        <el-col :span="12">
          <h1 class="app-wp__text--center" v-text=" id ? '<?php esc_attr_e( 'Edit Notification', 'app-wp' ) ?>' : '<?php esc_attr_e( 'New Notification', 'app-wp' ) ?>' "></h1>
        </el-col>
        <el-col :span="6" class="app-wp__text--right">
          <el-switch  v-if="form"
            v-model="form.status"
            active-text="<?php esc_attr_e( 'Active', 'app-wp' ) ?>"
            inactive-text="<?php esc_attr_e( 'Inactive', 'app-wp' ) ?>"
            active-value="publish"
            inactive-value="draft">
          </el-switch>
        </el-col>
      </el-row>
      <el-row v-if="form" style="margin-bottom: 3rem; border-bottom: 2px solid #F2F2F2; padding-bottom: 4rem;">
        <el-col :span="14" :offset="5">
          <el-form ref="form" :model="form" label-position="top" class="app-wp__form-edit-type">
            <h2><?php esc_attr_e( 'What kind of notification is this?', 'app-wp' ) ?></h2>
            <el-form-item label="<?php esc_attr_e( 'Notification Name', 'app-wp' ) ?>">
              <el-input v-model="form.name" size="large" placeholder="<?php esc_attr_e( 'Enter notification name here', 'app-wp' ) ?>"></el-input>
            </el-form-item>
            <el-row :gutter="20">
              <el-col :span="16">
                <el-form-item label="<?php esc_attr_e( 'Notification Trigger', 'app-wp' ) ?>">
                  <el-select v-model="form.trigger">
                    <el-option label="Booking Confirmation" value="booking_confirmation"></el-option>
                    <el-option label="Booking Cancellation" value="booking_cancellation"></el-option>
                  </el-select>
                </el-form-item>

              </el-col>
              <el-col :span="8">
                <el-form-item label="<?php esc_attr_e( 'Notification Type', 'app-wp' ) ?>">
                  <el-radio-group v-model="form.type" class="app-wp__form-edit-type__duration-radio">
                    <el-radio-button label="email"><i class="fa far fa-envelope-open"></i></el-radio-button>
                    <el-radio-button label="sms" disabled><i class="fa far fa-comments"></i></el-radio-button>
                    <el-radio-button label="api" disabled><i class="fa far fa-code-branch"></i></el-radio-button>
                  </el-radio-group>
                </el-form-item>
              </el-col>
            </el-row>

          </el-form>
        </el-col>
        <el-col :span="14" :offset="5" v-if="hasChanges()" class="local-appointmentsm--top-2 local-appointmentsm--bottom-2 app-wp__text--right">
          <el-button v-on:click="reventChanges" type="text"><i class="fa far fa-undo-alt local-appointmentsm--right-05"></i>Revert Changes</el-button>
          <el-button v-on:click="saveChanges" type="success">Save Changes</el-button>
        </el-col>
      </el-row>

      <el-row v-if="form">
        <el-col :span="14" :offset="5">
          <el-form ref="form" :model="form" label-position="top" class="app-wp__form-edit-type">
            <h2><?php esc_attr_e( 'What is this email about?', 'app-wp' ) ?></h2>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="<?php esc_attr_e( 'From Name', 'app-wp' ) ?>">
                  <el-input v-model="form.from_name" size="large" placeholder="<?php esc_attr_e( 'Enter from name here', 'app-wp' ) ?>"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="<?php esc_attr_e( 'From Email', 'app-wp' ) ?>">
                  <el-input v-model="form.from_email" size="large" placeholder="<?php esc_attr_e( 'Enter from email here', 'app-wp' ) ?>"></el-input>
                </el-form-item>
              </el-col>
            </el-row>
            <el-form-item label="<?php esc_attr_e( 'Recipient', 'app-wp' ) ?>">
              <el-input v-model="form.to" size="large" placeholder="<?php esc_attr_e( 'Enter recipient email here', 'app-wp' ) ?>"></el-input>
            </el-form-item>
            <el-form-item label="<?php esc_attr_e( 'Subject', 'app-wp' ) ?>">
              <el-input v-model="form.subject" size="large" placeholder="<?php esc_attr_e( 'Enter subject here', 'app-wp' ) ?>"></el-input>
            </el-form-item>
            <el-form-item label="<?php esc_attr_e( 'Body', 'app-wp' ) ?>">
              <el-input type="textarea" :rows="10" v-model="form.body" size="large" placeholder="<?php esc_attr_e( 'Enter body here', 'app-wp' ) ?>"></el-input>
            </el-form-item>
            <el-button v-if="form.subject && form.body" size="mini" type="text" v-on:click="showEmailPreview()">Preview Email</el-button>
          </el-form>
        </el-col>
        <el-col :span="14" :offset="5" v-if="hasChanges()" class="local-appointmentsm--top-2 local-appointmentsm--bottom-2 app-wp__text--right">
          <el-button v-on:click="reventChanges" type="text"><i class="fa far fa-undo-alt local-appointmentsm--right-05"></i>Revert Changes</el-button>
          <el-button v-on:click="saveChanges" type="success">Save Changes</el-button>
        </el-col>
      </el-row>
    </div>

    <el-dialog :visible.sync="dialog_preview_email" v-if="_.size(preview_email) > 0" center custom-class="app-wp__modal-edit-availability">
      <template slot="title">
        <div class="el-dialog__title">Preview: {{preview_email.name}}</div>
      </template>
      <div class="app-wp__preview-email">
        <el-row align="middle" type="flex"  :gutter="20">
          <el-col :span="21">
            <h4>{{preview_email.from_name}} <{{preview_email.from_email}}> <small class="local-appointments-pull-right">{{preview_email.sent_date}}</small></h4>
            <div v-html="previewEmail(preview_email.subject)" class="app-wp__preview-email__subject"></div>
            To: {{preview_email.recipient}}
          </el-col>
          <el-col :span="3" class="app-wp__text--right"><div class="app-wp__preview-email__avatar" v-text="getInitials(preview_email.from_name)"></div></el-col>
        </el-row>
        <div v-html="previewEmail(preview_email.body)"></div>
      </div>
    </el-dialog>

  </div>
</script>
