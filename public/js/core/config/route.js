app.service('dbService',[
	'$http',
	function($http) {
		return {
			getData: function($q, $http) {
				var defer = $q.defer();
				$http.get('api/getUserInfo').success(function(data) {
					defer.resolve(data);
				});
				return defer.promise;
			}
		};
	}
]);


/**
 * Directive Define title of the page
 */
app.directive('title', ['$rootScope', '$timeout',
	function($rootScope, $timeout) {
		return {
			getInfo: function() {
				var listener = function(event, toState) {
					$timeout(function() {
						$rootScope.title = (toState.data && toState.data.pageTitle)
								? toState.data.pageTitle
								: 'Default title';
					});
				};
				$rootScope.$on('$stateChangeSuccess', listener);
			}
		};
	}
]);
app.config([
	'$stateProvider',
	'$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {
		var name = ' SKWeb Solution';
		// var featureRole = {};
		// if(featureRole.role_name == "sokhom21") {
			$stateProvider.state('license', {
				url: '/license',
				templateUrl: 'js/ng/app/license/views/index.html',
				controller: 'license_ctrl',
				data: { pageTitle: 'License' + name}
			});
		// }
		$stateProvider.
			state('dashboard', {
				url: '/dashboard',
				templateUrl: 'js/ng/app/index/partials/index.html',
				controller: 'index_ctrl as vm',
				data: { pageTitle: 'DashBoard' + name}
			})
			.state('journal_entry', {
				url: '/journal_entry',
				templateUrl: 'js/ng/app/journal/views/index.html',
				controller: 'journal_ctrl as vm',
				data: { pageTitle: 'Journal' + name}
			})
			.state('ledger_report', {
				url: '/ledger_report',
				templateUrl: 'js/ng/app/ledger_report/views/index.html',
				controller: 'ledger_report_ctrl as vm',
				data: { pageTitle: 'Ledger Report' + name}
			})
			.state('account_type', {
				url: '/account_type',
				templateUrl: 'js/ng/app/account_type/views/index.html',
				controller: 'account_type_ctrl as vm',
				data: { pageTitle: 'Account Type' + name}
			})
			// customer route
			.state('customer_list', {
				url: '/customer_list',
				templateUrl: 'js/ng/app/customer_list/views/index.html',
				controller: 'customer_list_ctrl as vm',
				data: { pageTitle: 'Customer List' + name}
			})
            .state('customer_list_create', {
                url: '/customer_list/create',
                templateUrl: 'js/ng/app/customer_list/views/create.html',
                controller: 'customer_list_create_ctrl as vm',
                data: { pageTitle: 'Customer List Create' + name}
            })
            .state('customer_list_edit', {
                url: '/customer_list/edit/:id',
                templateUrl: 'js/ng/app/customer_list/views/create.html',
                controller: 'customer_list_create_ctrl as vm',
                data: { pageTitle: 'Customer List Edit' + name}
            })
			.state('customer_type', {
				url: '/customer_type',
				templateUrl: 'js/ng/app/customer_type/views/index.html',
				controller: 'customer_type_ctrl as vm',
				data: { pageTitle: 'Customer Type' + name}
			})
			.state('create_invoice', {
				url: '/create_invoice',
				templateUrl: 'js/ng/app/create_invoice/views/index.html',
				controller: 'create_invoice_ctrl as vm',
				data: { pageTitle: 'Create Invoice' + name}
			})
			/** customer received payment route **/
			.state('received_payment', {
				url: '/received_payment',
				template: '<div ui-view/>',
				redirectTo: 'received_payment.search',
				data: { pageTitle: 'Receive Payment' + name}
			})
				.state('received_payment.search', {
					url: '/',
					templateUrl: 'js/ng/app/received_payment/views/index.html',
					controller: 'received_payment_ctrl as vm',
					data: { pageTitle: 'Receive Payment' + name}
				})
				.state('received_payment.create', {
					url: '/create',
					templateUrl: 'js/ng/app/received_payment/views/create.html',
					controller: 'received_payment_create_ctrl as vm',
					data: { pageTitle: 'Receive Payment' + name}
				})
				.state('received_payment.detail', {
					url: '/detail/:id',
					templateUrl: 'js/ng/app/received_payment/views/detail.html',
					controller: 'received_payment_detail_ctrl as vm',
					data: { pageTitle: 'Receive Payment' + name}
				})
			/** end customer received payment route **/
			.state('service', {
				url: '/service',
				templateUrl: 'js/ng/app/service/views/index.html',
				controller: 'service_ctrl as vm',
				data: { pageTitle: 'Service' + name}
			})
			// user route
			.state('user', {
				url: '/user',
				templateUrl: 'js/ng/app/user/views/index.html',
				controller: 'user_ctrl as vm',
				data: { pageTitle: 'User' + name}
			})
			// staff route
			.state('staff_list', {
				url: '/staff_list',
				templateUrl: 'js/ng/app/staff_list/views/index.html',
				controller: 'staff_list_ctrl as vm',
				data: { pageTitle: 'Staff List' + name}
			})
			// customer_birthday
			.state('customer-birthday', {
				url: '/customer-birthday',
				templateUrl: 'js/ng/app/customer_birthday/views/index.html',
				controller: 'customer_birthday_ctrl as vm',
				data: { pageTitle: 'Customer Birthday' + name}
			})
			// doctor type route
			.state('doctor_type', {
				url: '/doctor_type',
				template: '<div ui-view/>',
				redirectTo: 'doctor_type.list'
			})
			.state('doctor_type.list', {
				url: '/',
				templateUrl: 'js/ng/app/doctor_type/views/index.html',
				controller: 'doctor_type_ctrl as vm',
				data: { pageTitle: 'Doctor Type' + name}
			})
			.state('doctor_type.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/doctor_type/views/create.html',
				controller: 'doctor_type_create_ctrl as vm',
				data: { pageTitle: 'Edit Doctor Type' + name}
			})
			.state('doctor_type.create', {
				url: '/create',
				templateUrl: 'js/ng/app/doctor_type/views/create.html',
				controller: 'doctor_type_create_ctrl as vm',
				data: { pageTitle: 'Create Doctor Type' + name}
			})
			/***********************************
			*****  Doctor list route ***********
		  	************************************/
			.state('doctor_list', {
				url: '/doctor_list',
				template: '<div ui-view/>',
				redirectTo: 'doctor_list.list'
			})
			.state('doctor_list.list', {
				url: '/',
				templateUrl: 'js/ng/app/doctor_list/views/index.html',
				controller: 'doctor_list_ctrl as vm',
				data: { pageTitle: 'Doctor List' + name}
			})
			.state('doctor_list.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/doctor_list/views/create.html',
				controller: 'doctor_create_ctrl as vm',
				data: { pageTitle: 'Edit Doctor List' + name}
			})
			.state('doctor_list.create', {
				url: '/create',
				templateUrl: 'js/ng/app/doctor_list/views/create.html',
				controller: 'doctor_create_ctrl as vm',
				data: { pageTitle: 'Create Doctor List' + name}
			})

			/**************************
			 * Doctor expense router **
			 **************************/
			.state('doctor_expense', {
				url: '/doctor_expense',
				templateUrl: 'js/ng/app/doctor_expense/views/index.html',
				controller: 'doctor_expense_ctrl as vm',
				data: { pageTitle: 'Doctor Expense' + name}
			})
			// product type route
			.state('product_type', {
				url: '/product_type',
				templateUrl: 'js/ng/app/products_type/views/index.html',
				controller: 'products_type_ctrl as vm',
				data: { pageTitle: 'Product Type' + name}
			})
			/**
			 * Product List Route
			 */
			.state('product_list', {
				url: '/product_list',
				template: '<div ui-view/>',
				redirectTo: 'product_list.list'
			})
			.state('product_list.list', {
				url: '/',
				templateUrl: 'js/ng/app/products_list/views/index.html',
				controller: 'products_list_ctrl as vm',
				data: { pageTitle: 'Product List' + name}
			})
            .state('product_list.create', {
                url: '/create',
                templateUrl: 'js/ng/app/products_list/views/create.html',
                controller: 'products_list_create_ctrl as vm',
                data: { pageTitle: 'Create Product List' + name}
            })
            .state('product_list.edit', {
                url: '/edit/:id',
                templateUrl: 'js/ng/app/products_list/views/create.html',
                controller: 'products_list_create_ctrl as vm',
                data: { pageTitle: 'Edit Product List' + name}
            })
			.state('import_product', {
				url: '/import_product',
				templateUrl: 'js/ng/app/import_product/views/index.html',
				controller: 'import_product_ctrl as vm',
				data: { pageTitle: 'Import Product List' + name}
			})
			/**
			 * Stock out route
			 */
			.state('stock_out', {
				url: '/stock_out',
				template: '<div ui-view/>',
				redirectTo: 'stock_out.list'
			})
			.state('stock_out.list', {
				url: '/',
				templateUrl: 'js/ng/app/stock_out/views/index.html',
				controller: 'stock_out_ctrl as vm',
				data: { pageTitle: 'Stock Out' + name}
			})
			.state('stock_out.create', {
				url: '/create',
				templateUrl: 'js/ng/app/stock_out/views/create.html',
				controller: 'stock_out_create_ctrl as vm',
				data: { pageTitle: 'Stock Out' + name}
			})
			.state('stock_out.detail', {
				url: '/detail/:id',
				templateUrl: 'js/ng/app/stock_out/views/detail.html',
				controller: 'stock_out_detail_ctrl as vm',
				data: { pageTitle: 'Stock Out Detail' + name}
			})
			/**
			 * Setting route
			 */
			.state('exchange-rate', {
				url: '/exchange-rate',
				templateUrl: 'js/ng/app/exchange_rate/views/index.html',
				controller: 'exchange_rate_ctrl as vm',
				data: { pageTitle: 'Exchange Rate' + name}
			})
			/**
			 * vendor type route
			 */
			.state('vendor_type', {
				url: '/vendor_type',
				template: '<div ui-view/>',
				redirectTo: 'vendor_type.list'
			})
			.state('vendor_type.list', {
				url: '/',
				templateUrl: 'js/ng/app/vendor_type/views/index.html',
				controller: 'vendor_type_ctrl as vm',
				data: { pageTitle: 'vendor type List' + name}
			})
			.state('vendor_type.create', {
				url: '/create',
				templateUrl: 'js/ng/app/vendor_type/views/create.html',
				controller: 'vendor_type_create_ctrl as vm',
				data: { pageTitle: 'create vendor type' + name}
			})
			.state('vendor_type.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/vendor_type/views/create.html',
				controller: 'vendor_type_create_ctrl as vm',
				data: { pageTitle: 'edit vendor type' + name}
			})
			/**
			 * Vendor List Route
			 */
			.state('vendor_list', {
				url: '/vendor_list',
				template: '<div ui-view/>',
				redirectTo: 'vendor_list.list'
			})
			.state('vendor_list.list', {
				url: '/',
				templateUrl: 'js/ng/app/vendor_list/views/index.html',
				controller: 'vendor_list_ctrl as vm',
				data: { pageTitle: 'Vendor List' + name}
			})
			.state('vendor_list.create', {
				url: '/create',
				templateUrl: 'js/ng/app/vendor_list/views/create.html',
				controller: 'vendor_list_create_ctrl as vm',
				data: { pageTitle: 'Create Vendor List' + name}
			})
			.state('vendor_list.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/vendor_list/views/create.html',
				controller: 'vendor_list_create_ctrl as vm',
				data: { pageTitle: 'Edit Vendor List' + name}
			})

			.state('vendor_balance', {
				url: '/vendor_balance',
				templateUrl: 'js/ng/app/report_vendor_balance/views/index.html',
				controller: 'report_vendor_balance_ctrl as vm',
				data: { pageTitle: 'Vendor Balance' + name}
			})
			// purchase route
			.state('purchase', {
				url: '/purchase',
				template: '<div ui-view/>',
				redirectTo: 'purchase.list'
			})
			.state('purchase.list', {
				url: '/',
				templateUrl: 'js/ng/app/purchase/views/index.html',
				controller: 'purchase_ctrl as vm',
				data: { pageTitle: 'Purchase List' + name}
			})
			.state('purchase.create', {
				url: '/create',
				templateUrl: 'js/ng/app/purchase/views/create.html',
				controller: 'purchase_create_ctrl as vm',
				data: { pageTitle: 'Create Purchase' + name}
			})
			.state('purchase.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/purchase/views/create.html',
				controller: 'purchase_create_ctrl as vm',
				data: { pageTitle: 'Edit Purchase' + name}
			})
			.state('purchase.detail', {
				url: '/detail/:id',
				templateUrl: 'js/ng/app/purchase/views/detail.html',
				controller: 'purchase_detail_ctrl as vm',
				data: { pageTitle: 'Purchase Detail' + name}
			})

			//.state('purchase.detail', {
			//	url: '/purchase/detail/:id',
			//	templateUrl: 'js/ng/app/purchase/views/detail.html',
			//	controller: 'purchase_detail_ctrl'
			//})
			.state('pay_bill', {
				url: '/pay_bill',
				templateUrl: 'js/ng/app/pay_bill/views/index.html',
				controller: 'pay_bill_ctrl as vm',
				data: { pageTitle: 'Pay Bill' + name}
			})
			// report purchase route
			.state('report_purchase', {
				url: '/report_purchase',
				templateUrl: 'js/ng/app/report_purchase/views/index.html',
				controller: 'report_purchase_ctrl as vm',
				data: { pageTitle: 'Report Purchase Detail' + name}
			})
			// report_purchase_summary route
			.state('report_purchase_summary', {
				url: '/report_purchase_summary',
				templateUrl: 'js/ng/app/report_purchase_summary/views/index.html',
				controller: 'report_purchase_summary_ctrl as vm',
				data: { pageTitle: 'Report Purchase Summary' + name}
			})
			.state('account_payable', {
				url: '/account_payable',
				templateUrl: 'js/ng/app/report_pay_bill/views/index.html',
				controller: 'report_pay_bill_ctrl as vm',
				data: { pageTitle: 'Account Payable' + name}
			})
			.state('account_payable_summary', {
				url: '/account_payable_summary',
				templateUrl: 'js/ng/app/report_payment_summary/views/index.html',
				controller: 'report_pay_bill_summary_ctrl as vm',
				data: { pageTitle: 'Account Payable Summary' + name}
			})
			// report invoice rote
			.state('/report_invoice', {
				url: '/report_invoice',
				templateUrl: 'js/ng/app/report_invoice/views/index.html',
				controller: 'report_invoice_ctrl'
			})
			// staff payroll rote
			.state('staff_payroll', {
				url: '/staff_payroll',
				templateUrl: 'js/ng/app/pay_roll/views/index.html',
				controller: 'pay_roll_ctrl as vm',
				data: { pageTitle: 'Staff Payroll' + name}
			})
			// report_staff rote
			.state('staff_report', {
				url: '/staff_report',
				templateUrl: 'js/ng/app/report_staff/views/index.html',
				controller: 'report_staff_ctrl as vm',
				data: { pageTitle: 'Staff Report' + name}
			})
			// report_receive_payment rote
			.state('account_receivable', {
				url: '/account_receivable',
				templateUrl: 'js/ng/app/report_receive_payment/views/index.html',
				controller: 'report_receive_payment_ctrl as vm',
				data: { pageTitle: 'Account Receivable' + name}
			})
			// report_receive_payment rote
			.state('account_receivable_summary', {
				url: '/account_receivable_summary',
				templateUrl: 'js/ng/app/report_account_receivable_summary/views/index.html',
				controller: 'report_account_receivable_summary_ctrl as vm',
				data: { pageTitle: 'Account Receivable Summary' + name}
			})
			// report stock rote
			.state('stock_report', {
				url: '/stock_report',
				templateUrl: 'js/ng/app/report_stock/views/index.html',
				controller: 'report_stock_ctrl as vm',
				data: { pageTitle: 'Stock Report' + name}
			})
			// report_sale summary rote
			.state('report_sale_summary', {
				url: '/report_sale_summary',
				templateUrl: 'js/ng/app/report_sale_summary/views/index.html',
				controller: 'report_sale_summary_ctrl as vm',
				data: { pageTitle: 'Report Sale Summary' + name}
			})
			// report sale service rote
			.state('report_sale', {
				url: '/report_sale',
				templateUrl: 'js/ng/app/report_sale/views/index.html',
				controller: 'report_sale_ctrl as vm',
				data: { pageTitle: 'Report Sale Detail' + name}
			})
			// setting company profile rote
			.state('company-profile', {
				url: '/company-profile',
				templateUrl: 'js/ng/app/setting/views/index.html',
				controller: 'setting_ctrl as vm',
				data: { pageTitle: 'Company Profile' + name}
			})
			// report customer rote
			.state('customer_report', {
				url: '/customer_report',
				templateUrl: 'js/ng/app/report_customer/views/index.html',
				controller: 'report_customer_ctrl as vm',
				data: { pageTitle: 'Customer Report' + name}
			})
			// report doctor rote
			.state('doctor_report', {
				url: '/doctor_report',
				templateUrl: 'js/ng/app/report_doctor/views/index.html',
				controller: 'report_doctor_ctrl as vm',
				data: { pageTitle: 'Doctor Report' + name}
			})
			/**
			 * start appointment route
			 */
			.state('appointment', {
				url: '/appointment',
				template: '<div ui-view></div>',
				redirectTo: 'appointment.list'
			})
			.state('appointment.list', {
				url: '',
				templateUrl: 'js/ng/app/appointment/views/index.html',
				controller: 'appointment_ctrl as vm',
				data: { pageTitle: 'Appointment' + name}
			})
			.state('appointment.create', {
				url: '/create',
				templateUrl: 'js/ng/app/appointment/views/create.html',
				controller: 'appointment_create_ctrl as vm',
				data: { pageTitle: 'Create Appointment' + name}
			})
			.state('appointment.edit', {
				url: '/edit/:id',
				templateUrl: 'js/ng/app/appointment/views/create.html',
				controller: 'appointment_create_ctrl as vm',
				data: { pageTitle: 'Edit Appointment' + name}
			})
			.state('appointment_report', {
				url: '/appointment_report',
				templateUrl: 'js/ng/app/appointment_report/views/index.html',
				controller: 'appointment_report_ctrl as vm',
				data: { pageTitle: 'Appointment Report' + name}
			})
			// report payroll route
			.state('payroll_report', {
				url: '/payroll_report',
				templateUrl: 'js/ng/app/report_payroll/views/index.html',
				controller: 'report_payroll_ctrl as vm',
				data: { pageTitle: 'Payroll Report' + name}
			})
			// chart account route
			.state('balance_sheet', {
				url: '/balance_sheet',
				templateUrl: 'js/ng/app/report_balance_sheet/views/index.html',
				controller: 'report_balance_sheet_ctrl as vm',
				data: { pageTitle: 'Report Balance Sheet' + name}
			})
			// chart account route
			.state('chart_account', {
				url: '/chart_account',
				templateUrl: 'js/ng/app/chart_account/views/index.html',
				controller: 'chart_account_ctrl as vm',
				data: { pageTitle: 'Chart Account' + name}
			})
			.state('journal_report', {
				url: '/journal_report',
				templateUrl: 'js/ng/app/report_journal/views/index.html',
				controller: 'journal_report_ctrl as vm',
				data: { pageTitle: 'Journal Report' + name}
			})
			.state('cash_flow', {
				url: '/cash_flow',
				templateUrl: 'js/ng/app/report_cash_flow/views/index.html',
				controller: 'cash_flow_report_ctrl as vm',
				data: { pageTitle: 'Cash Flow' + name}
			})
			.state('income_statement', {
				url: '/income_statement',
				templateUrl: 'js/ng/app/report_income_statement/views/index.html',
				controller: 'income_statement_report_ctrl as vm',
				data: { pageTitle: 'Income Statement' + name}
			})
			.state('customer_balance', {
				url: '/customer_balance',
				templateUrl: 'js/ng/app/report_customer_balance/views/index.html',
				controller: 'report_customer_balance_ctrl as vm',
				data: { pageTitle: 'Customer Balance' + name}
			})
			.state('daily_case_report', {
				url: '/daily_case_report',
				templateUrl: 'js/ng/app/report_daily_case/views/index.html',
				controller: 'report_daily_case_ctrl as vm',
				data: { pageTitle: 'Daily Case Report' + name}
			})
			.state('role', {
				url: '/role',
				templateUrl: 'js/ng/app/role/views/index.html',
				controller: 'role_ctrl as vm',
				data: { pageTitle: 'Role' + name}
			})
		;
		$urlRouterProvider.otherwise('dashboard');
		// use the HTML5 History API
		//$locationProvider.html5Mode(true);
	}
]);

// for redirect to child from parent
app.run(['$rootScope', '$state', function($rootScope, $state) {
	$rootScope.$on('$stateChangeStart', function(evt, to, params) {
		if (to.redirectTo) {
			evt.preventDefault();
			$state.go(to.redirectTo, params, {location: 'replace'})
		}
	});
}]);