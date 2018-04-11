<script type="text/x-template" id="local-appointmentstemplate__settings">
  <div>
    <local-appointmentsnavigation></local-appointmentsnavigation>
    <div class="app-wp__content">
      <el-row class="app-wp__content-header" align="middle" type="flex">
        <el-col :span="12">
          <h1><?php esc_html_e( 'Settings', 'app-wp' ) ?></h1>
        </el-col>
        <el-col :span="12" class="app-wp__text--right">
          n
        </el-col>
      </el-row>

      <el-form ref="form_settings" :model="form_settings" label-position="top">
        <el-form-item label="Currency" prop="name">
          <span slot="label">Currency:</span>
          <el-select placeholder="Choose Currency" v-model="form_settings.currency" filterable>
            <el-option v-for="curr in currencies" :value="curr.code" :label="curr.code + ' - ' + curr.name"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="<?php esc_attr_e( 'Currency Thoursands Separator', 'app-wp' ) ?>">
          <el-input v-model="form_settings.currency_thousands"></el-input>
        </el-form-item>
        <el-form-item label="<?php esc_attr_e( 'Currency Decimals Separator', 'app-wp' ) ?>">
          <el-input v-model="form_settings.currency_separator"></el-input>
        </el-form-item>
        <el-form-item label="<?php esc_attr_e( 'Currency Position', 'app-wp' ) ?>">
          <el-radio-group v-model="form_settings.currency_position" class="app-wp__form-edit-type__duration-radio">
            <el-radio-button :label="1">{{ '99' | currency( form_settings.currency, form_settings.currency_decimals, { thousandsSeparator: form_settings.currency_thousands, decimalSeparator: form_settings.currency_separator } ) }}</el-radio-button>
            <el-radio-button :label="2">{{ '99' | currency( form_settings.currency, form_settings.currency_decimals, { thousandsSeparator: form_settings.currency_thousands, decimalSeparator: form_settings.currency_separator, symbolOnLeft: false } ) }}</el-radio-button>
            <el-radio-button :label="3">{{ '99' | currency( form_settings.currency, form_settings.currency_decimals, { thousandsSeparator: form_settings.currency_thousands, decimalSeparator: form_settings.currency_separator, spaceBetweenAmountAndSymbol: true  } ) }}</el-radio-button>
            <el-radio-button :label="4">{{ '99' | currency( form_settings.currency, form_settings.currency_decimals, { thousandsSeparator: form_settings.currency_thousands, decimalSeparator: form_settings.currency_separator, spaceBetweenAmountAndSymbol: true, symbolOnLeft: false  } ) }}</el-radio-button>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="Currency" prop="name">
          <span slot="label">Currency Decimals:</span>
          <el-input-number v-model="form_settings.currency_decimals" :min="0" :max="4"></el-input-number>
        </el-form-item>
      </el-form>
    </div>
  </div>
</script>
