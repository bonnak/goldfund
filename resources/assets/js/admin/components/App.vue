<template>
	<div id="app">
		<md-sidenav class="md-fixed main-sidebar" ref="leftSidenav">
			<div class="top-of-side-bar">
				<md-image md-src="./images/logo.png" style="height:100px"></md-image> 
			</div>
			<div class="main-sidebar-links phone-viewport">
				<md-list>
	  				<md-list-item>
			    		<router-link :to="{ path: '/customer' }">
							<i class="fa fa-users"></i><span>Customer</span>
	  					</router-link>
	  				</md-list-item>
	  				<md-list-item>
	  					<i class="fa fa-money"></i>
				    	<span>Deposit</span>
				    	<md-list-expand>
				    		<md-list>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/deposit/pending' }"><span>Pending Deposit</span></router-link></md-list-item>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/deposit/approve' }"><span>Approve Deposit</span></router-link></md-list-item>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/deposit/expire' }"><span>Expire Deposit</span></router-link></md-list-item>
				            </md-list>
				    	</md-list-expand>
	  				</md-list-item>	  				
  					<md-list-item>
				    	<i class="fa fa-dollar"></i>
				    	<span>Withdrawal</span>
				    	<md-list-expand>
				    		<md-list>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/withdrawal/pending' }"><span>Pending Withdrawal</span></router-link></md-list-item>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/withdrawal/approve' }"><span>Approve Withdrawal</span></router-link></md-list-item>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/withdrawal/cancel' }"><span>Cancel Withdrawal</span></router-link></md-list-item>
				            </md-list>
				    	</md-list-expand>
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
  					<md-list-item>
				    	<i class="fa fa-file-text"></i>
				    	<span>Page</span>
				    	<md-list-expand>
				    		<md-list>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/page/faq' }"><span>Faq</span></router-link></md-list-item>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/page/about-us' }"><span>About Us</span></router-link></md-list-item>
				        		<md-list-item class="md-inset"><router-link :to="{ path: '/page/what-is-forex' }"><span>What is forex</span></router-link></md-list-item>
				            </md-list>
				    	</md-list-expand>
				    </md-list-item>
			  	</md-list>
			</div>
		</md-sidenav>

		<div class="page-content" ref="pageContent">
		  <md-toolbar class="top-bar">
			  <div class="md-toolbar-container">
			    <md-button class="md-icon-button" id="btn-toggle-sidebar" @click.native="toggleLeftSidenav">
			     	<i class="fa fa-bars"></i>
			    </md-button>

			    <span style="flex: 1;"></span>

			    <div class="dropdown user-dropdown">
				    <a href="#" class="dropdown-toggle user-link" data-toggle="dropdown" aria-expanded="true">
					  	<!-- <md-avatar class="user-avatar">
							  <img src="https://placeimg.com/40/40/people/5" alt="Avatar">
							</md-avatar> -->
							<span class="user-name">{{ user.username }}</span>
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
import Api from '../api/Api'

export default {
	data(){
		return {
			user: {}
		}
	},

	created(){
		Api.get('auth/user').then((response) => {
			this.user = response.data;
		});
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

	&:hover{
		background-color: #34c164 !important;
	}
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

<style lang="scss">
.main-sidebar{
	.md-sidenav-content{
		.main-sidebar-links{
			.md-list-expand{
				.md-list-item{
					.md-button{
						padding-left: 72px;
					}
				}
			}

			.md-list{
				.md-list-item{
					i{
						text-align: center;
					}

					.md-button-ghost {
					    width: 100%;
					    margin: 0;
					    position: absolute;
					    top: 0;
					    right: 0;
					    bottom: 0;
					    left: 0;
					    z-index: 1;
					    border-radius: 0;
					}
				}
			}
		}
	}
}

.md-pagination-select{
	.md-list-item.md-menu-item.md-option{
		.md-list-item-container.md-button{
			min-height: auto;
		}
	}

	.md-list-item.md-menu-item.md-option{
		.md-button.md-button-ghost{
			display: none;
		}
	}
}


.md-button{
	&.md-raised{
		width: 100%;
	}

	&.btn-action{
		i{
		    display: block;
		    margin-left: -5px;
		    color: #fff;
		}
	}

	&.btn-refresh{
		min-width: auto;

		i{
			font-size: 20px; 
			color: #636b6f;
		}
	}
}

.search{
    position: relative;
    right: 0;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    width: 100%;

    input{
        border-radius: 20px;
        width: 250px;
    }

    span{
        border: none;
        background: transparent;
        padding: 0 0 0 5px;
        font-size: 22px;
        display: inline-block;
        margin-right: 15px;
    }
}

.md-theme-app.md-button:not([disabled]).md-primary.md-raised, 
.md-theme-app.md-button:not([disabled]).md-primary.md-fab{
	color: #fff !important;
}
</style>


<style lang="scss">
.notifications{
  position: fixed;
  top: auto;
  bottom: 20px;
  right: 0;
  z-index: 1024 + 233;
  pointer-events: none;

	.notification{
    	margin: 20px;
	}
}

.notification{
	position: relative;
	min-width: 182px;
	backface-visibility: hidden;
	transform: translate3d(0, 0, 90);
	pointer-events: all;
	border-radius: 3px;
	padding: 20px 10px 20px 20px;

	&.is-success{
	    background-color: #23d160;
	    color: #fff;
	}

	.delete{
		position: absolute !important;
    	right: 0.5em;
    	top: 0.5em;
		user-select: none;
		background-color: rgba(10, 10, 10, 0.2);
		border: none;
		border-radius: 290486px;
		cursor: pointer;
		display: inline-block;
		font-size: 1rem;
		height: 20px;
		outline: none;
		position: relative;
		vertical-align: top;
		width: 20px;

		&::before, &::after {
		    background-color: white;
		    content: "";
		    display: block;
		    left: 50%;
		    position: absolute;
		    top: 50%;
		    transform: translateX(-50%) translateY(-50%) rotate(45deg);
		    transform-origin: center center;
		}

		&::before {
		    height: 2px;
		    width: 50%;
		}

		&::after {
		    height: 50%;
		    width: 2px;
		}
	}
}
</style>