var AppWpMixinsRoutesSettings = {
  data: function(){
    var vm = this;
    return {
      form_settings: {
        currency: window.local_appointments_locale.currency,
        currency_position: 1,
        currency_decimals: window.local_appointments_locale.currency_decimals,
        currency_thousands: window.local_appointments_locale.currency_thousands,
        currency_separator: window.local_appointments_locale.currency_separator
      }
    }
  },
  watch:{
    form_settings: {
      handler: function(n){
        if( n.currency_thousands.length > 1 ){
          this.form_settings.currency_thousands = n.currency_thousands[1];
        }
        if( n.currency_separator.length > 1 ){
          this.form_settings.currency_separator = n.currency_separator[1];
        }
      },
      deep: true
    }
  },
  computed: {
    currencies: function(){
      return window.local_appointments_locale.currencies;
    }
  },
  mounted: function(){
    var vm = this;
  },

}
