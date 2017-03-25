<template>
	<div>
	    <component :is="current_view" :data="data"
	    		@show-create="current_view = '_Create'"	 
	    		@show-view="showInfoView"     		
	    		@show-edit="showEditView"
	    		@close-form="current_view = '_View'">
	  	</component>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins'
import _View from './View.vue'
import _Edit from './Edit.vue'

export default{

	mixins: [_mixin],

	components: {
		_View,
		_Edit
	},

	data(){
		return {
			current_view : '_View',
			data: null
		}
	},

	methods: {
		showEditView(data){
			this.data = data;
			this.current_view = '_Edit';
		}
	}
}
</script>