<script type="text/x-template" id="locapp-template__component__shortcode-services-choose-service">
  <div :class="preview ? 'loc-app-sc-services' : ''"  :data-preview="preview">
    <div class="loc-app-sc-services__services-list loc-app-sc-services__services-list--default" :class="classes">
      <div v-for="service in services" class="loc-app-sc-services__service" v-on:click="openDay(service)">
        <div class="loc-app-sc-services__service__content" :style="'border-color:' + service.color" >
          <h3>{{service.name}}</h3>
          <p v-if="options.show_tagline" v-text="service.tagline"></p>
          <span v-if="options.show_duration" class="loc-app-sc-services__service__duration">{{service.duration | minToHours}}</span>
          <span v-if="options.show_price">{{service.price | currency( currency_symbol, currency_decimals, currency_options ) }}</span>
        </div>
      </div>
    </div>
  </div>
</script>
