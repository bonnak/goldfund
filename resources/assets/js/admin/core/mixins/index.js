export default{
	methods: {
		showView(data){
			this.data = data;
			this.current_view = '_View';
		},
		
		showEdit(data){
			this.data = data;
			this.current_view = '_Edit';
		}
	}
}