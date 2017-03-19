export default{
	methods: {
		showInfoView(data){
			this.data = data;
			this.current_view = '_Info';
		},
		
		showEditView(data){
			this.data = data;
			this.current_view = '_Edit';
		}
	}
}