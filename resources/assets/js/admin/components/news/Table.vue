<template>
	<md-table-card>
		<md-layout md-gutter>
			<md-layout md-flex="10">
				<md-button class="md-raised md-primary" @click.native="showCreate">Create</md-button>
			</md-layout>
			<md-layout></md-layout>
		</md-layout>
    	<md-table>
		  <md-table-header>
		    <md-table-row>
		    	<md-table-head>Title</md-table-head>
		    	<md-table-head>Content</md-table-head>
		    	<md-table-head>Published</md-table-head>
		    	<md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in data_grid" :key="rowIndex" :md-item="el">
	    		<md-table-cell>{{ el.title }}</md-table-cell>
	    		<md-table-cell>{{ el.content | truncate(70)}}</md-table-cell>
	    		<md-table-cell>{{ el.published | isActive }}</md-table-cell>
		        <md-table-cell class="flex-end-action">
		        	<md-button 
		        		class="md-fab md-primary md-mini btn-action"
		        		@click.native="showEdit(el)">
					    	<i class="fa fa-pencil"></i>
					    	<md-tooltip md-direction="top">Edit</md-tooltip>
					</md-button>
		        </md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>

		<md-table-pagination v-if="pagination.per_page <= pagination.total"
			ref="pagination"
		    :md-size="pagination.per_page"
		    :md-total="pagination.total"
		    :md-page="pagination.current_page"
		    :md-page-options="[10, 50, 100]"
		    md-label="Per page"
		    @pagination="onPagination">
		</md-table-pagination>
  </md-table-card>
</template>

<script>
import _ from 'lodash'
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{

	mixins: [_mixin],

	computed: {
	    ...mapGetters({
	      data_grid: 'news/data',
	      pagination: 'news/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	mounted(){
	},

	methods:{
		...mapActions({
	  		fetchData: 'news/fetchData',
	  	})
	},

	filters: {  
	  	truncate: function(string, value) {
	    	return string.substring(0, value) + '...';
	    }  
	}
}
</script>