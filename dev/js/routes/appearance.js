var AppWpMixinsRoutesAppearance = {
  data: function(){
    var vm = this;
    return {
      form: {},
      form_witness: {},
      loading: false,
      form_builder: {
        service: {},
        day: moment().format(),
        time: 0
      },
      dialog_services: false,
      dialog_days: false,
      dialog_time: false,
      dialog_details: false,
      tabs_services: 'general',
      tabs_days: 'general',
      tabs_time: 'general',
      tabs_details: 'general',
    }
  },
  mounted: function(){
    var vm = this;

    vm.form = vm.normalize( vm.models.shortcodes.services );
    vm.form_witness = vm.normalize( vm.form );

    vm.getShortcodeOptions( 'free' );

    var sticky = new Waypoint.Sticky({
      element: jQuery('.locapp-sticky-header .locapp-header' ),
      offset: 30
    })

/*
    vm.loading = true;
    vm.getService();*/

  },
  computed: {
    selected_service: {
      get: function(){
        return _.isEmpty( this.form_builder.service ) ? ( this.$router.app.services ? this.$router.app.services[0] : {} ) : this.form_builder.service;
      },
      set: function(v){
        this.form_builder.service = this.normalize( v );
      }
    }
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
            vm.form = vm.normalizeServicesShortcode(response.body);
            vm.form_witness = vm.normalize(vm.form);
          }
          vm.loading = false;


      }, function(response){
        vm.loading = false;
        //console.log(response);
      });
    },
    saveChanges: function(){
      var vm = this;

      vm.loading = true;

      vm.$http.post(
        window.local_appointments_locale.rest_api_base.shortcodes.services + 'free',
        vm.form, {
        emulateJSON: true,
        headers: {
          'X-WP-Nonce' : window.local_appointments_locale.rest_nonce
        }
      }).then(function(response){
        console.log(response);
        if( response.status === 200 && response.body === true ){
          vm.form_witness = vm.normalize(vm.form);

          vm.$message({
            type: 'success',
            message: 'Appearance Saved succesfully'
          });
        }

        /* Error */
        else {
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
    hasChanges: function(){
      var vm = this;
      return !_.isEqual(vm.normalize( vm.form ), vm.form_witness);
    },
    reventChanges: function(){
      var vm = this;
      vm.form = vm.normalize( vm.form_witness );
    },
    addField: function(type){
      var vm = this;
      var field = {
        mandatory: false,
        allow_mandatory: true,
        allow_delete: true,
        status: true,
        label: '',
        type: type,
        value: ''
      };

      switch( type ){
        case 'text' : {
          field.label = "New Single Line Text Field";
          field.placeholder = "Enter Text here";
        } break;
        case 'textblock' : {
          field.label = "New Text Block Field";
          field.content = "Please add some text here.";
        } break;
        case 'date' : {
          field.label = "New Date Field";
          field.placeholder = "Enter Text here";
        } break;
        case 'textarea' : {
          field.label = "New Multiline Text Field";
          field.placeholder = "Enter Text here";
        } break;
        case 'checkbox' : {
          field.label = "New Checkbox Field";
          field.options = 'Check me',
          field.default = false;
        } break;
        case 'checkboxes' : {
          field.label = "New Checkboxes List Field";
          field.options = [ 'Option 1', 'Option 2','Option 3'];
          field.value = [];
        } break;
        case 'radio' : {
          field.label = "New Radio List Field";
          field.options = [ 'Option 1', 'Option 2','Option 3'];
        } break;
        case 'multiselect' : {
          field.label = "New Multi Select Field";
          field.options = [ 'Option 1', 'Option 2','Option 3'];
          field.placeholder = "Choose Options";
          field.value = [];
        } break;
        case 'select' : {
          field.label = "New Select Field";
          field.options = [ 'Option 1', 'Option 2','Option 3'];
          field.placeholder = "Choose option";
        } break;
      }
      vm.form.fields.push(field);
      vm.dialog_details = false;
    },
    updateFields: function(n){
      this.form.fields = n;
    },
    openDay: function(n){
      this.form_builder.service  = this.normalize( n );
    },
    openTime: function(n){
      console.log('sss', n);
      this.form_builder.day = n.date;
    },
    openDetails: function(n){
      this.form_builder.time = n;
    }
  }
}
