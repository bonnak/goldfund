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
		    <md-table-row v-for="(user, rowIndex) in users" :key="rowIndex" :md-item="user" md-selection>
		      <md-table-cell>{{ user.username }}</md-table-cell>
		      <md-table-cell>{{ user.email }}</md-table-cell>
		      <md-table-cell>{{ user.is_active | active}}</md-table-cell>
		      <md-table-cell>{{ user.created_at }}</md-table-cell>
		    </md-table-row>
		  </md-table-body>
		</md-table>
		<md-table-pagination
	    md-size="5"
	    md-total="10"
	    md-page="1"
	    md-label="Rows"
	    md-separator="of"
	    :md-page-options="[5, 10, 25, 50]"
	    @pagination="onPagination">
	  </md-table-pagination>
  </md-table-card>
</template>

<script>
import Api from '../../api/RestApi'

export default{
	data(){
		return{
			users: []
		}
	},

	created(){
		Api.get('users').then((response) => {
			var data = response.data.data;

			data.forEach(el => {
				this.users.push(el);
			});
		});
	},

	methods:{
		onSelect(data){
		 	console.log(data);
		},

		onSort(data){
		 	console.log(data);
		},

		onPagination(pagination){
			console.log(pagination);
		}
	}
}
</script>