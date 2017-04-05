import Vue from 'vue'
import Notification from 'vue-bulma-notification'

export default (Vue, options) => {
	const NotificationComponent = Vue.extend(Notification);

	Vue.prototype.$notify = function (options) {		
		new NotificationComponent({
		    el: document.createElement('div'),
		    propsData: Object.assign({
				title: '',
				message: '',
				type: '',
				direction: '',
				duration: 1000000,
				container: '.notifications'
			}, options)
		});
	}
}