<template>
	<md-table-card>
    <md-table @select="onSelect" @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		      <md-table-head md-sort-by="username">Username</md-table-head>
		      <md-table-head>Email</md-table-head>
		      <md-table-head>Active</md-table-head>
		      <md-table-head>Created Date</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(data, rowIndex) in data_grid" :key="rowIndex" :md-item="data">
		      <md-table-cell>{{ data.username }}</md-table-cell>
		      <md-table-cell>{{ data.email }}</md-table-cell>
		      <md-table-cell>{{ data.is_active | isActive }}</md-table-cell>
		      <md-table-cell>{{ data.created_at }}</md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>
		<md-table-pagination v-if="pagination.per_page <= pagination.total"
	    :md-size="pagination.per_page"
	    :md-total="pagination.total"
	    :md-page="pagination.current_page"
	    :md-page-options="[5, 10, 25, 50]"
	    md-label="Per page"
	    @pagination="onPagination">
	  </md-table-pagination>
  </md-table-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import _mixin from '../../core/mixins/table'

export default{
	mixins: [_mixin],

	computed: {
	    ...mapGetters({
	      data_grid: 'user/data',
	      pagination: 'user/pagination'
	    })
	},

	created(){
		this.fetchData();
	},

	methods:{
		...mapActions({
  		fetchData: 'user/fetchData'
  	})
	}
}
</script>