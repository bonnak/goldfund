<template>
	<div>
	    <component :is="current_view" :data="data"
	    		@show-create-view="current_view = '_Create'"	 
	    		@show-view-info="showInfoView"     		
	    		@show-edit-view="showEditView"
	    		@close-form-message="current_view = '_Table'">
	  	</component>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins'
import _Table from './Table.vue'

export default{

	mixins: [_mixin],

	components: {
		_Table
	},

	data(){
		return {
			current_view : '_Table',
			data: null
		}
	}
}
</script>