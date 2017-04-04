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
		    	<md-table-head>Question</md-table-head>
		    	<md-table-head>Answer</md-table-head>
		    	<md-table-head>Action</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in data_grid" :key="rowIndex" :md-item="el">
	    		<md-table-cell>{{ el.question }}</md-table-cell>
	    		<md-table-cell>{{ el.answer }}</md-table-cell>
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
import _mixin from '../../../core/mixins/table'

export default{

	mixins: [_mixin],

	data(){
		return {
			contentHtml : '<div></div>',
			canceling_data: null,
			approving_data: null
		}
	},

	computed: {
	    ...mapGetters({
	      data_grid: 'faq/data',
	      pagination: 'faq/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	mounted(){
	},

	methods:{
		...mapActions({
	  		fetchData: 'faq/fetchData',
	  	})
	}
}
</script>