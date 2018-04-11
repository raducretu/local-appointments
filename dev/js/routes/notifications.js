var AppWpMixinsRoutesNotifications = {
  data: function(){
    return {
      notifications: [],
      currentPage: 1,
      perPage: 10,
      total: 1000,
      loading: false,
    }
  },
  mounted: function(){
    var vm = this;
    if( vm.$router.app.notifications.length === 0 ) vm.getNotifications();
  },
  methods: {
    getNotifications: function(){
      var vm = this;
      vm.loading = true;
      vm.$http.get(
        window.local_appointments_locale.rest_api_base.notifications + '?status=any&page=' + vm.currentPage + "&per_page=" + vm.perPage,
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
        console.log(response);
        vm.$router.app.notifications = _.map( response.body, vm.normalizeNotification );
        vm.$router.app.notifications_total = parseInt( response.headers.map['x-wp-total'] );
        vm.loading = false;
      }, function(response){
        console.log(response);
        vm.loading = false;
      });
    },
    handleSizeChange: function(val) {
      var vm = this;
      vm.perPage = val;
      vm.getNotifications();
    },
    handleCurrentChange: function(val) {
      var vm = this;
      vm.getNotifications();
    },
    handleCommand: function(com){
      var vm = this;
      if( com.method === 'delete' ){
        vm.deleteNotification(com.notification.id);
      }
      else if( com.method === 'edit' ){
        vm.$router.push({ name: 'notification', params: { id: com.notification.id, notification: com.notification } });
      }
      else if( com.method === 'duplicate' ){
        var duplicate = _.filter( vm.notifications, function(o){
          return o.id === com.notification.id;
        });
        if( ! _.isUndefined( duplicate[0] ) ){
          delete duplicate[0].id;
          vm.duplicateNotification(duplicate[0]);
        }
      }
    },
    duplicateNotification: function(duplicate){
      var vm = this;
      vm.loading = true;
      vm.$http.post(
        window.local_appointments_locale.rest_api_base.notifications,
        duplicate, {
        emulateJSON: true,
        headers: {
          'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
        }
      }).then(function(response){
        console.log(response);
        if( response.status === 201 ){
          vm.$message({
            type: 'success',
            message: 'Service created succesfully'
          });
          vm.$router.app.notifications.unshift( response.body );
        } else {
          vm.$message({
            type: 'danger',
            message: 'Something went wrong. Please try again'
          });
        }
        vm.loading = false;
      }, function(response){
        vm.$message({
          type: 'danger',
          message: 'Something went wrong. Please try again'
        });
        vm.loading = false;
        console.log(response);
      });
    },
    deleteNotification: function(id){
      var vm = this;

      vm.$http.delete(
        window.local_appointments_locale.rest_api_base.notifications + id + '/?force=true',
        {
          emulateJSON: true,
          headers: {
            'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
          }
        }).then(function(response){
        console.log(response);
        if( response.status === 200 && response.body.deleted ){
          vm.getNotifications();
          vm.$message({
            type: 'success',
            message: 'Service deleted succesfully'
          });
        }
      }, function(response){
        console.log(response);
        vm.$message({
          type: 'danger',
          message: 'Could not delete service. Please try again'
        });
      });

    },
    handleSelectionChange: function(val) {
      this.multipleSelection = val;
    },
    routeTo: function(route){
      this.$router.push(route);
    }
  }
}
