import _ from 'lodash'

export default{
	data(){
		return{
			query_search: ''
		}
	},

	methods: {
		closeForm(){
			this.$emit('close-form');
		},

		showViewInfo(data){
			this.$emit('show-view', data);
		},

		showEdit(data){
			this.$emit('show-edit', data);
		},

		onSelect(data){
		 	console.log(data);
		},

		onSort(data){
		 	console.log(data);
		},

		onPagination(pagination){
			this.fetchData({
				pagination: { per_page: pagination.size, current_page: pagination.page },
				query: this.query_search
			});
		}
	},

	watch:{
		'query_search': _.debounce(function (new_val, old_val) {
			if(new_val !== old_val){
				this.pagination.current_page = 1;
			}
			
            this.fetchData({ pagination: this.pagination, query: this.query_search });
        }, 500)
	}
}