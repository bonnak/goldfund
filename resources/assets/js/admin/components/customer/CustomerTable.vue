<template>
	<md-table-card>
    <md-table @select="onSelect" @sort="onSort">
		  <md-table-header>
		    <md-table-row>
		      <md-table-head>Surname</md-table-head>
		      <md-table-head>Given name</md-table-head>
		      <md-table-head>Gender</md-table-head>
		      <md-table-head>Date of birth</md-table-head>
		      <md-table-head>Sponsor</md-table-head>
		      <md-table-head>Created Date</md-table-head>
		    </md-table-row>
		  </md-table-header>

		  <md-table-body>
		    <md-table-row v-for="(el, rowIndex) in customers" :key="rowIndex" :md-item="el" md-selection>
		      <md-table-cell>{{ el.surname }}</md-table-cell>
		      <md-table-cell>{{ el.given_name }}</md-table-cell>
		      <md-table-cell>{{ el.gender }}</md-table-cell>
		      <md-table-cell>{{ el.date_of_birth }}</md-table-cell>
		      <md-table-cell>{{ el.sponsor_id }}</md-table-cell>
		      <md-table-cell>{{ el.created_at }}</md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>
		<md-table-pagination
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
import Api from '../../api/RestApi'

export default{
	data(){
		return{
			customers: [],
			pagination: {
				data : [],
				current_page : 1,
				from : 1, 
				last_page : 1,
				per_page : 1,
				to : 1,
				total : 0,				
				next_page_url : null,
				prev_page_url : null,
			}
		}
	},

	created(){
		this.loadData({ size : 5, page: 1});
	},

	mounted(){
	},

	methods:{
		loadData(pagination){
			Api.get('customers', pagination).then((response) => {	
				this.pagination.current_page = parseInt(response.data.current_page);
				this.pagination.from = parseInt(response.data.from);
				this.pagination.last_page = parseInt(response.data.last_page);
				this.pagination.per_page = parseInt(response.data.per_page);
				this.pagination.to = parseInt(response.data.to);
				this.pagination.total = parseInt(response.data.total);
				this.pagination.next_page_url = response.data.next_page_url;
				this.pagination.prev_page_url = response.data.prev_page_url;

				var data = response.data.data;

				this.customers.splice(0);

				data.forEach(el => {
					this.customers.push(el);
				});
			});
		},

		onSelect(data){
		 	console.log(data);
		},

		onSort(data){
		 	console.log(data);
		},

		onPagination(pagination){
			this.loadData(pagination);
		}
	}
}
</script>