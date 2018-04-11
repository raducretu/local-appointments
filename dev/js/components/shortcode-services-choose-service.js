Vue.component('locapp-shortcode-services-choose-service', {
  props: [ 'options', 'preview' ],
  template: '#locapp-template__component__shortcode-services-choose-service',
  data: function(){
    var vm = this;
    return {
      loading: false,
      services: {}
    }
  },
  mounted: function(){
    var vm = this;
    if( _.isEmpty( vm.services ) ) vm.getServices();
  },
  computed: {
    classes: function(){
      var vm = this;
      return  'columns--' + vm.options['columns'];
    }
  },
  methods: {
    getServices: function(){
      var vm = this;
      vm.loading = true;
      vm.$http.get(
        window.local_appointments_locale.rest_api_base.services + '?per_page=100',
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
        vm.services = _.map( response.body, vm.normalizeService );
        vm.loading = false;
        if( ! _.isUndefined( vm.services[0] ) && vm.preview ) vm.$emit( 'service-selected', vm.services[0] );
      }, function(response){
        console.log(response);
        vm.loading = false;
      });
    },
    openDay: function(service){
      this.$emit( 'service-selected', service );
    },
  }
});
