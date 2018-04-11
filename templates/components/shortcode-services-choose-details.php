<script type="text/x-template" id="locapp-template__component__shortcode-services-choose-details">
  <div :class="preview ? 'loc-app-sc-services' : ''"  :data-preview="preview">
    <div v-if="service" class="loc-app-sc-services__details">
      <div class="loc-app-sc-services__details__summary">
        <h3><i :style="'color:' + service.color" class="fa fas fa-circle"></i>{{service.name}}</h3>
        {{day|moment('MMMM DD, YYYY')}} - {{time|toHours}}
        <br><br><br>
        <h4>{{service.tagline}}</h4>
        <p>{{service.description}}</p>

      </div>
      <div class="loc-app-sc-services__details__content">
        <template v-if="preview">
          <draggable v-model="fields" :options="{ handle: '.fa-ellipsis-v' }">
            <div v-for="(question, id) in fields"  :data-id="id" :key="id" class="app-wp__additional__form-questions__question" :class="question.status ? '' : 'app-wp__additional__form-questions__question--inactive' ">
                <i class="fa far fa-lg fa-ellipsis-v"></i>
                <i class="fa far fa-lg fa-edit" v-on:click="editField(question, id)"></i>

                <label class="app-wp__additional__form-questions__label">{{question.label}} <sup v-if="question.mandatory" class="fa far fa-asterisk" style="color: red; font-size: 60%"></sup></label>
                <div v-if="question.type === 'text'">
                  <el-input v-model="question.value" :placeholder="question.placeholder"></el-input>
                </div>
                <div v-if="question.type === 'textblock'" v-html="parseMarkdown(question.content)"></div>
                <div v-else-if="question.type === 'email'">
                  <el-input v-model="question.value" :placeholder="question.placeholder"></el-input>
                </div>
                <div v-else-if="question.type === 'textarea'">
                  <el-input type="textarea" v-model="question.value" :placeholder="question.placeholder" :rows="3"></el-input>
                </div>
                <div v-else-if="question.type === 'date'">
                  <el-date-picker v-model="question.value" type="date" :placeholder="question.placeholder"></el-date-picker>
                </div>
                <div v-else-if="question.type === 'checkbox'">
                  <el-checkbox v-model="question.value">{{question.options}}</el-checkbox>
                </div>
                <div v-else-if="question.type === 'checkboxes'">
                  <el-checkbox-group v-model="question.value">
                    <el-checkbox v-for="(option, option_key) in question.options" :key="option_key" :label="option">{{option}}</el-checkbox>
                  </el-checkbox-group>
                </div>
                <div v-else-if="question.type === 'radio'">
                  <el-radio v-model="question.value" v-for="(option, option_key) in question.options" :key="option_key" :label="option">{{option}}</el-radio>
                </div>
                <div v-else-if="question.type === 'multiselect'">
                   <el-select v-model="question.value" multiple :placeholder="question.placeholder">
                     <el-option
                       v-for="(item, item_id) in question.options"
                       :key="item_id"
                       :label="item"
                       :value="item">
                     </el-option>
                   </el-select>
                </div>
                <div v-else-if="question.type === 'select'">
                   <el-select v-model="question.value" :placeholder="question.placeholder">
                     <el-option
                       v-for="(item, item_id) in question.options"
                       :key="item_id"
                       :label="item"
                       :value="item">
                     </el-option>
                   </el-select>
                </div>

            </div>
          </draggable>
        </template>
        <template v-else>
          <div v-for="(question, id) in fields"  :data-id="id" :key="id" class="app-wp__additional__form-questions__question" :class="question.status ? '' : 'app-wp__additional__form-questions__question--inactive' ">

              <label class="app-wp__additional__form-questions__label">{{question.label}} <sup v-if="question.mandatory" class="fa far fa-asterisk" style="color: red; font-size: 60%"></sup></label>
              <div v-if="question.type === 'text'">
                <input v-model="question.value" :placeholder="question.placeholder"></input>
              </div>
              <div v-else-if="question.type === 'textblock'" v-html="parseMarkdown(question.content)"></div>
              <div v-else-if="question.type === 'email'">
                <input v-model="question.value" :placeholder="question.placeholder"></input>
              </div>
              <div v-else-if="question.type === 'textarea'">
                <el-input type="textarea" v-model="question.value" :placeholder="question.placeholder" :rows="3"></el-input>
              </div>
              <div v-else-if="question.type === 'date'">
                <el-date-picker v-model="question.value" type="date" :placeholder="question.placeholder"></el-date-picker>
              </div>
              <div v-else-if="question.type === 'checkbox'">
                <el-checkbox v-model="question.value">{{question.options}}</el-checkbox>
              </div>
              <div v-else-if="question.type === 'checkboxes'">
                <el-checkbox-group v-model="question.value">
                  <el-checkbox v-for="(option, option_key) in question.options" :key="option_key" :label="option">{{option}}</el-checkbox>
                </el-checkbox-group>
              </div>
              <div v-else-if="question.type === 'radio'">
                <el-radio v-model="question.value" v-for="(option, option_key) in question.options" :key="option_key" :label="option">{{option}}</el-radio>
              </div>
              <div v-else-if="question.type === 'multiselect'">
                 <el-select v-model="question.value" multiple :placeholder="question.placeholder">
                   <el-option
                     v-for="(item, item_id) in question.options"
                     :key="item_id"
                     :label="item"
                     :value="item">
                   </el-option>
                 </el-select>
              </div>
              <div v-else-if="question.type === 'select'">
                 <el-select v-model="question.value" :placeholder="question.placeholder">
                   <el-option
                     v-for="(item, item_id) in question.options"
                     :key="item_id"
                     :label="item"
                     :value="item">
                   </el-option>
                 </el-select>
              </div>

          </div>
        </template>
        <a href="#" class="loc-app-btn">Confirm Appointment</a>

      </div>
    </div>
    <el-dialog title="Edit Field" :visible.sync="dialog_edit_field" center custom-class="app-wp__modal-edit-availability">
      <template slot="title">
        <el-switch v-model="edit_field.status" style="position: absolute; left: 25px;top: 22px;" active-text="Visible" :disabled="!edit_field.allow_delete"></el-switch>
        <div class="el-dialog__title">Edit Field</div>
      </template>
      <div v-if="edit_field">
        <label class="app-wp__label">Field Label</label>
        <el-input v-model="edit_field.label" placeholder="Enter field label here"></el-input>
        <el-switch v-model="edit_field.mandatory" active-text="Mandatory" inactive-text="Optional" :disabled="!edit_field.allow_mandatory" class="local-appointments-pull-right local-appointmentsm--top-1"></el-switch>
        <label v-if="edit_field.placeholder" class="app-wp__label local-appointmentsm--top-3">Placeholder</label>
        <el-input v-if="edit_field.placeholder" v-model="edit_field.placeholder" placeholder="Enter field placeholder here"></el-input>

        <div v-if="edit_field.type === 'checkbox'">
          <label class="app-wp__label local-appointmentsm--top-3">Option Label</label>
          <el-input v-model="edit_field.options" placeholder="Enter field placeholder here"></el-input>
          <label class="app-wp__label local-appointmentsm--top-2">Default checked? <el-switch v-model="edit_field.default" active-text="Yes" inactive-text="No" class="local-appointmentsm--left-1"></el-switch></label>
        </div>

        <div v-if="edit_field.type === 'textblock'">
          <label class="app-wp__label local-appointmentsm--top-3">Text Block Content</label>
          <el-input  type="textarea" :rows="4" v-model="edit_field.content" placeholder="Enter field content here"></el-input>
        </div>

        <div v-if="edit_field.type === 'checkboxes' || edit_field.type === 'radio'">
          <label class="app-wp__label local-appointmentsm--top-3">Choices</label>
          <el-row v-for="(option, option_id) in edit_field.options" align="middle" type="flex" class="local-appointmentsm--bottom-05">
            <el-col :span="22"><el-input v-model="edit_field.options[option_id]" size="medium"></el-input></el-col>
            <el-col :span="2" class="app-wp__text--right"><i v-if="edit_field.options.length > 1" v-on:click="removeOption(option_id)" class="fa far fa-trash-alt"></i></el-col>
          </el-row>
          <el-button type="text" size="small" v-on:click="addOption">+ Add choice</el-button>
        </div>

        <div v-if="edit_field.type === 'multiselect' || edit_field.type === 'select'">
          <label class="app-wp__label local-appointmentsm--top-2">Choices</label>
          <el-row v-for="(option, option_id) in edit_field.options" align="middle" type="flex" class="local-appointmentsm--bottom-05">
            <el-col :span="22"><el-input v-model="edit_field.options[option_id]" size="medium"></el-input></el-col>
            <el-col :span="2" class="app-wp__text--right"><i v-if="edit_field.options.length > 1" v-on:click="removeOption(option_id)" class="fa far fa-trash-alt"></i></el-col>
          </el-row>
          <el-button type="text" size="small" v-on:click="addOption">+ Add choice</el-button>
        </div>


      </div>
      <div slot="footer" class="dialog-footer local-appointmentsm--top-2">
        <el-row>
          <el-col v-if="edit_field.allow_delete" :span="12" class="app-wp__text--left">
            <el-button type="danger" v-on:click="removeField()">Delete Field</el-button>
          </el-col>
          <el-col v-if="edit_field.allow_delete" :span="12" class="app-wp__text--right">
            <el-button type="primary" v-on:click="saveField()">Save Field</el-button>
          </el-col>
          <el-col v-else :span="24"><el-button type="primary" v-on:click="saveField()">Save Field</el-button></el-col>
        </el-row>
      </div>
    </el-dialog>
  </div>
</script>
