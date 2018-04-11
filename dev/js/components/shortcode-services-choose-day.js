Vue.component('locapp-shortcode-services-choose-day', {
  props: [ 'options', 'preview', 'service', 'options' ],
  template: '#locapp-template__component__shortcode-services-choose-day',
  data: function(){
    var vm = this;
    return {
      loading: false,
      filter_day: -1,
      filter_time_starting: 0,
      filter_time_ending: 1440,
      first_day: parseInt( window.local_appointments_locale.first_day ),
      today: moment().format('YYYY-MM-DD'),
      calendar_day: '',
      limit: vm.options.days_limit,
    }
  },
  mounted: function(){
    if( ! _.isUndefined( this.service ) ){
      this.setDefaultTimeFilters()
    }
  },
  watch: {
    service: function(n){
      var vm = this;
      vm.setDefaultTimeFilters();
      if( ! _.isUndefined( vm.days[0] ) && vm.preview ) vm.$emit( 'day-selected', vm.days[0] );
    }
  },
  computed: {
    classes: function(){
      var vm = this;
      return  'columns--' + vm.options['columns'];
    },
    week: function(){
      var vm = this;
			var week = [];
			for(var  $i = vm.first_day; $i < vm.first_day + 7; $i++ ){
				var $key = $i <= 6 ? $i : Math.abs( $i - 7 );
        if( vm.isWorkingDay( $key ) ) week.push($key);
			}
			return week;
    },
    services_min_time: function(){
      var vm = this;
      var min = 1441;
      if( ! _.isUndefined( vm.service.availability.days )  ){
        _.each( vm.service.availability.days, function(day){
          _.each( day, function(interval){
            min = interval[0] < min ? interval[0] : min;
          });
        });
      }
      return min;
    },
    services_max_time: function(){
      var vm = this;
      var max = -1;
      if( ! _.isUndefined( vm.service.availability.days )  ){
        _.each( vm.service.availability.days, function(day){
          _.each( day, function(interval){
            max = interval[1] < max ? max : interval[1];
          });
        });
      }
      return max;
    },
    filter_starting_times: function(){
      var vm = this;
      var out = [];
      var min = vm.services_min_time;
      var max = vm.services_max_time;
      for( var i = min; i <= max; i++ ){
        if( i % 60 === 0 ){
          out.push(i);
        }
      }
      return out;
    },
    filter_ending_times: function(){
      var vm = this;
      var out = [];
      var min = vm.services_min_time + vm.service.duration;
      var max = vm.services_max_time;
      for( var i = min; i <= max; i++ ){
        if( i % 60 === 0 ){
          out.push(i);
        }
      }
      return out;
    },
    days: function(){
      var vm = this;
			var days = [];
      var limit = vm.limit < vm.options.days_limit ? vm.options.days_limit : vm.limit;
      var service = vm.normalize( vm.service );
      var counter = 0;
      while( days.length < limit && counter <= 100 ){
        var print = true;
        var calendar_day = vm.today; //vm.calendar_day !== null && vm.calendar_day.length > 0 ? vm.calendar_day : vm.today;
        var m = moment(calendar_day).add( counter, 'days' );
        var day = moment(calendar_day).add( counter, 'days' ).isoWeekday().toString();

        if( vm.filter_day !== -1 && parseInt( vm.filter_day ) !== parseInt( day )  ){
          print = false;
        }
        if( print && ! _.isUndefined( service.availability.empty ) && service.availability.empty.indexOf( m.format('YYYY_MM_DD') ) >= 0 ){
          print = false;
        }
        if( print && ! _.isUndefined( service.availability.days ) && ! _.isUndefined( service.availability.days[day] )  ){

          _.each( service.availability.days[day], function(i){

            var min = i[0] < vm.filter_time_starting ? i[0] : vm.filter_time_starting;
            var max = i[1] > vm.filter_time_ending ? i[1] : vm.filter_time_ending;
            if( max - min > i[1] - i[0] + vm.filter_time_ending - vm.filter_time_starting  ){
              print = false;
            } else {
              print = true;
            }

          });

        } else {
          print = false;
        }

        if( print ){
          days.push({
            date: m.format('YYYY-MM-DD'),
            today: m.isSame( vm.today, 'day'),
            unavaiable: Math.random() >= 0.5
          });
        }

        counter++;

      }
			return _.sortBy( days, [ 'date' ] );
		}
  },
  methods: {
    setDefaultTimeFilters: function(){
      this.filter_time_starting = this.filter_starting_times[0];
      this.filter_time_ending = this.filter_ending_times[this.filter_ending_times.length-1];
    },
    isWorkingDay: function(d){
      var vm = this;
      var out = false;
      _.each( vm.service.availability.specific, function(o,k){
        if( moment( k.split('_').join('/') ).isoWeekday() === d ) out = true;
      });
      _.each( vm.service.availability.days, function(o,k){
        if( parseInt( k ) === d ) out = true;
      });
      return out;
    },
    selectDay: function(day){
      this.$emit( 'day-selected', day );
    },
    getDayName: function( day_num ){
			return window.local_appointments_locale.day_names[day_num];
		},
    showMore: function(){
      this.limit += this.options.days_limit;
    },
    openTime: function(day){
      var vm = this;
      vm.form.day = day.date;
      vm.choose_time = true;
      vm.choose_day = false;
    },
    getDayClasses: function(d){
      var vm = this;
      var out = '';
      if( d.unavaiable ) out += 'local-appointmentsshortcode-services__day--unavailable ';
      if( d.today ) out += 'local-appointmentsshortcode-services__day--today ';
      return out;
    },
    isSameMonth: function(day, k){
      var vm = this;
      if( _.isUndefined( vm.days[ k-1 ] ) || _.isUndefined( vm.days[ k-1 ].date ) ) return false;
      return !moment(day.date).isSame( moment(vm.days[k-1].date), 'month' );
    },
    backToServices: function(){
      var vm = this;
    },
  }
});
