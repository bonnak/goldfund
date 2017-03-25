<template>
	<div>
	    <component :is="current_view" :data="data"
	    		@show-create="current_view = '_Create'"	      		
	    		@show-view="showView"
	    		@close-form="current_view = '_Table'">
	  	</component>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins'
import _Table from './Table.vue'
//import _Info from './Info.vue'

export default{
	
	mixins: [_mixin],
	
	components: {
		_Table,
		//_Info
	},

	data(){
		return {
			current_view : '_Table',
			data: null
		}
	},

	methods: {
		showInfoView(data){
			this.data = data;
			this.current_view = '_Info';
		}
	}
}
</script>