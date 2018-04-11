Vue.component('locapp-shortcode-services-choose-details', {
  props: [ 'options', 'service', 'preview', 'day', 'time', 'fields' ],
  template: '#locapp-template__component__shortcode-services-choose-details',
  data: function(){
    var vm = this;
    return {
      loading: false,
      edit_field: {},
      edit_field_id: 0,
      dialog_edit_field: false
    }
  },
  methods: {
    openDay: function(service){
      this.$emit( 'service-selected', service );
    },
    editField: function(q, id){
      console.log(q, id);
      var vm = this;
      vm.edit_field = JSON.parse( JSON.stringify( q ) );
      vm.edit_field_id = parseInt( id );
      vm.dialog_edit_field = true;
    },
    saveField: function(){
      var vm = this;
      var out = JSON.parse( JSON.stringify( vm.fields ) );
      out[vm.edit_field_id] = JSON.parse( JSON.stringify( vm.edit_field ) );
      vm.$emit( 'fields-updated', out );
      vm.dialog_edit_field = false;
    },
    addOption: function(){
      var vm = this;
      vm.edit_field.options.push( 'Option ' + ( vm.edit_field.options.length + 1 ).toString() );
    },
    removeOption: function(id){
      var vm = this;
      vm.edit_field.options.splice(id,1);
    },
  }
});
