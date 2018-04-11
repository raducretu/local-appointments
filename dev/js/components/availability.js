Vue.component('locapp-availability', {
  template: '#locapp-template__component__availability',
  props: {
    color: '',
    value: {}
  },
  watch: {
    value: function(newVal){
      this.schedule = newVal;
    },
    color: function(newVal, oldVal){
      var vm = this;
    }
  },
  data: function(){
    var vm = this;
    return {
      first_day: parseInt( window.local_appointments_locale.first_day ),
      today: moment().format('YYYY-MM-DD'),
      calendar_days: [],
      calendar_day: moment().format('YYYY-MM-DD'),
      schedule: vm.normalize( vm.value ),
      dialogVisible: false,
      edit_day: moment().format('YYYY-MM-DD'),
      edit_day_slots: []
    }
  },
  computed: {
    week: function(){
      var vm = this;
			var week = [];
			for(var  $i = vm.first_day; $i < vm.first_day + 7; $i++ ){
				var $key = $i <= 6 ? $i : Math.abs( $i - 7 );
        week.push($key);
			}
			return week;
    },
    days: function(){
      var vm = this;
			var days = [];

			var firstDayLocale = vm.first_day === 0 ? 7 : vm.first_day;

			var subtract = Math.abs( ( firstDayLocale - 7  -  moment(vm.calendar_day).startOf('week').isoWeekday() ) % 7 );

			var add = firstDayLocale === moment(vm.calendar_day).endOf('week').isoWeekday() ? 6 : Math.abs( 7 - moment(vm.calendar_day).endOf('week').isoWeekday() ) ;

			var firstDay = moment(vm.calendar_day).startOf('week').subtract( -1, 'days');
			var lastDay = moment(vm.calendar_day).add(28, 'days').endOf('week').add( add-1, 'days' );

			for (var m = moment(firstDay); m.diff(lastDay, 'days') <= 0; m.add(1, 'days')) {
			  days.push({
					date : m.format('YYYY-MM-DD'),
					past : moment(moment(vm.today).format('YYYY-MM-DD')).isAfter(m.format('YYYY-MM-DD'), 'day'),
					future : moment(m.format('YYYY-MM-DD')).isAfter(moment(vm.today).endOf('month').format('YYYY-MM-DD'), 'day'),
					today: m.isSame( vm.today, 'day')
				});
			}
			return _.sortBy( days, [ 'date' ] );
		},
  },
  methods: {
    isPrevDisabled: function(){
      return !moment( this.today ).isBefore( this.calendar_day );
    },
    goToday: function(){
      this.calendar_day = this.today;
    },
    isTodayThisMonth: function(){
      return moment(this.today).isSame(this.calendar_day, 'month');
    },
    goNext: function(){
      var vm = this;
      vm.calendar_day = moment(vm.calendar_day).add(35, 'days').format('YYYY-MM-DD');
    },
    goPrev: function(){
      var vm = this;
      vm.calendar_day = moment(vm.calendar_day).subtract(35,'days').format('YYYY-MM-DD');
    },
    addInterval: function(){
      var vm = this;
      vm.edit_day_slots.push([1020, 1200]);
    },
    normalize: function(arr){
      return JSON.parse(JSON.stringify(arr));
    },
    deleteSlot: function(slot){
      var vm = this;
      vm.edit_day_slots.splice(slot, 1);
    },
    editDay: function(day){
      var vm = this;
      var key = moment( day.date ).format('YYYY_MM_DD');
      if( ! _.isUndefined( vm.schedule.empty ) && ! _.isUndefined( vm.schedule.empty ) && vm.schedule.empty.indexOf( key ) >= 0 ){
        vm.edit_day_slots = [];
      }

      else if( ! _.isUndefined( vm.schedule.specific ) && ! _.isUndefined( vm.schedule.specific[key] ) ){
        vm.edit_day_slots = vm.normalize(vm.schedule.specific[key]);
      }

      else if( ! _.isUndefined( vm.schedule.days[moment(day.date).isoWeekday()] ) ){
        vm.edit_day_slots = vm.normalize( vm.schedule.days[moment(day.date).isoWeekday()] );
      }

      else{
        vm.edit_day_slots = [];
      }
      vm.edit_day = day.date;
      vm.dialogVisible = true;
    },
    getWeek: function(count){
      var vm = this;
      var days_new = JSON.parse( JSON.stringify( vm.days ) );
      return days_new.splice( (count - 1) * 7 , 7 );
    },
    getDayClasses: function(day){
      var vm = this;
      var out = '';
      if( day.past === true ){
        out += 'locapp-availability__day--past ';
      }
      if( day.today === true ){
        out += 'locapp-availability__day--today ';
      }
      if( ! day.past ){
        out += 'locapp-availability__day--selectable ';
      }
      return out;
    },
    getDaySlots: function(date){
      var vm = this;
      var slot = false;
      var out = [];
      var key = moment(date).format('YYYY_MM_DD');
      if( ! _.isUndefined( vm.schedule.empty ) && ! _.isUndefined( vm.schedule.empty ) && vm.schedule.empty.indexOf( key ) >= 0 ){
        return [];
      }
      if( ! _.isUndefined( vm.schedule.specific ) && ! _.isUndefined( vm.schedule.specific[key] ) ){
        return vm.schedule.specific[key];
      }
      if( ! _.isUndefined( vm.schedule.days[ moment(date).isoWeekday() ] ) ){
        out = vm.schedule.days[ moment(date).isoWeekday() ]
      }
      return out;
    },
    getDayName: function( day_num ){
			return window.local_appointments_locale.day_names_short[day_num];
		},
    normalize: function(n){
      return JSON.parse( JSON.stringify( n ) );
    },
    saveHours: function( all ){
      var vm = this;

      if( all === true ){

        var conflicts = [];

        if( ! _.isUndefined( vm.schedule.specific ) ){
          _.each( vm.schedule.specific, function(o,k){
            if( moment( k.split('_').join('/') ).format('d') === moment( vm.edit_day ).format('d') ){
              conflicts.push(k);
            }
          });
        }

        if( ! _.isUndefined( vm.schedule.empty ) ){
          _.each( vm.schedule.empty, function(o){
            if( moment( o.split('_').join('/') ).format('d') === moment( vm.edit_day ).format('d') ){
              conflicts.push(o);
            }
          });
        }

        if( conflicts.length > 0 ){

          vm.$confirm('This will permanently delete the file. Continue?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning'
          }).then(function(r){
            _.each(conflicts, function(conflict){
              if( ! _.isUndefined( vm.schedule.specific ) ){
                vm.schedule.specific = _.remove( vm.schedule.specific, function(date){
                  return date === conflict;
                });
              }
              if( ! _.isUndefined( vm.schedule.empty ) && vm.schedule.empty.indexOf( conflict ) >= 0 ){
                vm.schedule.empty.splice( vm.schedule.empty.indexOf( conflict ), 1);
              }
            });
            vm.schedule.days[moment( vm.edit_day ).format('d')] = vm.normalize(vm.edit_day_slots);
            vm.dialogVisible = false;
            vm.$emit( 'input', vm.normalize( vm.schedule ) );

            vm.$message({
              type: 'success',
              message: 'Delete completed'
            });

          }).catch(function(){
            vm.$message({
              type: 'info',
              message: 'Delete canceled'
            });
          });
        } else {
          vm.schedule.days[moment( vm.edit_day ).format('d')] = vm.normalize(vm.edit_day_slots);
          vm.dialogVisible = false;
          vm.$emit( 'input', vm.normalize( vm.schedule ) );
        }


      }

      /* Save Single Day */
      else {

        if( _.isEmpty( vm.edit_day_slots ) ){
          vm.schedule.empty = [ moment( vm.edit_day ).format('YYYY_MM_DD') ];
        } else {
          if( _.isUndefined( vm.schedule.specific ) ){
             vm.schedule.specific = {};
          }
          vm.schedule.specific[ moment( vm.edit_day ).format('YYYY_MM_DD') ] = vm.normalize(vm.edit_day_slots);
        }

        vm.$emit( 'input', vm.normalize( vm.schedule ) );
        vm.dialogVisible = false;
      }
    },
    checkIntervals: function(){
      var vm = this;
      var out = true;
      var min = 0;
      var max = 0;
      if( vm.edit_day_slots.length > 1 ){
        _.each( vm.edit_day_slots, function(o,i){
          _.each(vm.edit_day_slots, function(oo,ii){
            if( i !== ii ){
              min = o[0] < oo[0] ? o[0] : oo[0];
              max = o[1] >= oo[1] ? o[1] : oo[1];
              if( max - min < o[1] - o[0] + oo[1] - oo[0] ){
                out = false;
              }
            }

          });
        });
      }
      return out;
    }
  }
})
