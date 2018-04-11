Vue.component('locapp-shortcode-services-choose-time', {
  props: [ 'options', 'service', 'preview', 'day' ],
  template: '#locapp-template__component__shortcode-services-choose-time',
  data: function(){
    var vm = this;
    return {
      loading: false,
      confirm_time: false,
    }
  },
  computed: {
    times: function(){
      var vm = this;
      var times = [];
      var day_availability = ! _.isUndefined( vm.service.availability.days[ moment(vm.day).isoWeekday().toString() ] ) ? vm.service.availability.days[ moment(vm.day).isoWeekday().toString() ] : [];

      _.each(day_availability, function(o){
        for( var i = o[0]; i < o[1] - vm.service.duration; i++ ){
          if( i % vm.options.time_increments === 0 ){
            times.push(i);
          }
        }
      });
      return times;
    },
  },
  methods: {
    confirmTime: function(time, save){
      var vm = this;
      vm.confirm_time = time;
      if( save ){
        this.$emit( 'time-selected', time );
      }
    },
    clearConfirmation: function(e){
      this.confirm_time = false;
    },
    isSamePeriod: function(time, k){
      var vm = this;
      if( _.isUndefined( vm.times[ k-1 ] ) ) return false;
      return time / 60 >= 12 && vm.times[ k-1 ] / 60 < 12 ;
    },
    getTimeClasses: function(time){
      var vm = this;
      var out = '';
      if( vm.confirm_time !== false && vm.confirm_time !== time ){
        out += 'loc-app-sc-services__time--not-confirm';
      } else if( vm.confirm_time !== false && vm.confirm_time === time ){
        out += 'loc-app-sc-services__time--confirm';
      }
      return out;
    },
  }
});
