export default{
	methods: {
		closeForm(){
			this.$emit('close-form-message');
		},

		onSelect(data){
		 	console.log(data);
		},

		onSort(data){
		 	console.log(data);
		},

		onPagination(pagination){
			this.fetchData({ per_page: pagination.size, current_page: pagination.page });
		}
	}
}