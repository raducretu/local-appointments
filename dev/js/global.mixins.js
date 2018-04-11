Vue.mixin({
  data: function(){
    return{
      models: {
        service: {
          id: 0,
          status: 'publish',
          tagline: '',
          name: '',
          price: 0,
          description: '',
          color: '#EB2026',
          duration_type: 30,
          duration: 30,
          availability: {
            days: {
              1: [ [ 540, 1020 ] ],
              2: [ [ 540, 1020 ] ],
              3: [ [ 540, 1020 ] ],
              4: [ [ 540, 1020 ] ],
              5: [ [ 540, 1020 ] ],
            },
            specific: {},
            empty: []
          },
          padding: {
            before: 0,
            after: 0
          },
          rolling_method: 1,
          rolling_days: 40,
          rolling_date_range: [],
          capacity: 1,
        },
        notification: {
          id: 0,
          status: 'publish',
          name: '',
          type: 'email',
          trigger: 'booking_confirmation',
          system: false,
          subject: '',
          body: '',
          from_name: window.local_appointments_locale.current_user.name,
          from_email: window.local_appointments_locale.current_user.email,
          to: '{{invitee_email}}'
        },
        shortcodes: window.local_appointments_locale.models.shortcodes
      }
    }
  },
  computed: {
    date_format: function(){
      return window.local_appointments_locale.date_format;
    },
    currency_symbol: function(){
      return window.local_appointments_locale.currency_symbol;
    },
    currency_decimals: function(){
      return window.local_appointments_locale.currency_decimals;
    },
    currency_options: function(){
      return {
        thousandsSeparator: window.local_appointments_locale.currency_thousands,
        decimalSeparator: window.local_appointments_locale.currency_separator,
        symbolOnLeft: window.local_appointments_locale.currency_position === 1 || window.local_appointments_locale.currency_position === 3 ? false : true,
        spaceBetweenAmountAndSymbol: window.local_appointments_locale.currency_position === 2 || window.local_appointments_locale.currency_position === 4
      }
    }
  },
  methods: {
    normalizeServicesShortcode: function( o ){
      var vm = this;
      return _.pick(o, _.keys(vm.models.shortcodes.services));
    },
    normalizeNotification: function( o ){
      var vm = this;
      return _.pick(o, _.keys(vm.models.notification));
    },
    normalizeService: function( o ){
      var vm = this;
      return _.pick(o, _.keys(vm.models.service));
    },
    normalize: function(arr){
      return JSON.parse(JSON.stringify(arr));
    },
    getInitials: function(name){
      var vm = this;
      var out = '';
      if( typeof name === 'undefined' || name === null || name.length <= 1 ) return '';
      var words = name.split( ' ' );
      if( words.length > 1 ){
        words = words.slice(0,2);
        _.each( words, function(val, index){
          out += typeof val[0] !== 'undefined' ? val[0] : '';
        });
      } else{
        out = words[0].length > 1 ? words[0].substring(0,2) : words[0];
      }
      out.replace(' ', '');
      return out;
    },
  }
});
