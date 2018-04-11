Vue.component('local-appointmentsshortcode-services', {
  props: [ 'atts' ],
  template: '#local-appointmentstemplate__component__shortcode-services',
  data: function(){
    var vm = this;
    return {
      loading: false,
      choose_service: true,
      choose_day: false,
      choose_time: false,
      choose_details: false,
      form: {
        service: {},
        day: '',
        time: 0
      },
      options: {}
    }
  },
  watch: {
    options: {
      handler: function(o){
        this.limit = o.days_limit;
      },
      deep: true
    }
  },
  mounted: function(){
    var vm = this;
    if( _.isEmpty( vm.options ) ) vm.getShortcodeOptions('free');
  },
  methods: {
    getShortcodeOptions: function( id ){
      var vm = this;
      vm.$http.get(
        window.local_appointments_locale.rest_api_base.shortcodes.services + id,
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
          console.log(response);
          if( response.status === 200 ){
            vm.options = vm.normalizeServicesShortcode(response.body);
          }
          vm.loading = false;

      }, function(response){
        vm.loading = false;
        //console.log(response);
      });
    },
    confirmTime: function(time, save){
      var vm = this;
      vm.confirm_time = time;
      if( save ){
        vm.form.time = time;
        vm.choose_time = false;
        vm.choose_details = true;
      }
    },
    openTime: function(day){
      var vm = this;
      vm.form.day = day.date;
      vm.choose_time = true;
      vm.choose_day = false;
    },
    backToServices: function(){
      var vm = this;
      vm.choose_service = true;
      vm.choose_day = false;
      vm.form.service = {};
    },
    backToDays: function(){
      var vm = this;
      vm.choose_service = false;
      vm.choose_day = true;
      vm.choose_time = false;
      vm.form.day = '';
    },
    openDay: function(service){
      var vm = this;
      vm.choose_service = false;
      vm.choose_day = true;
      vm.form.service = service;
    },
    openDetails: function(time){
      var vm = this;
      vm.choose_time = false;
      vm.choose_details = true;
      vm.form.time = time;
    },
    normalize: function(arr){
      return JSON.parse(JSON.stringify(arr));
    },
  }
});
