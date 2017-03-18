<template>
	<div>
	    <component :is="current_view" :data="data"
	    		@show-create-view="current_view = '_Create'"	      		
	    		@show-view-info="showInfoView"
	    		@close-form-message="current_view = '_Table'">
	  	</component>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _Table from './Table.vue'
import _Info from './Info.vue'

export default{
	components: {
		_Table,
		_Info
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
		},

	 //  	...mapActions({
	 //  		clearStore: 'language/clearStore'
		// })
	},

	// beforeRouteLeave (to, from, next){
 //    	this.clearStore();
 //    	next();
	// }
}
</script>