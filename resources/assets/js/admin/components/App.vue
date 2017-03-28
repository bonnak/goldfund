<template>
	<div id="app">
		<md-sidenav class="md-fixed main-sidebar" ref="leftSidenav">
			<div class="top-of-side-bar">
				<md-image md-src="./images/logo.png" style="height:100px"></md-image> 
			</div>
			<div class="main-sidebar-links phone-viewport">
				<md-list>
					<md-list-item>
				    	<router-link :to="{ path: '/user' }">
							<i class="fa fa-user"></i><span>User</span>
		  				</router-link>
				    </md-list-item>
	  				<md-list-item>
			    		<router-link :to="{ path: '/customer' }">
							<i class="fa fa-users"></i><span>Customer</span>
	  					</router-link>
	  				</md-list-item>
	  				<md-list-item>
	  					<router-link :to="{ path: '/deposit' }">
							<i class="fa fa-money"></i><span>Deposit History</span>
	  					</router-link>
	  				</md-list-item>
	  				<md-list-item>
	  					<router-link :to="{ path: '/withdrawal' }">
							<i class="fa fa-dollar"></i><span>Withdrawal</span>
	  					</router-link>
	  				</md-list-item>
	  				<md-list-item>
	  					<router-link :to="{ path: '/geneology' }">
							<i class="fa fa-sitemap"></i><span>Geneology</span>
	  					</router-link>
  					</md-list-item>
  					<md-list-item>
	  					<router-link :to="{ path: '/company/profile' }">
							<i class="fa fa-building"></i><span>Company Profile</span>
	  					</router-link>
  					</md-list-item>
			  	</md-list>
			</div>
		</md-sidenav>

		<div class="page-content" ref="pageContent">
		  <md-toolbar class="top-bar">
			  <div class="md-toolbar-container">
			    <md-button class="md-icon-button" id="btn-toggle-sidebar" @click="toggleLeftSidenav">
			      <md-icon>menu</md-icon>
			    </md-button>

			    <span style="flex: 1;"></span>

			    <div class="dropdown user-dropdown">
				    <a href="#" class="dropdown-toggle user-link" data-toggle="dropdown" aria-expanded="true">
					  	<!-- <md-avatar class="user-avatar">
							  <img src="https://placeimg.com/40/40/people/5" alt="Avatar">
							</md-avatar> -->
							<span class="user-name">administrator</span>
						</a>
	          <ul class="dropdown-menu">
					    <li><a href="/admin/logout">Logout</a></li>
					  </ul>
					 </div>
			  </div>
			</md-toolbar>
		  
		  <div class="main-content">
		    <router-view></router-view>
		  </div>
	  </div>
	</div>
</template>

<script>
export default {
	created(){
		
	},

	mounted(){
		this.toggleLeftSidenav();
	},
	
  methods: {
    toggleLeftSidenav() {
      this.$refs.leftSidenav.toggle();
      
      var el_page_ontent = this.$refs.pageContent;

      $(el_page_ontent).toggleClass('open-nav');
    }
  }
}
</script>

<style lang="scss">
body.md-theme-app{
	background-color: #ecf0f5 !important;
}

.page-content{
	margin-left: 0;
	transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);

	&.open-nav{
		margin-left: 280px
	}

	.main-content{
		padding: 15px;
		background-color: #ecf0f5;
	}
}

.main-sidebar{
	.md-sidenav-content{
		width: 280px;
		left: -280px;
		transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
		background-color: #222d32 !important;
		display: flex;
		flex-flow: column;
		overflow: hidden;

		.main-sidebar-links{
			flex: 1;
			overflow: auto;

			.md-list-expand{
				.md-list-item{
					.md-button{
						padding-left: 84px;
					}
				}
			}

			.md-list{
				.md-list-item{
					i{
						display: inline-block;
					    width: 40px;
					    font-size: 20px;
					}

					a{
						padding-top: 5px;
					    padding-bottom: 5px;
					    text-decoration: none;

						&:hover{
							color: #00bcd4;
							background: rgba(62, 78, 86, 0.56)
						}
					}
				}
			}
		}

		.top-of-side-bar{
	    width: 100%;
	    min-height: 120px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	    background: #fff;
		}

		.md-theme-app.md-list .md-list-item-container{
			background-color: inherit;
		}

		.md-list-expand .md-list.md-theme-app{
			background-color: rgba(153,153,153,0.05);
		}
	}

	&.md-active{
		.md-sidenav-content{
			left: 0;
		}

		.md-sidenav-backdrop{
			display: none;
		}
	}

	.md-theme-app.md-list{
		background-color: #222d32;
		color: #fff;

		.md-list-item .md-icon{
			color: #fff;
		}
	}

	.md-theme-app.md-list .md-list-item-expand .md-list-item-container:hover, 
	.md-theme-app.md-list .md-list-item-expand .md-list-item-container:focus,
	.md-button:hover:not([disabled]):not(.md-raised) {
    background-color: rgba(153,153,153,0.2);
	}
}

#btn-toggle-sidebar{
	color: #fff;
}

.md-divider.md-inset{
	margin-left: 0;
}

.top-bar{
	z-index: 99;

	.user-link{
		text-decoration: none !important;
		color: #fff !important;
		padding: 24px 10px;

		&:hover{
			background-color: rgba(0, 0, 0, 0.12);
		}
	}

	.user-dropdown{		
		.dropdown-menu{
			border-radius: 0;
			border: 1px solid rgba(0, 0, 0, 0.06);

			a{
				text-decoration: none;
				
				&:hover{
					background-color: rgba(0, 0, 0, 0.06);
				}
			}
		}
	}

	.user-avatar{
		margin: inherit;
	}

	.user-name{
		margin-left: 10px;
	}
}
</style>

<style lang="scss">
.md-theme-app.md-button:not([disabled]).md-green.md-fab{
	background-color: #47a567;
}

.label-gold{
	background-color: #cbb956;
}
.label-basic{
	background-color: #d77ade;
}
.label-platinum{
	background-color: #c5c5c5;
}

.md-table-cell.flex-end-action{
	.md-table-cell-container{
		display: flex !important;
		align-items: center !important;
		justify-content: flex-end !important;
	}
}

.md-danger{
	background-color: #ed6b75 !important;
}

.md-dialog-title{
	padding: 13px;
	margin: 0;

	.icon-danger{
		color: #ed6b75;
	}

	.icon-success{
		color: #2ab27b;
	}
}

.md-dialog-content{
	padding: 13px;
	background: none;
	text-align: center;
}
</style>