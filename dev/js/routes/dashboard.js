var AppWpMixinsRoutesDashboard = {
  methods: {
    getRandomInt: function (min, max) {
      min = Math.ceil(min);
      max = Math.floor(max);
      return Math.floor(Math.random() * (max - min)) + min; //The maximum is exclusive and the minimum is inclusive
    }
  },
  computed: {
    bookings_by_day: function(){
      var vm = this;
      var days = {};
      vm.bookings = _.orderBy( vm.bookings, ['date'] );
      _.each( vm.bookings, function(val){
        var day_slug = moment(val.date).format('DD_MM_YYY');
        if( typeof days[day_slug] === 'undefined' ){
          days[day_slug] = [val];
        } else {
          days[day_slug].push(val);
        }
      });
      return _.values(days);
    }
  }
}
